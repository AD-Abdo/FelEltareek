<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public $order;
    public $user;

    public function  __construct()
    {
        $this->order = new Order();
        $this->user = new User();
    }

    public function message()
    {
        return [
            'name.required' => 'اسم المستخدم مطلوب',
            'name.string' => 'يجب ادخال اسم مدير صحيح',
            'name.min' => 'اسم المستخدم يجب ان بحتوى على اكثر من 3 احرف',
            'name.max' => 'اسم المستخدم يجب ان يحتوى على أقل من 30 حرفأ',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'يجب توافق كلمتى المرور',
            'password.min' => 'كلمة المرور يجب ان تحتوى على أكثر من 8 أحرف',

        ];
    }
    public function index()
    {
        $day_now =  Carbon::today()->toDateString();
        $pendding_Order = $this->order->where('addCutomer',1)->count();
        $today_added_order = $this->order->where('addCutomer',0)->whereDate('created_at',$day_now)->count();
        $today_finish_order = $this->order->where('addCutomer',0)->whereDate('done_date',$day_now)->count();
        $customer_added_today = $this->user->where('role',3)->whereDate('created_at',$day_now)->count();
        $admins_all = $this->user->where('role',1)->count();
        $delivery_all = $this->user->where('role',2)->count();
        $customer_all = $this->user->where('role',3)->count();

        //delivery
        $delivery_id  =  null;
        if(Auth::user()->Delivery !=null){
            $delivery_id = Auth::user()->Delivery->id;
        }
        $orders_delivery_all = $this->order->where('delivery_id',$delivery_id)->where('status',0)->whereDate('created_at',$day_now)->count();
        $orders_today_delivery = $this->order->where('delivery_id',$delivery_id)->where('status',2)->whereDate('done_date',$day_now)->count();
        $orders_today_delivery_all = $this->order->where('delivery_id',$delivery_id)->where('status',2)->count();

        $customer_id  =  null;
        if(Auth::user()->Customer !=null){
            $customer_id = Auth::user()->Customer->id;
        }
        $orders_customer_all = $this->order->where('customer_id',$customer_id)->where('status',0)->count();
        $orders_today_customer = $this->order->where('customer_id',$customer_id)->where('status',2)->whereDate('done_date',$day_now)->count();
        $orders_today_customer_all = $this->order->where('customer_id',$customer_id)->where('status',2)->count();
        return view('dashboard.index',compact('today_added_order','today_finish_order','customer_added_today','admins_all','delivery_all',
        'customer_all','orders_delivery_all','orders_today_delivery','orders_today_delivery_all','orders_customer_all',
        'orders_today_customer','orders_today_customer_all','pendding_Order'));
    }

    public function Profile()
    {
        return view('dashboard.profile');
    }

    public function ProfileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ],$this->message());
        $user = $this->user->find(Auth::user()->id);
        if($user-> name == $request->name){
            return redirect()->route('dashboard.profile')->with('message','لم يتم  تعديل البيانات الشخصية لعدم التغيير فى البيانات ');
        }
        $user->update([
            'name'=>$request->name,
        ]);


        return redirect()->route('dashboard.profile')->with('message','تم تعديل بيانات الصفحة الشخصية  بنجاح');
    }

    
    public function changePassword()
    {
        return view('dashboard.changePassword');
    }

    public function changePasswordUpdate(Request $request)
    {
        if($request->password == null){
            return redirect()->route('dashboard.changePassword')->with('message','لم يتم  تعديل كلمة المرور لعدم التغيير فى البيانات ');
        }
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ],$this->message());
        $user = $this->user->find(Auth::user()->id);
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);


        return redirect()->route('dashboard.changePassword')->with('message','تم تعديل بيانات كلمة المرور  بنجاح');
    }
    public function Logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
