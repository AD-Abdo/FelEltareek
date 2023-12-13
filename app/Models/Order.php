<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //0 waitig //1 inway //2 done //3 cancel
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone1',
        'phone2',
        'price',
        'ship',
        'bounce',
        'notes',
        'status',
        'done_date',
        'customer_id',
        'delivery_id',
        'user_create',
        'serial',
        'pay',
        'mortgee',
        'addCutomer',
        'created_at',
        'country'
    ];

    protected $casts = [
        'created_at'
    ];

    public function Customer()
    {
        return $this->belongsTo(Cutsomer::class,'customer_id');
    }

    public function Delivery()
    {
        return $this->belongsTo(Delivery::class,'delivery_id','id');
    }

    public function UserCreate()
    {
        return $this->belongsTo(User::class,'user_create','id');
    }
}
