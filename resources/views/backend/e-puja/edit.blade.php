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
                <form method="POST" action="{{ route('e_puja.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="previous_url" value="{{url()->previous()}}" />
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
                                            <label for="Category" class="form-label">Prashad<span>*</span></label>
                                            <select class="form-select " aria-label="Prashad" name="prashad" id="prashad"
                                                required>
                                                <option value="">Select</option>
                                                <option value="yes" @if ($product->prashad == 'yes') selected @endif>Yes
                                                </option>
                                                <option value="no" @if ($product->prashad == 'no') selected @endif>No
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <br>
                                            <label for="Category" class="form-label">Prashad Text<span>*</span></label>
                                            <input type="text" class="form-control" name="prashad_text" id="prashad_text"
                                                placeholder="Enter Prashad Text" value="{{ $product->prashad_text }}">
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for="prashad_text_hindi" class="form-label">Prashad Text Hindi<span>*</span></label>
                                            <input type="text" class="form-control" name="prashad_text_hindi" id="prashad_text_hindi" value="{{ $product->prashad_text_hindi }}"
                                                placeholder="Enter Prashad Text Hindi" >
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="Prashad Price" class="form-label">Prashad Price<span>*</span></label>
                                            <input type="number" class="form-control" name="prashad_price" id="prashad_price" value="{{$product->prashad_price}}"
                                                placeholder="Enter Prashad Price">
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for="Category" class="form-label">Fake Devote<span>*</span></label>
                                            <input type="text" class="form-control" name="fake_devote" id="fake_devote"
                                                placeholder="Enter Fake Devote" value="{{ $product->fake_devote }}">
                                        </div>

                                        <div class="col-md-12" style="display:none;">
                                            <br>
                                            <label for="Category" class="form-label">Location Type<span>*</span></label>
                                            <select class="form-select " aria-label="Location Type" name="location_type"
                                                id="location_type" required>
                                                <option value="">Select Location Type</option>
                                                <option value="online" @if ($product->location_type == 'online') selected @endif>
                                                    Online</option>
                                                <option value="offline" @if ($product->location_type == 'offline') selected @endif>
                                                    Offline</option>
                                                <option value="both" @if ($product->location_type == 'both') selected @endif>
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
                                            <textarea class="form-control" id="short_description" name="short_description">{{ $product->short_description }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="short_description" class="form-label">Short Description
                                                (Hindi)</label>
                                            <textarea class="form-control" id="short_description_hindi" name="short_description_hindi">{{ $product->short_description_hindi }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="inputProductTags" class="form-label">Product Tags</label>
                                            <input type="text" class="form-control" name="tag" id="inputProductTags"
                                                value="{{ $product->tag }}" placeholder="Enter Product Tags">
                                        </div>


                                        <div class="col-md-12 " style="display:none;">
                                            <label for="language" class="form-label">Language<span>*</span></label>
                                            <select class="form-select select2" aria-label="Language" name="language[]"
                                                id="language" multiple>
                                                <option value="">Select Language</option>
                                                @foreach (App\Models\Language::all() as $language)
                                                    <option value="{{ $language->id }}"
                                                        @if (in_array($language->id, json_decode($product->language))) selected @endif>
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
                                                    <option value="{{ $category->id }}"
                                                        @if ($category->id == $product->category_id) selected @endif>
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
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="meta_keywords" placeholder="Meta Keywords"
                                                value="{{ $product->meta_keywords }}">
                                        </div>
                                        <div class="col-md-12  mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_description">{{ $product->meta_description }}</textarea>
                                        </div>
                                        <div class="col-md-12  mb-3 one_day">
                                            <label for="meta_description" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" name="start_date" id="start_date"
                                                placeholder="Enter Start Date" value="{{ $product->start_date }}"
                                                required>
                                        </div>
                                        <div class="col-md-12  mb-3">
                                            <label for="meta_description" class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="date" id="date"
                                                value="{{ $product->date }}" placeholder="Enter Date" required>
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for="tithi" class="form-label">Tithi</label>
                                            <input type="text" class="form-control" name="tithi" id="tithi"
                                                placeholder="Enter Tithi" value="{{ $product->tithi }}">
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for="tithi_hindi" class="form-label">Tithi Hindi</label>
                                            <input type="text" class="form-control" name="tithi_hindi" id="tithi_hindi"
                                                placeholder="Enter Tithi Hindi"  value="{{ $product->tithi_hindi }}">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="document" class="form-label">Photos<span>*</span></label>
                                            <div class="needsclick dropzone" id="document-dropzone">

                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Description</label>
                            <textarea id="text_editor" name="description">{{ $product->description }}
                            </textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputProductDescription" class="form-label">Description (Hindi)</label>
                            <textarea id="description_hindi" name="description_hindi">{{ $product->description_hindi }}
                            </textarea>
                        </div>
                        {{-- <div class="col-md-12 mb-3">
                            <label for="inputProductPromise" class="form-label">Benefits</label>
                            <textarea id="promise" name="promise">{{ $product->promise }}
                            </textarea>
                        </div> --}}
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
        ClassicEditor
            .create(document.querySelector('#text_editor'))
            .catch(error => {
                console.error(error);
            });

        // ClassicEditor
        //     .create(document.querySelector('#key_insight'))
        //     .catch(error => {
        //         console.error(error);
        //     });


        // ClassicEditor
        //     .create(document.querySelector('#key_insight_hindi'))
        //     .catch(error => {
        //         console.error(error);
        //     });

        // ClassicEditor
        //     .create(document.querySelector('#promise'))
        //     .catch(error => {
        //         console.error(error);
        //     });

        // ClassicEditor
        //     .create(document.querySelector('#promise_hindi'))
        //     .catch(error => {
        //         console.error(error);
        //     });

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
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('admin_projects.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove();
                if (typeof file.name !== 'undefined') {
                    name = file.name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="photos[]"][value="' + name + '"]').remove();
            },
            init: function() {
                @if (isset($product) && $product->photos)
                    @foreach ($product->photos as $media)
                        var existingFileUrl = "{{ uploaded_asset($media) }}";
                        var mockFile = {
                            name: "{{ $media }}",
                            size: "30.3",
                            accepted: true
                        };

                        // Add the mock file to the Dropzone
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, existingFileUrl);
                        this.emit("complete", mockFile);

                        // Disable further file uploads

                        // Customize the look and behavior of the thumbnail
                        this.options.thumbnail.call(this, mockFile, existingFileUrl);
                        $('form').append('<input type="hidden" name="photos[]" value="{{ $media }}">');
                    @endforeach
                @endif
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection
