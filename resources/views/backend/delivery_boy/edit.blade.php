@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Update Delivery Boy</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        <form class="row g-4" method="post" action="{{ route('delivery-boy.update', $delivery_boy->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="col-md-6">
                                <label for="fullname" class="form-label">Name<span>*</span></label>
                                <input type="text" class="form-control" value="{{  $delivery_boy->name }}"
                                    id="name" name="name" placeholder="Name">
                                @error('name')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone<span>*</span></label>
                                <input type="text" class="form-control" value="{{  $delivery_boy->phone }}"
                                    id="phone" name="phone" placeholder="Phone">
                                @error('phone')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{  $delivery_boy->email }}"
                                    id="email" name="email" placeholder="Email">
                                <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                    role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @error('email')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputChoosePassword" class="form-label">Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" value="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address<span>*</span></label>
                                <textarea class="form-control" placeholder="Address" name="address">{{  $delivery_boy->address }}</textarea>
                                @error('address')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="aadhaar_front" class="form-label">Aadhaar Front Image<span>*</span></label>
                                <input type="file" class="form-control" id="aadhaar_front" placeholder="Select Image"
                                    name="aadhaar_front">
                                <img class="mt-2" id="img" src="{{uploaded_asset($delivery_boy->aadhaar_front)}}"
                                    onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                    height="80px" width="80px">
                                @error('aadhaar_front')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="aadhaar_back" class="form-label">Aadhaar Back Image<span>*</span></label>
                                <input type="file" class="form-control" id="aadhaar_back" placeholder="Select Image"
                                    name="aadhaar_back">
                                <img class="mt-2" id="img2" src="{{uploaded_asset($delivery_boy->aadhaar_back)}}"
                                    onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                    height="80px" width="80px">
                                @error('aadhaar_back')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pan" class="form-label">Pan Image</label>
                                <input type="file" class="form-control" id="pan" placeholder="Select Image"
                                    name="pan">
                                <img class="mt-2" id="img3" src="{{uploaded_asset($delivery_boy->pan)}}"
                                    onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                    height="80px" width="80px">
                                @error('pan')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" class="form-control"
                                    value="{{ $delivery_boy->bank_name }}" id="bank_name"
                                    name="bank_name" placeholder="Bank Name">
                                @error('bank_name')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bank_account_no" class="form-label">Bank Account No.</label>
                                <input type="text" class="form-control"
                                    value="{{ $delivery_boy->bank_account_no }}"
                                    id="bank_account_no" name="bank_account_no" placeholder="Account No.">
                                @error('bank_account_no')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ifsc_code" class="form-label">IFSC Code</label>
                                <input type="text" class="form-control"
                                    value="{{$delivery_boy->ifsc_code }}" id="ifsc_code"
                                    name="ifsc_code" placeholder="IFSC Code">
                                @error('ifsc_code')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Update</button>
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

        aadhaar_front.onchange = evt => {
            const [file] = aadhaar_front.files
            if (file) {
                img.src = URL.createObjectURL(file)
            }
        }

        aadhaar_back.onchange = evt => {
            const [file] = aadhaar_back.files
            if (file) {
                img2.src = URL.createObjectURL(file)
            }
        }

        pan.onchange = evt => {
            const [file] = pan.files
            if (file) {
                img3.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
