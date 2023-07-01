<?php

namespace App\UnitsOfWork\Interfaces;

use Illuminate\Database\Eloquent\LengthAwarePaginator;
use App\Models\Employee;

interface IEmployeeUOW
{
    public function indexEmployees() : LengthAwarePaginator;
    public function indexEmployeesForDepartment(string $id) : LengthAwarePaginator;
    public function indexRestoreEmployees() : LengthAwarePaginator;
    public function showEmployee(string $id) : ?Employee;
    public function storeEmployee(?array $payload) : ?Employee;
    public function updateEmployee(string $id, ?array $payload) : ?Employee;
    public function destroyEmployee(string $id) : bool;
    public function restoreEmployee(string $id) : bool;
}