@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Add Customer</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        <form class="row g-4" method="post" action="{{ route('customer.store') }}" enctype="multipart/form-data" >
                            @csrf

                            <div class="col-md-6">
                                <label for="fullname" class="form-label">Name<span>*</span></label>
                                    <input type="text" class="form-control" id="fullname" name="name"
                                        placeholder="Name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Address" class="form-label">Address<span>*</span></label>
                                    <input type="text" class="form-control" id="Address" name="address"
                                        placeholder="Address" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email<span>*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email" required>
                                        <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                            </div>
                            <div class="col-md-6">
                                <label for="mobile_no" class="form-label">Mobile No<span>*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Mobile No." required>
                                        <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                            </div>
                            <div class="col-md-6">
                                <label for="inputChoosePassword" class="form-label">Password<span>*</span></label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" value="{{old('password')}}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="profile_picture"
                                    placeholder="profile Picture" name="profile_picture">
                            </div>
                            <div class="col-12">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
@endsection

