<div class="wrapper">
    <div class="leftside-menu">
        <div class="h-100" id="leftside-menu-container" data-simplebar>
            <a href="{{route('index')}}" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{asset('backend/images/app_setup/' . appSetupValue('logo'))}}" alt="" height="50" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'">
                </span>
                <span class="logo-sm">
                    <img src="{{asset('backend/images/app_setup/' . appSetupValue('logo'))}}" alt="" height="16" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'">
                </span>
            </a>
            <ul class="side-nav">
                <li class="side-nav-item">
                    <a href="{{route('dashboard')}}" class="side-nav-link active">
                        <i class="uil-home-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                 <li class="side-nav-item">
                    <a href="{{route('user.customer_order')}}" class="side-nav-link">
                        <i class="uil-volume"></i>
                        <span>Order Summary </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{route('user.customer_e_puja_order')}}" class="side-nav-link">
                        <i class="uil-volume"></i>
                        <span>E Puja Order</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{route('logout')}}" class="side-nav-link">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
