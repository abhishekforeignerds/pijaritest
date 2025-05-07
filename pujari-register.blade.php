@extends('frontend.layouts.app')
@section('content')
    {{-- <section class="page-title">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Pujari Register</h1>
            </div>
        </div>
    </section> --}}

    <section class="login-rgstr">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-6 mx-auto booking-form-column">
                    <div class="inner-column wow fadeInRight animated" data-wow-delay="200ms">
                        <div class="sec-title"> <span class="sub-title">Purohits &amp; Pandits</span>
                            <h2>Register</h2>
                        </div>
                        <form class="bk-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="frm-field">
                                        <input name="name" class="form-control" type="text" placeholder="Enter Your Name *" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="frm-field">
                                        <input name="phone" class="form-control" type="number" placeholder="Enter Your Phone Number *" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="frm-field">
                                        <input name="password" class="form-control" id="password" type="password" placeholder="Password *" required>
                                        <span id="togglePassword"><i class="fa fa-eye-slash"></i></span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="frm-field">
                                        <input name="c_password" class="form-control" id="confirmPassword" type="password" placeholder="Confirm Password *" required>
                                        <span id="toggleConfirmPassword"><i class="fa fa-eye-slash"></i></span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-submit">
                                        <button type="submit">Login</button>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="rbt-lost-password mt-10 text-center">
                                        Do you have an account? <a class="rbt-btn-link" href="{{route('pujari-login')}}">Login Now</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
        const confirmPassword = document.querySelector("#confirmPassword");

        // Toggle Password Visibility
        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            const icon = this.querySelector('i');
            if (type === "password") {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // Toggle Confirm Password Visibility
        toggleConfirmPassword.addEventListener("click", function () {
            const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
            confirmPassword.setAttribute("type", type);

            const icon = this.querySelector('i');
            if (type === "password") {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    </script>

@endsection
