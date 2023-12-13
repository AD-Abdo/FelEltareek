@extends('dashboard.layouts.main')
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
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">تحديث سعر طلب المندوب : {{$order->Delivery->User->name }}</h4>
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.deliverys.getOrders',$order->Delivery->id) }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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

                <form method="POST" action="{{ URL::route('dashboard.deliverys.getOrders.price.edit',$order->id) }}"> 
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="price" class="form-label">السعر المستلم</label>
                                <input type="number" name="price" class="form-control" value="{{ $order->bounce }}" id="price" placeholder="السعر المستلم">
                            </div>
                            
                        </div>
                    </div>
                        @if($errors->any())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if($errors->has('price'))
                                        <div class="alert alert-danger " style="font-weight: bold" role="alert">
                                            {{ $errors->first('price') }}
                                        </div>
                                    @endif
                                </div>
                                
                            </div>
                        @endif
                   

                    <div class="row text-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100" title="تعديل">تعديل</button>
                        </div>
                        
                        <div class="col-md-4"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>


@endsection