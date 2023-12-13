@extends('dashboard.layouts.main')
@php
    $list[0]="";
    $list[1]="";
    $list[2]="";
    $list[3]="mm-active";
    $list[4]="";
    $list[5]="";


@endphp
@section('content')
<div class="row">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">تعديل البيانات الشخصية</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.home') }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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

                <form method="POST" action="{{ URL::route('dashboard.profile.update') }}"> 
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" id="name" placeholder="ادخل الاسم">
                            </div>
                            
                        </div>
                        
                    </div>
                    @if($errors->any())
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if($errors->has('name'))
                                    <div class="alert alert-danger " style="font-weight: bold" role="alert">
                                        {{ $errors->first('name') }}
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