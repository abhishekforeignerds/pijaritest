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
                                    <h4 class="page-title">User Password</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3 text-uppercase bg-light p-2">Password Change</h5>
                            <hr>
                            <form action="{{route('customer.password_update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <input type="text" id="password" name="password" value="" class="form-control" required>
                                    </div>
                                    {{-- <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{Auth::user()->email}}" class="form-control" placeholder="Email" readonly required>
                                    </div> --}}
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
