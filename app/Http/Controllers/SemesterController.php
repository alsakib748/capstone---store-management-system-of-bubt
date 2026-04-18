<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function AllSemester()
    {
        $semester = Semester::orderBy('id', 'asc')->get();
        return view('admin.backend.semester.all_semester', compact('semester'));
    }
    //End Method

    public function AddSemester()
    {
        return view('admin.backend.semester.add_semester');
    }
    //End Method

    public function StoreSemester(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:semesters,name',
            'code' => 'required|min:3|max:3|unique:semesters,code',
        ]);

        Semester::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        $notification = array(
            'message' => 'Semester Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.semester')->with($notification);

    }
    //End Method

    public function EditSemester($id)
    {
        $semester = Semester::find($id);
        return view('admin.backend.semester.edit_semester', compact('semester'));
    }
    //End Method

    public function UpdateSemester(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:semesters,name,' . $request->id,
            'code' => 'required|min:3|max:3|unique:semesters,code,' . $request->id,
        ]);

        $semester_id = $request->id;

        Semester::find($semester_id)->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        $notification = array(
            'message' => 'Semester Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.semester')->with($notification);

    }
    //End Method

    public function DeleteSemester($id)
    {
        Semester::find($id)->delete();

        $notification = array(
            'message' => 'Semester Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method
}
