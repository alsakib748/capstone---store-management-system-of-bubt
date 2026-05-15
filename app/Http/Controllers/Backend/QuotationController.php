<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function AllQuotation()
    {
        $allData = Quotation::with(['supplier', 'createdBy'])
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.backend.quotation.all_quotation', compact('allData'));
    }

    public function AddQuotation()
    {
        $suppliers = Supplier::all();
        return view('admin.backend.quotation.add_quotation', compact('suppliers'));
    }

    public function QuotationProductSearch(Request $request)
    {
        $query = trim((string) $request->input('query', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'code', 'product_qty')
            ->limit(10)
            ->get();

        $productIds = $products->pluck('id')->unique()->values()->all();
        $priceByProductId = collect();
        if (! empty($productIds)) {
            $latestIds = DB::table('purchase_items')
                ->select('product_id', DB::raw('MAX(id) as max_id'))
                ->whereIn('product_id', $productIds)
                ->groupBy('product_id');

            $priceByProductId = DB::table('purchase_items as pi')
                ->joinSub($latestIds, 'latest', function ($join) {
                    $join->on('pi.id', '=', 'latest.max_id');
                })
                ->whereIn('pi.product_id', $productIds)
                ->select('pi.product_id', 'pi.net_unit_cost')
                ->get()
                ->keyBy('product_id');
        }

        $formattedProducts = $products->map(function ($product) use ($priceByProductId) {
            $row = $priceByProductId->get($product->id);
            $unitPrice = $row ? (float) $row->net_unit_cost : 0.0;

            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'stock' => $product->product_qty,
                'unit_price' => round($unitPrice, 2),
            ];
        });

        return response()->json($formattedProducts);
    }

    public function StoreQuotation(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            // Generate quotation number
            $lastQuotation = Quotation::orderBy('id', 'desc')->first();
            $nextId = $lastQuotation ? $lastQuotation->id + 1 : 1;
            $quotationNo = 'QTN-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $grandTotal = 0;

            $quotation = Quotation::create([
                'quotation_no' => $quotationNo,
                'tracking_no' => $request->tracking_no,
                'supplier_id' => $request->supplier_id ?? null,
                'quotation_date' => $request->date,
                'discount' => $request->discount ?? 0,
                'notes' => $request->notes,
                'grand_total' => 0,
                'created_by' => auth()->id(),
            ]);

            foreach ($request->products as $productId => $productData) {
                $product = Product::findOrFail($productId);
                $price = isset($productData['price']) ? (float) $productData['price'] : 0.0;
                $qty = isset($productData['quantity']) ? (int) $productData['quantity'] : 0;
                $total = round($price * $qty, 2);

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $productId,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $total,
                ]);

                $grandTotal += $total;
            }

            $quotation->update([
                'subtotal' => $grandTotal,
                'grand_total' => $grandTotal - ($request->discount ?? 0),
            ]);

            DB::commit();

            $notification = array(
                'message' => 'Quotation Stored Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.quotation')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }
    }

    public function EditQuotation($id)
    {
        $editData = Quotation::with(['quotationItems.product', 'supplier'])->findOrFail($id);
        $suppliers = Supplier::all();
        return view('admin.backend.quotation.edit_quotation', compact('editData', 'suppliers'));
    }

    public function UpdateQuotation(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $quotation = Quotation::findOrFail($id);

            $quotation->update([
                'tracking_no' => $request->tracking_no,
                'supplier_id' => $request->supplier_id ?? null,
                'quotation_date' => $request->date,
                'discount' => $request->discount ?? 0,
                'notes' => $request->notes,
            ]);

            // Delete old items
            QuotationItem::where('quotation_id', $quotation->id)->delete();

            $grandTotal = 0;

            foreach ($request->products as $productId => $productData) {
                $product = Product::findOrFail($productId);
                $price = isset($productData['price']) ? (float) $productData['price'] : 0.0;
                $qty = isset($productData['quantity']) ? (int) $productData['quantity'] : 0;
                $total = round($price * $qty, 2);

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $productId,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $total,
                ]);

                $grandTotal += $total;
            }

            $quotation->update([
                'subtotal' => $grandTotal,
                'grand_total' => $grandTotal - ($request->discount ?? 0),
            ]);

            DB::commit();

            $notification = array(
                'message' => 'Quotation Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.quotation')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DetailsQuotation($id)
    {
        $quotation = Quotation::with(['supplier', 'createdBy', 'quotationItems.product'])
            ->findOrFail($id);
        return view('admin.backend.quotation.quotation_details', compact('quotation'));
    }

    public function InvoiceQuotation($id)
    {
        $quotation = Quotation::with(['supplier', 'createdBy', 'quotationItems.product'])
            ->findOrFail($id);

        $pdf = \Pdf::loadView('admin.backend.quotation.invoice_pdf', compact('quotation'));
        return $pdf->download('quotation_' . $id . '.pdf');
    }

    public function DeleteQuotation($id)
    {
        try {
            DB::beginTransaction();

            $quotation = Quotation::findOrFail($id);
            QuotationItem::where('quotation_id', $id)->delete();
            $quotation->delete();

            DB::commit();

            $notification = array(
                'message' => 'Quotation Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.quotation')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
