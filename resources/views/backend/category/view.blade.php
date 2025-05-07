@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-6 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">{{ !empty($category->id) ? 'View' : 'Add' }} Category</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                        <div class="col-md-12">
                            <label for="bsValidation1" class="form-label">Business Category<span>*</span></label>
                            <select class="form-select mb-3" aria-label="Default select example"
                                name="business_category_id">
                                <option value="">Select Business Category</option>
                                @foreach (App\Models\BusinessCategory::all() as $business_category)
                                    <option value="{{ $business_category->id }}"
                                        @if (!empty($category->business_category_id)) @if ($business_category->id == $category->business_category_id) {{ 'selected' }} @endif
                                        @endif>{{ $business_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Category Name<span>*</span></label>
                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                placeholder="Category Name"
                                value="@if (!empty($category->name)) {{ $category->name }} @endif" required>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation2" class="form-label">Icon</label>
                            <input type="file" class="form-control" id="Icon" placeholder="Icon" name="icon"
                                onchange="preview()">
                            <img id="frame"
                                src="{{$category->full_image_url}}"
                                style="{{ !empty($category->icon) ? 'display:block' : 'display:none' }}" width="100px"
                                height="100px" />
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
