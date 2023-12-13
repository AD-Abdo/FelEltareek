<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutsomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone1',
        'phone2',
        'address',
        'user_id',
        'user_create'
    ];

    protected $casts = [
        'created_at'
    ];

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function UserCreate()
    {
        return $this->belongsTo(User::class,'user_create','id');
    }
}
