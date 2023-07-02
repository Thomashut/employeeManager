<?php

namespace App\UnitsOfWork\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Department;

interface IDepartmentUOW
{
    public function indexDepartments() : LengthAwarePaginator;
    public function indexRestoreDepartments() : LengthAwarePaginator;
    public function showDepartment(string $id) : ?Department;
    public function storeDepartment(?array $payload = null) : ?Department;
    public function updateDepartment(string $id, ?array $payload = null) : ?Department;
    public function destroyDepartment(string $id) : bool;
    public function restoreDepartment(string $id) : bool;
}