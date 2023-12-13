<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="name" class="form-label">اسم المستلم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="ادخل اسم المستلم">
        </div>
        
    </div>
    
    
    
</div>
    <div class="row "  >
        <div class="col-md-12 text-center" style="display: none" id="error_name">
                <div class="alert alert-danger " style="font-weight: bold" role="alert" id="name_error">
                    
                </div>
        </div>
        
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="price" class="form-label">سعر الطلب</label>
            <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="price" placeholder="ادخل سعر الطلب">
        </div>
        
    </div>
    
    
    
    
</div>

    <div class="row error"  >
        <div class="col-md-12 text-center" id="error_price" style="display: none">
                <div class="alert alert-danger " style="font-weight: bold" role="alert" id="price_error">
                </div>
            
        </div>
       
        
    </div>




<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone1" class="form-label">رقم الهاتف</label>
            <input type="text" name="phone1" value="{{ old('phone1') }}" class="form-control" id="phone1" placeholder="ادخل رقم الهاتف">
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone2" class="form-label">رقم الهاتف ( فى حالة وجود رقمين للعميل )</label>
            <input type="text" name="phone2" value="{{ old('phone2') }}" class="form-control" id="phone2" placeholder="ادخل رقم الهاتف">
        </div>
    </div>
    
</div>

    <div class="row error" > 
        <div class="col-md-6 text-center" id="error_phone1" style="display: none">
                <div class="alert alert-danger " style="font-weight: bold" role="alert" id="phone1_error">
                </div>
        </div>
        <div class="col-md-6 text-center" id="error_phone2" style="display: none">
                <div class="alert alert-danger " style="font-weight: bold" role="alert" id="phone2_error">
                </div>
        </div>
    </div>







<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="address" class="form-label">عنوان المستلم</label>
            <input type="text" name="address" value="{{ old('address') }}" class="form-control" id="address" placeholder="ادخل عنوان المستلم">
        </div>
        
    </div>
    
</div>
    <div class="row error" >
        <div class="col-md-12 text-center" id="error_address" style="display: none">
                <div class="alert alert-danger " style="font-weight: bold" role="alert" id="error_address">
                </div>
        </div>
    </div>
