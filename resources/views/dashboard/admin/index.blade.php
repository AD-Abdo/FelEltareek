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
        <h4 class="mb-sm-0 font-size-18">كل المديرين</h4>


        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.admins.create') }}" class="btn btn-outline-primary btn-sm" title="اضافة مدير جديد">
                        <i class="fas fa-plus"></i>&nbsp
                        اضافة مدير جديد
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
                                <td colspan="3">
                                    <form action="{{ URL::route('dashboard.admins.search') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="name" value="{{ $search_value }}" class="form-control text-center" id="name" placeholder=" ابحث باسم المدير">
                                    </form>                        
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.admins.index') }}" class="btn btn-outline-primary btn-sm w-100" title="عرض الكل">
                                        <i class="mdi mdi-close"></i>عرض الكل
                                    </a>
                                </td>
                            @else
                                <td colspan="4">
                                    <form action="{{ URL::route('dashboard.admins.search') }}" method="POST" >
                                        @csrf
                                        @method('POST')
                                        <input style="border-radius: 50px;box-shadow: 3px 3px 5px #888888; " type="text" name="name"  class="form-control text-center" id="name" placeholder=" ابحث باسم المدير">
                                    </form>                        
                                </td>
                            @endif
                        </thead>
                        <thead>
                            <tr >
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>تاريخ / وقت الانشاء</th>
                            </tr>
                        </thead>
                        @php
                            $id = 1;
                        @endphp
                        <tbody>
                           @if(count($admins) > 0)
                                @foreach($admins as $admin)
                                    <tr>
                                        <td data-field="id" style="width: 170.312px;">{{ $id++ }}</td>
                                        <td data-field="name" style="width: 422.609px;">{{ $admin->name }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ $admin->email }}</td>
                                        <td data-field="id" style="width: 170.312px;">{{ date('l, d M Y - h:i A', strtotime($admin->created_at)) }}</td>
                                        
                                    </tr>
                                @endforeach
                           @else
                                <td colspan="4" class="text-center bg-primary" style="color: #fff">لا يوجد مديرين الان</td>
                           @endif

                        </tbody>
                       
                    </table>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection