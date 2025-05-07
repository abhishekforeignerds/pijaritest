@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-12 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">{{ !empty($brand->id) ? 'Edit' : 'Add' }} Brand</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="brand" name="brand" method="post" action="{{ route('brand.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (!empty($brand->id))
                            <input type="hidden" name="id" value="{{ $brand->id }}" />
                        @endif
                        <div class="form-body row mt-4">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="bsValidation1" class="form-label">Brand Name<span>*</span></label>
                                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                                placeholder="Category Name"
                                                value="@if (!empty($brand->name)) {{ $brand->name }} @endif" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="bsValidation2" class="form-label">Icon</label>
                                            <input type="file" class="form-control" id="Icon" placeholder="Icon" name="icon"
                                                onchange="preview()">
                                            <img id="frame"
                                                src="@if(!empty($brand->full_image_url)){{$brand->full_image_url}}@endif"
                                                style="{{ !empty($brand->icon) ? 'display:block' : 'display:none' }}" width="100px"
                                                height="100px" />
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="short_description" class="form-label">Short Description</label>
                                            <textarea class="form-control" placeholder="Short Description" name="short_description">@if(!empty($brand->short_description)){{ $brand->short_description }}@endif</textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea id="text_editor" name="description"> @if(!empty($brand->description)){{$brand->description}}@endif</textarea>
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
                                            value="@if(!empty($brand->meta_title)){{$brand->meta_title}}@endif" >
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                            placeholder="Meta Keywords"
                                            value="@if(!empty($brand->meta_keywords)){{ $brand->meta_keywords }}@endif" >
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" placeholder="Meta Description" name="meta_description">@if(!empty($brand->meta_description)){{ $brand->meta_description }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">{{ !empty($brand->id) ? 'Update' : 'Submit' }}</button>
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
