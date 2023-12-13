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
        <h4 class="mb-sm-0 font-size-18">طلبات العميل  {{ $customer->User->name }} - اضافة / تعديل مندوب لطلب المستلم {{ $order->name }}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"> 
                    <a href="{{ route('dashboard.orders.index',$customer) }}" class="btn btn-outline-primary btn-sm" title="رجوع">
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

                <form > 
                       
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="delivery_id" class="form-label">المندوب</label>
                                <select class="form-control select2 " data-select2-id="1" tabindex="-1" aria-hidden="true" name="delivery_id" id="delivery_id">
                                    <option disabled selected data-select2-id="3">اختر المندوب</option>
                                    @foreach($deliverys as $delivery)
                                        <option value="{{ $delivery->id }}" data-select2-id="21">{{ $delivery->User->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            
                        </div>
                        
                        
                        
                    </div>
                        <div class="row">
                            <div class="col-md-12 text-center" id="error_delivery_id" style="display: none">
                                    <div class="alert alert-danger " style="font-weight: bold" role="alert" id="delivery_id_error">
                                    </div>
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
            setTimeout(function() {
                $('#error').fadeOut('slow');
            }, 3000); 

        });
        
    </script>


    <script>
        $(document).ready(function(){
            $('#delivery_id').val('{{ $order->delivery_id }}');
        });
    </script>
    <script type="text/javascript">

   

        $.ajaxSetup({
    
            headers: {
    
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    
            }
    
        });
    
    
    
        
    
        $(".btn-submit").click(function(e){
    
      
    
            e.preventDefault();
    
       
    
            var delivery_id = $("#delivery_id").val();

            var user_create = 1;
    
            $.ajax({
    
               type:'POST',
    
               url:"{{ URL::route('dashboard.orders.setDelivey',[$customer->id,$order->id]) }}",
    
               data:{
                delivery_id:delivery_id,
                user_create:user_create,
    
                },
    
               success:function(data){
                
                    returnData =data['data'];
                    status = data['status'];
                    if(status == 'true'){
                        $('#liveToastmessage').css('display','block').css('opacity','100%');
                        message = $('#toast-body');
                        message.append(returnData);
                        
                        setTimeout(function() {
                            $('#liveToastmessage').css('display','none');
                            message.empty();
                        }, 3000); 
                    }
                    else{
                        if(returnData['delivery_id'] !=null){
                                error_name = $('#error_delivery_id');
                                error_name.css('display','block');
                                name_error = $('#delivery_id_error');
                                name_error.append(returnData['delivery_id']);
                                setTimeout(function() {
                                name_error.empty();
                                error_name.css('display','none');
                            }, 2000); 
                        }
    
                        
                       
                    }
                    
    
               }
              
    
            });
    
      
    
        });
    
    </script>
@endpush