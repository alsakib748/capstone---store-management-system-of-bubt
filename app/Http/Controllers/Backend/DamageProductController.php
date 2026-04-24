<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DamageProduct;
use App\Models\DamageProductItem;
use App\Models\Product;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DamageProductController extends Controller
{
    private function getDamageNoteColumn(): string
    {
        return Schema::hasColumn('damage_products', 'note') ? 'note' : 'notes';
    }

    private function getDamageQtyColumn(): string
    {
        return Schema::hasColumn('damage_product_items', 'quantity') ? 'quantity' : 'qty';
    }

    public function AllDamageProduct()
    {
        $allData = DamageProduct::with(['semester', 'damageProductItem'])->orderBy('id', 'desc')->get();
        return view('admin.backend.damage-product.all_damage_product', compact('allData'));
    }
    // End Method

    public function AddDamageProduct()
    {
        $semesters = Semester::all();
        return view('admin.backend.damage-product.add_damage_product', compact('semesters'));
    }
    // End Method

    public function DamageProductProductSearch(Request $request)
    {
        $query = trim((string) $request->input('query', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
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

    public function StoreDamageProduct(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'semester_id' => 'required',
            'products' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $noteColumn = $this->getDamageNoteColumn();
            $qtyColumn = $this->getDamageQtyColumn();

            $damageProductData = [
                'date' => $request->date,
                'semester_id' => $request->semester_id,
                'tracking_no' => $request->tracking_no,
                'note_no' => $request->note_no,
            ];
            $damageProductData[$noteColumn] = $request->note ?? $request->notes;

            $damageProduct = DamageProduct::create($damageProductData);

            // Store Damage Product Items & Decrease Stock
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $quantity = (int) ($productData['quantity'] ?? 0);

                if ($quantity < 1) {
                    throw new \Exception('Damage quantity must be at least 1.');
                }

                if ($quantity > (int) $product->product_qty) {
                    throw new \Exception("Insufficient stock for {$product->name}.");
                }

                $itemData = [
                    'damage_product_id' => $damageProduct->id,
                    'product_id' => $productData['id'],
                ];
                $itemData[$qtyColumn] = $quantity;

                DamageProductItem::create($itemData);

                // Decrease product stock
                $product->decrement('product_qty', $quantity);
            }

            DB::commit();

            $notification = array(
                'message' => 'Damage Product Stored Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.damage.product')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
    // End Method

    public function EditDamageProduct($id)
    {
        $editData = DamageProduct::with(['damageProductItem.product'])->findOrFail($id);
        $semesters = Semester::all();
        return view('admin.backend.damage-product.edit_damage_product', compact('editData', 'semesters'));
    }
    // End Method

    public function UpdateDamageProduct(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'semester_id' => 'required',
            'products' => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            $damageProduct = DamageProduct::findOrFail($id);
            $noteColumn = $this->getDamageNoteColumn();
            $qtyColumn = $this->getDamageQtyColumn();

            $damageProductData = [
                'date' => $request->date,
                'semester_id' => $request->semester_id,
                'tracking_no' => $request->tracking_no,
                'note_no' => $request->note_no,
            ];
            $damageProductData[$noteColumn] = $request->note ?? $request->notes;

            $damageProduct->update($damageProductData);

            // Get Old Items and restore stock
            $oldItems = DamageProductItem::where('damage_product_id', $damageProduct->id)->get();
            foreach ($oldItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->increment('product_qty', (int) ($oldItem->quantity ?? $oldItem->qty));
                }
            }

            // Delete old items
            DamageProductItem::where('damage_product_id', $damageProduct->id)->delete();

            // Add new items and decrease stock
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $quantity = (int) ($productData['quantity'] ?? 0);

                if ($quantity < 1) {
                    throw new \Exception('Damage quantity must be at least 1.');
                }

                if ($quantity > (int) $product->product_qty) {
                    throw new \Exception("Insufficient stock for {$product->name}.");
                }

                $itemData = [
                    'damage_product_id' => $damageProduct->id,
                    'product_id' => $productData['id'],
                ];
                $itemData[$qtyColumn] = $quantity;

                DamageProductItem::create($itemData);

                $product->decrement('product_qty', $quantity);
            }

            DB::commit();

            $notification = array(
                'message' => 'Damage Product Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.damage.product')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
    // End Method

    public function DetailsDamageProduct($id)
    {
        $damageProduct = DamageProduct::with(['semester', 'damageProductItem.product'])->find($id);
        return view('admin.backend.damage-product.damage_product_details', compact('damageProduct'));
    }
    // End Method

    public function InvoiceDamageProduct($id)
    {
        $damageProduct = DamageProduct::with(['semester', 'damageProductItem.product'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.backend.damage-product.invoice_pdf', compact('damageProduct'));
        return $pdf->download('damage_product_' . $id . '.pdf');
    }
    // End Method

    public function DeleteDamageProduct($id)
    {
        try {
            DB::beginTransaction();

            $damageProduct = DamageProduct::findOrFail($id);
            $damageItems = DamageProductItem::where('damage_product_id', $id)->get();

            // Restore product stock
            foreach ($damageItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('product_qty', (int) ($item->quantity ?? $item->qty));
                }
            }

            // Delete items and main record
            DamageProductItem::where('damage_product_id', $id)->delete();
            $damageProduct->delete();

            DB::commit();

            $notification = array(
                'message' => 'Damage Product Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.damage.product')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    // End Method
}