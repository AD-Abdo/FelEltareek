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
        <h4 class="mb-sm-0 font-size-18">طلبات العميل  {{ $customer->User->name }} - عرض بيانات طلب المستلم {{ $order->name }}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.orders.index',$customer) }}" class="btn btn-outline-primary btn-sm show" >
                        <i class="fas fa-arrow-left"></i>&nbsp
                    </a>
                </li>
            </ol>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <form> 

                    @include('dashboard.order.form')
                    <div class="row">  
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="delivery_id" class="form-label">المندوب</label>
                                <select class="form-control select2 " data-select2-id="1" tabindex="-1" aria-hidden="true" name="delivery_id" id="delivery_id">
                                    <option disabled selected data-select2-id="3">اختر المندوب</option>
                                    @foreach($deliverys as $delivery)
                                        <option value="{{ $delivery->id }}" data-select2-id="21">{{ $delivery->User->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                if($order->status == 0 ){
                                    $status = 'فى الانتظار';
                                }else if($order->status == 1 ){
                                    $status = 'فى الطرق';
                                }else if($order->status == 2 ){
                                    $status = 'تم التوصبل';
                                }else if($order->status == 3 ){
                                    $status = 'ملغى';
                                }
                                else if($order->status == 4 ){
                                    $status = 'ملغى';
                                }
                                else if($order->status == 5 ){
                                    $status = 'تم الدفع';
                                }
                                else if($order->status == 6 ){
                                    $status = 'مرتجع';
                                }
                                else if($order->status == 7 ){
                                    $status = 'مرتجع جزئي';
                                }
                                
                            @endphp
                                <label for="status" class="form-label">حالة الطلب</label>
                                <input type="text" name="ship" value="{{ $status }}" class="form-control" id="ship" placeholder="حالة الطلب" disabled>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bounce" class="form-label">السعر المدفوع حتى الان</label>
                                <input type="text" name="bounce" value="{{ $order->bounce }}" class="form-control" id="bounce" placeholder="السعر المدفوع حتى الان" disabled>
                            </div>
                            
                        </div>
                        
                        
                        
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                    if($order->status == 0 || $order->status ==  1  ){
                                        $mortage = 0;
                                    }else{
                                        if((($order->price + $order->ship ) - $order->bounce) == ($order->price + $order->ship )){
                                            $mortage = "الطلب بالكامل مرتجع ولم يتم دفع مصاريف الشحن";
                                        }else if((($order->price + $order->ship ) - $order->bounce) == ($order->price )){
                                            $mortage = "الطلب بالكامل مرتجع وتم دفع مصاريف الشحن";
                                        }
                                        else{
                                            $mortage = ($order->price + $order->ship ) - $order->bounce;
                                        }
                                    }
                                    
                                @endphp
                                <label for="ship" class="form-label">سعر المرتجع</label>
                                <input type="text" name="ship" value="{{ $mortage }}" class="form-control" id="ship" placeholder="السعر المدفوع حتى الان" disabled>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                if($order->status == 0 || $order->status ==  1  ){
                                    $total = 0;
                                }else{
                                    $total = $order->bounce - $order->ship;
                                }

                                if($total < 0 ){
                                    $total =  $order->ship -  $order->bounce ;
                                    $total = 'مطلوب من العميل قيمة الشحن وهى : '.$total.' جنية';
                                }
                                
                            @endphp
                                <label for="ship" class="form-label">مبلغ يتم توصيله للعميل</label>
                                <input type="text" name="ship" value="{{ ($total) }}" class="form-control" id="ship" placeholder="السعر المدفوع حتى الان" disabled>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">ملاحظات</label>
                                <textarea name="notes" class="form-control w-100" id="notes" placeholder="ملاحظات الطلب" disabled>{{ $order->notes ?? 'لا يوجد ملاحظات حتى الان' }}</textarea>
                        </div>
                            
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="user_create" class="form-label">انشئ / تم التعديل</label>
                            <input name="text" class="form-control w-100" id="user_create"  disabled>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
    
</div>


@endsection
@push('js')

    <script>
        $(document).ready(function(){
            
            $('#name').val('{{ $order->name }}').attr('disabled',true);
            $('#customer_id').val('{{ $order->customer_id }}').attr('disabled',true);
            $('#delivery_id').val('{{ $order->delivery_id ?? "لم يتم اختيار اى مندوب" }}').attr('disabled',true);
            $('#price').val('{{ $order->price }}').attr('disabled',true);
            $('#ship').val('{{ $order->ship }}').attr('disabled',true);
            $('#phone1').val('{{ $order->phone1 ??"لم يتم اضافة رقم عميل أخر"  }}').attr('disabled',true);
            $('#phone2').val('{{ $order->phone2 ??"لم يتم اضافة رقم عميل أخر" }}').attr('disabled',true);
            $('#address').val('{{ $order->address ?? "لا يوجد عنوان مضاف" }}').attr('disabled',true);
            $('#user_create').val('{{ $order->UserCreate->name }}').attr('disabled',true);

        });
    </script>
@endpush