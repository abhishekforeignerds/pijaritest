@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-6 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">{{ !empty($subCategory->id) ? 'View' : 'Add' }} Sub Category</h6>
                        </div>
                    </div>
                </div>

                        <div class="col-md-12">
                            <label for="bsValidation1" class="form-label">Category Name<span>*</span></label>
                            <select class="form-select mb-3" aria-label="Default select example" name="category_id">
                                <option selected="">Select Category</option>
                                @foreach (App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}"
                                        @if (!empty($subCategory->category_id)) @if ($category->id == $subCategory->category_id) {{ 'selected' }} @endif
                                        @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Sub Category Name<span>*</span></label>
                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                placeholder="Sub Category Name"
                                value="@if (!empty($subCategory->name)) {{ $subCategory->name }} @endif" required>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation2" class="form-label">Icon</label>
                            <input type="file" class="form-control" id="Icon" placeholder="Icon" name="icon"
                                onchange="preview()">
                            <img id="frame"
                                src="{{$subCategory->full_image_url}}"
                                style="{{ !empty($subCategory->icon) ? 'display:block' : 'display:none' }}"
                                width="100px" height="100px" />
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
