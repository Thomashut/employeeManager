<?php

namespace App\Http\Controllers\WebControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UnitsOfWork\Interfaces\IEmployeeUOW;
use App\UnitsOfWork\Interfaces\IDepartmentUOW;

use Illuminate\View\View;

/**
 * Will handle the requests and responses for Employees on the web route group
 */
class EmployeeController extends Controller
{
    protected IEmployeeUOW $eUOW;
    protected IDepartmentUOW $dUOW;

    public function __construct(IEmployeeUOW $eUOW, IDepartmentUOW $dUOW) 
    {
        $this->eUOW = $eUOW;
        $this->dUOW = $dUOW;
    }

    public function index(Request $request) : View
    {
        $employees = $this->eUOW->indexEmployees();

        return view('employees.list', ['employees' => $employees]);
    }

    public function create(Request $request) : View
    {
        $departments = $this->dUOW->indexDepartments();
        return view('employees.form', ['departments' => $departments]);
    }

    public function edit(string $id, Request $request) : View
    {
        $departments = $this->dUOW->indexDepartments();
        $employee = $this->eUOW->showEmployee($id);
        if(is_null($employee)) return view('employees.list', ['message' => "Employee Not Found"]);

        return view('employees.form', ['employee' => $employee, 'department' => $departments]);
    }

    public function store(Request $request) : View
    {
        $employee = $this->eUOW->storeEmployee();
        if(is_null($employee)) 
            return view('employees.form', 
            [
                'departments' => $this->dUOW->indexDepartments(),
                'errors' => $request->request_result_error
            ]);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => "Employee Saved Successfully"
        ]);
    }

    public function update(string $id, Request $request) : View
    {
        $employee = $this->eUOW->updateEmployee($id);
        if(is_null($employee)) 
            return view('employees.form', 
            [
                'departments' => $this->dUOW->indexDepartments(),
                'errors' => $request->request_result_error
            ]);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => "Employee Saved Successfully"
        ]);
    }

    public function destroy(string $id, Request $request) : View
    {
        $check = $this->eUOW->destroyEmployee($id);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => $check ? 
            'Employee Deleted Successfully' : 
            'Failed to Delete Employee'
        ]);
    }

    public function restore(string $id, Request $request) : View
    {
        $check = $this->eUOW->destroyEmployee($id);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => $check ? 
            'Employee Restored Successfully' : 
            'Failed to Restore Employee'
        ]);
    }
}
