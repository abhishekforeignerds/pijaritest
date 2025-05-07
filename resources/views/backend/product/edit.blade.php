@extends('backend.layouts.app')
@section('content')
<style>
    .file_input {
        display: none;
    }

    .uploadButton {
        display: inline-block;
        position: relative;
        cursor: pointer;
    }

    .imagePreview {
        width: 70px;
        height: 70px;
        border: 1px solid #ccc;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }

    #imageActions {
        /*position: absolute;*/
        /*top: 10px;*/
        /*right: 10px;*/
        display: none;
        float: right;
    }

    .actionIcon {
        background-color: #fff;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .actionIcon:hover {
        opacity: 1;
    }
</style>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <form method="POST" action="{{ route('admin_product.update', $product->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Update Puja</h6>
                        </div>
                        <div class="ms-auto"><button type="submit"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0">Update</button></div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="form-body row mt-4">
                        <div class="col-lg-6">
                            <div class="border border-3 p-4 rounded">
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <label for="Category" class="form-label">Location Type<span>*</span></label>
                                        <select class="form-select " aria-label="Location Type" name="location_type"
                                            id="location_type" required>
                                            <option value="">Select Location Type</option>
                                            <option value="online" @if ($product->location_type == 'online') selected
                                                @endif>
                                                Online</option>
                                            <option value="offline" @if ($product->location_type == 'offline') selected
                                                @endif>
                                                Offline</option>
                                            <option value="both" @if ($product->location_type == 'both') selected
                                                @endif>
                                                Both</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="inputProductTitle" class="form-label">Puja
                                            Name (English)<span>*</span></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter product name" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <br>
                                        <label for="inputProductTitle" class="form-label">Puja Name
                                            (Hindi)<span>*</span></label>
                                        <input type="text" class="form-control" name="name_hindi" id="name_hindi"
                                            placeholder="Enter Puja Name" value="{{ $product->name_hindi }}" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <textarea class="form-control" id="short_description"
                                            name="short_description">{{ $product->short_description }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="short_description" class="form-label">Short Description
                                            (Hindi)</label>
                                        <textarea class="form-control" id="short_description_hindi"
                                            name="short_description_hindi">{{ $product->short_description_hindi }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="inputProductTags" class="form-label">Product Tags</label>
                                        <input type="text" class="form-control" name="tag" id="inputProductTags"
                                            value="{{ $product->tag }}" placeholder="Enter Product Tags">
                                    </div>



                                    {{-- <div class="col-md-12">
                                        <label for="pincode" class="form-label">Pincode<span>*</span></label>
                                        <select class="form-select select2" aria-label="Pincode" name="pincode[]"
                                            id="pincode" multiple required>
                                            <option value="">Select Pincode</option>
                                            @foreach (App\Models\Pincode::all() as $pincode)
                                            @php
                                            $productPincodes = json_decode($product->pincode, true) ?? []; // Fallback
                                            to an empty array
                                            @endphp
                                            <option value="{{ $pincode->id }}" @if (in_array($pincode->id,
                                                $productPincodes))
                                                selected
                                                @endif>
                                                {{ $pincode->pincode }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <div class="col-md-12 ">
                                        <label for="language" class="form-label">Language<span>*</span></label>
                                        <select class="form-select select2" aria-label="Language" name="language[]"
                                            id="language" multiple required>
                                            <option value="">Select Language</option>
                                            @foreach (App\Models\Language::all() as $language)
                                            <option value="{{ $language->id }}" @if (in_array($language->id,
                                                json_decode($product->language))) selected @endif>
                                                {{ $language->language }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="border border-3 p-4 rounded">

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="Category" class="form-label">Product
                                            Category<span>*</span></label>
                                        <select class="form-select " aria-label="Product Category" name="category_id"
                                            id="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach (App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}" @if ($category->id ==
                                                $product->category_id) selected @endif>
                                                {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-12  mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title"
                                            placeholder="Meta Title" value="{{ $product->meta_title }}">
                                    </div>
                                    <div class="col-md-12  mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                            placeholder="Meta Keywords" value="{{ $product->meta_keywords }}">
                                    </div>
                                    <div class="col-md-12  mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control"
                                            name="meta_description">{{ $product->meta_description }}</textarea>
                                    </div>
                                    {{-- <div class="col-md-12  mb-3">
                                        <label for="meta_description" class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" id="date"
                                            value="{{ $product->date }}" placeholder="Enter Date">
                                    </div> --}}
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>



                    <div class="col-md-12 mb-3">
                        <label for="inputProductDescription" class="form-label">Puja Benefits</label>
                        <textarea id="key_insight" name="key_insight">{{ $product->key_insight }}
                            </textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="inputProductDescription" class="form-label">Puja Benefits (Hindi)</label>
                        <textarea id="key_insight_hindi" name="key_insight_hindi">{{ $product->key_insight_hindi }}
                            </textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="inputProductDescription" class="form-label">Our Promise </label>
                        <textarea id="promise" name="promise">{{ $product->promise }}
                            </textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="inputProductDescription" class="form-label">Our Promise (Hindi)</label>
                        <textarea id="promise_hindi" name="promise_hindi">{{ $product->promise_hindi }}
                            </textarea>
                    </div>



                    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css"
                        rel="stylesheet">
                    <div class="col-md-12 mb-3">
                        <label for="faq" class="form-label">FAQ</label>
                        <textarea class="form-control  summernote" id="faq" name="faq">{{ $product->faq }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="faq_hindi" class="form-label">FAQ (Hindi)</label>
                        <textarea class="form-control  summernote" id="faq_hindi"
                            name="faq_hindi">{{ $product->faq_hindi }}</textarea>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
                    </script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js">
                    </script>
                    <script>
                        $(document).ready(function () {
                            $('.summernote').summernote({
    height: 300,                 // set editor height
    tabsize: 2,
    codeviewFilter: false,       // Allow full HTML
    codeviewIframeFilter: true,  // Optional: isolate HTML inside iframe
});
});
                    </script>


                    <div class="col-md-12 mb-3">
                        <label for="inputProductDescription" class="form-label">Description</label>
                        <textarea class="summernote" id="text_editor" name="description">{{ $product->description }}
    </textarea>
                    </div>


                    <div class="col-md-12 mb-3">
                        <label for="inputProductDescription" class="form-label">Description (Hindi)</label>
                        <textarea id="description_hindi" name="description_hindi">{{ $product->description_hindi }}
                            </textarea>
                    </div>

                    <div class="col-lg-1 mb-2">
                        <label for="fileInput_1" class="uploadButton">
                            <img class="imagePreview" id="imagePreview_fileInput_1"
                                src="@if (!empty($product->thumbnail)) {{ $product->full_image_url }}@else{{ 'https://static.thenounproject.com/png/187803-200.png' }} @endif"
                                alt="Placeholder">
                        </label>
                        <input type="file" class="file_input" id="fileInput_1" name="thumbnail"
                            onchange="file_add_new('fileInput_1')" accept="image/*">
                    </div>
                    <small class="text-muted" id="sizeMessage">
                        Please upload an image with dimensions 1000x1000 pixels.
                    </small>
                    <!--end row-->
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--end page wrapper -->
@endsection
@section('script')
<script>
    // ClassicEditor
    //         .create(document.querySelector('#text_editor'))
    //         .catch(error => {
    //             console.error(error);
    //         });

        ClassicEditor
            .create(document.querySelector('#key_insight'))
            .catch(error => {
                console.error(error);
            });


        ClassicEditor
            .create(document.querySelector('#key_insight_hindi'))
            .catch(error => {
                console.error(error);
            });



        ClassicEditor
            .create(document.querySelector('#promise'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#promise_hindi'))
            .catch(error => {
                console.error(error);
            });

        // ClassicEditor
        //     .create(document.querySelector('#faq'))
        //     .catch(error => {
        //         console.error(error);
        //     });

        // ClassicEditor
        //     .create(document.querySelector('#faq_hindi'))
        //     .catch(error => {
        //         console.error(error);
        //     });

        ClassicEditor
            .create(document.querySelector('#short_description'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#short_description_hindi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#description_hindi'))
            .catch(error => {
                console.error(error);
            });
</script>
<script>
    $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Choose one thing",
                allowClear: true
            });

           if (typeof product_type_check === 'function') {
    product_type_check();
} else {
    console.warn("product_type_check is not defined yet.");
}
        });
</script>

<script>
    function file_add(id) {
            var file = $('#fileInput' + id).get(0).files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function() {
                    $("#imagePreview_fileInput" + id).attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

        function file_add_new(id) {
            var file = $('#' + id).get(0).files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function() {
                    $("#imagePreview_" + id).attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }

        }


</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection