<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            @if (!empty(appSetupValue('logo')))
                <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}" class="logo-icon"
                    alt="logo icon">
            @endif
        </div>
        {{-- <div>
            @if (!empty(appSetupValue('app_name')))
              <h4 class="logo-text">{{(appSetupValue('app_name'))}}</h4>
            @endif
        </div> --}}

    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.password') }}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-log-in-circle"></i>
                </div>
                <div class="menu-title">Change Password</div>
            </a>
        </li>
        <li class="menu-label">Customer & Pujari</li>
        @if (auth()->guard('admin')->user()->can('customer-list'))
            <li>
                <a href="{{ route('customer_list') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-user"></i>
                    </div>
                    <div class="menu-title">Customer</div>
                </a>
            </li>
        @endif
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cog"></i>
                </div>
                <div class="menu-title">Pujaries</div>
            </a>
            <ul>
                <li> <a href="{{ route('pujari_list') }}"><i class='bx bx-radio-circle'></i>All</a> </li>
                <li> <a href="{{ route('verified_pujari_list') }}"><i class='bx bx-radio-circle'></i>Verified</a> </li>
                <li> <a href="{{ route('unverified_pujari_list') }}"><i class='bx bx-radio-circle'></i>UnVerified </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('our_pujari.index') }}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-user-plus"></i>
                </div>
                <div class="menu-title">Our Pujari</div>
            </a>
        </li>
        <li class="menu-label">Puja</li>
        @if (auth()->guard('admin')->user()->can('category-list'))
            <li>
                <a href="{{ route('category.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-cube"></i>
                    </div>
                    <div class="menu-title">Category</div>
                </a>
            </li>
        @endif
        @if (auth()->guard('admin')->user()->can('product-list'))
            <li>
                <a href="{{ route('admin_product.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-cart-alt"></i>
                    </div>
                    <div class="menu-title">All Puja</div>
                </a>
            </li>
        @endif
        <li>
            <a href="{{ route('temple_puja.index') }}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-flag"></i>
                </div>
                <div class="menu-title">Teerth puja</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class="bx bx-cog"></i>
                </div>
                <div class="menu-title">E-Puja</div>
            </a>
            <ul>
                <li> <a href="{{ route('e_puja.index') }}"><i class='bx bx-radio-circle'></i>Running E-Puja</a> </li>
                <li> <a href="{{ route('e_puja_upcoming') }}"><i class='bx bx-radio-circle'></i>Upcoming E-Puja</a>
                </li>
                <li> <a href="{{ route('e_puja_completed') }}"><i class='bx bx-radio-circle'></i>Completed E-Puja </a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Order</li>
        @if (auth()->guard('admin')->user()->can('order-list'))
            {{-- <li>
            <a href="{{route('brand.index')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-trophy"></i>
                </div>
                <div class="menu-title">Brands</div>
            </a>
        </li> --}}
        @endif
        @if (auth()->guard('admin')->user()->can('order-list'))
            <li>
                <a href="{{ route('admin.orders') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-shopping-bag"></i>
                    </div>
                    <div class="menu-title">Order</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.one_day_orders') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bxs-basket"></i>
                    </div>
                    <div class="menu-title">E-Puja Order</div>
                </a>
            </li>
        @endif
        <li class="menu-label">City</li>
        @if (auth()->guard('admin')->user()->can('service_city-list'))
            <li>
                <a href="{{ route('admin.service_city') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-been-here"></i>
                    </div>
                    <div class="menu-title">Service City</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.terth_city') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-been-here"></i>
                    </div>
                    <div class="menu-title">Teerth City</div>
                </a>
            </li>
        @endif

        @if (auth()->guard('admin')->user()->can('service_city-list'))
            <li>
                <a href="{{ route('admin.pincode') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-user-voice"></i>
                    </div>
                    <div class="menu-title">Pincode</div>
                </a>
            </li>
        @endif

        @if (auth()->guard('admin')->user()->can('service_city-list'))
            <li>
                <a href="{{ route('admin.language') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-user-voice"></i>
                    </div>
                    <div class="menu-title">Language</div>
                </a>
            </li>
        @endif
        <li class="menu-label">Enquiry</li>
        @if (auth()->guard('admin')->user()->can('enquiry-list'))
            <li>
                <a href="{{ route('enquiry.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-message-dots"></i>
                    </div>
                    <div class="menu-title">Enquiry</div>
                </a>
            </li>
            <li>
                <a href="{{ route('product_enquiry') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-message-dots"></i>
                    </div>
                    <div class="menu-title">Product Enquiry</div>
                </a>
            </li>
            <li class="menu-label">Kundali</li>
            <li>
                <a href="{{ route('kundali.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-message"></i>
                    </div>
                    <div class="menu-title">Kundali</div>
                </a>
            </li>
            <li class="menu-label">Blog</li>
            <li>
                <a href="{{ route('blog.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-news"></i>
                    </div>
                    <div class="menu-title">Blog</div>
                </a>
            </li>
            <li class="menu-label">Testimonial & Review</li>
            <li>
                <a href="{{ route('testimonial.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-user-pin"></i>
                    </div>
                    <div class="menu-title">Testimonial</div>
                </a>
            </li>

            <li>
                <a href="{{ route('review.index') }}" aria-expanded="false">
                    <div class="parent-icon"><i class="bx bx-star"></i>
                    </div>
                    <div class="menu-title">Review</div>
                </a>
            </li>
        @endif
        <li class="menu-label">Setting</li>
        @if (auth()->guard('admin')->user()->can('setting-list'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-cog"></i>
                    </div>
                    <div class="menu-title">Web Setting</div>
                </a>
                <ul>
                    @if (auth()->guard('admin')->user()->can('slider-list'))
                        <li> <a href="{{ route('slider.index') }}"><i class='bx bx-radio-circle'></i>Slider</a> </li>
                    @endif
                    @if (auth()->guard('admin')->user()->can('banner-list'))
                        <li> <a href="{{ route('banner.index') }}"><i class='bx bx-radio-circle'></i>Banner</a> </li>
                    @endif
                    @if (auth()->guard('admin')->user()->can('app_setup-view'))
                        <li> <a href="{{ route('app_setup.index') }}"><i class='bx bx-radio-circle'></i>Web Setup</a>
                        </li>
                    @endif
                    <li> <a href="{{ route('policy.index') }}"><i class='bx bx-radio-circle'></i>Policies</a> </li>
                </ul>
            </li>
        @endif


        @if (auth()->guard('admin')->user()->can('contact_us-list'))
            {{-- <li>
            <a href="{{route('admin.contact_us')}}" aria-expanded="false">
                <div class="parent-icon"><i class="bx bx-user-plus"></i>
                </div>
                <div class="menu-title">Contacts</div>
            </a>
        </li> --}}
        @endif

        @if (auth()->guard('admin')->user()->canany(['roles-list', 'staff-list']))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Role & Permission</div>
                </a>
                <ul>
                    <li> <a href="{{ route('roles.index') }}"><i class='bx bx-radio-circle'></i>Role</a></li>
                    <li> <a href="{{ route('staff.index') }}"><i class='bx bx-radio-circle'></i>Staff</a></li>
                </ul>
            </li>
        @endif

    </ul>
    <!--end navigation-->
</div>
