<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function AllDepartment()
    {
        $department = Department::orderBy('id', 'asc')->get();
        return view('admin.backend.department.all_department', compact('department'));
    }
    //End Method

    public function AddDepartment()
    {
        return view('admin.backend.department.add_department');
    }
    //End Method

    public function StoreDepartment(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:departments,name',
            'code' => 'required|min:2|max:2|unique:departments,code',
        ]);

        Department::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        $notification = array(
            'message' => 'Department Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.department')->with($notification);

    }
    //End Method

    public function EditDepartment($id)
    {
        $department = Department::find($id);
        return view('admin.backend.department.edit_department', compact('department'));
    }
    //End Method

    public function UpdateDepartment(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:departments,name,' . $request->id,
            'code' => 'required|min:2|max:2|unique:departments,code,' . $request->id,
        ]);

        $department_id = $request->id;

        Department::find($department_id)->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        $notification = array(
            'message' => 'Department Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.department')->with($notification);

    }
    //End Method

    public function DeleteDepartment($id)
    {
        Department::find($id)->delete();

        $notification = array(
            'message' => 'Department Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method
}
