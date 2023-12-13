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
        <h4 class="mb-sm-0 font-size-18">اضافة طلب جديد للعميل  - {{ $customer->User->name }}</h4>

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

                <form> 
                    @include('dashboard.order.form')

                    <div class="row text-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn-submit btn btn-primary w-100" title="اضافة">اضافة</button>
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

   
    <script type="text/javascript">

   

        $.ajaxSetup({
    
            headers: {
    
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    
            }
    
        });


    
        
    
        $(".btn-submit").click(function(e){
    
      
    
            e.preventDefault();
    
       
    
            var name = $("#name").val();
            var country = $("#country").val();
            var phone1 = $("#phone1").val();
            var phone2 = $("#phone2").val();
            var price = $("#price").val();
            var ship = $("#ship").val();
            var address = $("#address").val();           
            var customer_id = "{{ $customer->id }}";
            var user_create = 1;
    
            $.ajax({
    
               type:'POST',
    
               url:"{{ URL::route('dashboard.orders.store') }}",
    
               data:{
                name:name,
                country:country,
                phone1:phone1,
                phone2:phone2,
                price:price,
                ship:ship,
                address:address,
                customer_id:customer_id,
                user_create:user_create,
                

                },
    
               success:function(data){
                
                    returnData =data['data'];
                    status = data['status'];
                    if(status == 'true'){
                        $('#liveToastmessage').css('display','block').css('opacity','100%');
                        message = $('#toast-body');
                        message.append(returnData);
                        $("#name").val('');
                        $("#country").val('');
                        $("#phone1").val('');
                        $("#phone2").val('');
                        $("#price").val('');
                        $("#ship").val('');
                        $("#address").val('');
                        setTimeout(function() {
                            $('#liveToastmessage').css('display','none');
                            message.empty();

                            
                           

                        }, 3000); 
                    }
                    else{
                        if(returnData['name'] !=null){
                                error_name = $('#error_name');
                                error_name.css('display','block');
                                name_error = $('#name_error');
                                name_error.append(returnData['name']);
                                setTimeout(function() {
                                name_error.empty();
                                error_name.css('display','none');
                            }, 2000); 
                        }

                        if(returnData['price'] !=null || returnData['ship'] !=null){
                                error_price = $('#error_price');
                                error_ship = $('#error_ship');

                                error_price.css('display','block');
                                error_ship.css('display','block');
                               
                                price_error  = $('#price_error');
                                ship_error  = $('#ship_error');

                                country_error  = $('#country_error');

                                price_error.append(returnData['price']);
                                ship_error.append(returnData['ship']);

                                setTimeout(function() {
                                    price_error.empty();
                                    ship_error.empty();
                                    error_price.css('display','none');
                                    error_ship.css('display','none');
                            }, 2000); 
                        }

                        if(returnData['phone1'] !=null || returnData['phone2'] !=null){
                                error_phone1 = $('#error_phone1');
                                error_phone2 = $('#error_phone2');
                                error_phone1.css('display','block');
                                error_phone2.css('display','block');
                               
                               
                                phone1_error  = $('#phone1_error');
                                phone2_error  = $('#phone2_error');

                                phone1_error.append(returnData['phone1']);
                                phone2_error.append(returnData['phone2']);

                                setTimeout(function() {
                                    phone1_error.empty();
                                    phone2_error.empty();
                                    error_phone1.css('display','none');
                                    error_phone2.css('display','none');
                            }, 2000); 
                        }

                        if(returnData['address'] !=null){
                                error_address = $('#error_address');
                                error_address.css('display','block');
                                address_error  = $('#address_error');
                                address_error.append(returnData['address']);
                                setTimeout(function() {
                                    address_error.empty();
                                    error_address.css('display','none');
                            }, 2000); 
                        }
                        if(returnData['country'] !=null){
                            
                            error_country = $('#error_country');
                            error_country.css('display','block');
                                country_error  = $('#country_error');
                                country_error.append(returnData['country']);
                                setTimeout(function() {
                                    country_error.empty();
                                    error_country.css('display','none');
                            }, 2000); 
                        }


                        
                       
                    }
                    
    
               }
              
    
            });
    
      
    
        });
    
    </script>
    
       
    
    
@endpush
