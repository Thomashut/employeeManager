<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Employee;

/**
 * Department represents a selection of employees.
 * Each department may have many employees assigned to it.
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "id";
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = ['active' => 'boolean'];
    protected $fillable =
    [
        'name',
        'description',
        'active'
    ];
    protected $attributes =
    [
        'active' => true
    ];

    // Model Functions

    /**
     * Accepts an array containing data. Will store in self and perist to database.
     * @param array $payload ['name', 'description', 'active']
     * @return ?Department
     */
    public function storeDepartment(array $payload) : ?Department
    {
        $request = request();
        try {
            $this->name = $payload['name'] ?? null;
            $this->description = $payload['description'] ?? null;
            $this->active = $payload['active'] ?? true;

            $this->save();
            return $this;
        } catch (\Exception $e) {
            $request->merge(['request_result_error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Accepts an array containing data. Will update self and perist to database
     * @param array $payload ['name', 'description', 'active']
     * @return ?Department
     */
    public function updateDepartment(array $payload) : ?Department
    {
        $request = request();
        try {
            $this->name = $payload['name'] ??
                $this->name;
            $this->description = $payload['description'] ??
                $this->description;
            $this->active = $payload['active'] ??
                $this->active;

            $this->save();
            return $this;
        } catch (\Exception $e) {
            $request->merge(['request_result_error' => $e->getMessage()]);
            return null;
        }
    }

    // Model Relations

    public function Employees() : array
    {
        return $this->hasMany('App\Models\Employee', 'department_id', 'id');
    }
}
