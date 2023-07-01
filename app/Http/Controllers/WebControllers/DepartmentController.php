<?php

namespace App\Http\Controllers\WebControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UnitsOfWork\Interfaces\IDepartmentUOW;

use Illuminate\View\View;

class DepartmentController extends Controller
{
    protected IDepartmentUOW $dUOW;

    public function __construct(IDepartmentUOW $dUOW) 
    {
        $this->dUOW = $dUOW;
    }

    public function index(Request $request) : View
    {
        $departments = $this->dUOW->indexDepartments();

        return view('departments.list', ['departments' => $departments]);
    }

    public function create(Request $request) : View
    {
        $departments = $this->dUOW->indexDepartments();
        return view('departments.form', ['department' => null, 'edit' => false]);
    }

    public function edit(string $id, Request $request) : View
    {
        $department = $this->dUOW->showDepartment($id);
        if(is_null($department)) return view('departments.list', ['message' => "Department Not Found"]);

        return view('departments.form', ['department' => $department, 'edit' => true]);
    }

    public function store(Request $request) : View
    {
        $department = $this->dUOW->storeDepartment();
        if(is_null($department)) 
            return view('departments.form', 
            [
                'errors' => $request->request_result_error
            ]);
        return view('departments.list', [
            'departments' => $this->dUOW->indexDepartments(),
            'message' => "Department Saved Successfully"
        ]);
    }

    public function update(string $id, Request $request) : View
    {
        $department = $this->dUOW->updateDepartment($id);
        if(is_null($department)) 
            return view('departments.form', 
            [
                'errors' => $request->request_result_error
            ]);
        return view('departments.list', [
            'departments' => $this->dUOW->indexDepartments(),
            'message' => "Department Saved Successfully"
        ]);
    }

    public function destroy(string $id, Request $request) : View
    {
        $check = $this->dUOW->destroyDepartment($id);
        return view('departments.list', [
            'departments' => $this->dUOW->indexDepartments(),
            'message' => $check ? 
            'Department Deleted Successfully' : 
            'Failed to Delete Department'
        ]);
    }

    public function restore(string $id, Request $request) : View
    {
        $check = $this->dUOW->destroyDepartment($id);
        return view('departments.list', [
            'departments' => $this->dUOW->indexDepartments(),
            'message' => $check ? 
            'Department Restored Successfully' : 
            'Failed to Restore Department'
        ]);
    }
}
