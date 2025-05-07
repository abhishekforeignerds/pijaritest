@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-12 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <!-- Back Arrow with Route -->
                            <a href="{{ route('category.index') }}" class="btn btn-link">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                        <div>
                            <h6 class="card_title">{{ !empty($category->id) ? 'Edit' : 'Add' }} Category</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="category" name="category" method="post" action="{{ route('category.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (!empty($category->id))
                            <input type="hidden" name="id" value="{{ $category->id }}" />
                        @endif
                        <div class="form-body row mt-4">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="bsValidation1" class="form-label">Category Name<span>*</span></label>
                                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                                placeholder="Category Name"
                                                value="@if (!empty($category->name)) {{ $category->name }} @endif" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="name_hindi" class="form-label">Category Name Hindi<span>*</span></label>
                                            <input type="text" class="form-control" name="name_hindi" id="name_hindi"
                                                placeholder="Category Name Hindi"
                                                value="@if (!empty($category->name_hindi)) {{ $category->name_hindi }} @endif" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="bsValidation2" class="form-label">Icon</label>
                                            <input type="file" class="form-control" id="Icon" placeholder="Icon" name="icon"
                                                onchange="preview()">
                                            <img id="frame"
                                                src="@if(!empty($category->full_image_url)){{$category->full_image_url}}@endif"
                                                style="{{ !empty($category->icon) ? 'display:block' : 'display:none' }}" width="100px"
                                                height="100px" />
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="short_description" class="form-label">Short Description</label>
                                            <textarea class="form-control" placeholder="Short Description" name="short_description">@if(!empty($category->short_description)){{ $category->short_description }}@endif</textarea>
                                        </div>
                                        <div class="col-md-12  mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea id="text_editor" name="description"> @if(!empty($category->description)){{$category->description}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title"
                                            placeholder="Meta Title"
                                            value="@if(!empty($category->meta_title)){{$category->meta_title}}@endif" >
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                            placeholder="Meta Keywords"
                                            value="@if(!empty($category->meta_keywords)){{ $category->meta_keywords }}@endif" >
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" placeholder="Meta Description" name="meta_description">@if(!empty($category->meta_description)){{ $category->meta_description }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-custom">{{ !empty($category->id) ? 'Update' : 'Submit' }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    ClassicEditor
        .create( document.querySelector( '#text_editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection
