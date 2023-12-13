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
        <h4 class="mb-sm-0 font-size-18">طلبات العميل  {{ $customer->User->name }} - تعديل طلب المستلم {{ $order->name }}</h4>

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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                if($order->status == 0 ){
                                    $status = 'فى الانتظار';
                                }else if($order->status == 1 ){
                                    $status = 'فى الطرق';
                                }else if($order->status == 2 ){
                                    $status = 'تم التوصبل';
                                }else if($order->status == 3 ){
                                    $status = 'ملغى';
                                }
                                else if($order->status == 4 ){
                                    $status = 'ملغى من جهة المدير';
                                }
                                
                            @endphp
                                <label for="status" class="form-label">حالة الطلب</label>
                                <input type="text" name="ship" value="{{ $status }}" class="form-control" id="ship" placeholder="حالة الطلب" disabled>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bounce" class="form-label">السعر المدفوع حتى الان</label>
                                <input type="text" name="bounce" value="{{ $order->bounce }}" class="form-control" id="bounce" placeholder="السعر المدفوع حتى الان" disabled>
                            </div>
                            
                        </div>
                        
                        
                        
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                    if($order->status == 0 || $order->status ==  1  || $order->status ==  4){
                                        $mortage = 0;
                                    }else{
                                        if((($order->price + $order->ship ) - $order->bounce) == ($order->price + $order->ship )){
                                            $mortage = "الطلب بالكامل مرتجع ولم يتم دفع مصاريف الشحن";
                                        }else if((($order->price + $order->ship ) - $order->bounce) == ($order->price )){
                                            $mortage = "الطلب بالكامل مرتجع وتم دفع مصاريف الشحن";
                                        }
                                        else{
                                            $mortage = ($order->price + $order->ship ) - $order->bounce;
                                        }
                                    }
                                    
                                @endphp
                                <label for="ship" class="form-label">سعر المرتجع</label>
                                <input type="text" name="ship" value="{{ $mortage }}" class="form-control" id="ship" placeholder="السعر المدفوع حتى الان" disabled>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                if($order->status == 0 || $order->status ==  1 ){
                                    $total = 0;
                                }else if($order->status == 4 ){
                                    $total = 0;
                                }else{
                                    $total = $order->bounce - $order->ship;
                                }

                                if($total < 0 ){
                                    $total =  $order->ship -  $order->bounce ;
                                    $total = 'مطلوب من العميل قيمة الشحن وهى : '.$total.' جنية';
                                }
                                
                            @endphp
                                <label for="ship" class="form-label">مبلغ يتم توصيله للعميل</label>
                                <input type="text" name="ship" value="{{ ($total) }}" class="form-control" id="ship" placeholder="السعر المدفوع حتى الان" disabled>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea name="notes" class="form-control w-100" id="notes" placeholder="ملاحظات الطلب" disabled>{{ $order->notes ?? 'لا يوجد ملاحظات حتى الان' }}</textarea>
                        </div>
                            
                    </div>
                       
                        
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="user_create" class="form-label">انشئ / تم التعديل</label>
                            <input name="text" class="form-control w-100" id="user_create"  disabled>
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
        $('#name').val('{{ $order->name }}');
        $('#customer_id').val('{{ $order->customer_id }}').attr('disabled',true);
        $('#price').val('{{ $order->price }}');
        $('#ship').val('{{ $order->ship }}');
        $('#phone1').val('{{ $order->phone1 }}');
        $('#phone2').val('{{ $order->phone2 }}');
        $('#address').val('{{ $order->address }}');
        $('#user_create').val('{{ $order->UserCreate->name }}').attr('disabled',true);
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

        

        var name = $("#name").val();
        var country = $("#country").val();
        var phone1 = $("#phone1").val();
        var phone2 = $("#phone2").val();
        var price = $("#price").val();
        var ship = $("#ship").val();
        var address = $("#address").val();           
        var user_create = 1;

        $.ajax({

           type:'POST',

           url:"{{ URL::route('dashboard.orders.update',[$customer->id,$order->id]) }}",

           data:{
            name:name,
            country:country,
            phone1:phone1,
            phone2:phone2,
            price:price,
            ship:ship,
            address:address,
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