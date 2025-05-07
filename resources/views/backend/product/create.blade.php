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
                <form method="POST" action="{{ route('admin_product.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="top_search justify-content-start">
                                    <!-- Back Arrow with Route -->
                                    <a href="{{ route('admin_product.index') }}" class="btn btn-link">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                    <h6 class="card_title">Add New Puja</h6>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="top_search">
                                    <button type="submit" class="btn btn-custom radius-30 mt-2 mt-lg-0">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-body row mt-4">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="Category" class="form-label">Location Type<span>*</span></label>
                                            <select class="form-select " aria-label="Location Type" name="location_type"
                                                id="location_type" required>
                                                <option value="">Select Location Type</option>
                                                <option value="online">Online</option>
                                                <option value="offline">Offline</option>
                                                <option value="both">Both</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="inputProductTitle" class="form-label">Puja Name
                                                (English)<span>*</span></label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Puja Name" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="inputProductTitle" class="form-label">Puja Name
                                                (Hindi)<span>*</span></label>
                                            <input type="text" class="form-control" name="name_hindi" id="name_hindi"
                                                placeholder="Enter Puja Name" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="short_description" class="form-label">Short Description
                                                (English)</label>
                                            <textarea class="form-control" id="short_description" name="short_description"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="short_description" class="form-label">Short Description
                                                (Hindi)</label>
                                            <textarea class="form-control" id="short_description_hindi" name="short_description_hindi"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="inputProductTags" class="form-label">Puja Tags</label>
                                            <input type="text" class="form-control" name="tag" id="inputProductTags"
                                                placeholder="Enter Product Tags">
                                        </div>
                                        {{-- <div class="col-md-12">
                                            <label for="pincode" class="form-label">Pincode<span>*</span></label>
                                            <select id="pincode" class="form-select select2" aria-label="Pincode" name="pincode[]" id="pincode" multiple required>
                                                <option value="">Select Pincode</option>
                                            </select>
                                        </div> --}}

                                        <div class="col-md-12 ">
                                            <label for="language" class="form-label">Language<span>*</span></label>
                                            <select class="form-select select2" aria-label="Language" name="language[]"
                                                id="language" multiple required>
                                                <option value="">Select Language</option>
                                                @foreach (App\Models\Language::all() as $language)
                                                    <option value="{{ $language->id }}">{{ $language->language }}</option>
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
                                            <label for="Category" class="form-label">Puja Category<span>*</span></label>
                                            <select class="form-select " aria-label="Product Category" name="category_id"
                                                id="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach (App\Models\Category::all() as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12  mb-2">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" id="meta_title"
                                                placeholder="Meta Title" value="">
                                        </div>
                                        <div class="col-md-12  mb-2">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="meta_keywords" placeholder="Meta Keywords" value="">
                                        </div>
                                        <div class="col-md-12  mb-2">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_description"></textarea>
                                        </div>
                                        <div class="col-md-12  mb-2 one_day" style="display:none;">
                                            <label for="meta_description" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="date" id="date"
                                                placeholder="Enter Date">
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Key Insights (English)</label>
                            <textarea id="key_insight" name="key_insight">
                            </textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Key Insights (Hindi)</label>
                            <textarea id="key_insight_hindi" name="key_insight_hindi">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Our Promise (English)</label>
                            <textarea id="promise" name="promise">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Our Promise (Hindi)</label>
                            <textarea id="promise_hindi" name="promise_hindi">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">FAQ (English)</label>
                            <textarea id="faq" name="faq">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">FAQ (Hindi)</label>
                            <textarea id="faq_hindi" name="faq_hindi">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Description (English)</label>
                            <textarea id="text_editor" name="description">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Description (Hindi)</label>
                            <textarea id="description_hindi" name="description_hindi">
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="col-lg-1 mb-2">
                                <label for="fileInput" class="uploadButton">
                                    <img class="imagePreview" id="imagePreview_fileInput"
                                        src="https://static.thenounproject.com/png/187803-200.png" alt="Placeholder">
                                </label>
                                <input type="file" class="file_input" id="fileInput" name="thumbnail"
                                    onchange="file_add_new('fileInput')" accept="image/*">
                            </div>
                            <small class="text-muted" id="sizeMessage">
                                Please upload an image with dimensions 1000x1000 pixels.
                            </small>
                        </div>
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
        ClassicEditor
            .create(document.querySelector('#text_editor'))
            .catch(error => {
                console.error(error);
            });

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

        ClassicEditor
            .create(document.querySelector('#faq'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#faq_hindi'))
            .catch(error => {
                console.error(error);
            });

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
            product_type_check();
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
    <script>
        function getPincode() {
            var city_id = $('#city').val();
            $.ajax({
                url: "{{ route('get-pincode') }}", // Laravel route
                type: "POST",
                data: {
                    city_id: city_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#pincode').empty();
                    console.log(response);

                    $.each(response, function(key, city) {
                        $('#pincode').append(
                            `<option value="${city.pincode}" selected>${city.pincode}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
