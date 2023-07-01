<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;

use App\Models\Department;
use App\Models\User;

/**
 * Employee represents a individual working at the company.
 * This model will capture their data related to the person.
 * Employees may be allocated to a single department at a time. 
 */
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "id";
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'dob'];
    protected $casts = 
    [
        'dob' => 'date',
        'active' => 'boolean'
    ];
    protected $fillable = 
    [
        'firstname',
        'surname',
        'dob',
        'status',
        'active'
    ];
    protected $attributes = 
    [
        'status' => 0,
        'active' => true
    ];

    // Model Functions

    /**
     * Accepts array containing data. Stores data in self and perists to database
     * @param array $payload ['firstname', 'surname', 'dob', 'status', 'active', 'department_id']
     * @return ?Employee 
     */
    public function storeEmployee(array $payload) : ?Employee
    {
        $request = request();
        try {
            $this->firstname = $payload['firstname'] ?? null;
            $this->surname = $payload['surname'] ?? null;
            $this->dob = $payload['dob'] ?? null;
            $this->status = $payload['status'] ?? 0;
            $this->active = $payload['active'] ?? true;
            $this->contact_email = $payload['contact_email'] ?? null;
            $this->contact_phone = $payload['contact_phone'] ?? null;
            $this->contact_address = $payload['contact_address'] ?? null;

            $this->department_id = $payload['department_id'] ?? null;

            $this->save();
            return $this;
        } catch (\Exception $e) {
            $request->merge(['request_result_error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Accepts array containing data. Updates data in self and perists to database
     * @param array $payload ['firstname', 'surname', 'dob', 'status', 'active', 'department_id']
     * @return ?Employee 
     */
    public function updateEmployee(array $payload) : ?Employee
    {
        $request = request();
        try {
            $this->firstname = $payload['firstname'] ??
                $this->firstname;
            $this->surname = $payload['surname'] ??
                $this->surname;
            $this->dob = $payload['dob'] ??
                $this->dob;
            $this->status = $payload['status'] ??
                $this->status;
            $this->active = $payload['active'] ??
                $this->active;
            $this->contact_email = $payload['contact_email'] ?? 
                $this->contact_email;
            $this->contact_phone = $payload['contact_phone'] ?? 
                $this->contact_phone;
            $this->contact_address = $payload['contact_address'] ?? 
                $this->contact_phone;

            $this->department_id = $payload['department_id'] 
                ?? $this->department_id;

            $this->save();
            return $this;
        } catch (\Exception $e) {
            $request->merge(['request_result_error' => $e->getMessage()]);
            return null;
        }
    }

    // Model Relations

    public function Department() : BelongsTo
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function User() : hasOne
    {
        return $this->hasOne('App\Models\User', 'employee_id', 'id');
    }
}
