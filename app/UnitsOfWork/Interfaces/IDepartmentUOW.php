<?php

namespace App\UnitsOfWork\Interfaces;

use Illuminate\Database\Eloquent\LengthAwarePaginator;
use App\Models\Department;

interface IDepartmentUOW
{
    public function indexDepartments() : LengthAwarePaginator;
    public function indexRestoreDepartments() : LengthAwarePaginator;
    public function showDepartment(string $id) : ?Department;
    public function storeDepartment(?array $payload) : ?Department;
    public function updateDepartment(string $id, ?array $payload) : ?Department;
    public function destroyDepartment(string $id) : bool;
    public function restoreDepartment(string $id) : bool;
}