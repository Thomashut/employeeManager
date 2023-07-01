<?php

namespace App\UnitsOfWork;

use App\UnitsOfWork\Interfaces\IDepartmentUOW;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Department;

const DEFAULTDEPARTMENTPERPAGE = 30;
class DepartmentUOW implements IDepartmentUOW
{
    protected Department $dep;

    public function __construct(Department $dep)
    {
        $this->dep = $dep;
    }

    /**
     * Returns a paginator listing all active and non deleted departments
     * @return LengthAwarePaginator
     */
    public function indexDepartments() : LengthAwarePaginator
    {
        $request = request();
        return $this->dep::where('active', true)->paginate(DEFAULTDEPARTMENTPERPAGE);
    }

    /**
     * Will return all departments which have been soft deleted
     *  @return LengthAwarePaginator
     */
    public function indexRestoreDepartments() : LengthAwarePaginator
    {
        $request = request();
        return $this->dep::withTrashed()->whereNotNull('deleted_at')->paginate(DEFAULTDEPARTMENTPERPAGE);
    }

    /**
     * Will load a departmen, eagerly loading it's employee relations too. Will return null if id is not valid or deleted
     * @param string $id
     * @return ?Department
     */
    public function showDepartment(string $id) : ?Department
    {
        return $this->dep::where('id', $id)->where('active', true)->with(['Employees'])->first();
    }

    /**
     * Will create and store a department 
     * @param ?array $payload - If null will use request body
     * @return ?Department
     */
    public function storeDepartment(?array $payload = null) : ?Department
    {
        $request = request();
        if(is_null($payload)) $payload = $request->all();
        return $this->dep->storeDepartment($payload);
    }
    
    /**
     * Will update an existing department
     * @param string $id
     * @param ?array $payload - If null will use request body
     * @return ?Department
     */
    public function updateDepartment(string $id, ?array $payload = null) : ?Department
    {
        $request = request();
        if(is_null($payload)) $payload = $request->all();
        $department = $this->dep::where('id', $id)->first();
        if(is_null($department)) {
            $request = request();
            $request->merge(['request_result_error' => 'department not found']);
            return null;
        }
        return $department->updateDepartment($payload);
    }
    
    /**
     * Will soft delete an existing department
     * @param string $id
     * @return bool - true if deleted sucessfully
     */
    public function destroyDepartment(string $id) : bool
    {
        $department = $this->dep::where('id', $id)->first();
        if(is_null($department)) {
            $request = request();
            $request->merge(['request_result_error' => 'department not found']);
            return false;
        }
        try {
            $department->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function restoreDepartment(string $id) : bool
    {
        $department = $this->dep::withTrashed()->where('id', $id)->first();
        if(is_null($department)) {
            $request = request();
            $request->merge(['request_result_error' => 'department not found']);
            return false;
        }
        try {
            $department->restore();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}