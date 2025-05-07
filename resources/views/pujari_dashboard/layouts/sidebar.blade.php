<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="{{ route('index') }}"> <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                    class="logo-icon" alt="logo icon"> </a>
        </div>
        <div>
            <h4 class="logo-text"></h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{Route::is('pujari.dashboard') ? 'mm-active' : ''}}">
            <a href="{{ route('pujari.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="{{Route::is('pujari.profile') ? 'mm-active' : ''}}">
            <a href="{{ route('pujari.profile') }}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Profile</div>
            </a>
        </li>
        <li class="{{Route::is('assign_puja') ? 'mm-active' : ''}}">
            <a href="{{ route('assign_puja') }}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-list-check"></i>
                </div>
                <div class="menu-title">Assign Puja</div>
            </a>
        </li>
        <li class="{{Route::is('wallet') ? 'mm-active' : ''}}">
            <a href="{{ route('wallet') }}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-wallet"></i>
                </div>
                <div class="menu-title">Wallet</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
