
<!doctype html>
<html lang="en" dir="rtl">
<head>
        
        <meta charset="utf-8" />
         <title> شركة فى الطريق للشحن | تسجيل الدخول </title>
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/icon.png')}}">
        <meta content="width=device-width, initial-scale=1" name="viewport" />

        <!-- Bootstrap Css -->
         <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
    
        label,li,p,table,h1,h2,h3,h4,h5,h6,a,button,input,span,footer,.alert,#liveToast,textarea,.select2,.toast{
            font-family: 'Cairo', sans-serif !important;
        }
        .navbar-brand-box{
            padding: 0px;
        }
        .breadcrumb-item+.breadcrumb-item::before{
            content: '';
        }
        .profile-user-wid {
            margin: auto;
            margin-top: -26px;
        }
    </style>

    @stack('css')

</head>
<body data-sidebar="dark" data-layout-mode="light">
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class=" bg-soft" style="background-color: #2A3042">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-primary p-4 text-center">
                                        <h5 class=" text-bold mb-3" style="color: #fff;font-weight: bold">تسجيل الدخول </h5>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="card-body pt-0"> 
                            <div class="auth-logo">
                                <a href="{{ URL::route('login') }}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/icon.png')}}" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>

                                <a href="{{ URL::route('login') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/icon.png')}}" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            @if(session()->has('error') )
                            <div class="row "  >
                                <div class="col-md-12 text-center">
                                    <div class="alert alert-danger " role="alert" id="name_error">
                                        برجاء التاكد من البريد الالكترونى او كلمة المرور
                                        
                                    </div>
                                </div>
                                
                            </div>
                            @endif
                            <div class="p-2">
                                <form class="form-horizontal" action="{{ route('signin') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-3">
                                        <label for="username" class="form-label">البريد الالكتروني</label>
                                        <input name="email" type="email" required class="form-control" id="username" placeholder="ادخل البريد الالكتروني">
                                    </div>
            
                                    <div class="mb-3">
                                        <label class="form-label">كلمة المرور</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input name="password" required type="password" class="form-control" placeholder="ادخل كلمة المرور" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" style="color: #2A3042" type="checkbox" id="remember-check">
                                        <label class="form-check-label" for="remember-check">
                                            تذكرني
                                        </label>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <button class="btn  waves-effect waves-light" style="background-color: #2A3042;color:#fff" type="submit">تسجيل الدخول</button>
                                    </div>
        
                                    

                                    
                                </form>
                            </div>
        
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>


        <script src="{{URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
        

    <script src="{{URL::asset('assets/js/app.js')}}"></script>
</body>
</html>