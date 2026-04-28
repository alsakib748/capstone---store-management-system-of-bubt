<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Issue;
use App\Models\IssueItem;
use App\Models\Product;
use App\Models\Semester;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    public function GetUsersByDepartment($department_id)
    {
        if (!$department_id) {
            return response()->json([]);
        }

        $users = User::where('department_id', $department_id)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    public function MyIssue()
    {
        $userId = auth()->id();
        $allData = Issue::with(['semester', 'user', 'issuedByUser'])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.backend.issue.my_issue', compact('allData'));
    }

    public function AllIssue()
    {
        $allData = Issue::with(['semester', 'user', 'issuedByUser'])->orderBy('id', 'desc')->get();
        return view('admin.backend.issue.all_issue', compact('allData'));
    }

    public function AddIssue()
    {
        $semesters = Semester::all();
        $users = User::all();
        $departments = Department::all();
        return view('admin.backend.issue.add_issue', compact('semesters', 'users', 'departments'));
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
                    ->orWhere('code', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->where('product_qty', '>', 0)
            ->with(['brand:id,name', 'category:id,category_name', 'subcategory:id,subcategory_name'])
            ->select('id', 'name', 'code', 'sku', 'brand_id', 'category_id', 'subcategory_id', 'product_qty')
            ->limit(10)
            ->get();

        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'sku' => $product->sku,
                'brand' => $product->brand?->name ?? '-',
                'category' => $product->category?->category_name ?? '-',
                'subcategory' => $product->subcategory?->subcategory_name ?? '-',
                'stock' => $product->product_qty,
            ];
        });

        return response()->json($formattedProducts);
    }

    public function StoreIssue(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'semester_id' => 'required',
            'user_id' => 'required',
            'department_id' => 'required',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $issue = Issue::create([
                'date' => $request->date,
                'user_id' => $request->user_id,
                'issued_by' => auth()->id(),
                'semester_id' => $request->semester_id,
                'department_id' => $request->department_id,
                'notes' => $request->notes,
            ]);

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);

                $requestedQty = $productData['quantity'];
                if ($product->product_qty < $requestedQty) {
                    throw new \Exception("Insufficient stock for product: {$product->name}. Available: {$product->product_qty}");
                }

                IssueItem::create([
                    'issue_id' => $issue->id,
                    'product_id' => $productData['id'],
                    'qty' => $requestedQty,
                ]);

                $product->decrement('product_qty', $requestedQty);
            }

            DB::commit();

            $notification = array(
                'message' => 'Issue Stored Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.issue')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }
    }

    public function EditIssue($id)
    {
        $editData = Issue::with(['issueItems.product', 'user'])->findOrFail($id);
        $semesters = Semester::all();
        $users = User::all();
        $departments = Department::all();
        return view('admin.backend.issue.edit_issue', compact('editData', 'semesters', 'users', 'departments'));
    }

    public function UpdateIssue(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'semester_id' => 'required',
            'user_id' => 'required',
            'department_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $issue = Issue::findOrFail($id);

            $issue->update([
                'date' => $request->date,
                'user_id' => $request->user_id,
                'semester_id' => $request->semester_id,
                'department_id' => $request->department_id,
                'notes' => $request->notes,
            ]);

            $oldIssueItems = IssueItem::where('issue_id', $issue->id)->get();

            foreach ($oldIssueItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->increment('product_qty', $oldItem->qty);
                }
            }

            IssueItem::where('issue_id', $issue->id)->delete();

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);

                $requestedQty = $productData['quantity'];
                if ($product->product_qty < $requestedQty) {
                    throw new \Exception("Insufficient stock for product: {$product->name}. Available: {$product->product_qty}");
                }

                IssueItem::create([
                    'issue_id' => $issue->id,
                    'product_id' => $productData['id'],
                    'qty' => $requestedQty,
                ]);

                if ($product) {
                    $product->decrement('product_qty', $requestedQty);
                }
            }

            DB::commit();

            $notification = array(
                'message' => 'Issue Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.issue')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DetailsIssue($id)
    {
        $issue = Issue::with(['user', 'semester', 'department', 'issuedByUser', 'issueItems.product'])->find($id);
        return view('admin.backend.issue.issue_details', compact('issue'));
    }

    public function InvoiceIssue($id)
    {
        $issue = Issue::with(['user', 'semester', 'department', 'issuedByUser', 'issueItems.product'])->find($id);

        $pdf = Pdf::loadView('admin.backend.issue.invoice_pdf', compact('issue'));
        return $pdf->download('issue_' . $id . '.pdf');
    }

    public function DeleteIssue($id)
    {
        try {
            DB::beginTransaction();
            $issue = Issue::findOrFail($id);
            $issueItems = IssueItem::where('issue_id', $id)->get();

            foreach ($issueItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('product_qty', $item->qty);
                }
            }
            IssueItem::where('issue_id', $id)->delete();
            $issue->delete();
            DB::commit();

            $notification = array(
                'message' => 'Issue Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.issue')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}