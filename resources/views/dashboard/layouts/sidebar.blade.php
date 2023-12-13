<div class="vertical-menu">

    <div data-simplebar="init" class="h-100"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="left: -20px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll; padding-left: 20px; padding-bottom: 0px;"><div class="simplebar-content" style="padding: 0px;">

        <!--- Sidemenu -->
        <div id="sidebar-menu" class="mm-active">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mm-show" id="side-menu">
                <li class="menu-title" key="t-menu">القائمة</li>

                <li class="{{ $list[0] }}">
                    <a href="{{ URL::route('dashboard.home') }}" class=" waves-effect {{ $list[0] }}">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">لوحة التحكم</span>
                    </a>
                </li>

               @if(Auth::user()->role == 1)

                <li class="menu-title" key="t-customer">نشاط العملاء</li>

                <li class="{{ $list[1] }}">
                    <a href="{{ URL::route('dashboard.customers.index') }}" class="waves-effect {{ $list[1] }}">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-customer">العملاء</span>
                    </a>
                </li>
                <li class="{{ $list[5] }}">
                    <a href="{{ URL::route('dashboard.orders.pendding') }}" class="waves-effect {{ $list[5] }}">
                        <i class="bx bxs-hot"></i>
                        <span key="t-customer">الطلبات المعلقة</span>
                    </a>
                </li>

               
               
              
                <li class="menu-title" key="t-delivery">نشاط المناديب</li>

                <li class="{{ $list[2] }}">
                    <a href="{{ URL::route('dashboard.deliverys.index') }}" class="waves-effect" {{ $list[2] }}>
                        <i class="bx bx-run"></i>
                        <span key="t-delivery">المناديب</span>
                    </a>
                    
                </li>

                
                <li class="menu-title" key="t-admin">نشاط المدير</li>

                <li class="{{ $list[3] }}">
                    <a href="{{ URL::route('dashboard.admins.index') }}" class="waves-effect {{ $list[3] }}">
                        <i class="bx bx-user"></i>
                        <span key="t-admin">المدراء</span>
                    </a>
                    
                </li>
                @endif
                @if(Auth::user()->role == 2)

                
                <li class="{{ $list[2] }}">
                    <a href="{{ URL::route('dashboard.delivery.orders.index') }}" class="waves-effect" {{ $list[2] }}>
                        <i class="bx bx-run"></i>
                        <span key="t-delivery">الطلبات</span>
                    </a>
                    
                </li>

                
                
                @endif
                @if(Auth::user()->role == 3)

                
                <li class="{{ $list[4] }}">
                    <a href="{{ URL::route('dashboard.customer.orders.create') }}" class="waves-effect" {{ $list[2] }}>
                        <i class="bx bx-plus"></i>
                        <span key="t-delivery">اضافة طلب</span>
                    </a>
                    
                </li>
                <li class="{{ $list[2] }}">
                    <a href="{{ URL::route('dashboard.customer.orders.index') }}" class="waves-effect" {{ $list[2] }}>
                        <i class="bx bx-run"></i>
                        <span key="t-delivery">الطلبات</span>
                    </a>
                    
                </li>

                
                
                @endif

                   
        </div>
        <!-- Sidebar -->
    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1398px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 334px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
</div>