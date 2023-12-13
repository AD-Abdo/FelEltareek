<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderController extends Controller
{
    public $user;
    public $delivery;
    public $order;

    public function __construct()
    {
        $this->user = new User();
        $this->delivery = new Delivery();
        $this->order = new Order();
    }
    public function index()
    {
        $orders = $this->order->where('addCutomer',0)->where('delivery_id',Auth::user()->Delivery->id)->where('status',0)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_address = null;
        $search_name = null;
        $search_phone = null;
        $search_phoneNumber = null;
        return view('dashboard.delivery_order.index',compact('orders','search','search_value','search_value','search_name','search_phone','search_address','search_phoneNumber'));
    }
    public function waiting()
    {
        $orders = $this->order->where('addCutomer',0)->where('delivery_id',Auth::user()->Delivery->id)->where('status',0)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_address = null;
        $search_name = null;
        $search_phone = null;
        $search_phoneNumber = null;
        return view('dashboard.delivery_order.index',compact('orders','search','search_value','search_name','search_phone','search_address','search_phoneNumber'));
    }
    public function onWay()
    {
        $orders = $this->order->where('addCutomer',0)->where('delivery_id',Auth::user()->Delivery->id)->where('status',1)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_address = null;
        $search_name = null;
        $search_phone = null;
        $search_phoneNumber = null;
        return view('dashboard.delivery_order.index',compact('orders','search','search_value','search_name','search_phone','search_address','search_phoneNumber'));
    }
    public function completed()
    {
        $orders = $this->order->where('addCutomer',0)->where('delivery_id',Auth::user()->Delivery->id)->where('status',2)->latest()->paginate(10);
        $search = false;
        $search_value = null;
        $search_address = null;
        $search_name = null;
        $search_phone = null;
        $search_phoneNumber = null;
        return view('dashboard.delivery_order.index',compact('orders','search','search_value','search_name','search_phone','search_address','search_phoneNumber'));
    }

    public function show($id)
    {
        $order = $this->order->find($id);
        return view('dashboard.delivery_order.edit',compact('order'));
    }

    public function update($id,Request $request)
    {
        $order = $this->order->where('id',$id)->first();
        if($order == null){
            return redirect()->route('dashboard.delivery.orders.index')->with('message','لم يتم العثور على بيانات الطلب');
        }


        $order->update([
            'status' => 2,
            'bounce' => $request->total,
            'notes' => $request->notes,
            'done_date' => Carbon::today()->toDateString()
        ]);
        return redirect()->route('dashboard.delivery.orders.index')->with('message','تم توصيل الطلب بنجاح');
    }
    public function agree($id)
    {
        $order = $this->order->where('id',$id)->first();
        if($order == null){
            return redirect()->route('dashboard.delivery.orders.index')->with('message','لم يتم العثور على بيانات الطلب');
        }


        $order->update([
            'status' => 1,
        ]);
        return redirect()->route('dashboard.delivery.orders.index')->with('message','الطلب جاهز للتوصيل');
    }
    
    public function cancelDelivery(Request $request)
    {
        $order = $this->order->where('id',$request->id)->first();
        if($order == null){
            return redirect()->route('dashboard.delivery.orders.index')->with('message','لم يتم العثور على بيانات الطلب');
        }

        $order->update([
            'delivery_id' => null,
            'status' => 0,
        ]);
        return redirect()->back()->with('message','تم الغاء الطلب من المندوب ويمكن اضافة مندوب اخر');
    }
    
    public function searchOrder(Request $request)
    {
        
        $delivery = Auth::user()->Delivery;
        if($delivery == null){
            return redirect()->route('dashboard.deliverys.index')->with('message','لم يتم العثور على بيانات المندوب');
        }

        
        
        $search = true;
        $search_value = $request->date;
        $search_name = $request->name;
        $search_phone = $request->phone;
        $search_address = $request->address;
        $search_phoneNumber = $request->phoneNumber;
        
        $query = $this->order;
        if($request->date != null){
            $query = $query->whereDate('done_date',$request->date);
        }
        if($request->name != null){
            $query = $query->where('name',"like","%".$request->name."%");
        }
        if($request->phone != null){
            $query = $query->where('phone2',$request->phone);
        }
        if($request->address != null){
            $query = $query->where('address',"like","%".$request->address."%");
        }
        if($request->phoneNumber != null){
            $query = $query->where('phone1',"like","%".$request->phoneNumber."%");
        }
        
        
        $orders = $query->where('delivery_id',Auth::user()->Delivery->id)->whereIn('status',[0,1,2,3])->latest()->paginate(100000);
       
        

        return view('dashboard.delivery_order.index',compact('delivery','orders','search','search_value','search_name','search_phone','search_address','search_phoneNumber'));
    }
    
    // public function searchOrder($customer,Request $request)
    // {
        
        
    //     $search = true;
    //     $search_value = $request->date;
        
    //     if($request->date != null){
    //          $orders = $this->order->where('delivery_id',$id)->whereIn('status',[0,1,2,3,4])->whereDate('done_date',$request->date)->latest()->paginate(500);
    //     }

    //     if($request->date != null ){
    //         $orders = $this->order->where('delivery_id',$id)->whereIn('status',[0,1,2,3,4])->latest()->paginate(500);
    //     }
        

    //     return view('dashboard.delivery.orders.index',compact('orders','search','search_value'));
    // }
}
