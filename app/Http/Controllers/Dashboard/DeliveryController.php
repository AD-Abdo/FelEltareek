<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeliveryController extends Controller
{
    public $user;
    public $order;
    public $delivery;

    public function __construct()
    {
        $this->user = new User();
        $this->order = new Order();
        $this->delivery = new Delivery();
    }

    public function message()
    {
        return [
            'name.required' => 'اسم المندوب مطلوب',
            'name.string' => 'يجب ادخال اسم دليفرى صحيح',
            'name.min' => 'اسم المندوب يجب ان بحتوى على اكثر من 3 احرف',
            'name.max' => 'اسم المندوب يجب ان يحتوى على أقل من 30 حرفأ',
            'email.required' => 'البريد الالكتورنى مطلوب',
            'email.email' => 'يجب ادخال بريد الكتروني صحيح',
            'email.unique' => 'البريد الالكتروني هذا مضاف من قبل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'يجب توافق كلمتى المرور',
            'password.min' => 'كلمة المرور يجب ان تحتوى على أكثر من 8 أحرف',
            'phone1.required' => 'رقم الهاتف مطلوب',
            'phone1.regex' => 'يجب ادخال رقم هاتف صحيح',
            'phone2.regex' => 'يجب ادخال رقم هاتف صحيح',

        ];
    }

    public function index()
    {
        $deliverys = $this->delivery->latest()->paginate(10);
        $search = false;
        $search_value = null;
        
        return view('dashboard.delivery.index',compact('deliverys','search','search_value'));
    }

    public function orders($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('delivery_id',$id)->whereIn('status',[0,1,2,3,5])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_name = null;
        $search_phone = null;
        $search_address = null;
        $printing = false;
        return view('dashboard.delivery.orders',compact('delivery','orders','search','search_value','search_name','search_phone','search_address','printing'));
    }
    
    public function searchOrder($id,Request $request)
    {
        
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        
        
        
        $search = true;
        $search_value = $request->date;
        $search_name = $request->name;
        $search_phone = $request->phone;
        $search_address = $request->address;
        
        $order = $this->order;
        if($request->date != null){
            $query = $order->whereDate('done_date',$request->date);
        }
        if($request->name != null){
            $query = $order->where('name',"like","%".$request->name."%");
        }
        if($request->address != null){
            $query = $order->where('address',"like","%".$request->address."%");
        }
        if($request->phone != null){
            $query = $order->where('phone2',$request->phone);
        }
        
        
        
        $orders = $query->where('delivery_id',$id)->whereIn('status',[0,1,2,3,5])->latest()->paginate(100000);
       
        $printing = false;


        return view('dashboard.delivery.orders',compact('delivery','orders','search','search_value','search_name','search_phone','search_address','printing'));
    }
    public function waiting($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('delivery_id',$id)->whereIn('status',[0])->latest()->paginate(100);
        $search = false;
        $search_value = null;
        $search_name = null;
        $search_phone = null;
        $search_address = null;
        $printing = true;
        return view('dashboard.delivery.orders',compact('delivery','orders','search','search_value','search_name','search_phone','printing'));
    }
    
    public function onWay($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('delivery_id',$id)->whereIn('status',[1])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_name = null;
        $search_phone = null;
        $search_address = null;
        $printing = false;
        return view('dashboard.delivery.orders',compact('delivery','orders','search','search_value','search_name','search_phone','search_address','printing'));
    }
    public function completed($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('delivery_id',$id)->whereIn('status',[2])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_name = null;
        $search_phone = null;
        $search_address = null;
        $printing = false;
        return view('dashboard.delivery.orders',compact('delivery','orders','search','search_value','search_name','search_phone','search_address','printing'));
    }
    public function customerCancel($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('delivery_id',$id)->whereIn('status',[3])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_name = null;
        $search_phone = null;
        $search_address = null;
        $printing = false;
        return view('dashboard.delivery.orders',compact('delivery','orders','search','search_value','search_name','search_phone','search_address','printing'));
    }

    public function show($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        return view('dashboard.delivery.show',compact('delivery'));
    }
    public function edit($id)
    {
        $delivery = $this->delivery->find($id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        return view('dashboard.delivery.edit',compact('delivery'));
    }

    public function create()
    {
        
        return view('dashboard.delivery.create');
    }
    
    public function price($id)
    {
        $order = $this->order->find($id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على ببانات الطلب');
        }
        return view('dashboard.delivery.price',compact('order'));
    }
    
    public function priceEdit($id,Request $request)
    {
        $order = $this->order->find($id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على ببانات الطلب');
        }
        $request->validate([
            'price' => 'required|not_in:0',
        ],[
            'price.required' => 'يجب ادخال السعر المستلم',    
            'price.not_in' => 'السعر المستلم يجب ان يكون 1 جنيه او أكثر',    
        ]);
        
        $order->update([
            'bounce' => $request->price
        ]);
        return redirect()->route('dashboard.deliverys.getOrders.price',$order->id)->with('message','تم تخديث السعر المستلم بنجاح');
    }
    
    public function cancelShipping($id)
    {
        $order = $this->order->find($id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على ببانات الطلب');
        }
        $delivery = $order->delivery_id;
        $order->update([
            'bounce' => 0,
            'status' => 0,
            'done_date' => null,
            'notes' => null,
            'delivery_id' => null,
            'pay' => null
        ]);
        return redirect()->route('dashboard.deliverys.getOrders',$delivery)->with('message','تم تعديل الاوردر وحاليا بمرحلة الانتظار');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'phone1' => 'required|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable|regex:/(01)[0-9]{9}/',
        ],$this->message());
        $user = $this->user->create([
            'name'=>$request->name,
            'email' => $request->email,
            'role' => 2,
            'password' => Hash::make($request->password)
        ]);

        $this->delivery->create([
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'user_id' => $user->id,
            'user_create' => Auth::user()->id
        ]);

        return redirect()->route('dashboard.deliverys.index')->with('message','تم اضافة بيانات المندوب بنجاح');
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'nullable|string|min:3|max:30',
            'password' => 'nullable|confirmed|min:8',
            'phone1' => 'nullable|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable|regex:/(01)[0-9]{9}/',
        ],$this->message());

        $delivery = $this->delivery->find($id);
        if($request->name != $delivery->User->name ||
        $request->password != null || $request->phone1 != $delivery->phone1 ||
        $request->phone2 != $delivery->phone2){

            $delivery->User->update([
                'name'=>$request->name,
                'password' => Hash::make($request->password)
            ]);
            
            $delivery->update([
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'user_create' => Auth::user()->id
            ]);

            return redirect()->route('dashboard.deliverys.edit',$delivery->id)->with('message','تم تعديل بيانات المندوب بنجاح');

        }

        return redirect()->route('dashboard.deliverys.edit',$delivery->id)->with('message','لم يتم تعديل بيانات المندوب لعدم التغيير فى البيانات');
        

        
    }
    
    

    public function search(Request $request)
    {
        $deliverys_ids = [];
        $users = $this->user->where('name','LIKE',$request->name.'%')->where('role',2)->get();
        foreach($users as $user){
            array_push($deliverys_ids,$user->id);
        }
        $deliverys = $this->delivery->whereIn('user_id',$deliverys_ids)->latest()->paginate(10);
        $search = true;
        $search_value = $request->name;
        $printing = true;

        return view('dashboard.delivery.index',compact('deliverys','search','search_value','printing'));
    }



    public function destroy(Request $request)
    {
        $delivery = $this->delivery->find($request->id);
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }

        $delivery->User->delete();
        return redirect()->route('dashboard.deliverys.index')->with('message','تم حذف بيانات المندوب بنجاح');
    }
}
