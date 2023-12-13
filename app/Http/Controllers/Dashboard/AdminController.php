<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function message()
    {
        return [
            'name.required' => 'اسم المدير مطلوب',
            'name.string' => 'يجب ادخال اسم مدير صحيح',
            'name.min' => 'اسم المدير يجب ان بحتوى على اكثر من 3 احرف',
            'name.max' => 'اسم المدير يجب ان يحتوى على أقل من 30 حرفأ',
            'email.required' => 'البريد الالكتورنى مطلوب',
            'email.email' => 'يجب ادخال بريد الكتروني صحيح',
            'email.unique' => 'البريد الالكتروني هذا مضاف من قبل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'يجب توافق كلمتى المرور',
            'password.min' => 'كلمة المرور يجب ان تحتوى على أكثر من 8 أحرف',

        ];
    }

    public function index()
    {
        $admins = $this->user->where('role',1)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.admin.index',compact('admins','search','search_value'));
    }

    
    public function create()
    {
        return view('dashboard.admin.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ],$this->message());
        $this->user->create([
            'name'=>$request->name,
            'email' => $request->email,
            'role' => 1,
            'password' => Hash::make($request->password)
        ]);


        return redirect()->route('dashboard.admins.index')->with('message','تم اضافة بيانات المدير بنجاح');
    }

    

    public function search(Request $request)
    {
        $admins = $this->user->where('name','LIKE',$request->name.'%')->where('role',1)->latest()->paginate(10);
        $search = true;
        $search_value = $request->name;
        return view('dashboard.admin.index',compact('admins','search','search_value'));
    }



   
}
