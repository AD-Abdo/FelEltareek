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
        <h4 class="mb-sm-0 font-size-18">عرض بيانات المندوب - {{ $delivery->User->name }}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.deliverys.index') }}" class="btn btn-outline-primary btn-sm show" >
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
                    @include('dashboard.delivery.form')
                </form>
            </div>
        </div>
    </div>
    
</div>


@endsection
@push('js')

    <script>
        $(document).ready(function(){
            $('#name').val('{{ $delivery->User->name }}').attr('disabled',true);
            $('#email').val('{{ $delivery->User->email }}').attr('disabled',true);
            $('#password').val('لا يمكن اظهار كلمة المرور').attr('disabled',true).get(0).type = 'text';
            $('#password_confirmation').val('لا يمكن اظهار تاكيد كلمة المرور').attr('disabled',true).get(0).type='text';
            $('#phone1').val('{{ $delivery->phone1 }}').attr('disabled',true);
            $('#phone2').val('{{ $delivery->phone2 ??"لم يتم اضافة رقم دليفرى أخر" }}').attr('disabled',true);
        });
    </script>
@endpush