@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-6 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">{{ !empty($brand->id) ? 'View' : 'Add' }} Brand</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">


                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                placeholder="Category Name"
                                value="@if (!empty($brand->name)) {{ $brand->name }} @endif" disabled>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation2" class="form-label">Icon</label>
                            <img id="frame"
                                src="{{$brand->full_image_url}}"
                                style="{{ !empty($brand->icon) ? 'display:block' : 'display:none' }}" width="100px"
                                height="100px" />
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
