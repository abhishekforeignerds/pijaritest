<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backend/images/favicon-32x32.png') }}')}}" type="image/png" />
    <!-- loader-->
    <link href="{{ asset('backend/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet">

    @if (appSetupValue('app_name'))
        <title>{{ appSetupValue('app_name') }} | Admin</title>
    @endif
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <div class="page-content vh-100 d-flex align-items-center justify-content-center login-form">
            <div class="row">
                <div class="col-lg-8 col-md-9 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-6 pe-lg-0 d-lg-block d-none">
                                <img src="{{ asset('backend/images/login-images/pujari.gif') }}" class="login-gif">
                            </div>
                            <div class="col-lg-6 ps-lg-0">
                                <div class="p-lg-4 p-3">
                                    <div class="mb-3 text-center">
                                        @if (!empty(appSetupValue('logo')))
                                            <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                                                width="40%" alt="">
                                        @else
                                            <h5 class="">{{ appSetupValue('app_name') }} </h5>
                                        @endif
                                    </div>
                                    <div class="text-center mb-4">
                                        <p class="mb-0 cust-t">Please log in to your account</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="post" action="{{ route('admin.login') }}">
                                            @csrf
                                            <div class="col-12 mb-2">
                                                <input type="email" name="email" class="form-control"
                                                    id="inputEmailAddress" placeholder="Enter Your Email"
                                                    value="{{ old('email') }}">
                                                <span
                                                    style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                    role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password"
                                                        class="form-control border-end-0" id="inputChoosePassword"
                                                        value="{{ old('password') }}" placeholder="Enter Password"> <a
                                                        href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class="bx bx-hide"></i></a>
                                                    <span
                                                        style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                        role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn login-button">Sign in</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end wrapper-->

    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('backend/js/app.js') }}"></script>
</body>

</html>
