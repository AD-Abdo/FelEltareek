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
        <h4 class="mb-sm-0 font-size-18">كل طلبات العميل : {{ $customer->User->name }}</h4>
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.orders.index',$customer->id) }}" class="btn btn-outline-success btn-sm" title="اضافة طلب جديد">
                        <i class="fas bx bxs-user-detail"></i>&nbsp
                    </a>
                    <a href="{{ route('dashboard.customers.index') }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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
                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">                            
                        <thead>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customers.getOrders.waiting',$customer->id) }}" class="btn btn-primary btn-sm w-100" title="فى الانتظار">
                                    <i class="fas fa-hashtag"></i> فى الانتظار
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customers.getOrders.onWay',$customer->id) }}" class="btn btn-primary btn-sm w-100" title="فى الطريق">
                                    <i class="fas fa-hashtag"></i> فى الطريق
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customers.getOrders.completed',$customer->id) }}" class="btn btn-primary btn-sm w-100" title="تم التوصيل">
                                    <i class="fas fa-hashtag"></i> تم التوصيل
                                </a>
                            </td>
                            <td colspan="1">
                                <a href="{{ route('dashboard.customers.getOrders.customerCancel',$customer->id) }}" class="btn btn-primary btn-sm w-100" title="ملغى من قبل المستلم">
                                    <i class="fas fa-hashtag"></i> ملغى من قبل المستلم
                                </a>
                            </td>
                            
                            <td colspan="1">
                                <a href="{{ route('dashboard.customers.getOrders',$customer->id) }}" class="btn btn-primary btn-sm w-100" title="عرض الكل">
                                    <i class="fas fa-hashtag"></i> عرض الكل
                                </a>
                            </td>
                            <td colspan="3">
                            </td>
                            
                        </thead>
                        <thead>
                            <tr >
                                <th>رقم الطلب</th>
                                <th>الاسم</th>
                                <th>السعر</th>
                                <th>الشحن</th>
                                <th>السعر الكلى شامل الشحن</th>
                                <th>حالة الطلب</th>
                                <th>تاريخ وصول الطلب</th> 
                                <th>تاريخ استلام الطلب</th>

                                <th>الفاتورة</th>
                            </tr>
                        </thead>
                        
                        <tbody>
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
                                @endphp
                                    <tr>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->serial }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{  $order->ship }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price + $order->ship }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $status  }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->done_date != null ? date('l, d M Y - h:i A', strtotime($order->done_date)) : 'لم يتم توصيل الطلب' }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->done_date != null ? date('l, d M Y - h:i A', strtotime($order->created_at)) : 'لم يتم توصيل الطلب' }}</td>

                                        <td data-field="id" style="width: 170.312px;">
                                            <a href="#" class="btn btn-primary btn-sm w-100" title="فاتورة الطلب">
                                                <i class="bx bx-receipt" title="فاتورة الطلب"></i>
                                            </a>
                                        </td>

                                       
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="9" class="text-center bg-primary" style="color: #fff">لا يوجد طلبات الان</td>
                           @endif

                        </tbody>
                        <tfoot>
                            <tr>
                                {{ $orders->links() }}
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection