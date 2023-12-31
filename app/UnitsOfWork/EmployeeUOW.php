<?php

namespace App\UnitsOfWork;

use App\UnitsOfWork\Interfaces\IEmployeeUOW;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Employee;
use App\Models\User;

const DEFAULTEMPLOYEEPERPAGE = 30;
class EmployeeUOW implements IEmployeeUOW
{
    protected Employee $employee;
    protected User $user;

    public function __construct(Employee $employee, User $user)
    {
        $this->employee = $employee;
        $this->user = $user;
    }

    /**
     * Returns a paginator listing all active and non deleted employees
     * @return LengthAwarePaginator
     */
    public function indexEmployees() : LengthAwarePaginator
    {
        $request = request();
        return $this->employee::where('active', true)->paginate(DEFAULTEMPLOYEEPERPAGE);
    }

    /**
     * Will return all employees linked to a given department
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function indexEmployeesForDepartment(string $id) : LengthAwarePaginator
    {
        return $this->employee::where('active', true)->whereHas('department', function(Builder $query) use ($id) {
            return $query->where('id', $id);
        })->paginate(DEFAULTEMPLOYEEPERPAGE);
    }

    /**
     * Will return all employees which have been soft deleted
     *  @return LengthAwarePaginator
     */
    public function indexRestoreEmployees() : LengthAwarePaginator
    {
        $request = request();
        return $this->employee::withTrashed()->whereNotNull('deleted_at')->paginate(DEFAULTEMPLOYEEPERPAGE);
    }

    /**
     * Will load a employeeartmen, eagerly loading it's employee relations too. Will return null if id is not valid or deleted
     * @param string $id
     * @return ?Employee
     */
    public function showEmployee(string $id) : ?Employee
    {
        return $this->employee::where('id', $id)->where('active', true)->with(['Department'])->first();
    }

    /**
     * Will create and store a employee 
     * @param ?array $payload - If null will use request body
     * @return ?Employee
     */
    public function storeEmployee(?array $payload = null) : ?Employee
    {
        $request = request();
        if(is_null($payload)) $payload = $request->all();

        $employee = $this->employee->storeEmployee($payload);
        if(is_null($employee)) return $employee;
        $payload['employee_id'] = $employee->id;
        $user = $this->user->storeUser($payload);
        if(is_null($user)) return null;

        return $employee;
    }
    
    /**
     * Will update an existing employee
     * @param string $id
     * @param ?array $payload - If null will use request body
     * @return ?Employee
     */
    public function updateEmployee(string $id, ?array $payload = null) : ?Employee
    {
        $request = request();
        if(is_null($payload)) $payload = $request->all();
        $employee = $this->employee::where('id', $id)->first();
        if(is_null($employee)) {
            $request = request();
            $request->merge(['request_result_error' => 'employee not found']);
            return null;
        }
        return $employee->updateEmployee($payload);
    }
    
    /**
     * Will soft delete an existing employee
     * @param string $id
     * @return bool - true if deleted sucessfully
     */
    public function destroyEmployee(string $id) : bool
    {
        $employee = $this->employee::where('id', $id)->first();
        if(is_null($employee)) {
            $request = request();
            $request->merge(['request_result_error' => 'employee not found']);
            return false;
        }
        try {
            $employee->delete();
            if(isset($employee->User) && !is_null($employee->user)) $employee->User->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function restoreEmployee(string $id) : bool
    {
        $employee = $this->employee::withTrashed()->where('id', $id)->first();
        if(is_null($employee)) {
            $request = request();
            $request->merge(['request_result_error' => 'employee not found']);
            return null;
        }
        try {
            $employee->restore();
            if(!is_null($employee->User()->withTrashed()->first())) $employee->User()->withTrashed()->first()->restore();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}