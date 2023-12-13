<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cutsomer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerOrderController extends Controller
{
    public $user;
    public $customer;
    public $order;

    public function __construct()
    {
        $this->user = new User();
        $this->customer = new Cutsomer();
        $this->order = new Order();
    }
    public function index()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->whereIn('status',[0,1,2,3,4,5,6])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;
        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    public function create()
    {
        return view('dashboard.customer_order.create');
    }
    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    public function message()
    {
        return [
            'name.required' => 'اسم المستلم مطلوب',
            'name.string' => 'يجب ادخال اسم عميل صحيح',
            'name.min' => 'اسم المستلم يجب ان بحتوى على اكثر من 3 احرف',
            'name.max' => 'اسم المستلم يجب ان يحتوى على أقل من 30 حرفأ',
            'phone1.required' => 'رقم الهاتف مطلوب',
            'phone1.regex' => 'يجب ادخال رقم هاتف صحيح',
            'phone2.regex' => 'يجب ادخال رقم هاتف صحيح',
            'address.required' => 'عنوان العميل مطلوب',
            'address.min' => 'عنوان العميل يجب ان يحتوى على أكثر من 10 أحرف',
            'price.required' => 'سعر الطلب مطلوب',
            'price.numeric' => 'سعر الطلب يجب ان يحتوى على ارقام فقط',
            'ship.required' => 'سعر التوصيل مطلوب',
            'ship.numeric' => 'سعر التوصيل يجب ان يحتوى على ارقام فقط',
            'customer_id.required' => 'يجب اخيار العميل',
            'customer_id.integer' => 'نأسف عميل غير مسجل على النظام',
            'delivery_id.required' => 'يجب اخيار المندوب',
            'delivery_id.integer' => 'نأسف المندوب غير مسجل على النظام',
            'country.required' => 'يجب ادخال المحافظة',

        ];
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'phone1' => 'nullable|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable',
            'address' => 'nullable|min:1',
            'price' => 'required|numeric',
            'country' => 'required'

        ],$this->message());

        if($validator->fails()){
            return response()->json(['data'=>$validator->errors(),'status'=>false])->setStatusCode(200);
        }

       

        $serial = $this->generateRandomString();
        $serial_search = $this->order->where('serial',$serial)->first();
        if($serial_search != null){
            $serial = $this->generateRandomString();
            $serial_search = $this->order->where('serial',$serial)->first();
            if($serial_search != null){
                $serial = $this->generateRandomString();
                $serial_search = $this->order->where('serial',$serial)->first();
                if($serial_search != null){
                    $serial = $this->generateRandomString();
                    $serial_search = $this->order->where('serial',$serial)->first();
                }
            }
        }
        $request->has('address') ? $address = $request->address : $address = null; 
        $request->has('phone1') ? $phone1 = $request->phone1 : $phone1 = null; 
        $request->has('phone2') ? $phone2 = $request->phone2 : $phone2 = null; 
        $this->order->create([
            'name' => $request->name,
            'address' => $address,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'price' => $request->price,
            'ship' => 0,
            'status' => 0,
            'serial' => $serial,
            'customer_id' => $request->customer_id,
            'user_create' => auth()->user()->Customer->id,
            'addCutomer' => 1,
            'country' => $request->country,

        ]);
        return response()->json(['data'=>'تم اضافة بيانات الطلب  بنجاح','status'=>true])->setStatusCode(200);
    }

    
    public function search(Request $request)
    {
        $search = true;
        $search_value = $request->search_value;
        $search_phone = $request->search_phone;

        $query = $this->order->where('customer_id',Auth::user()->customer->id)->whereIn('status',[0,1,2,3,4,5,6]);

        if($search_value != null){
            $query = $query->where('name','LIKE','%'.$request->search_value.'%');
        }
        if($search_phone != null){
            $query = $query->where('phone1','LIKE','%'.$request->search_phone.'%');
        }
        $orders = $query->latest()->paginate(10);
        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    public function waiting()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->where('status',0)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;

        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    public function onWay()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->where('status',1)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;

        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    public function completed()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->where('status',2)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;

        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    
    public function pay()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->where('status',5)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;

        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    
    public function cancel()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->where('status',6)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;

        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }
    
    public function amount()
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',Auth::user()->customer->id)->where('status',7)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_phone = null;

        return view('dashboard.customer_order.index',compact('orders','search','search_value','search_phone'));
    }

    

    
    
}
