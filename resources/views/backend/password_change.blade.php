@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row">
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3 text-uppercase bg-light p-2">Password Change</h5>
                            <hr>
                            <form action="{{route('admin.password_update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <input type="text" id="password" name="password" value="" class="form-control" required>
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
</div>
@endsection
