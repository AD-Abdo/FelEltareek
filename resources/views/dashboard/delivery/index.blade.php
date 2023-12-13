@extends('dashboard.layouts.main')
@push('css')
<link href="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

@endpush
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
        <h4 class="mb-sm-0 font-size-18">كل المناديب</h4>


        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.deliverys.create') }}" class="btn btn-outline-primary btn-sm" title="اضافة مندوب جديد">
                        <i class="fas fa-plus"></i>&nbsp
                        اضافة مندوب جديد
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
                            @if($search == true)
                                <td colspan="6">
                                    <form action="{{ URL::route('dashboard.deliverys.search') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="name" value="{{ $search_value }}" class="form-control text-center" id="name" placeholder=" ابحث باسم المندوب">
                                    </form>                        
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.deliverys.index') }}" class="btn btn-outline-primary btn-sm w-100" title="عرض الكل">
                                        <i class="mdi mdi-close"></i>عرض الكل
                                    </a>
                                </td>
                            @else
                                <td colspan="7">
                                    <form action="{{ URL::route('dashboard.deliverys.search') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="name"  class="form-control text-center" id="name" placeholder=" ابحث باسم المندوب">
                                    </form>                        
                                </td>
                            @endif
                        </thead>
                        <thead>
                            <tr >
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>رقم الهاتف 1</th>
                                <th>رقم الهاتف 2</th>
                                <th>أنشئ بواسطة</th>
                                <th>تاريخ / وقت الانشاء</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        @php
                            $id = 1;
                        @endphp
                        <tbody>
                           @if(count($deliverys) > 0)
                                @foreach($deliverys as $delivery)
                                    <tr>
                                        <td data-field="id" style="width: 170.312px;">{{ $id++ }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $delivery->User->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $delivery->phone1 }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $delivery->phone2 ?? 'لا يوجد' }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $delivery->UserCreate->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ date('l, d M Y - h:i A', strtotime($delivery->created_at)) }}</td>
                                        <td style="width: 100px">
                                            <a href="{{ URL::route('dashboard.deliverys.getOrders',$delivery->id) }}" class="btn btn-outline-success btn-sm edit" title="طلبات المندوب {{ $delivery->User->name }}">
                                                <i class="fas fa-shopping-basket" title="طلبات المندوب {{ $delivery->User->name }}"></i>
                                            </a>
                                            <a href="{{ URL::route('dashboard.deliverys.show',$delivery->id) }}" class="btn btn-outline-info btn-sm edit" title="عرض بيانات المندوب">
                                                <i class="far fa-eye" title="عرض بيانات المندوب"></i>
                                            </a>
                                            <a href="{{ URL::route('dashboard.deliverys.edit',$delivery->id) }}" class="btn btn-outline-secondary btn-sm edit" title="تعديل بيانات المندوب">
                                                <i class="fas fa-pencil-alt" title="تعديل بيانات المندوب"></i>
                                            </a>
                                            
                                            
                                            <button value="{{ $delivery->id }}" onclick="Delete({{ $delivery->id }})" type="button" class="btn btn-outline-danger btn-sm edit" title="حذف بيانات المندوب">
                                                <i class="fas fa-trash-alt" title="حذف بيانات المندوب"></i>
                                            </button>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="7" class="text-center bg-primary" style="color: #fff">لا يوجد مناديب الان</td>
                           @endif

                        </tbody>
                        
                    </table>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            {{ $deliverys->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection
@push('js')
    <script src="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <div class="swal2-container swal2-center swal2-backdrop-show" id="divDelete" style="overflow-y: auto;">
        <div aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-popup swal2-modal swal2-icon-warning swal2-show" tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: flex;">
            <div class="swal2-header">
                <ul class="swal2-progress-steps" style="display: none;">
                </ul>
                <div class="swal2-icon swal2-error" style="display: none;">
                </div>
                <div class="swal2-icon swal2-question" style="display: none;">
                </div>
                <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;">
                    <div class="swal2-icon-content">!</div>
                </div>
                <div class="swal2-icon swal2-info" style="display: none;">
                </div>
                <div class="swal2-icon swal2-success" style="display: none;">
                </div>
                <img class="swal2-image" style="display: none;">
                <h2 class="swal2-title" id="swal2-title" style="display: flex;">هل انت متاكد من عملية الحذف ؟</h2>
                <button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
            </div>
            <div class="swal2-content">
                <input class="swal2-input" style="display: none;">
                <input type="file" class="swal2-file" style="display: none;">
                <div class="swal2-range" style="display: none;">
                    <input type="range">
                    <output></output>
                </div>
                <select class="swal2-select" style="display: none;"></select>
                <div class="swal2-radio" style="display: none;">
                </div>

                <label for="swal2-checkbox" class="swal2-checkbox" style="display: none;">
                    <input type="checkbox">
                    <span class="swal2-label"></span>
                </label>
                <textarea class="swal2-textarea" style="display: none;"></textarea>
                <div class="swal2-validation-message" id="swal2-validation-message"></div>
            </div>
            <div class="swal2-actions">
                <div class="swal2-loader"></div>

                <form method="POST" action="{{ URL::route('dashboard.deliverys.destroy') }}" style="display: inline">
                    @csrf
                    @method('POST')
                    <input type="number" value="" name="id" id="customerDelete" style="display: none">
                    <button type="submit" class="swal2-confirm btn btn-success mt-2" style="display: inline-block;" title="حذف بيانات المندوب">
                        حذف بيانات المندوب
                    </button>
                </form>
                <button type="button" class="swal2-deny" aria-label="" style="display: none;" >الفاء</button>
                <button type="button" class="swal2-cancel btn btn-danger ms-2 mt-2" aria-label=""  id="noDelete" style="display: inline-block;">الغاء</button>
            </div>
            <div class="swal2-footer" style="display: none;"></div>
            <div class="swal2-timer-progress-bar-container">
                <div class="swal2-timer-progress-bar" style="display: none;"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#divDelete").hide();
        });
        function Delete(id){
            $('#customerDelete').val(id);

            console.log($('#customerDelete').val());
            $('#divDelete').show();
        }
        $( "#delete" ).click(function() {
            $('#customerDelete').val($('#delete').val());

            console.log($('#customerDelete').val());
            $('#divDelete').show();
        });

        $( "#noDelete" ).click(function() {
            $('#divDelete').hide();
        });
    </script>


@endpush
