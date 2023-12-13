<?php

namespace App\Http\Controllers;

use App\Models\Cutsomer;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $orders = Order::where('addCutomer',0)->count();
        $customers = Cutsomer::count();
        return view('index',compact('orders','customers'));
    }
}
