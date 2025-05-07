@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-6 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">{{ !empty($category->id) ? 'Edit' : 'Add' }} Service Category</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="category" name="category" method="post"
                        action="{{ route('service_category.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (!empty($category->id))
                            <input type="hidden" name="id" value="{{ $category->id }}" />
                        @endif
                        <div class="col-md-12">
                            <label for="bsValidation1" class="form-label">Business Category<span>*</span></label>
                            <select class="form-select mb-3" aria-label="Default select example" name="business_category_id">
                                <option value="">Select Business Category</option>
                                @foreach(App\Models\BusinessCategory::all() as $business_category)
                                <option value="{{$business_category->id}}" @if (!empty($category->business_category_id)) @if($business_category->id==$category->business_category_id) {{'selected'}} @endif @endif>{{$business_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation1" class="form-label">Category Name<span>*</span></label>
                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                placeholder="Category Name"
                                value="@if (!empty($category->name)) {{ $category->name }} @endif" required>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation2" class="form-label">Icon</label>
                            <input type="file" class="form-control" id="Icon" placeholder="Icon" name="icon" onchange="preview()">
                            <img id="frame" src="@if(!empty($category->full_image_url)){{$category->full_image_url}}@endif" style="{{ !empty($category->icon) ? 'display:block' : 'display:none' }}" width="100px" height="100px"/>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit"
                                    class="btn btn-primary px-4">{{ !empty($category->id) ? 'Update' : 'Submit' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
