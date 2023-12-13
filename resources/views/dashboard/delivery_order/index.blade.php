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
        <h4 class="mb-sm-0 font-size-18" id="title1">كل طلبات المندوب - {{ Auth::user()->name }}</h4>



        

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
                        <thead>
                            @if($search == true)
                                <td colspan="9">
                                    <form action="{{ URL::route('dashboard.delivery.orders.searchOrder') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <div class="row">
                                                     <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="date" value="{{ $search_value }}"  name="date"  class="form-control text-center" id="date" placeholder=" ابحث بتاريخ وصول الطلبات">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_name }}"  name="name"  class="form-control text-center" id="date" placeholder=" ابحث باسم صاحب الطلب">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_phone }}"  name="phone"  class="form-control text-center" id="date" placeholder=" ابحث برقم البوليصة">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_address }}"  name="address"  class="form-control text-center" id="date" placeholder=" ابحث بالمحافظة">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value="{{ $search_phoneNumber }}"  name="phoneNumber"  class="form-control text-center" id="phone" placeholder=" ابحث برقم الهاتف">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;display: inline  " type="submit" class="form-control btn btn-primary btn-sm " value="بحث">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>                        
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.delivery.orders.index') }}" class="btn btn-outline-primary btn-sm w-100" title="عرض الكل">
                                        <i class="mdi mdi-close"></i>عرض الكل
                                    </a>
                                </td>
                            @else
                                <td colspan="9">
                                    <form action="{{ URL::route('dashboard.delivery.orders.searchOrder') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <div class="row">
                                                    
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="date" name="date"  class="form-control text-center" id="date" placeholder=" ابحث بتاريخ وصول الطلبات">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="name"  class="form-control text-center" id="date" placeholder=" ابحث باسم صاحب الطلب">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="phone"  class="form-control text-center" id="date" placeholder=" ابحث برقم البوليصة">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" value=""  name="address"  class="form-control text-center" id="date" placeholder=" ابحث بالمحافظة">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text"   name="phoneNumber"  class="form-control text-center" id="phone" placeholder=" ابحث برقم الهاتف">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input style="border-radius: 50px;display: inline  " type="submit" class="form-control btn btn-primary btn-sm " value="بحث">
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
                                <a href="{{ route('dashboard.delivery.orders.waiting') }}" class="btn btn-primary btn-sm w-100" title="فى الانتظار">
                                    <i class="fas fa-hashtag"></i> فى الانتظار
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.delivery.orders.onWay') }}" class="btn btn-primary btn-sm w-100" title="فى الطريق">
                                    <i class="fas fa-hashtag"></i> فى الطريق
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.delivery.orders.completed') }}" class="btn btn-primary btn-sm w-100" title="تم التوصيل">
                                    <i class="fas fa-hashtag"></i> تم التوصيل
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.delivery.orders.index') }}" class="btn btn-primary btn-sm w-100" title="عرض الكل">
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
                                <th>رقم الهاتف</th>
                                <th>سعر الطلب </th>
                                <th class="noprint">العنوان</th>
                                <th class="noprint">اسم العميل</th>
                                <th class="noprint">حالة الطلب</th>
                                <th>تاريخ  التوصيل </th>
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
                                    $total =  $total + ($order->bounce - $order->ship);
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
                                @endphp
                                    <tr>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->phone2 }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }} <span style="color:#00FF00">@if($order->bounce == $order->price)&nbsp ✓ @endif </span></td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->phone1 }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price + $order->ship}} جنية</td>
                                        
                                         <td data-field="id" style="width: 170.312px;">{{ $order->address}}</td>
                                         <td data-field="id" style="width: 170.312px;">{{ $order->Customer->User->name}}</td>
                                        
                                        <td class="noprint" data-field="id" style="width: 170.312px;">{{ $status  }}</td>
                                        @if($order->status == 2)
                                            <td data-field="id" style="width: 170.312px;">{{ date('l, d M Y - h:i A', strtotime($order->done_date))}} </td>
                                        @else
                                        <td data-field="id" style="width: 170.312px;">-</td>
                                        @endif
                                        <td  class="noprint" style="width: 100px">
                                            @if($order->status == 0 )
                                                <a href="{{ URL::route('dashboard.delivery.orders.agree',$order->id) }}" class="btn btn-outline-info btn-sm edit" title="جاهز للتوصيل">
                                                    <i class="mdi mdi-run" title="جاهز للتوصيل"></i>
                                                </a>
                                            @elseif($order->status == 1 )
                                                <a href="{{ URL::route('dashboard.delivery.orders.show',$order->id) }}" class="btn btn-outline-info btn-sm edit" title="عرض بيانات الطلب">
                                                    <i class="far fa-eye" title="عرض بيانات الطلب"></i>
                                                </a>
                                            @else
                                            -
                                            @endif
     
                                            
                                        </td>
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="10" class="text-center bg-primary noprint" style="color: #fff">لا يوجد طلبات الان</td>
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