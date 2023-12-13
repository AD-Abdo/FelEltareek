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
        <h4 class="mb-sm-0 font-size-18">طلب العميل  {{ $order->name }} </h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.delivery.orders.index') }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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

                <form  action="{{ URL::route('dashboard.delivery.orders.update',$order->id) }}" method="POST">
                    @csrf
                    @method('PATCH') 
                    @include('dashboard.delivery_order.form')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="total" class="form-label">المبلغ المستلم من العميل</label>
                            <input type="number" name="total" value="{{ old('total') }}" class="form-control" id="total" placeholder="ادخل المبلغ المستلم من العميل">
                        </div>
                            
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea name="notes" class="form-control w-100" id="notes" placeholder="ملاحظات الطلب"></textarea>
                        </div>
                            
                    </div>
                       
                        
                                  
                    
                    <div class="row text-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100 btn-submit" title="تعديل">تعديل</button>
                        </div>
                        
                        <div class="col-md-4"></div>
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
        $('#price').val('{{ $order->price + $order->ship }}').attr('disabled',true);
        $('#phone1').val('{{ $order->phone1 }}').attr('disabled',true);
        $('#phone2').val('{{ $order->phone2 }}').attr('disabled',true);
        $('#address').val('{{ $order->address }}').attr('disabled',true);
        $('#user_create').val('{{ $order->UserCreate->name }}').attr('disabled',true);
    });
</script>

@endpush