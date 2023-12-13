<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AddCustomerRequest;
use App\Models\Cutsomer;
use App\Models\Cutstomer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public $user;
    public $order;
    public $customer;

    public function __construct()
    {
        $this->user = new User();
        $this->order = new Order();
        $this->customer = new Cutsomer();
    }

    public function message()
    {
        return [
            'name.required' => 'اسم العميل مطلوب',
            'name.string' => 'يجب ادخال اسم عميل صحيح',
            'name.min' => 'اسم العميل يجب ان بحتوى على اكثر من 3 احرف',
            'name.max' => 'اسم العميل يجب ان يحتوى على أقل من 30 حرفأ',
            'email.required' => 'البريد الالكتورنى مطلوب',
            'email.email' => 'يجب ادخال بريد الكتروني صحيح',
            'email.unique' => 'البريد الالكتروني هذا مضاف من قبل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'يجب توافق كلمتى المرور',
            'password.min' => 'كلمة المرور يجب ان تحتوى على أكثر من 8 أحرف',
            'phone1.required' => 'رقم الهاتف مطلوب',
            'phone1.regex' => 'يجب ادخال رقم هاتف صحيح',
            'phone2.regex' => 'يجب ادخال رقم هاتف صحيح',
            'address.required' => 'عنوان العميل مطلوب',
            'address.min' => 'عنوان العميل يجب ان يحتوى على أكثر من 10 أحرف'

        ];
    }

    public function index()
    {
        $customers = $this->customer->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.customer.index',compact('customers','search','search_value'));
    }

    public function orders($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('customer_id',$id)->whereIn('status',[0,1,2,3,4,5])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.customer.orders',compact('customer','orders','search','search_value'));
    }
    public function waiting($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('customer_id',$id)->whereIn('status',[0])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.customer.orders',compact('customer','orders','search','search_value'));
    }
    
    public function onWay($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('customer_id',$id)->whereIn('status',[1])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.customer.orders',compact('customer','orders','search','search_value'));
    }
    public function completed($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('customer_id',$id)->whereIn('status',[2])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.customer.orders',compact('customer','orders','search','search_value'));
    }
    public function customerCancel($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات المندوب');
        }
        $orders = $this->order->where('customer_id',$id)->whereIn('status',[3])->latest()->paginate(10);
        $search = false;
        $search_value = null;
        return view('dashboard.customer.orders',compact('customer','orders','search','search_value'));
    }

    public function show($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات العميل');
        }
        return view('dashboard.customer.show',compact('customer'));
    }
    public function edit($id)
    {
        $customer = $this->customer->find($id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات العميل');
        }
        return view('dashboard.customer.edit',compact('customer'));
    }

    public function create()
    {
        return view('dashboard.customer.create');
    }


    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'phone1' => 'required|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable|regex:/(01)[0-9]{9}/',
            'address' => 'required|min:10'
        ],$this->message());
        $user = $this->user->create([
            'name'=>$request->name,
            'email' => $request->email,
            'role' => 3,
            'password' => Hash::make($request->password)
        ]);

        $this->customer->create([
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'address' => $request->address,
            'user_id' => $user->id,
            'user_create' => Auth::user()->id
        ]);

        return redirect()->route('dashboard.customers.index')->with('message','تم اضافة بيانات العميل بنجاح');
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'nullable|string|min:3|max:30',
            'password' => 'nullable|confirmed|min:8',
            'phone1' => 'nullable|regex:/(01)[0-9]{9}/',
            'phone2' => 'nullable|regex:/(01)[0-9]{9}/',
            'address' => 'nullable|min:10'
        ],$this->message());

        $customer = $this->customer->find($id);
        if($request->name != $customer->User->name ||
        $request->password != null || $request->phone1 != $customer->phone1 ||
        $request->phone2 != $customer->phone2 || $request->address != $customer->address){

            $customer->User->update([
                'name'=>$request->name,
                'password' => Hash::make($request->password)
            ]);
            
            $customer->update([
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'address' => $request->address,
                'user_create' => Auth::user()->id
            ]);

            return redirect()->route('dashboard.customers.edit',$customer->id)->with('message','تم تعديل بيانات العميل بنجاح');

        }

        return redirect()->route('dashboard.customers.edit',$customer->id)->with('message','لم يتم تعديل بيانات العميل لعدم التغيير فى البيانات');
        

        
    }

    public function search(Request $request)
    {
        $customers_ids = [];
        $users = $this->user->where('name','LIKE',$request->name.'%')->where('role',3)->get();
        foreach($users as $user){
            array_push($customers_ids,$user->id);
        }
        $customers = $this->customer->whereIn('user_id',$customers_ids)->latest()->paginate(10);
        $search = true;
        $search_value = $request->name;
        return view('dashboard.customer.index',compact('customers','search','search_value'));
    }



    public function destroy(Request $request)
    {
        $customer = $this->customer->find($request->id);
        if($customer == null){
            return redirect()->route('dashboard.customers.index')->with('message','لم يتم العثور على بيانات العميل');
        }

        $customer->User->delete();
        return redirect()->route('dashboard.customers.index')->with('message','تم حذف بيانات العميل بنجاح');
    }
    
    public function adminCancel(Request $request)
    {
        $order = $this->order->find($request->id);
        if($order == null){
            return redirect()->back()->with('message','لم يتم العثور على بيانات العميل');
        }
        $order->update([
            'status' => 4 
        ]);
        return redirect()->back()->with('message','تم حذف بيانات العميل بنجاح');
    }
}
