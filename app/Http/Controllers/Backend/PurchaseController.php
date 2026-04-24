<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Semester;
use App\Models\Supplier;
use App\Models\WareHouse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;

class PurchaseController extends Controller
{
    public function AllPurchase()
    {
        $allData = Purchase::with(['semester', 'department'])->orderBy('id', 'desc')->get();
        return view('admin.backend.purchase.all_purchase', compact('allData'));
    }
    // End Method

    public function AddPurchase()
    {
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        $semesters = Semester::all();
        $departments = Department::all();
        return view('admin.backend.purchase.add_purchase', compact('suppliers', 'warehouses', 'semesters', 'departments'));
    }
    // End Method

    public function PurchaseProductSearch(Request $request)
    {
        $query = trim((string) $request->input('query', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $warehouseId = $request->input('warehouse_id');

        $products = Product::query()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->when($warehouseId, function ($q) use ($warehouseId) {
                $q->where('warehouse_id', $warehouseId);
            })
            ->select('id', 'name', 'code', 'sku', 'price', 'product_qty')
            ->limit(10)
            ->get();

        return response()->json($products);
    }
    // End Method

    public function GetUsersByDepartment($department_id)
    {
        if (!$department_id) {
            return response()->json([]);
        }

        $users = \App\Models\User::where('department_id', $department_id)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }
    // End Method

    public function StorePurchase(Request $request)
    {

        $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required',
        ]);

        try {

            DB::beginTransaction();

            $grandTotal = 0;

            $purchase = Purchase::create([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'tracking_no' => $request->tracking_no,
                'note_no' => $request->note_no,
                'semester_id' => $request->semester_id,
                'department_id' => $request->department_id,
                'user_id' => $request->user_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'note' => $request->note,
                'grand_total' => 0,
            ]);

            if ($request->hasFile('file_upload')) {
                $purchase->file_upload = $request->file('file_upload')->store('purchase-files', 'public');
                $purchase->save();
            }

            /// Store Purchase Items & Update Stock
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;

                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit cost is missing ofr the product id" . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $subtotal,
                ]);

                $product->increment('product_qty', $productData['quantity']);
            }

            $purchase->update(['grand_total' => $grandTotal + $request->shipping - $request->discount]);

            DB::commit();

            $notification = array(
                'message' => 'Purchase Stored Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.purchase')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // End Method


    public function EditPurchase($id)
    {
        $editData = Purchase::with(['purchaseItems.product', 'user'])->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        $semesters = Semester::all();
        $departments = Department::all();
        return view('admin.backend.purchase.edit_purchase', compact('editData', 'suppliers', 'warehouses', 'semesters', 'departments'));
    }
    // End Method

    public function UpdatePurchase(Request $request, $id)
    {

        $request->validate([
            'date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            $purchase = Purchase::findOrFail($id);

            $purchase->update([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'tracking_no' => $request->tracking_no,
                'note_no' => $request->note_no,
                'semester_id' => $request->semester_id,
                'department_id' => $request->department_id,
                'user_id' => $request->user_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'note' => $request->note,
                'grand_total' => $request->grand_total,
            ]);

            if ($request->hasFile('file_upload')) {
                if ($purchase->file_upload) {
                    Storage::disk('public')->delete($purchase->file_upload);
                }
                $purchase->file_upload = $request->file('file_upload')->store('purchase-files', 'public');
                $purchase->save();
            }

            /// Get Old Purchase Items
            $oldPurchaseItems = PurchaseItem::where('purchase_id', $purchase->id)->get();

            /// Loop for old purchase items and decrement product qty
            foreach ($oldPurchaseItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->decrement('product_qty', $oldItem->quantity);
                    // Decrement old quantity
                }
            }

            /// Delete old Purchase Items
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            // loop for new products and insert new purchase items

            foreach ($request->products as $product_id => $productData) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $productData['net_unit_cost'],
                    'stock' => $productData['stock'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $productData['subtotal'],
                ]);

                /// Update product stock by incremeting new quantity
                $product = Product::find($product_id);
                if ($product) {
                    $product->increment('product_qty', $productData['quantity']);
                    // Increment new quantity
                }
            }

            DB::commit();

            $notification = array(
                'message' => 'Purchase Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.purchase')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // End Method

    public function DetailsPurchase($id)
    {
        $purchase = Purchase::with(['supplier', 'semester', 'department', 'roles', 'purchaseItems.product'])->find($id);
        return view('admin.backend.purchase.purchase_details', compact('purchase'));

    }
    // End Method

    public function InvoicePurchase($id)
    {
        $purchase = Purchase::with(['supplier', 'warehouse', 'semester', 'department', 'roles', 'purchaseItems.product'])->find($id);

        $pdf = Pdf::loadView('admin.backend.purchase.invoice_pdf', compact('purchase'));
        return $pdf->download('purchase_' . $id . '.pdf');

    }
    // End Method

    public function ViewPurchaseFile($id)
    {
        $purchase = Purchase::findOrFail($id);

        if (!$purchase->file_upload || !Storage::disk('public')->exists($purchase->file_upload)) {
            abort(404, 'File not found');
        }

        return response()->file(storage_path('app/public/' . $purchase->file_upload));
    }
    // End Method

    public function DeletePurchase($id)
    {
        try {
            DB::beginTransaction();
            $purchase = Purchase::findOrFail($id);
            $purchaseItems = PurchaseItem::where('purchase_id', $id)->get();

            foreach ($purchaseItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty', $item->quantity);
                }
            }
            PurchaseItem::where('purchase_id', $id)->delete();
            $purchase->delete();
            DB::commit();

            $notification = array(
                'message' => 'Purchase Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.purchase')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // End Method


}