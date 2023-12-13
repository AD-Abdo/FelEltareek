@extends('dashboard.layouts.main')
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
        <h4 class="mb-sm-0 font-size-18" id="title1">كل طلبات العميل - {{ Auth::user()->name }}</h4>



        

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


                
                <div class="table-responsive noprint">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead class="noprint">
                         @if($search == true)
                                <td colspan="9">
                                    <form action="{{ URL::route('dashboard.customer.orders.search') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="search_value" value="{{ $search_value }}" class="form-control text-center" id="name" placeholder=" ابحث باسم العميل">

                                            </div>
                                            <div class="col-md-5">
                                                <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="search_phone" value="{{ $search_phone }}" class="form-control text-center" id="name" placeholder=" ابحث برقم العميل">

                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="بحث" class="btn btn-outline-success btn-sm w-100" >

                                            </div>
                                        </div>
                                    </form>                        
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.customer.orders.index') }}" class="btn btn-outline-primary btn-sm w-100" title="عرض الكل">
                                        <i class="mdi mdi-close"></i>عرض الكل
                                    </a>
                                </td>
                            @else
                                <td colspan="9">
                                    <form action="{{ URL::route('dashboard.customer.orders.search') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="search_value"  class="form-control text-center" id="name" placeholder=" ابحث باسم العميل">

                                            </div>
                                            <div class="col-md-5">
                                                <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="search_phone"  class="form-control text-center" id="name" placeholder=" ابحث برقم العميل">

                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="بحث" class="btn btn-outline-success btn-sm w-100" >

                                            </div>
                                        </div>
                                    </form>                        
                                </td>
                            @endif
                        </thead>
                        <thead class="noprint">
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.waiting') }}" class="btn btn-primary btn-sm w-100" title="فى الانتظار">
                                    <i class="fas fa-hashtag"></i> فى الانتظار
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.onWay') }}" class="btn btn-primary btn-sm w-100" title="فى الطريق">
                                    <i class="fas fa-hashtag"></i> فى الطريق
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.completed') }}" class="btn btn-primary btn-sm w-100" title="تم التوصيل">
                                    <i class="fas fa-hashtag"></i> تم التوصيل
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.cancel') }}" class="btn btn-primary btn-sm w-100" title="مرتجع">
                                    <i class="fas fa-hashtag"></i> مرتجع
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.amount') }}" class="btn btn-primary btn-sm w-100" title="مرتجع جزئي">
                                    <i class="fas fa-hashtag"></i> مرتجع جزئي
                                </a>
                            </td>
                            
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.pay') }}" class="btn btn-primary btn-sm w-100" title="تم الدفع">
                                    <i class="fas fa-hashtag"></i> تم الدفع
                                </a>
                            </td>
                            
                            <td colspan="1">
                                <a href="{{ route('dashboard.customer.orders.index') }}" class="btn btn-primary btn-sm w-100" title="عرض الكل">
                                   <i class="fas fa-hashtag"></i> عرض الكل
                                </a>
                            </td>
                            
                        </thead>
                        <thead>
                            <tr >
                                <th> رقم البوليصة</th>
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>العنوان</th>
                                <th>سعر الطلب </th>
                                <th class="noprint">حالة الطلب</th>
                                <th>تاريخ  التوصيل </th>
                                <th class="noprint">تاريخ دخول الطلب</th>

                                <th>تاريخ  المرتجع </th>
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
                                        $price = 0;
                                    }
                                    else if($order->status == 6 ){
                                        $status = 'مرتجع'; 
                                        $price = 0 ;
                                    }
                                    else if($order->status == 7 ){
                                        $status = 'مرتجع جزئي';
                                        $price = $order->bounce - $order->ship;
                                        if($price < 0 ){
                                            $price = " مطلوب من العميل ".abs($price);
                                        }
                                        
                                    }
                                @endphp
                                    <tr>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->phone2 ??'' }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }}</td>
                                        <td data-field="phone1" style="width: 422.609px;">{{ $order->phone1 }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->address }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price }} جنية</td>
                                        
                                        <td class="noprint" data-field="id" style="width: 170.312px;">{{ $status  }}</td>
                                        @if($order->status == 2)
                                            <td data-field="id" style="width: 170.312px;">{{ date('l, d M Y - h:i A', strtotime($order->done_date))}} </td>
                                        @else
                                        <td data-field="id" style="width: 170.312px;">-</td>
                                        @endif
                                        <td data-field="id" style="width: 170.312px;">{{ $order->created_at != null ? date('l, d M Y - h:i A', strtotime($order->created_at)): 'لا يوجد تاريح' }}</td>

                                         <td data-field="id" style="width: 170.312px;">{{ $order->mortgee != null ? date('l, d M Y - h:i A', strtotime($order->mortgee)): '-' }}</td>
                                        
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="9" class="text-center bg-primary noprint" style="color: #fff">لا يوجد طلبات الان</td>
                           @endif

                        </tbody>
                        
                    </table>
                    <div class="row noprint">
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                    
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


@endsection