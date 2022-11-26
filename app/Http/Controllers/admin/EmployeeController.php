<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('admin.employees', [
            'employees' => $employees
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string'],
            'lname' => ['required', 'string'],
            'natid' => ['required', 'string', 'max:15'],
            'sex' => ['required', 'string'],
            'phone' => ['required', 'digits:10', 'starts_with:07'],
            'address' => ['required', 'string']
        ]);

        try{
            $emp = new Employee();
            $emp->reference = rand(111111,999999);
            $emp->fname = $request->fname;
            $emp->lname = $request->lname;
            $emp->natid = $request->natid;
            $emp->sex = $request->sex;
            $emp->phone = $request->phone;
            $emp->address = $request->address;
            $emp->save();

            return redirect()->back()->with('success', 'Successfully added new employee');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'integer'],
            'fname' => ['required', 'string'],
            'lname' => ['required', 'string'],
            'natid' => ['required', 'string', 'max:15'],
            'sex' => ['required', 'string'],
            'phone' => ['required', 'digits:10', 'starts_with:07'],
            'address' => ['required', 'string']
        ]);

        try{
            $emp = Employee::find($request->employee_id);
            $emp->fname = $request->fname;
            $emp->lname = $request->lname;
            $emp->natid = $request->natid;
            $emp->sex = $request->sex;
            $emp->phone = $request->phone;
            $emp->address = $request->address;
            $emp->save();

            return redirect()->back()->with('success', 'Successfully updated employee');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'integer']
        ]);

        try{
            $emp = Employee::find($request->employee_id);

            $prof = Project::where('assigned_to', $emp->id)->first();
            if(is_null($prof))
            {
                $emp->delete();

                return redirect()->back()->with('success', 'Successfully deleted employee');
            }

            return redirect()->back()->with('error', 'Cannot delete employee at the moment');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', 'ERROR: '.$e->getMessage());
        }
    }
}
