<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Genial</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{route('vendor.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{route('vendor.profile')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Profile</div>
            </a>
        </li>
        <li>
            <a href="{{route('product.index')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-cart-alt"></i>
                </div>
                <div class="menu-title">Product</div>
            </a>
        </li>
        <li>
            <a href="{{route('service.index')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Service</div>
            </a>
        </li>
        <li>
            <a href="{{route('vendor_payment_histroy')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-wallet-alt"></i>
                </div>
                <div class="menu-title">Payment Histroy</div>
            </a>
        </li>
        <li>
            <a href="{{route('topup_category')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-duplicate"></i>
                </div>
                <div class="menu-title">Topup Categories</div>
            </a>
        </li>
        <li>
            <a href="{{route('vendor.orders')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-notification"></i>
                </div>
                <div class="menu-title">Order</div>
            </a>
        </li>
        <li>
            <a href="{{route('vendor.service_orders')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-notification"></i>
                </div>
                <div class="menu-title">Service Order</div>
            </a>
        </li>
        <li>
            <a href="{{route('pos.index')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-repost"></i>
                </div>
                <div class="menu-title">POS</div>
            </a>
        </li>

    </ul>
    <!--end navigation-->
</div>
