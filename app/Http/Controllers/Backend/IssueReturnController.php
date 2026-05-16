<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Issue;
use App\Models\IssueItem;
use App\Models\IssueReturn;
use App\Models\IssueReturnItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class IssueReturnController extends Controller
{
    public function AllIssueReturn()
    {
        $allData = IssueReturn::with(['user', 'issue', 'semester'])
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.backend.issue-return.all_issue_return', compact('allData'));
    }

    public function AddIssueReturn()
    {
        $departments = Department::all();
        // Get issues that have products with qty > 0 (not fully returned)
        $issues = Issue::with(['user', 'department', 'semester'])
            ->whereHas('issueItems', function ($query) {
                $query->where('qty', '>', 0);
            })
            ->orderBy('date', 'desc')
            ->get();
        return view('admin.backend.issue-return.add_issue_return', compact('departments', 'issues'));
    }

    public function GetIssueProducts($issueId)
    {
        $issue = Issue::with([
            'user',
            'department',
            'semester',
            'issueItems.product.brand',
            'issueItems.product.category',
            'issueItems.product.subcategory'
        ])->findOrFail($issueId);

        $products = [];
        foreach ($issue->issueItems as $item) {
            $product = $item->product;
            if (!$product)
                continue;

            // qty in issue_items now represents remaining qty
            $remainingQty = $item->qty;

            if ($remainingQty <= 0)
                continue;

            $products[] = [
                'id' => $product->id,
                'issue_item_id' => $item->id,
                'name' => $product->name,
                'code' => $product->code,
                'brand' => $product->brand?->name ?? '-',
                'category' => $product->category?->category_name ?? '-',
                'subcategory' => $product->subcategory?->subcategory_name ?? '-',
                'issued_qty' => $item->qty,
                'remaining_qty' => $remainingQty,
                'current_stock' => $product->product_qty,
            ];
        }

        return response()->json([
            'issue' => [
                'id' => $issue->id,
                'date' => $issue->date,
                'tracking_no' => $issue->tracking_no,
                'user' => $issue->user?->name ?? '-',
                'department' => $issue->department?->name ?? '-',
                'semester' => $issue->semester?->name ?? '-',
            ],
            'products' => $products
        ]);
    }

    public function IssueProductSearch(Request $request)
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
            ->where('product_qty', '>', 0)
            ->with(['brand:id,name', 'category:id,category_name', 'subcategory:id,subcategory_name'])
            ->select('id', 'name', 'code', 'brand_id', 'category_id', 'subcategory_id', 'product_qty')
            ->limit(10)
            ->get();

        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'brand' => $product->brand?->name ?? '-',
                'category' => $product->category?->category_name ?? '-',
                'subcategory' => $product->subcategory?->subcategory_name ?? '-',
                'stock' => $product->product_qty,
            ];
        });

        return response()->json($formattedProducts);
    }

    public function StoreIssueReturn(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'issue_id' => 'required',
            'user_id' => 'required',
            'products' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $issue = Issue::findOrFail($request->issue_id);

            $issueReturn = IssueReturn::create([
                'return_date' => $request->date,
                'issue_id' => $request->issue_id,
                'semester_id' => $issue->semester_id,
                'user_id' => $request->user_id,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($request->products as $productId => $productData) {
                $product = Product::findOrFail($productId);
                $returnQty = $productData['quantity'];

                // Find issue_item by issue_id and product_id
                $issueItem = IssueItem::where('issue_id', $request->issue_id)
                    ->where('product_id', $productId)
                    ->first();

                // Create return item
                IssueReturnItem::create([
                    'issue_return_id' => $issueReturn->id,
                    'product_id' => $productId,
                    'qty' => $returnQty,
                    'condition' => $productData['condition'] ?? 'good',
                ]);

                // Decrease qty in issue_items
                if ($issueItem) {
                    $issueItem->decrement('qty', $returnQty);
                }

                // Increase product stock
                $product->increment('product_qty', $returnQty);
            }

            DB::commit();

            $notification = array(
                'message' => 'Issue Return Stored Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.issue.return')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }
    }

    public function EditIssueReturn($id)
    {
        $editData = IssueReturn::with(['issue', 'semester', 'issueReturnItems.product', 'issueReturnItems.issueItem'])
            ->findOrFail($id);
        $departments = Department::all();
        $issues = Issue::with(['user', 'department', 'semester'])->get();
        return view('admin.backend.issue-return.edit_issue_return', compact('editData', 'departments', 'issues'));
    }

    public function UpdateIssueReturn(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'issue_id' => 'required',
            'user_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $issueReturn = IssueReturn::findOrFail($id);
            $issue = Issue::findOrFail($request->issue_id);
            $oldReturnItems = IssueReturnItem::where('issue_return_id', $issueReturn->id)->get();

            // Reverse old stock changes and qty
            foreach ($oldReturnItems as $oldItem) {
                // Decrease product stock (reverse increment)
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->decrement('product_qty', $oldItem->qty);
                }

                // Reverse qty in issue_items - find by issue_id and product_id
                $issueItem = IssueItem::where('issue_id', $issueReturn->issue_id)
                    ->where('product_id', $oldItem->product_id)
                    ->first();
                if ($issueItem) {
                    $issueItem->increment('qty', $oldItem->qty);
                }
            }

            IssueReturnItem::where('issue_return_id', $issueReturn->id)->delete();

            $issueReturn->update([
                'return_date' => $request->date,
                'issue_id' => $request->issue_id,
                'semester_id' => $issue->semester_id,
                'user_id' => $request->user_id,
                'notes' => $request->notes,
            ]);

            foreach ($request->products as $productId => $productData) {
                $product = Product::findOrFail($productId);
                $returnQty = $productData['quantity'];

                // Find issue_item by issue_id and product_id
                $issueItem = IssueItem::where('issue_id', $request->issue_id)
                    ->where('product_id', $productId)
                    ->first();

                // Create new return item
                IssueReturnItem::create([
                    'issue_return_id' => $issueReturn->id,
                    'product_id' => $productId,
                    'qty' => $returnQty,
                    'condition' => $productData['condition'] ?? 'good',
                ]);

                // Decrease qty in issue_items
                if ($issueItem) {
                    $issueItem->decrement('qty', $returnQty);
                }

                // Increase product stock
                $product->increment('product_qty', $returnQty);
            }

            DB::commit();

            $notification = array(
                'message' => 'Issue Return Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.issue.return')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DetailsIssueReturn($id)
    {
        $issueReturn = IssueReturn::with([
            'issue',
            'user',
            'createdBy',
            'semester',
            'issueReturnItems.product',
            'issueReturnItems.issueItem'
        ])->findOrFail($id);

        return view('admin.backend.issue-return.issue_return_details', compact('issueReturn'));
    }

    public function InvoiceIssueReturn($id)
    {
        $issueReturn = IssueReturn::with([
            'issue',
            'user',
            'createdBy',
            'semester',
            'issueReturnItems.product'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.backend.issue-return.invoice_pdf', compact('issueReturn'));
        return $pdf->download('issue_return_' . $id . '.pdf');
    }

    public function DeleteIssueReturn($id)
    {
        try {
            DB::beginTransaction();

            $issueReturn = IssueReturn::findOrFail($id);
            $returnItems = IssueReturnItem::where('issue_return_id', $id)->get();

            foreach ($returnItems as $item) {
                // Decrease product stock (reverse increment)
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty', $item->qty);
                }

                // Reverse qty in issue_items - find by issue_id and product_id
                $issueItem = IssueItem::where('issue_id', $issueReturn->issue_id)
                    ->where('product_id', $item->product_id)
                    ->first();
                if ($issueItem) {
                    $issueItem->increment('qty', $item->qty);
                }
            }

            IssueReturnItem::where('issue_return_id', $id)->delete();
            $issueReturn->delete();

            DB::commit();

            $notification = array(
                'message' => 'Issue Return Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.issue.return')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
