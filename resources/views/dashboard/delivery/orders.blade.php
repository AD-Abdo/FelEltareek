@extends('dashboard.layouts.main')
@push('css')
<link href="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

@endpush

@php
    $list[0]="";
    $list[1]="";
    $list[2]="mm-active";
    $list[3]="";
    $list[4]="";
    $list[5]="";


@endphp
@section('content')
<div class="row">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between print">
        <h4 class="mb-sm-0 font-size-18 print" id="title2" style="display: none">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/icon.png')}}" alt="" height="60">
            </span>
        </h4>

        <h4 class="mb-sm-0 font-size-18 print" id="title2" style="display: none">كل طلبات المندوب : {{ $delivery->User->name }}</h4>

        <h4 class="mb-sm-0 font-size-18 noprint">كل طلبات المندوب : {{ $delivery->User->name }}</h4>
        <div class="page-title-right noprint">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    @if($printing == true)
                        <a style="display:inline !important"   href="javascript:window.print()" class="btn btn-outline-success btn-sm .noprint" title="طباعة الطلبات"><i class="fa fa-print"></i></a>
                        
                        
                    @endif
                    <a href="{{ route('dashboard.deliverys.index') }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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
                <div class=" print" style="visibility: hidden;display: none">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        
                        
                        <thead>
                            <tr >
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>السعر الكلى شامل الشحن</th>
                                <th>اسم العميل</th>
                                <th>العنوان</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @php
                                    $total = 0;
                                    $totalNumbers =  0;
                                    $printingNumber= 0;
                                @endphp
                           @if(count($orders) > 0)
                                
                                @foreach($orders as $order)
                                @php
                                    if($order->status == 0 ){
                                        $status = 'فى الانتظار';  
                                    }
                                    else if($order->status == 1 ){
                                        $status = 'فى الطريق'; 
                                    }
                                    else if($order->status == 2 ){
                                        $status = 'تم التوصيل';
                                    }
                                    else if($order->status == 3 ){
                                        $status = 'ملغى من جهة المستلم';  
                                    }
                                    else if($order->status == 4 ){
                                        $status = 'ملغى من جهة المدير';
                                    }
                                    else if($order->status == 5 ){
                                        $status = 'تم الدفع';
                                    }
                                    
                                    if($search == true){
                                        if($order->status == 2){
                                            $total = $total + $order->bounce;
                                            $totalNumbers = $totalNumbers +1;
                                        }
                                        else{
                                            $total = $total;
                                            $totalNumbers = $totalNumbers;
                                        }
                                    }
                                    $printingNumber = $printingNumber + $order->price + $order->ship ;
                                    
                                    
                                    
                                @endphp
                                    <tr>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }} <span style="color:##00FF00">@if($order->bounce == $order->price)&nbsp ✓ @endif </span> </td>
                                        <td data-field="phone1" style="width: 422.609px;">{{ $order->phone1 ?? '-' }} <span style="color:##00FF00"></td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price + $order->ship  }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->Customer->User->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->address  }}</td>
                                         

                                       
                                    </tr>
                                @endforeach
                                @if($search == true)
                                    <tr>
                                        <td colspan="11" class="text-center bg-primary" style="color: #fff">الاجمالي {{$total }} جنية + ( عدد الطلبات تم توصيلها {{ $totalNumbers }} )</td>
                                    </tr>
                                @endif
                                @if($printing == true)
                                     <tr>
                                        <td colspan="11" class="text-center bg-primary" style="color: #fff">الاجمالي {{ $printingNumber }} جنية</td>
                                    </tr>
                                @endif
                           @else
                           <tr>
                                <td colspan="11" class="text-center bg-primary" style="color: #fff">لا يوجد طلبات الان</td>
                            </tr>
                                
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
                        <thead>
                            @if($search == true)
                                <td colspan="10">
                                    <form action="{{ URL::route('dashboard.deliverys.getOrders.search',$delivery->id) }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-10">
                                                 <div class="row">
                                                     <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="date" value="{{ $search_value }}"  name="date"  class="form-control text-center" id="date" placeholder=" ابحث بتاريخ وصول الطلبات">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_name }}"  name="name"  class="form-control text-center" id="date" placeholder=" ابحث باسم صاحب الطلب">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_phone }}"  name="phone"  class="form-control text-center" id="date" placeholder=" ابحث برقم البوليصة">
                                                    </div>
                                                    
                                                     <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_address }}"  name="address"  class="form-control text-center" id="date" placeholder=" ابحث بالمحافظة">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="border-radius: 50px;display: inline  " type="submit" class="form-control btn btn-primary btn-sm " value="بحث">
                                            </div>
                                        </div>
                                    </form>                        
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.deliverys.getOrders',$delivery->id) }}" class="btn btn-outline-primary btn-sm w-100" title="عرض الكل">
                                        <i class="mdi mdi-close"></i>عرض الكل
                                    </a>
                                </td>
                            @else
                                <td colspan="11">
                                    <form action="{{ URL::route('dashboard.deliverys.getOrders.search', $delivery->id) }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-9">
                                                 <div class="row">
                                                    
                                                    <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="date" name="date"  class="form-control text-center" id="date" placeholder=" ابحث بتاريخ وصول الطلبات">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="name"  class="form-control text-center" id="date" placeholder=" ابحث باسم صاحب الطلب">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="phone"  class="form-control text-center" id="date" placeholder=" ابحث برقم البوليصة">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value=""  name="address"  class="form-control text-center" id="date" placeholder=" ابحث بالمحافظة">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input style="border-radius: 50px;display: inline  " type="submit" class="form-control btn btn-primary btn-sm " value="بحث">
                                            </div>
                                        </div>
                                    </form>                        
                                </td>
                            @endif
                        </thead>
                        <thead>
                            <td colspan="1">
                                <a href="{{ route('dashboard.deliverys.getOrders.waiting',$delivery->id) }}" class="btn btn-primary btn-sm w-100" title="فى الانتظار">
                                    <i class="fas fa-hashtag"></i> فى الانتظار
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.deliverys.getOrders.onWay',$delivery->id) }}" class="btn btn-primary btn-sm w-100" title="فى الطريق">
                                    <i class="fas fa-hashtag"></i> فى الطريق
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.deliverys.getOrders.completed',$delivery->id) }}" class="btn btn-primary btn-sm w-100" title="تم التوصيل">
                                    <i class="fas fa-hashtag"></i> تم التوصيل
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.deliverys.getOrders.customerCancel',$delivery->id) }}" class="btn btn-primary btn-sm w-100" title="ملغى من قبل المستلم">
                                    <i class="fas fa-hashtag"></i> ملغى من قبل المستلم
                                </a>
                            </td>
                            
                            <td colspan="1">
                                <a href="{{ route('dashboard.deliverys.getOrders',$delivery->id) }}" class="btn btn-primary btn-sm w-100" title="عرض الكل">
                                    <i class="fas fa-hashtag"></i> عرض الكل
                                </a>
                            </td>
                            <td colspan="2">
                            </td>
                            
                            
                        </thead>
                        <thead>
                            <tr >
                                <th>رقم البوليصة</th>
                                <th>الاسم</th>
                                <th>السعر</th>
                                <th>الشحن</th>
                                <th>السعر الكلى شامل الشحن</th>
                                <th>اسم العميل</th>
                                <th>العنوان</th>
                                <th>ملاحظات</th>
                                <th>حالة الطلب</th>
                                <th>تاريخ ووقت الوصول</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @php
                                    $total = 0;
                                    $totalNumbers =  0;
                                    $printingNumber = 0;
                                @endphp
                           @if(count($orders) > 0)
                                
                                @foreach($orders as $order)
                                @php
                                    if($order->status == 0 ){
                                        $status = 'فى الانتظار';  
                                    }
                                    else if($order->status == 1 ){
                                        $status = 'فى الطريق'; 
                                    }
                                    else if($order->status == 2 ){
                                        $status = 'تم التوصيل';
                                    }
                                    else if($order->status == 3 ){
                                        $status = 'ملغى من جهة المستلم';  
                                    }
                                    else if($order->status == 4 ){
                                        $status = 'ملغى من جهة المدير';
                                    }
                                    else if($order->status == 5 ){
                                        $status = 'تم الدفع';
                                    }
                                    
                                    if($search == true){
                                        if($order->status == 2){
                                            $total = $total + $order->bounce;
                                            $totalNumbers = $totalNumbers +1;
                                        }
                                        else{
                                            $total = $total;
                                            $totalNumbers = $totalNumbers;
                                        }
                                    }


                                    $printingNumber = $printingNumber + $order->price + $order->ship ;
                                    
                                @endphp
                                    <tr>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->phone2 ?? '' }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }} <span style="color:##00FF00">@if($order->bounce == $order->price)&nbsp ✓ @endif </span> </td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{  $order->ship }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->bounce }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->Customer->User->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->address  }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->notes  }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $status  }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->done_date != null ? date('l, d M Y - h:i A', strtotime($order->done_date)) : 'لم يتم توصيل الطلب' }}</td>
                                         <td data-field="id" style="width: 170.312px;">
                                        @if(Auth::user()->role ==1 && ($order->status == 1 || $order->status == 0))
                                            <button value="{{ $order->id }}" type="button" onclick="Delete({{ $order->id }})" class="btn btn-outline-danger btn-sm edit" title="حذف المندوب من هذا الطلب">
                                                <i class="bx bx-run" title="حذف المندوب من هذا الطلب"></i>
                                            </button>
                                        @endif
                                        @if(Auth::user()->role ==1 && $order->status == 2)
                                            <a href="{{ URL::route('dashboard.deliverys.getOrders.price',$order->id) }}" class="btn btn-outline-secondary btn-sm edit" title="تعديل السعر المستلم">
                                                <i class="fas fa-pencil-alt" title="تعديل السعر المستلم"></i>
                                            </a>
                                            <a href="{{ URL::route('dashboard.deliverys.getOrders.cancelShipping',$order->id) }}" class="btn btn-outline-danger btn-sm edit" title="تعديل حالة الطلب لــــ فى الانتظار">
                                                <i class=" fas fa-backspace" title="تعديل حالة الطلب لــــ فى الانتظار"></i>
                                            </a>
                                        @endif
                                        
                                        
                                        
                                         <td data-field="id" style="width: 170.312px;">

                                       
                                    </tr>
                                @endforeach
                                @if($search == true)
                                    <tr>
                                        <td colspan="11" class="text-center bg-primary" style="color: #fff">الاجمالي {{$total }} جنية + ( عدد الطلبات تم توصيلها {{ $totalNumbers }} )</td>
                                    </tr>
                                @endif
                                @if($printing == true)
                                    <tr>
                                        <td colspan="11" class="text-center bg-primary" style="color: #fff">الاجمالي {{ $printingNumber }} جنية</td>
                                    </tr>
                                @endif
                           @else
                           <tr>
                                <td colspan="11" class="text-center bg-primary" style="color: #fff">لا يوجد طلبات الان</td>
                            </tr>
                                
                           @endif
                           

                        </tbody>
                        
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 text-center">
         {{ $orders->links() }}
    </div>
</div>


@endsection

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
                <h2 class="swal2-title" id="swal2-title" style="display: flex;">هل انت متاكد من عملية حذف المندوب من هذا الطلب ؟</h2>
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

                <form method="POST" action="{{ URL::route('dashboard.deliverys.cancel') }}" style="display: inline">
                    @csrf
                    @method('POST')
                    <input type="number" value="" name="id" id="customerDelete" style="display: none">
                    <button type="submit" class="swal2-confirm btn btn-success mt-2" style="display: inline-block;" title="حذف المندوب من هذا الطلب">
                        حذف المندوب من هذا الطلب
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
        
        function Delete(id){
            $('#customerDelete').val(id);

            console.log($('#customerDelete').val());
            $('#divDelete').show();
        }
        $( "#delete" ).click(function() {
            $('#customerDelete').val($('#delete').val());

            console.log($('#customerDelete').val());
            $('#divDelete').show();
        });

        $( "#noDelete" ).click(function() {
            $('#divDelete').hide();
        });
    </script>


@endpush
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
