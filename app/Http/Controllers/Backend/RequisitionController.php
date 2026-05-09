<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Issue;
use App\Models\IssueItem;
use App\Models\Product;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Semester;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequisitionController extends Controller
{
    private function getRoleIdsForRequisitionUser(Request $request): array
    {
        $targetUserId = $request->input('user_id');

        // Only use target user if a valid user_id is provided (not empty)
        if (!empty($targetUserId)) {
            $targetUser = User::find($targetUserId);
            if ($targetUser) {
                return $targetUser->roles()->pluck('roles.id')->toArray();
            }
        }

        // Fall back to authenticated user's roles
        $authUser = $request->user();
        return $authUser ? $authUser->roles()->pluck('roles.id')->toArray() : [];
    }

    public function AllRequisition()
    {
        $allData = Requisition::with(['semester', 'user'])->orderBy('id', 'desc')->get();
        return view('admin.backend.requisition.all_requisition', compact('allData'));
    }
    // End Method

    public function MyRequisition()
    {
        $userId = auth()->id();
        $allData = Requisition::with(['semester', 'user'])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.backend.requisition.my_requisition', compact('allData'));
    }
    // End Method

    public function AddRequisition()
    {
        $semesters = Semester::all();
        $users = User::all();
        return view('admin.backend.requisition.add_requisition', compact('semesters', 'users'));
    }
    // End Method

    public function RequisitionProductSearch(Request $request)
    {
        $query = trim((string) $request->input('query', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $roleIds = $this->getRoleIdsForRequisitionUser($request);

        if (empty($roleIds)) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->whereHas('allowedRoles', function ($q) use ($roleIds) {
                $q->whereIn('roles.id', $roleIds);
            })
            ->with(['brand:id,name', 'category:id,category_name', 'subcategory:id,subcategory_name'])
            ->select('id', 'name', 'code', 'sku', 'brand_id', 'category_id', 'subcategory_id')
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
            ];
        });

        return response()->json($formattedProducts);
    }
    // End Method

    // public function GetUsersByDepartment($department_id)
    // {
    //     if (!$department_id) {
    //         return response()->json([]);
    //     }

    //     $users = User::where('department_id', $department_id)
    //         ->select('id', 'name', 'email')
    //         ->orderBy('name')
    //         ->get();

    //     return response()->json($users);
    // }
    // End Method

    public function StoreRequisition(Request $request)
    {

        $request->validate([
            'date' => 'required|date',
            'semester_id' => 'required',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
        ]);

        try {

            DB::beginTransaction();
            $roleIds = $this->getRoleIdsForRequisitionUser($request);

            // Use authenticated user if no user_id provided
            $userId = $request->user_id ?? auth()->id();

            $requisition = Requisition::create([
                'date' => $request->date,
                'user_id' => $userId,
                'semester_id' => $request->semester_id,
                'notes' => $request->notes,
            ]);

            /// Store Requisition Items
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);

                $isAllowed = $product->allowedRoles()->whereIn('roles.id', $roleIds)->exists();
                if (!$isAllowed) {
                    throw new \Exception("You are not allowed to requisition product: {$product->name}");
                }

                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'product_id' => $productData['id'],
                    'qty' => $productData['quantity'],
                ]);

                $product->increment('product_qty', $productData['quantity']);
            }

            DB::commit();

            $notification = array(
                'message' => 'Requisition Stored Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.requisition')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }
    }
    // End Method


    public function EditRequisition($id)
    {
        $editData = Requisition::with(['requisitionItems.product', 'user'])->findOrFail($id);

        // Prevent editing if requisition is already issued
        if ($editData->status === 'issued') {
            $notification = array(
                'message' => 'Cannot edit an issued requisition.',
                'alert-type' => 'error'
            );
            return redirect()->route('all.requisition')->with($notification);
        }

        $semesters = Semester::all();
        $users = User::all();
        $departments = Department::all();
        return view('admin.backend.requisition.edit_requisition', compact('editData', 'semesters', 'users', 'departments'));
    }
    // End Method

    public function UpdateRequisition(Request $request, $id)
    {

        $request->validate([
            'date' => 'required|date',
        ]);

        $action = $request->input('action', 'update');

        DB::beginTransaction();

        try {

            $requisition = Requisition::findOrFail($id);

            // Prevent updating if requisition is already issued
            if ($requisition->status === 'issued') {
                throw new \Exception('Cannot update an issued requisition.');
            }

            $roleIds = $this->getRoleIdsForRequisitionUser($request);

            // Keep the original user_id - never change it
            $originalUserId = $requisition->user_id;

            $requisition->update([
                'date' => $request->date,
                'user_id' => $originalUserId,
                'semester_id' => $request->semester_id,
                'notes' => $request->notes,
            ]);


            // If action is 'issue', create Issue record WITHOUT modifying requisition
            if ($action === 'issue') {
                // Create Issue record
                $issue = Issue::create([
                    'date' => date('Y-m-d'),
                    'requisition_id' => $requisition->id,
                    'user_id' => $requisition->user_id,
                    'issued_by' => auth()->id(),
                    'semester_id' => $requisition->semester_id,
                    'department_id' => $requisition->department_id,
                    'notes' => $requisition->notes,
                ]);

                // Create Issue Items from the adjusted quantities in the request
                foreach ($request->products as $product_id => $productData) {
                    $qty = intval($productData['quantity']);

                    // Create issue item even for qty 0
                    IssueItem::create([
                        'issue_id' => $issue->id,
                        'product_id' => $product_id,
                        'qty' => $qty,
                    ]);

                    // Decrement product stock only if qty > 0
                    if ($qty > 0) {
                        $product = Product::find($product_id);
                        if ($product) {
                            $product->decrement('product_qty', $qty);
                        }
                    }
                }

                // Update requisition status to issued
                $requisition->update(['status' => 'issued']);

                DB::commit();

                $notification = array(
                    'message' => 'Requisition Issued Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('all.requisition')->with($notification);
            }

            // Normal update (not issuing) - modify requisition table
            /// Get Old Purchase Items
            $oldRequisitionItems = RequisitionItem::where('requisition_id', $requisition->id)->get();

            /// Loop for old purchase items and decrement product qty
            foreach ($oldRequisitionItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->decrement('product_qty', $oldItem->qty);
                }
            }

            /// Delete old Purchase Items
            RequisitionItem::where('requisition_id', $requisition->id)->delete();

            // loop for new products and insert new purchase items
            foreach ($request->products as $product_id => $productData) {
                $product = Product::findOrFail($product_id);

                $isAllowed = $product->allowedRoles()->whereIn('roles.id', $roleIds)->exists();
                if (!$isAllowed) {
                    throw new \Exception("You are not allowed to requisition product: {$product->name}");
                }

                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'product_id' => $product_id,
                    'qty' => $productData['quantity'],
                ]);

                /// Update product stock by incrementing new quantity
                if ($product) {
                    $product->increment('product_qty', $productData['quantity']);
                }
            }

            DB::commit();

            $notification = array(
                'message' => 'Requisition Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.requisition')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // End Method

    public function DetailsRequisition($id)
    {
        $requisition = Requisition::with(['user', 'semester', 'requisitionItems.product', 'issue.issueItems.product', 'issue.issuedByUser'])->find($id);
        return view('admin.backend.requisition.requisition_details', compact('requisition'));

    }
    // End Method

    public function InvoiceRequisition($id)
    {
        $requisition = Requisition::with(['user', 'semester', 'requisitionItems.product'])->find($id);

        $pdf = Pdf::loadView('admin.backend.requisition.invoice_pdf', compact('requisition'));
        return $pdf->download('requisition_' . $id . '.pdf');

    }
    // End Method

    public function ViewRequisitionFile($id)
    {
        $requisition = Requisition::findOrFail($id);
        return response()->file(storage_path('app/private/' . $requisition->file_upload));
    }
    // End Method

    public function DeleteRequisition($id)
    {
        try {
            DB::beginTransaction();
            $requisition = Requisition::findOrFail($id);

            // Prevent deleting if requisition is already issued
            if ($requisition->status === 'issued') {
                $notification = array(
                    'message' => 'Cannot delete an issued requisition.',
                    'alert-type' => 'error'
                );
                return redirect()->route('all.requisition')->with($notification);
            }

            $requisitionItems = RequisitionItem::where('requisition_id', $id)->get();

            foreach ($requisitionItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty', $item->qty);
                }
            }
            RequisitionItem::where('requisition_id', $id)->delete();
            $requisition->delete();
            DB::commit();

            $notification = array(
                'message' => 'Requisition Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.requisition')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // End Method

    public function IssueRequisition(Request $request, $id)
    {
        $request->validate([
            'issue_date' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $requisition = Requisition::with('requisitionItems')->findOrFail($id);

            if ($requisition->status === 'issued') {
                throw new \Exception('This requisition has already been issued.');
            }

            // Create Issue record
            $issue = Issue::create([
                'date' => $request->issue_date,
                'requisition_id' => $requisition->id,
                'user_id' => $requisition->user_id,
                'issued_by' => auth()->id(),
                'semester_id' => $requisition->semester_id,
                'department_id' => $requisition->department_id,
                'notes' => $requisition->notes,
            ]);

            // Get adjusted quantities from request
            $items = $request->input('items', []);

            // Create Issue Items from Requisition Items with adjusted quantities
            foreach ($requisition->requisitionItems as $item) {
                $adjustedQty = isset($items[$item->id]) ? max(1, intval($items[$item->id])) : $item->qty;

                IssueItem::create([
                    'issue_id' => $issue->id,
                    'product_id' => $item->product_id,
                    'qty' => $adjustedQty,
                ]);

                // Decrement product stock when issued
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty', $adjustedQty);
                }
            }

            // Update requisition status to issued
            $requisition->update(['status' => 'issued']);

            DB::commit();

            $notification = array(
                'message' => 'Requisition Issued Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.requisition')->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    // End Method

}