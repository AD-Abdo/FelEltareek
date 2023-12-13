
<!doctype html>
<html lang="en" dir="rtl">
<head>
        
        <meta charset="utf-8" />
        <title> شركة فى الطريق للشحن | لوحة التحكم </title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/icon.png')}}">
        <!-- Bootstrap Css -->
        <link href="{{URL::asset('assets/css/bootstrap-rtl.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{URL::asset('assets/css/app-rtl.min.css')}}"  rel="stylesheet" type="text/css" />
        


        

        <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        
        label,li,p,table,h1,h2,h3,h4,h5,h6,a,button,input,span,footer,.alert,#liveToast,textarea,.select2,.toast,.cairo{
            font-family: 'Cairo', sans-serif !important;
        }
        .navbar-brand-box{
            padding: 0px;
        }
        .breadcrumb-item+.breadcrumb-item::before{
            content: '';
        }
    </style>

    @stack('css')

</head>
<body class="twocolumn-panel" data-sidebar="dark" data-layout-mode="light">
    <div id="layout-wrapper">
        
        @include('dashboard.layouts.header')
        @include('dashboard.layouts.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1005">
                        @if(session()->has('message'))
                            <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" >
                                <div class="toast-header" style="background-color: #FDC910;color: #2A3042">
                                    <strong class="me-auto">اشعار</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    {{ session()->get('message') }}
                                </div>
                            </div>
                        @endif
                        <div id="liveToastmessage" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header" style="background-color: #FDC910;color: #2A3042">
                                <strong class="me-auto">اشعار</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body"id="toast-body">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @include('dashboard.layouts.footer')
        </div>


    </div>
    
    <div class="rightbar-overlay"></div>

     <script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    
    <script>
            
        $(document).ready(function(){
            setTimeout(function() {
                $('#liveToast').fadeOut('slow');
            }, 3000); 

        });
    </script>
    
    @stack('js')

    <script src="{{URL::asset('assets/js/app.js')}}"></script>
</body>
</html>