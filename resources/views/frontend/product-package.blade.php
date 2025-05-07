{{-- @extends('frontend.layouts.app')

@section('meta')
<title>Puajri Ji</title>
<meta name="description" content="">
<meta name="keywords" content="">
@endsection


@section('content') --}}
@guest
<div id="custom-modal-overlay"></div>
<div class="modal-content" id="custom-login-modal">
    <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Customer Login</h5>
        <button type="button" class="close" id="custom-login-modal-close" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('customer.login') }}" method="POST" id="sms_form_modal">
            @csrf
            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
            <div class="form-group">
                <label for="customer_name">Name</label>
                <input type="text" class="form-control" id="customer_name" name="name" required>
            </div>
            <div class="form-group" id="sms_form_div">
                <label for="sms_number">Mobile Number</label>
                <input type="tel" class="form-control" name="input_name" id="sms_number" placeholder="10‑digit mobile"
                    maxlength="10" required>
                <span id="phone_check_error" class="text-danger"></span>
            </div>
            <div id="sms_otp" style="display:none;">
                <p>An OTP has been sent to <strong><span id="sms_otp_number"></span></strong>
                    <a href="#" onclick="sms_edit_number()">(Edit)</a>
                </p>
                <div class="form-group">
                    <input id="partitioned_sms" name="check_otp" class="form-control" maxlength="4"
                        placeholder="Enter OTP" required>
                    <span id="otp_error_sms" class="text-danger"></span>
                </div>
            </div>
            <div class="text-center">
                <button type="button" id="login_by_sms" class="btn btn-theme">Login with SMS OTP <i
                        class="fad fa-angle-right"></i></button>
                <button type="submit" class="btn btn-primary" style="display:none;" id="submit_login">Submit</button>
            </div>
        </form>
    </div>
</div>
<style>
    div#custom-login-modal {
        position: fixed;
        top: 150px;
        left: 24%;
        width: 50%;
        z-index: 100;
        margin: 0 auto;
    }

    #custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* semi-transparent black */
        z-index: 99;
    }
</style>
<script>
    document.getElementById('custom-login-modal-close').addEventListener('click', function () {
        document.getElementById('custom-login-modal').style.display = 'none';
        document.getElementById('custom-modal-overlay').style.display = 'none';
    });
</script>

@endguest
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- then Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- then Bootstrap’s JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

<script>
    @guest
    document.addEventListener('DOMContentLoaded', function () {
  // Show modal on page load
  const loginModal = document.getElementById('loginModal');
  if (loginModal) {
    const modal = new bootstrap.Modal(loginModal);
    modal.show();
  }

  // Custom validator for Indian phone numbers
  function isValidPhoneIND(phone) {
    if (!(phone.length === 10)) {
       
        return false;
    }
    phone = phone.replace(/\s+/g, "");
    return phone.length === 10 && /^[6789][0-9]{9}$/.test(phone);
  }

  // Add click listener for login by SMS
  const loginBtn = document.getElementById('login_by_sms');
  if (loginBtn) {
    loginBtn.addEventListener('click', function () {
        console.log('clicked')
      const phoneInput = document.getElementById('sms_number');
      const errorDiv = document.getElementById('phone_check_error');
      const phone = phoneInput.value.trim();

      errorDiv.textContent = '';

      if (isValidPhoneIND(phone)) {
        console.log('true')
        fetch('{{ route("send_otp") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            phone: phone,
            form_name: 'sms_form' // This is required in your controller!
        })
        })
        .then(res => res.json())
        .then(response => {
          if (response.status) {
            console.log(response)
            document.getElementById('sms_form_div').style.display = 'none';
            loginBtn.style.display = 'none';
            document.getElementById('sms_otp').style.display = 'block';
            document.getElementById('sms_otp_number').textContent = phone;
            console.log(response)
            // Save OTP for client-side check (not secure, just replicating logic)
            window.correctOtp = response.otp;
          } else {
            errorDiv.textContent = 'Invalid phone number';
          }
        });
    } else {
            errorDiv.textContent = 'Invalid phone number';
          }
    });
  }

  // Input listener for OTP verification
  const otpInput = document.getElementById('partitioned_sms');
  if (otpInput) {
    otpInput.addEventListener('input', function () {
      if (this.value.length === 4) {
        fetch('{{ route("check_otp") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ otp: this.value })
        })
        .then(res => res.json())
        .then(response => {
          const errorMsg = document.getElementById('otp_error_sms');
          const submitBtn = document.getElementById('submit_login');

          if (response.status) {
            errorMsg.textContent = 'OTP Verified!';
            errorMsg.classList.remove('text-danger');
            errorMsg.classList.add('text-success');
            submitBtn.style.display = 'block';
          } else {
            errorMsg.textContent = 'Incorrect OTP';
          }
        });
      }
    });
  }

  // Validate and submit the form
  const form = document.getElementById('sms_form_modal');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const phone = document.getElementById('sms_number').value.trim();
      const otp = document.getElementById('partitioned_sms').value.trim();

      let valid = true;

      if (!isValidPhoneIND(phone)) {
        alert('Please specify a valid phone number');
        valid = false;
      }

      if (otp != (window.correctOtp)) {
        alert('Invalid OTP');
        valid = false;
      }

      if (valid) {
        form.submit();
      }
    });
  }
});

// Optional: Edit phone number function
function sms_edit_number() {
  document.getElementById('sms_form_div').style.display = 'block';
  document.getElementById('login_by_sms').style.display = 'inline-block';
  document.getElementById('sms_otp').style.display = 'none';
}

    @endguest
</script>
@if ($product->product_type == 'all')
{{-- <section class="page-title">
    <div class="auto-container">
        <div class="row">
            <!-- Left Section -->
            <div class="col-12 col-lg-8 mb-3">
                <form action="{{ route('listing') }}" method="GET" enctype="multipart/form-data">
                    @if (session()->get('pooja_language') == 'English')
                    <div class="checkout-form">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="select-city mb-3 me-2 flex-grow-1">
                                <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                    data-live-search="true" onchange="set_city()">
                                    <option value="">Select City</option>
                                    @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                    <option value="{{ $city->city }}" @if (session()->get('city') == $city->city)
                                        selected @endif>
                                        {{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select-language mb-3 me-lg-2 me-0 flex-grow-1">
                                <select id="language" name="language"
                                    class="select-input-form js-example-basic-single w-100" onchange="set_language()">
                                    <option value="">Select Language</option>
                                    @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                    <option value="{{ $language->language }}" @if (session()->get('language') ==
                                        $language->language) selected @endif>
                                        {{ $language->language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="view-button">
                                <button class="theme-btn btn-style-one pack-btn" type="submit">
                                    <span class="btn-title">View All Services</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="checkout-form">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="select-city mb-3 me-2 flex-grow-1">
                                <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                    data-live-search="true" onchange="set_city()">
                                    <option value="">शहर चुनें</option>
                                    @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                    <option value="{{ $city->city }}" @if (session()->get('city') == $city->city)
                                        selected @endif>
                                        {{ $city->city }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select-language mb-3 me-lg-2 me-0 flex-grow-1">
                                <select id="language" name="language"
                                    class="select-input-form js-example-basic-single w-100" onchange="set_language()">
                                    <option value="">भाषा चुनें</option>
                                    @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                    <option value="{{ $language->language }}" @if (session()->get('language') ==
                                        $language->language) selected @endif>
                                        {{ $language->language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="view-button">
                                <button class="theme-btn btn-style-one pack-btn" type="submit">
                                    <span class="btn-title">सभी सेवाएं देखें</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <!-- Right Section -->
            @if (session()->get('pooja_language') == 'English')
            <div class="col-lg-4 col-12">
                <div class="sidebar-search">
                    <form action="{{ route('listing') }}" method="GET" class="search-form">
                        <div class="form-group d-flex">
                            <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="col-lg-4 col-12">
                <div class="sidebar-search">
                    <form action="{{ route('listing') }}" method="GET" class="search-form">
                        <div class="form-group d-flex">
                            <input type="search" name="search" placeholder="खोजें..." value="{{ request('search') }}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</section> --}}
{{-- <div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        <ul class="page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">Puja</a></li>
            <li class="breadcrumb-item">{{ $product->name }}</li>
        </ul>
    </div>
</div> --}}
{{-- <div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        @if (session()->get('pooja_language') == 'English')
        <ul class="page-breadcrumb  d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">Puja</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name }}</a>
            </li>
            <li class="breadcrumb-item"> Package </li>
            <li class="ms-auto">
                <a href="{{ route('details', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> Back</span>
                </a>
            </li>
        </ul>
        @else
        <ul class="page-breadcrumb  d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">मुखपृष्ठ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">पूजा</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name_hindi }}</a>
            </li>
            <li class="breadcrumb-item">पैकेज</li>
            <li class="ms-auto">
                <a href="{{ route('details', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> वापस</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</div> --}}
@endif
@if ($product->product_type == 'temple')
{{-- <div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        @if (session()->get('pooja_language') == 'English')
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teerth_puja') }}">Teerth Puja</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item"> Package </li>
            <li class="ms-auto">
                <a href="{{ route('details', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> Back</span>
                </a>
            </li>
        </ul>
        @else
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">मुखपृष्ठ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teerth_puja') }}">तीर्थ पूजा</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name_hindi }}</a>
            </li>
            <li class="breadcrumb-item">पैकेज</li>
            <li class="ms-auto">
                <a href="{{ route('details', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> वापस</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</div> --}}
@endif
<section class="package-details pujari_mobile_padding" id="pricing-packages">
</section>
<section class="package-details pujari_mobile_padding">
    <div class="auto-container">
        <div class="product-details__top">
            <h3 class="product-details__title mb-3">
                @if (session()->get('pooja_language') == 'English')
                Select Your Package
                @else
                अपना पैकेज चुनें
                @endif
            </h3>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xl-8">
                <div class="product-info package_scroll pujari_package_list">

                    <div class="product-details__content" id="package_list">
                        @include('frontend.package_list')
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4">
                <div class="product-details__buttons">
                    <div class="product-details__top">
                        <h3 class="product-details__title">
                            @if (session()->get('pooja_language') == 'English')
                            Order Summary
                            @else
                            आर्डर सारांश
                            @endif
                        </h3>
                    </div>
                    <div class="table table-striped table-bordered tbl-shopping-cart">
                        @if (session()->get('pooja_language') == 'English')
                        <div class="billing-details">
                            <table class="table table-striped table-bordered cart-total" id="cart-total-table-english">
                                <tbody id="cart-tbody-english">
                                    {{-- JS will inject all <tr> here --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>Rs <span id="total">0</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="ordercalculation">
                                <div class="pay d-flex justify-content-between">
                                    <div class="payfullamount">
                                        <input type="radio" name="deposite_radio" value="pay_full"
                                            onclick="toggleContent(this)" checked>
                                        <b>Pay Full Amount</b>
                                    </div>
                                </div>
                                <div class="full" id="full">
                                    <p class="total"><span class="advalet"> Total : </span> <strong> Rs <span
                                                id="total_amount">0</span></strong></p>
                                </div>
                                <div class="advance" id="advance">
                                    <p><span class="advalet">Advance</span> : <strong><span
                                                id="advance_amount">0</span></strong></p>
                                    <p><span class="advalet">Remaining</span> : <strong><span
                                                id="remaining_amount">0</span></strong></p>
                                    <p class="total"><span>Total</span>: <strong><span
                                                id="grand_total">0</span></strong></p>
                                </div>
                            </div>
                            <input type="hidden" id="order_id" name="order_id" />
                            <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />
                        </div>
                        @else
                        <div class="billing-details">
                            <table class="table table-striped table-bordered cart-total" id="cart-total-table-hindi">
                                <tbody id="cart-tbody-hindi">
                                    {{-- JS will inject here --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>कुल योग</td>
                                        <td>Rs <span id="total">0</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="ordercalculation">
                                <div class="pay d-flex justify-content-between">
                                    <div class="payfullamount">
                                        <input type="radio" name="deposite_radio" value="pay_full"
                                            onclick="toggleContent(this)" checked>
                                        <b>पूरा भुगतान करें</b>
                                    </div>
                                </div>
                                <div class="full" id="full">
                                    <p class="total"><span class="advalet"> कुल : </span> <strong> Rs <span
                                                id="total_amount">0</span></strong></p>
                                </div>
                                <div class="advance" id="advance">
                                    <p><span class="advalet">एडवांस</span> : <strong><span
                                                id="advance_amount">0</span></strong></p>
                                    <p><span class="advalet">बाकी</span> : <strong><span
                                                id="remaining_amount">0</span></strong></p>
                                    <p class="total"><span>कुल</span>: <strong><span id="grand_total">0</span></strong>
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" id="order_id" name="order_id" />
                            <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />
                        </div>
                        @endif
                    </div>

                    <div class="table-responsive" id="order_summary">



                        @include('frontend.package_order_summary')
                    </div>

                    <div class="product-details__buttons-1 text-center button-fixed">
                        <a href="{{ route('availability', $product->slug) }}" id="checkout-btn"
                            class="theme-btn btn-style-one w-100 disabled" style="pointer-events: none; opacity: 0.5;">
                            <span class="btn-title">
                                @if (session()->get('pooja_language') == 'English')
                                {{-- Proceed to check Date Availability --}}
                                Proceed to Checkout
                                @else
                                {{-- तारीख की उपलब्धता की जांच करने के लिए आगे बढ़ें --}}
                                चेकआउट के लिए आगे बढ़ें
                                @endif <i class="far fa-long-arrow-alt-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    @if (session()->get('pooja_language') == 'English')
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".read-more-btn").forEach(button => {
                    button.addEventListener("click", function() {
                        const description = this.previousElementSibling;

                        if (description.classList.contains("full")) {
                            description.classList.remove("full");
                            this.textContent = "Read More";
                        } else {
                            description.classList.add("full");
                            this.textContent = "Read Less";
                        }
                    });
                });
            });
        @else
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".read-more-btn").forEach(button => {
                    button.addEventListener("click", function() {
                        const description = this.previousElementSibling;

                        if (description.classList.contains("full")) {
                            description.classList.remove("full");
                            this.textContent = "और पढ़ें";
                        } else {
                            description.classList.add("full");
                            this.textContent = "कम पढ़ें";
                        }
                    });
                });
            });
        @endif
</script>
{{-- @endsection --}}