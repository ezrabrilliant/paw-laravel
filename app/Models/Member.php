<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $table = 'member';
    protected $primaryKey = 'member_id';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'nomor_telepon',
        'email',
        'password',
        'admin_access',
        'driver_access',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
