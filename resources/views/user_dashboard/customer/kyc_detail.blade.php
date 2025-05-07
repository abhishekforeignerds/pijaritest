@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h4 class="page-title">User KYC Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3 text-uppercase bg-light p-2">KYC Information</h5>
                            <hr>
                            <form action="{{route('customer.kyc_info_update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Aadhaar Number<span class="text-danger">*</span></label>
                                        <input type="text" name="aadhaar" id="aadhaar" class="form-control" value="{{Auth::user()->user_kyc->aadhaar}}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Aadhaar Front</label>
                                        <input type="file" name="aadhaar_front_file" id="aadhaar_front_file" class="form-control"  >
                                        <div class="p-2">
                                            <img src="@if(!empty(Auth::user()->user_kyc->aadhaar_front_file)){{asset('frontend/customer/'.Auth::user()->user_kyc->aadhaar_front_file)}}@endif" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" height="100px" width="100px">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Aadhaar back</label>
                                        <input type="file" name="aadhaar_back_file" id="aadhaar_back_file" class="form-control" >
                                        <div class="p-2">
                                            <img src="@if(!empty(Auth::user()->user_kyc->aadhaar_back_file)){{asset('frontend/customer/'.Auth::user()->user_kyc->aadhaar_back_file)}}@endif" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" height="100px" width="100px">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Pan Number<span class="text-danger">*</span></label>
                                        <input type="text" name="pan" id="pan" class="form-control" value="{{Auth::user()->user_kyc->pan}}"   required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Pan File</label>
                                        <input type="file" name="pan_file" id="pan_file" class="form-control" >
                                        <div class="p-2">
                                            <img src="@if(!empty(Auth::user()->user_kyc->pan_file)){{asset('frontend/customer/'.Auth::user()->user_kyc->pan_file)}}@endif" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" height="100px" width="100px">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Bank Passbook File</label>
                                        <input type="file" name="bank_passbook_file" id="bank_passbook_file" class="form-control"  >
                                        <div class="p-2">
                                            <img src="@if(!empty(Auth::user()->user_kyc->bank_passbook_file)){{asset('frontend/customer/'.Auth::user()->user_kyc->bank_passbook_file)}}@endif" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" height="100px" width="100px">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="images" class="form-label">Cancel Cheque File</label>
                                        <input type="file" name="cancelled_cheque_file" id="cancelled_cheque_file" class="form-control"  >
                                        <div class="p-2">
                                            <img src="@if(!empty(Auth::user()->user_kyc->cancelled_cheque_file)){{asset('frontend/customer/'.Auth::user()->user_kyc->cancelled_cheque_file)}}@endif" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" height="100px" width="100px">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        img_input1.onchange = evt =>{
            const [file] = img_input1.files
            if (file) {
                img1.src = URL.createObjectURL(file)
            }
        }
    </script>

@endsection
