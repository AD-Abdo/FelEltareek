<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cutsomer;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public $user;
    public $delivery;
    public $customer;
    public $order;

    public function __construct()
    {
        $this->user = new User();
        $this->delivery = new Delivery();
        $this->customer = new Cutsomer();
        $this->order = new Order();
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

    public function index($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
        $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }

    public function pendding()
    {
        $orders = $this->order->where('addCutomer',1)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
        $search_name = null;
        $search_phone = null;
        return view('dashboard.order.pendding',compact('orders','search','search_value','search_valueTo','search_name','search_phone'));
    }
    
    public function penddingDelete(Request $request)
    {
        $order = $this->order->find($request->id);
        if($order == null){
            return redirect()->route('dashboard.orders.pendding')->with('message','لم يتم العثور على بيانات الطلب');
        }

        $order->delete();
        return redirect()->route('dashboard.orders.pendding')->with('message','تم حذف بيانات الطلب بنجاح');
    }

    public function setPenddingPriceCreate($id,Request $request)
    {
        $order = $this->order->where('id',$id)->first();
        return view('dashboard.order.pendding_salary',compact('order'));


    }
    public function setPenddingPrice($id,Request $request)
    {
        
        $order = $this->order->where('id',$id)->first();
        if($order == null){
            return response()->json(['data'=>'لم يتم العثور على بيانات الطلب','status'=>true])->setStatusCode(200);
        }
        $request->validate([
            'ship' => 'required',

        ],$this->message());

        
       
        
    
        
        
        $order->update([
            'ship' => $request->ship ,
            'addCutomer' => 0,
            'created_at' => now()
        ]);
        return redirect()->route('dashboard.orders.pendding')->with('message','تم اضافة الطلب بنجاح');

    }
    public function waiting($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',0)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    public function onWay($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',1)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    public function completed($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',2)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    public function customerCancel($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',3)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    public function adminCancel($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',4)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    public function adminPay($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',5)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    
    public function adminAmoutShipping($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',7)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    
    public function orderCancel($customer)
    {
        $orders = $this->order->where('addCutomer',0)->where('customer_id',$customer)->where('status',6)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_valueTo = null;
         $search_name = null;
        $search_phone = null;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = null;
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_name','search_phone','customer','search_phoneNumber'));
    }
    
    
    public function setOrderCancel($id)
    {
        $order = $this->order->find($id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على ببانات الطلب');
        }
       
        $order->update([
            'bounce' => 0,
            'price' => 0,
            'status' => 6,
            'ship' => 0,
            'done_date' => now(),
            'mortgee' => now()
        ]);
        return redirect()->back()->with('message','تم تعديل حالة الطلب الى المرتجع');
    }
    
    public function amoutShipping($id)
    {
        $order = $this->order->find($id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على ببانات الطلب');
        }
        $order->update([
            'status' => 7,
        ]);
        
        return redirect()->route('dashboard.orders.index',$order->customer_id)->with('message','تم تعديل حالة الطلب بمرحلة المرتجع الجزئي  ');
    }


    public function show($customer,$id)
    {
        $order = $this->order->where('customer_id',$customer)->where('id',$id)->first();
        if($order == null){
            return redirect()->route('dashboard.orders.index')->with('message','لم يتم العثور على بيانات الطلب');
        }
        $status = $order->status;
        $deliverys = $this->delivery->get();
        $customers = $this->customer->get();
        $customer = $this->customer->find($customer);
        return view('dashboard.order.show',compact('order','deliverys','customers','customer','status'));
    }
    public function edit($customer,$id)
    {
        $order = $this->order->where('customer_id',$customer)->where('id',$id)->first();
        
        if($order == null){
            return redirect()->route('dashboard.orders.index')->with('message','لم يتم العثور على بيانات الطلب');
        }
        $deliverys = $this->delivery->get();
        $customers = $this->customer->get();
        $customer = $this->customer->find($customer);
        return view('dashboard.order.edit',compact('order','deliverys','customers','customer'));
    }

    public function delivery($customer,$id)
    {
        $order = $this->order->where('customer_id',$customer)->where('id',$id)->first();
        
        if($order == null){
            $customer = $this->customer->find($customer);
            return redirect()->route('dashboard.orders.index',$customer)->with('message','لم يتم العثور على بيانات الطلب');
        }
        $deliverys = $this->delivery->get();
        $customer = $this->customer->find($customer);
        return view('dashboard.order.delivery',compact('order','deliverys','customer'));
    }

    public function create($customer)
    {
        $deliverys = $this->delivery->get();
        $customer = $this->customer->find($customer);
        return view('dashboard.order.create',compact('deliverys','customer'));
    }

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'phone1' => 'nullable|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable',
            'address' => 'nullable|min:1',
            'price' => 'required|numeric',
            'ship' => 'required|numeric',
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
            'country' => $request->country,
            'address' => $address,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'price' => $request->price,
            'ship' => $request->ship,
            'status' => 0,
            'serial' => $serial,
            'customer_id' => $request->customer_id,
            'user_create' => auth()->user()->id
        ]);
        return response()->json(['data'=>'تم اضافة بيانات الطلب  بنجاح','status'=>true])->setStatusCode(200);
    }


    public function setDelivey($customer,$id,Request $request)
    {
        
        $order = $this->order->where('customer_id',$customer)->where('id',$id)->first();
        if($order == null){
            return response()->json(['data'=>'لم يتم العثور على بيانات الطلب','status'=>true])->setStatusCode(200);
        }
        $validator = Validator::make($request->all(),[
            'delivery_id' => 'required',

        ],$this->message());

        if($validator->fails()){
            return response()->json(['data'=>$validator->errors(),'status'=>false])->setStatusCode(200);
        }
       
        
       

        if($order->delivery_id == $request->delivery_id || $request->delivery_id == null ){
            return response()->json(['data'=>'لم يتم اضافة / تعديل مندوب للطلب لعدم التغيير فى البيانات','status'=>true])->setStatusCode(200);
        }

        
        
        $order->update([
            'delivery_id' => $request->delivery_id ,
            'user_create' => Auth::user()->id
        ]);
        $customer = $this->customer->find($customer);
        return response()->json(['data'=>'تم اضافة / تعديل مندوب للطلب','status'=>true])->setStatusCode(200);
    }

    public function update($customer,$id,Request $request)
    {
        $order = $this->order->where('customer_id',$customer)->where('id',$id)->first();
        if($order == null){
            return response()->json(['data'=>'لم يتم العثور على بيانات الطلب','status'=>true])->setStatusCode(200);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'phone1' => 'nullable|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable',
            'address' => 'nullable|min:1',
            'price' => 'required|numeric',
            'ship' => 'required|numeric',
            'country' => 'required'

        ],$this->message());

        if($validator->fails()){
            return response()->json(['data'=>$validator->errors(),'status'=>false])->setStatusCode(200);
        }
       


        if($order->name == $request->name && $order->address == $request->address && $order->phone1 == $request->phone1 &&
        $order->phone2 == $request->phone2 && $order->price == $request->price && $order->ship == $request->ship ){
            return response()->json(['data'=>'لم يتم تعديل بيانات الطلب لعدم التغيير فى البيانات','status'=>true])->setStatusCode(200);

        }

        $request->name != null ? $name = $request->name : $name = $order->name;
        $request->address != null ? $address = $request->address : $address = $order->address;
        $request->phone1 != null ? $phone1 = $request->phone1 : $phone1 = $order->phone1;
        $request->phone2 != null ? $phone2 = $request->phone2 : $phone2 = $order->phone2;
        $request->price != null ? $price = $request->price : $price = $order->price;
        $request->ship != null ? $ship = $request->ship : $ship = $order->ship;
        $request->country != null ? $country = $request->country : $country = $order->country;

        $order->update([
            'name' => $name,
            'country' => $country,
            'address' => $address,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'price' => $price,
            'ship' => $ship,
            'user_create' => Auth::user()->id
        ]);
        return response()->json(['data'=>'تم تعديل بيانات الطلب بنجاح','status'=>true])->setStatusCode(200);
    }

    public function search($customer,Request $request)
    {
        
        $search = true;
        $search_value = $request->name;
        $search_valueTo = $request->nameTo;
        $search_name = $request->customer;
        $search_phone = $request->phone;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = $request->phoneNumber;

        
        $query =  $this->order;
        if($request->name != null && $request->nameTo ){
            $query = $query->whereDate('done_date', '>=', $request->name)
                        ->whereDate('done_date', '<=', $request->nameTo);
        }
        else{
            if($request->name != null ){
                $query = $query->whereDate('done_date',$request->name);
            }
            if($request->nameTo ){
                $query = $query->whereDate('done_date',$request->nameTo);
            }
        }
        if($request->customer != null ){
             $query = $query->where('name','LIKE','%'.$request->customer.'%');
        }
        if($request->phone != null ){
             $query = $query->where('phone2','LIKE','%'.$request->phone.'%');
        }
        if($request->phoneNumber != null){
            $query = $query->where('phone1',"like","%".$request->phoneNumber."%");
        }
       
        
        
        $orders = $query->where('customer_id',$customer->id)->latest()->paginate(500);
        
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_phone','search_name','customer','search_phoneNumber'));
    }
    
    public function pay($customer,Request $request)
    {

        $search = true;
        $search_value = $request->name;
        $search_valueTo = $request->nameTo;
        $search_name = $request->customer;
        $search_phone = $request->phone;
        $customer = $this->customer->find($customer);
        $search_phoneNumber = $request->phoneNumber;
        
        $order =  $this->order;
        
        if($request->name != null && $request->nameTo ){
            $query = $order->whereDate('done_date', '>=', $request->name)
                        ->whereDate('done_date', '<=', $request->nameTo);
        }
        else{
            if($request->name != null ){
                $query = $order->whereDate('done_date',$request->name);
            }
            if($request->nameTo ){
                $query = $order->whereDate('done_date',$request->nameTo);
            }
        }
        if($request->customer != null ){
             $query = $order->where('name','LIKE','%'.$request->customer.'%');
        }
        if($request->phone != null ){
             $query = $order->where('phone2','LIKE','%'.$request->phone.'%');
        }
        if($request->name != null && $request->customer != null && $request->phone != null ){
            $query = $order;
        }
        
        $orders_data = $query->where('customer_id',$customer->id)->latest()->get();
        foreach($orders_data as $order){
            if($order->status == 2){
                $order->update([
                   'status' => 5 ,
                   'pay' => now()
                ]);
            }
        }
        
        $orders = $query->where('customer_id',$customer->id)->latest()->paginate(500);
        
        return view('dashboard.order.index',compact('orders','search','search_value','search_valueTo','search_phone','search_name','customer','search_phoneNumber'))->with('message','تم الدفع بنجاح');
    }

    public function destroy(Request $request)
    {
        $order = $this->order->find($request->id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على بيانات الطلب');
        }

        $order->delete();
        return redirect()->back()->with('message','تم حذف بيانات الطلب بنجاح');
    }

}
