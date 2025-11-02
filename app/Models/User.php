<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\PosRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

        public function hasPermission($permission)
    {
        return $this->roles->flatMap->permissions->pluck('name')->contains($permission);
    }
    

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function salesuser()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }

    
    protected $fillable = [
        'username',
        'email',
        'phone',
        'is_enabled',
        'file',
        'password',
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
    ];






}
