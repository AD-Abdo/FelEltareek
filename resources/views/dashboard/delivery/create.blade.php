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
        <h4 class="mb-sm-0 font-size-18">اضافة مندوب جديد</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.deliverys.index') }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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

                <form method="POST" action="{{ URL::route('dashboard.deliverys.store') }}"> 
                    @csrf
                    @method('POST')

                    @include('dashboard.delivery.form')

                    <div class="row text-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100" title="اضافة">اضافة</button>
                        </div>
                        
                        <div class="col-md-4"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>


@endsection