<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'employee_id',
        'manager'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'manager' => 'boolean'
    ];

    // Model Functions

    public function storeUser(array $payload) : ?User
    {
        $request = request();
        try {
            $this->email = $payload['email'];
            $this->password = Hash::make($payload['password']);
            $this->employee_id = $payload['employee_id'];

            $this->save();
            return $this;
        } catch (\Exception $e) {
            $request->merge(['request_result_error' => $e->getMessage()]);
            return null;
        }
    }

    // Model Relations

    public function Employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
