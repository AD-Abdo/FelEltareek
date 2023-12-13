<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">اسم المدير</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="ادخل اسم المدير">
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">البريدالاكلتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="ادخل البريد الالكتروني">
        </div>
    </div>
    
</div>
@if($errors->any())
    <div class="row">
        <div class="col-md-6 text-center">
            @if($errors->has('name'))
                <div class="alert alert-danger " style="font-weight: bold" role="alert">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>
        <div class="col-md-6 text-center">
            @if($errors->has('email'))
                <div class="alert alert-danger " style="font-weight: bold" role="alert">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>
    </div>
@endif

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


