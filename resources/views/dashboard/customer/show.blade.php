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
        <h4 class="mb-sm-0 font-size-18">عرض بيانات العميل - {{ $customer->User->name }}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.customers.index') }}" class="btn btn-outline-primary btn-sm show" >
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
                    @include('dashboard.customer.form')
                </form>
            </div>
        </div>
    </div>
    
</div>


@endsection
@push('js')

    <script>
        $(document).ready(function(){
            $('#name').val('{{ $customer->User->name }}').attr('disabled',true);
            $('#email').val('{{ $customer->User->email }}').attr('disabled',true);
            $('#password').val('لا يمكن اظهار كلمة المرور').attr('disabled',true).get(0).type = 'text';
            $('#password_confirmation').val('لا يمكن اظهار تاكيد كلمة المرور').attr('disabled',true).get(0).type='text';
            $('#phone1').val('{{ $customer->phone1 }}').attr('disabled',true);
            $('#phone2').val('{{ $customer->phone2 ??"لم يتم اضافة رقم عميل أخر" }}').attr('disabled',true);
            $('#address').val('{{ $customer->address }}').attr('disabled',true);
        });
    </script>
@endpush