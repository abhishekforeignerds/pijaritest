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
                                    <h4 class="page-title">User Profile</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <h5 class="mb-3 text-uppercase bg-light p-2">Personal Information</h5>
                            <hr>
                            <form action="{{route('customer.profile_update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" value="{{Auth::user()->name}}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{Auth::user()->email}}" class="form-control" placeholder="Email"  required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                        <input type="number" id="phone" name="phone" value="{{Auth::user()->phone}}" class="form-control" readonly required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                                        <input type="text" id="address" name="address" class="form-control" value="{{Auth::user()->address}}" placeholder="Address" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Birth Time<span class="text-danger">*</span></label>
                                        <input type="time" id="address" name="birthTime" class="form-control" value="{{Auth::user()->birthTime}}" placeholder="Birth Time" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Birth Date<span class="text-danger">*</span></label>
                                        <input type="date" id="address" name="birthDate" class="form-control" value="{{Auth::user()->birthDate}}" placeholder="Birth Date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Birth Place<span class="text-danger">*</span></label>
                                        <input type="text" id="address" name="birthPlace" class="form-control" value="{{Auth::user()->birthPlace}}" placeholder="Birth Place" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Gender<span class="text-danger">*</span></label>
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value="male" @if(Auth::user()->gender=='male') selected @endif >Male</option>
                                            <option value="female" @if(Auth::user()->gender=='female') selected @endif >Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="images" class="form-label">Profile Picture</label>
                                        <input type="file" name="profile_picture" id="img_input1" class="form-control" accept="image/*">
                                        <div class="p-2">
                                            <img id="img1" src="@if(!empty(Auth::user()->profile_picture)){{asset('frontend/customer/'.Auth::user()->profile_picture)}}@endif" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" height="100px" width="100px">
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
