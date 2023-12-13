<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image'
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function Delivery()
    {
        return $this->belongsTo(Delivery::class,'id','user_id');
    }

    public function Customer()
    {
        return $this->belongsTo(Cutsomer::class,'id','user_id');
    }
    
}
