<?php

namespace App\Http\Controllers\WebControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UnitsOfWork\Interfaces\IEmployeeUOW;
use App\UnitsOfWork\Interfaces\IDepartmentUOW;

use Illuminate\View\View;

use Illuminate\Support\Facades\Gate;

/**
 * Will handle the requests and responses for Employees on the web route group
 */

const MANAGEREMPLOYEEACCESS = 'manager-access';
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
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $employees = $this->eUOW->indexEmployees();

        return view('employees.list', ['employees' => $employees]);
    }

    public function restoreIndex(Request $request) : View
    {
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $employees = $this->eUOW->indexRestoreEmployees();

        return view('employees.list', ['employees' => $employees, "restore" => true]);
    }

    public function create(Request $request) : View
    {
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $departments = $this->dUOW->indexDepartments();
        return view('employees.form', ['employee' => null, 'departments' => $departments, 'edit' => false]);
    }

    public function edit(string $id, Request $request) : View
    {
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $departments = $this->dUOW->indexDepartments();
        $employee = $this->eUOW->showEmployee($id);
        if(is_null($employee)) return view('employees.list', ['employees' => $this->eUOW->indexEmployees(), 'message' => "Employee Not Found"]);

        return view('employees.form', ['employee' => $employee, 'departments' => $departments, 'edit' => true]);
    }

    public function store(Request $request) : View
    {
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $employee = $this->eUOW->storeEmployee();
        if(is_null($employee)) 
            return view('employees.form', 
            [
                'employee' => (object) $request->all(),
                'edit' => false,
                'departments' => $this->dUOW->indexDepartments(),
                'message' => $request->request_result_error
            ]);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => "Employee Saved Successfully"
        ]);
    }

    public function update(string $id, Request $request) : View
    {
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $employee = $this->eUOW->updateEmployee($id);
        if(is_null($employee)) 
            return view('employees.form', 
            [
                'departments' => $this->dUOW->indexDepartments(),
                'message' => $request->request_result_error
            ]);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => "Employee Saved Successfully"
        ]);
    }

    public function destroy(string $id, Request $request) : View
    {
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
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
        if(! Gate::allows(MANAGEREMPLOYEEACCESS) ) abort(403);
        $check = $this->eUOW->restoreEmployee($id);
        return view('employees.list', [
            'employees' => $this->eUOW->indexEmployees(),
            'message' => $check ? 
            'Employee Restored Successfully' : 
            'Failed to Restore Employee'
        ]);
    }
}
