@extends('dashboard.layouts.main')
@push('css')
<link href="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <style>
    @media print {
        *{
            font-size:15px !important;
        }
        .noprint{
            display:none !important;
        }
    }
    </style>
@endpush
@php
    $list[0]="";
    $list[1]="";
    $list[2]="";
    $list[3]="";
    $list[4]="";
    $list[5]="mm-active";

@endphp
@section('content')
<div class="row">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18" id="title1">كل الطلبات المعلقة
        @if($search == true)
            <form class="mt-2" style="display:inline  !important" action="{{ URL::route('dashboard.orders.pay',$customer) }}" method="POST" >
                @csrf
                @method('POST')
                <input style="display:none"  value="{{ $search_value }}" type="date" name="name"  class="form-control" id="name" placeholder=" ابحث برقم الطلب">
                <input style="display:none"  value="{{ $search_valueTo }}" type="date" name="nameTo"  class="form-control" id="nameTo" placeholder=" ابحث برقم الطلب">
                <input  style="display:none"  value="{{ $search_name }}" type="text" name="customer"  class="form-control" id="customer" placeholder=" ابحث باسم العميل">
                <input  style="display:none"  value="{{ $search_phone }}" type="text" name="phone"  class="form-control" id="phone" placeholder=" ابحث برقم العميل">
                <input style="display:inline  !important"  type="submit" class="mt-2 form-control btn btn-primary btn-sm " value="دفع الفاتورة">
            </form>    
        @endif
        </h4>



        
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <h4 class="mb-sm-0 font-size-18" id="title2" style="display: none">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/icon.png')}}" alt="" height="60">
                    </span>
                </h4>


                
                <div class="table-responsive noprint">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        
                        <thead>
                            <tr >
                                <th>رقم البوليصة</th>
                                <th> العميل</th>
                                <th>الاسم</th>
                                <th>سعر الطلب </th>
                                <th class="noprint">عنوان الطلب</th>
                                <th class="noprint">تاريخ انشاء الطلب</th>
                                <th class="noprint">العمليات</th>
                                
                            </tr>
                        </thead>
                        @php
                            $total = 0;
                        @endphp
                        <tbody>
                           @if(count($orders) > 0)
                                
                                @foreach($orders as $order)
                                   
                                    <tr>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->phone2 }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->Customer->User->name }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $order->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->price }} جنية</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->address ?? '-' }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $order->created_at != null ? date('l, d M Y - h:i A', strtotime($order->created_at)): 'لا يوجد تاريح' }}</td>

                                        <td  class="noprint" style="width: 100px">
                                            
                                                
                                                <a href="{{ URL::route('dashboard.orders.penddingSetPrice.Create',$order->id ) }}" type="button" class="btn btn-outline-success btn-sm edit"  title="اضافة الطلب">
                                                    <i class="fas fa-plus" title="اضافة الطلب"></i>
                                                </a>
                                                <button value="{{ $order->id }}" onclick="Delete({{ $order->id }})" type="button" class="btn btn-outline-danger btn-sm edit" title="حذف بيانات الطلب">
                                                    <i class="fas fa-trash-alt" title="حذف بيانات الطلب"></i>
                                                </button>

                                            
                                        </td>
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="7" class="text-center bg-primary noprint" style="color: #fff">لا يوجد طلبات الان</td>
                           @endif
                           
                           

                        </tbody>
                        
                    </table>
                    <div class="row noprint" >
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
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

                <form method="POST" action="{{ URL::route('dashboard.orders.pendding.delete') }}" style="display: inline">
                    @csrf
                    @method('POST')
                    <input type="number" value="" name="id" id="customerDelete" style="display: none">
                    <button type="submit" class="swal2-confirm btn btn-success mt-2" style="display: inline-block;" title="حذف بيانات الطلب">
                        حذف بيانات الطلب
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
