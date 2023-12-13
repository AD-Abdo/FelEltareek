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
        <h4 class="mb-sm-0 font-size-18">تعديل كلمة  المرور</h4>

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

                <form method="POST" action="{{ URL::route('dashboard.changePassword.update') }}"> 
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input id="password" type="password" name="password" class="form-control" id="password" placeholder="ادخل كلمة المرور">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تاكيد كلمة المرور</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="ادخل تاكيد كلمة المرور">
                            </div>
                        </div>
                        
                    </div>
                    @if($errors->any())
                        <div class="row">
                            <div class="col-md-6 text-center">
                                @if($errors->has('password'))
                                    <div class="alert alert-danger " style="font-weight: bold" role="alert">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 text-center">
                                @if($errors->has('password_confirmation'))
                                    <div class="alert alert-danger " style="font-weight: bold" role="alert">
                                        {{ $errors->first('password_confirmation') }}
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