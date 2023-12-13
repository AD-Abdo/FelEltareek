@extends('dashboard.layouts.main')
@push('css')
<link href="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <style>
    @media print {
        *{
            font-size:15px !important;
        }
        .noprint{
            display:none !important;
        }
    }
    </style>
@endpush
@php
    $list[0]="";
    $list[1]="mm-active";
    $list[2]="";
    $list[3]="";
    $list[4]="";
    $list[5]="";


@endphp
@section('content')
<div class="row">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18" id="title1">كل طلبات العميل - {{ $customer->User->name }}
        @if($search == true)
            <form class="mt-2" style="display:inline  !important" action="{{ URL::route('dashboard.orders.pay',$customer) }}" method="POST" >
                @csrf
                @method('POST')
                <input style="display:none"  value="{{ $search_value }}" type="date" name="name"  class="form-control" id="name" placeholder=" ابحث برقم الطلب">
                <input style="display:none"  value="{{ $search_valueTo }}" type="date" name="nameTo"  class="form-control" id="nameTo" placeholder=" ابحث برقم الطلب">
                <input  style="display:none"  value="{{ $search_name }}" type="text" name="customer"  class="form-control" id="customer" placeholder=" ابحث باسم العميل">
                <input  style="display:none"  value="{{ $search_phone }}" type="text" name="phone"  class="form-control" id="phone" placeholder=" ابحث برقم العميل">
                <input style="display:inline  !important"  type="submit" class="mt-2 form-control btn btn-primary btn-sm " value="دفع الفاتورة">
            </form>    
        @endif
        </h4>



        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    @if($search == true)
                        <a style="display:inline !important"   href="javascript:window.print()" class="btn btn-outline-success btn-sm .noprint" title="طباعة فاتورة"><i class="fa fa-print"></i></a>
                        
                        
                    @endif
                    <a href="{{ route('dashboard.orders.create',$customer) }}" class="btn btn-outline-success btn-sm .noprint" title="اضافة طلب جديد">
                        <i class="fas fa-plus"></i>&nbsp
                        اضافة طلب جديد
                    </a>
                    <a href="{{ route('dashboard.customers.index') }}" class="btn btn-outline-primary btn-sm .noprint" title="رجوع">
                        <i class="fas fa-arrow-left"></i>&nbsp
                    </a>
                </li>
            </ol>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <h4 class="mb-sm-0 font-size-18" id="title2" style="display: none">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/icon.png')}}" alt="" height="60">
                    </span>
                </h4>

                <h4 class="mb-sm-0 font-size-18" id="title2" style="display: none">فاتورة للعميل  {{ $customer->User->name }} - بتاريخ <span id="getDate"></span></h4>

                <div class=" print" style="visibility: hidden;display: none">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                       
                        
                        <thead>
                            <tr >
                                <th style="font-size:9px !important;">رقم البوليصة</th>
                                <th style="font-size:9px !important;">الاسم</th>
                                <th style="font-size:9px !important;">المحافظة</th>
                                <th style="font-size:9px !important;">الملاحظات</th>
                                <th style="font-size:9px !important;">سعر الطلب </th>
                                <th style="font-size:9px !important;">مبلغ يتم توصيله للعميل </th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @php $total = 0; @endphp
                           @if(count($orders) > 0)
                           
                                @foreach($orders as $order)
                                
                                    @php
                                        if($order->status == 2){
                                           $total =  $total + ($order->bounce - $order->ship);
                                        }
                                        else{
                                            $total =  $total;
                                           
                                        }
                                        if($order->status == 0 ){
                                            $status = 'فى الانتظار';  
                                            $price = $order->price;
                                        }
                                        else if($order->status == 1 ){
                                            $status = 'فى الطريق'; 
                                            $price = $order->price ;
                                        }
                                        else if($order->status == 2 ){
                                            $status = 'تم التوصيل';
                                            $price = $order->bounce - $order->ship;
                                            if($price < 0 ){
                                                $price = " مطلوب من العميل ".abs($price);
                                            }
                                        }
                                        else if($order->status == 3 ){
                                            $status = 'ملغى من جهة المستلم';  
                                            $price = 0; 
                                        }
                                        else if($order->status == 4 ){
                                            $status = 'ملغى من جهة المدير';
                                            $price = 0; 
                                        }
                                        else if($order->status == 5 ){
                                            $status = 'تم الدفع';
                                            if($order->bounce == 0){
                                                $price = $order->ship - (2*$order->ship);
                                            }
                                            else{
                                                $price = $order->bounce - ($order->price + $order->ship);
                                            }
                                            if($price < 0 ){
                                                $price = " مطلوب من العميل ".abs($price);
                                            }
                                        }
                                        else if($order->status == 6 ){
                                            $status = 'مرتجع'; 
                                            $price = 0 ;
                                        }
                                        else if($order->status == 7 ){
                                            $status = 'مرتجع جزئي'; 
                                            $price = $order->price;
                                        }
                                    @endphp
                               
                                    <tr>
                                        <td data-field="id" style="font-size:9px !important;">{{ $order->phone2 ?? '' }}</td>
                                        <td data-field="name" style="font-size:9px !important;">{{ $order->name }}</td>
                                        <td data-field="country" style="font-size:9px !important;">{{ $order->country ?? '-' }}</td>
                                         @if($order->status == 6)
                                            <td data-field="name" style="font-size:9px !important;">{{ $status }}</td>
                                        @elseif($order->status == 2 || $order->status == 1)
                                            @if($order->bounce == ($order->price + $order->ship))
                                                <td data-field="name" style="font-size:9px !important;">تم استلام المبلغ كامل</td>
                                            @else
                                                <td data-field="name" style="font-size:9px !important;">تعديل سعر + مرتجع جزئي </td>
                                            @endif
                                        @elseif($order->status == 5)
                                             <td data-field="name" style="font-size:9px !important;">تم سداد المبلغ للعميل</td>
                                        @else
                                          <td data-field="name" style="font-size:9px !important;">{{ $order->notes }}</td>
                                         @endif
                                        <td data-field="id" style="font-size:9px !important;">{{ $order->price }} جنية</td>
                                        @if($order->bounce ==  $order->ship)
                                            <td data-field="id" style="font-size:9px !important;">0 جنية</td>
                                        @elseif($order->price == 0 && $order->bounce == 0 )
                                            <td data-field="id" style="font-size:9px !important;">مطلوب من العميل{{$order->ship }} جنية</td>
                                        @elseif($order->bounce == 0 )
                                            <td data-field="id" style="font-size:9px !important;">{{ $price }} جنية</td>
                                        @else   
                                            <td data-field="id" style="font-size:9px !important;">{{ $order->bounce - $order->ship}} جنية</td>
                                        @endif
                                        
                                        

                                       
                                        
                                    </tr>
                                @endforeach
                                <tr class="text-center" style="color: #000 !important;text-align:center !important ">
                                    <td colspan="6" class="text-center  print" style="text-align:center !important"  >
                               
                                       @if($total >= 0 )
                                            <h6 style="color: #000 !important;text-align:center !important "> السعر الكلى للطلبات <span>{{ $total }} </span> جنية</h6>
                                       @else
                                             <h6 style="color: #000 !important;text-align:center !important "> السعر الكلى للطلبات <span>مبلغ مطلوب من العميل {{ abs($total) }} </span> جنية</h6>
                                       @endif
                                   </td>
                                </tr>
                           @else
                                <td colspan="6" class="text-center bg-primary noprint" style="color: #fff">لا يوجد طلبات الان</td>
                           @endif

                        </tbody>
                        
                    </table>
                    <div class="row noprint">
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive noprint">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead  class="noprint">
                            @if($search == true)
                                <td colspan="11">
                                    <form action="{{ URL::route('dashboard.orders.search',$customer) }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-12">
                                               <div class="row">
                                                     <div class="col-md-2">
                                                        <input  value="{{ $search_value }}"  type="date" name="name"  class="form-control" id="name" placeholder=" ابحث برقم الطلب">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input  value="{{ $search_valueTo }}"  type="date" name="nameTo"  class="form-control" id="nameTo" placeholder=" ابحث برقم الطلب">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input  value="{{ $search_name }}" type="text" name="customer"  class="form-control" id="customer" placeholder=" ابحث باسم العميل">
                                                    </div>
                                                    <div class="col-md-2">    
                                                        <input  value="{{ $search_phone }}" type="text" name="phone"  class="form-control" id="phone" placeholder=" ابحث برقم البوليصة">
                                                    </div>
                                                    <div class="col-md-2">    
                                                        <input  value="{{ $search_phoneNumber }}"  type="text" name="phoneNumber"  class="form-control" id="phoneNumber" placeholder=" ابحث برقم الهاتف">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="submit" class="form-control btn btn-primary btn-sm " value="بحث">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>                        
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.orders.index',$customer) }}" class="btn btn-outline-primary btn-sm w-100" title="عرض الكل">
                                        <i class="mdi mdi-close"></i>عرض الكل
                                    </a>
                                </td>
                            @else
                                <td colspan="12">
                                    <form action="{{ URL::route('dashboard.orders.search',$customer) }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <div class="row">
                                                     <div class="col-md-2">
                                                        <input  value="{{ $search_value }}"  type="date" name="name"  class="form-control" id="name" placeholder=" ابحث برقم الطلب">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input  value="{{ $search_valueTo }}" type="date" name="nameTo"  class="form-control" id="nameTo" placeholder=" ابحث برقم الطلب">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input  value="{{ $search_name }}" type="text" name="customer"  class="form-control" id="customer" placeholder=" ابحث باسم العميل">
                                                    </div>
                                                    <div class="col-md-2">    
                                                        <input  value="{{ $search_phone }}" type="text" name="phone"  class="form-control" id="phone" placeholder=" ابحث برقم البوليصة">
                                                    </div>
                                                    <div class="col-md-2">    
                                                        <input  value="{{ $search_phoneNumber }}" name="phoneNumber"  class="form-control" id="phone" placeholder=" ابحث برقم الهاتف">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="submit" class="form-control btn btn-primary btn-sm " value="بحث">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </form>                        
                                </td>
                            @endif
                        </thead>
                        <thead class="noprint">
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.waiting',$customer) }}" class="btn btn-primary btn-sm w-100" title="فى الانتظار">
                                    <i class="fas fa-hashtag"></i> فى الانتظار
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.onWay',$customer) }}" class="btn btn-primary btn-sm w-100" title="فى الطريق">
                                    <i class="fas fa-hashtag"></i> فى الطريق
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.completed',$customer) }}" class="btn btn-primary btn-sm w-100" title="تم التوصيل">
                                    <i class="fas fa-hashtag"></i> تم التوصيل
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.customerCancel',$customer) }}" class="btn btn-primary btn-sm w-100" title="ملغى من قبل المستلم">
                                    <i class="fas fa-hashtag"></i> ملغى من قبل المستلم
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.adminCancel',$customer) }}" class="btn btn-primary btn-sm w-100" title="ملغى من قبل المدير">
                                    <i class="fas fa-hashtag"></i> ملغى من قبل المدير
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.adminPay',$customer) }}" class="btn btn-primary btn-sm w-100" title="تم الدفع">
                                    <i class="fas fa-hashtag"></i> تم الدفع
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.orderCancel',$customer) }}" class="btn btn-primary btn-sm w-100" title="مرتجع">
                                    <i class="fas fa-hashtag"></i> مرتجع
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.adminAmoutShipping',$customer) }}" class="btn btn-primary btn-sm w-100" title="مرتجع جزئي">
                                    <i class="fas fa-hashtag"></i> مرتجع جزئي
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.orders.index',$customer) }}" class="btn btn-primary btn-sm w-100" title="عرض الكل">
                                   <i class="fas fa-hashtag"></i> عرض الكل
                                </a>
                            </td>
                            <td colspan="3">
                            </td>
                            
                        </thead>
                        <thead>
                            <tr >
                                 <th>رقم البوليصة</th>
                                <th>الاسم</th>
                                <th>سعر الطلب </th>
                                <th class="noprint">سعر التوصيل </th>
                                <th>مبلغ يتم توصيله للعميل </th>
                                <th class="noprint">اسم المندوب</th>
                                <th class="noprint">حالة الطلب</th>
                                <th class="noprint">عنوان الطلب</th>
                                <th class="noprint">تم الدفع بتاريخ</th>
                                <th class="noprint">مرتجع بتاريخ</th>
                                <th class="noprint">تاريخ دخول الطلب</th>
                                <th class="noprint">العمليات</th>
                                
                            </tr>
                        </thead>
                        @php
                            $total = 0;
                        @endphp
                        <tbody>
                           @if(count($orders) > 0)
                                
                                @foreach($orders as $order)
                                @php
                                    if($order->status == 2){
                                        if( $order->price != 0 && $order->bounce != 0){
                                            $total =  $total + ($order->bounce - $order->ship);
                                        }
                                        
                                        else{
                                            $total =  $total - $order->ship;
                                        }
                                        
                                    }
                                    else{
                                       $total =  $total;
                                    }
                                    
                                    if($order->status == 0 ){
                                        $status = 'فى الانتظار';  
                                        $price = $order->price ;
                                    }
                                    else if($order->status == 1 ){
                                        $status = 'فى الطريق'; 
                                       $price = $order->price ;
                                    }
                                    else if($order->status == 2 ){
                                        $status = 'تم التوصيل';
                                        $price = $order->bounce - $order->ship;
                                        if($price < 0 ){
                                            $price = " مطلوب من العميل ".abs($price);
                                        }
                                        
                                    }
                                    else if($order->status == 3 ){
                                        $status = 'ملغى من جهة المستلم';  
                                        $price = 0; 
                                    }
                                    else if($order->status == 4 ){
                                        $status = 'ملغى من جهة المدير';
                                        $price = 0; 
                                    }
                                    else if($order->status == 5 ){
                                        $status = 'تم الدفع';
                                        if($order->bounce == 0){
                                            $price = $order->ship - (2*$order->ship);
                                        }
                                        else{
                                            $price = $order->bounce - ($order->price + $order->ship);
                                        }
                                        if($price < 0 ){
                                            $price = " مطلوب من العميل ".abs($price);
                                        }
                                    }
                                    else if($order->status == 6 ){
                                        $status = 'مرتجع'; 
                                        $price = 0 ;
                                    }
                                    else if($order->status == 7 ){
                                        $status = 'مرتجع جزئي'; 
                                        $price = $order->price;
                                    }
                                @endphp
                                    <tr>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->phone2 }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price }} جنية</td>
                                        <td  class="noprint" data-field="id" style="width: 170.312px;">{{ $order->ship}} جنية</td>
                                        @if($order->bounce ==  $order->ship)
                                            <td data-field="id" style="width: 170.312px;">0 جنية</td>
                                        @elseif($order->price == 0 && $order->bounce == 0 )
                                            <td data-field="id" style="width: 170.312px;">مطلوب من العميل{{$order->ship }} جنية</td>
                                        @elseif($order->bounce == 0 )
                                            <td data-field="id" style="width: 170.312px;">{{ $price }} جنية</td>
                                        @else   
                                            <td data-field="id" style="width: 170.312px;">{{ $order->bounce - $order->ship}} جنية</td>
                                        @endif
                                        <td class="noprint" data-field="id" style="width: 170.312px;">{{ $order->Delivery->User->name ?? "لم يتم اختيار اى مندوب" }}</td>
                                        <td class="noprint" data-field="id" style="width: 170.312px;">{{ $status  }}</td>

                                        <td data-field="id" style="width: 170.312px;">{{ $order->address ?? '-' }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->pay != null ? date('l, d M Y - h:i A', strtotime($order->pay)): 'لم يتم الدفع حتي الان' }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->mortgee != null ? date('l, d M Y - h:i A', strtotime($order->mortgee)): 'لا يوجد تاريح' }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->created_at != null ? date('l, d M Y - h:i A', strtotime($order->created_at)): 'لا يوجد تاريح' }}</td>

                                        <td  class="noprint" style="width: 100px">
                                            @if($order->status == 0 )
                                                <a href="{{ URL::route('dashboard.orders.setOrderCancel',$order->id) }}" class="btn btn-outline-danger btn-sm edit" title="الطلب مرنجع">
                                                    <i class="fas fa-backspace" title="الطلب مرنجع"></i>
                                                </a>
                                            @endif
                                            @if( ($order->status == 2 || $order->status == 5 ))
                                                <a href="{{ URL::route('dashboard.orders.amoutShipping',$order->id) }}" class="btn btn-outline-dark btn-sm edit" title="مرتجع جزئي ">
                                                    <i class="fas fa-window-close" title="مرتجع جزئي"></i>
                                                </a>
                                            @endif
                                            @if($order->status != 6 )
                                                @if($order->status == 0 || $order->delivery == null)
                                                    @if($order->delivery_id != null)
                                                        <a href="{{ URL::route('dashboard.orders.delivery',[$customer,$order->id]) }}" class="btn btn-outline-primary btn-sm edit" title="تغيير المندوب ">
                                                            <i class="bx bx-run" title="تغيير المندوب"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ URL::route('dashboard.orders.delivery',[$customer,$order->id]) }}" class="btn btn-outline-primary btn-sm edit" title="اضافة مندوب للطلب">
                                                            <i class="bx bx-run" title="اضافة مندوب للطلب"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                
                                                <a href="{{ URL::route('dashboard.orders.show',[$customer,$order->id]) }}" class="btn btn-outline-info btn-sm edit" title="عرض بيانات الطلب">
                                                    <i class="far fa-eye" title="عرض بيانات الطلب"></i>
                                                </a>
                                                @if($order->status == 0 || $order->status == 1)
                                                <a href="{{ URL::route('dashboard.orders.edit',[$customer,$order->id]) }}" class="btn btn-outline-secondary btn-sm edit" title="تعديل بيانات الطلب">
                                                    <i class="fas fa-pencil-alt" title="تعديل بيانات الطلب"></i>
                                                </a>
                                                @endif
                                                
                                                <button value="{{ $order->id }}" onclick="Delete({{ $order->id }})" type="button" class="btn btn-outline-danger btn-sm edit"  title="الغاء الطلب">
                                                    <i class="fas fa-trash-alt" title="الغاء الطلب"></i>
                                                </button>
                                            @endif

                                            
                                        </td>
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="12" class="text-center bg-primary noprint" style="color: #fff">لا يوجد طلبات الان</td>
                           @endif
                           
                           <!--<td colspan="9" class="  print"  >-->
                               
                           <!--    @if($total > 0 )-->
                           <!--         <h6 style="color: #000 !important "> السعر الكلى للطلبات <span>{{ $total }} </span> جنية</h6>-->
                           <!--    @else-->
                           <!--          <h6 style="color: #000 !important "> السعر الكلى للطلبات <span>مبلغ مطلوب من العميل {{ abs($total) }} </span> جنية</h6>-->
                           <!--    @endif-->
                           <!--</td>-->

                        </tbody>
                        <!--<tfoot class="print" style="display: none" >-->
                        <!--    @if($total > 0 )-->
                        <!--        <h6 style="color: #000 !important "> السعر الكلى للطلبات <span>{{ $total }} </span> جنية</h6>-->
                        <!--   @else-->
                        <!--         <h6 style="color: #000 !important "> السعر الكلى للطلبات <span>مبلغ مطلوب من العميل {{ abs($total) }} </span> جنية</h6>-->
                        <!--   @endif-->
                        <!--</tfoot>-->
                        
                    </table>
                    <div class="row noprint" >
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                    <!--<div class="row print bg-primary" style="display: none">-->
                    <!--    <div class="d-flex justify-content-center" >-->
                    <!--        @if($total > 0 )-->
                    <!--            <h6 style="color: #000 !important "> السعر الكلى للطلبات <span>{{ $total }} </span> جنية</h6>-->
                    <!--       @else-->
                    <!--             <h6 style="color: #000 !important "> السعر الكلى للطلبات <span>مبلغ مطلوب من العميل {{ abs($total) }} </span> جنية</h6>-->
                    <!--       @endif-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>

            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    

    @media print {
        .noprint {
            visibility: hidden;
        }
        .print{
            visibility: visible !important;
            display: block  !important;
        }
        #title1{
            display: none
        }
        #title2{
            text-align: center !important;
            margin-top: 5% !important;
            margin-bottom: 5%  !important;
            visibility: visible !important;
            display: block  !important;
        }
    }
</style>
@endpush
@push('js')
<script>
    $(document).ready(function(){
   
        date = $('#name').val();
        console.log(date);
        getDate = $('#getDate');
        getDate.append(date);

        total = $('#total').val();
        console.log(total);
    });
</script>
@endpush

@push('js')
    <script src="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <div class="swal2-container swal2-center swal2-backdrop-show" id="divDelete" style="overflow-y: auto;">
        <div aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-popup swal2-modal swal2-icon-warning swal2-show" tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: flex;">
            <div class="swal2-header">
                <ul class="swal2-progress-steps" style="display: none;">
                </ul>
                <div class="swal2-icon swal2-error" style="display: none;">
                </div>
                <div class="swal2-icon swal2-question" style="display: none;">
                </div>
                <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;">
                    <div class="swal2-icon-content">!</div>
                </div>
                <div class="swal2-icon swal2-info" style="display: none;">
                </div>
                <div class="swal2-icon swal2-success" style="display: none;">
                </div>
                <img class="swal2-image" style="display: none;">
                <h2 class="swal2-title" id="swal2-title" style="display: flex;">هل انت متاكد من عملية الغاء الطلب ؟</h2>
                <button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
            </div>
            <div class="swal2-content">
                <input class="swal2-input" style="display: none;">
                <input type="file" class="swal2-file" style="display: none;">
                <div class="swal2-range" style="display: none;">
                    <input type="range">
                    <output></output>
                </div>
                <select class="swal2-select" style="display: none;"></select>
                <div class="swal2-radio" style="display: none;">
                </div>

                <label for="swal2-checkbox" class="swal2-checkbox" style="display: none;">
                    <input type="checkbox">
                    <span class="swal2-label"></span>
                </label>
                <textarea class="swal2-textarea" style="display: none;"></textarea>
                <div class="swal2-validation-message" id="swal2-validation-message"></div>
            </div>
            <div class="swal2-actions">
                <div class="swal2-loader"></div>

                <form method="POST" action="{{ URL::route('dashboard.customers.getOrders.adminCancel') }}" style="display: inline">
                    @csrf
                    @method('POST')
                    <input type="number" value="" name="id" id="customerDelete" style="display: none">
                    <button type="submit" class="swal2-confirm btn btn-success mt-2" style="display: inline-block;" title="الغاء الطلب">
                        الغاء الطلب
                    </button>
                </form>
                <button type="button" class="swal2-deny" aria-label="" style="display: none;" >الفاء</button>
                <button type="button" class="swal2-cancel btn btn-danger ms-2 mt-2" aria-label=""  id="noDelete" style="display: inline-block;">الغاء</button>
            </div>
            <div class="swal2-footer" style="display: none;"></div>
            <div class="swal2-timer-progress-bar-container">
                <div class="swal2-timer-progress-bar" style="display: none;"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#divDelete").hide();
        });
        $( "#delete" ).click(function() {
            $('#customerDelete').val($('#delete').val());

            console.log($('#customerDelete').val());
            $('#divDelete').show();
        });
        
        function Delete(id){
            $('#customerDelete').val(id);

            console.log($('#customerDelete').val());
            $('#divDelete').show();
        }

        $( "#noDelete" ).click(function() {
            $('#divDelete').hide();
        });
    </script>


@endpush



@endsection