@extends('vendor_dashboard.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">View service</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-body row mt-4">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label for="inputserviceTitle" class="form-label">Service Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Service name" value="{{ $service->name }}" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="inputserviceTitle" class="form-label">Thumbnail Image</label>
                                            <input type="file" class="form-control" name="thumbnail" accept="image/*"
                                                id="thumbnail" placeholder="Enter service title">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="document" class="form-label">Photos</label>
                                            <div class="needsclick dropzone " id="document-dropzone">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="Category" class="form-label">Service Category <span class="text-danger">*</span></label>
                                            <select class="form-select" aria-label="Service Category" name="category_id"
                                                id="category_id" onchange="get_subcategory()" required>
                                                <option>Select Category</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="SubCategory" class="form-label">Service SubCategory <span class="text-danger">*</span></label>
                                            <select class="form-select" aria-label="Service SubCategory"
                                                name="subcategory_id" id="subcategory_id" required>
                                                <option selected="">Select SubCategory</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Price" class="form-label">Price <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="Price" name="mrp"
                                                placeholder="00.00" value="{{ $service->mrp }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dPrice" class="form-label">Disconted Price <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="dPrice" name="price"
                                                placeholder="00.00" value="{{ $service->price }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputserviceTags" class="form-label">Service Tags</label>
                                            <input type="text" class="form-control" name="tag" id="inputserviceTags"
                                                placeholder="Enter service Tags">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputserviceDescription" class="form-label">Description</label>
                                            <textarea id="text_editor" name="description">{{$service->description}}
                                            </textarea>
                                        </div><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>

            </div>
        </div>
    </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
    <script>
        function get_category() {
            var vendor_id = "{{ Auth::guard('vendor')->user()->id }}";
            $.get('{{ route('get_service_category_by_vendor') }}', {
                _token: '{{ csrf_token() }}',
                vendor_id: vendor_id
            }, function(data) {
                $('#category_id').html(null);
                $('#category_id').append($('<option>', {
                    value: '',
                    text: 'Select Category'
                }));
                var checked = '';
                for (var i = 0; i < data.length; i++) {
                    if (data[i].id == '{{ $service->category_id }}') {
                        checked = 'selected';
                    }
                    $('#category_id').append('<option value="' + data[i].id + '" ' + checked + ' >' + data[i].name +
                        '</option>');
                }
            });

        }

        function get_subcategory() {
            var category_id = $('#category_id').val();
            $.get('{{ route('get_service_sub_category_by_category') }}', {
                _token: '{{ csrf_token() }}',
                category_id: category_id
            }, function(data) {
                $('#subcategory_id').html(null);
                $('#subcategory_id').append($('<option>', {
                    value: '',
                    text: 'Select SubCategory'
                }));
                var checked = '';
                for (var i = 0; i < data.length; i++) {
                    if (data[i].id == '{{ $service->subcategory_id }}') {
                        checked = 'selected';
                    }
                    $('#subcategory_id').append('<option value="' + data[i].id + '" ' + checked + ' >' + data[i]
                        .name + '</option>');
                }
            });
        }
        $(document).ready(function() {
            get_category();

            var category_id = "{{ $service->category_id}}";
            $.get('{{ route('get_service_sub_category_by_category') }}', {
                _token: '{{ csrf_token() }}',
                category_id: category_id
            }, function(data) {
                $('#subcategory_id').html(null);
                $('#subcategory_id').append($('<option>', {
                    value: '',
                    text: 'Select SubCategory'
                }));

                for (var i = 0; i < data.length; i++) {
                    var checked = '';
                    if (data[i].id == '{{ $service->subcategory_id }}') {
                        checked = 'selected';
                    }
                    $('#subcategory_id').append('<option value="' + data[i].id + '" ' + checked + ' >' + data[i]
                        .name + '</option>');
                }
            });
        });
    </script>
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('projects.storeMedia') }}',
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
                @if (isset($service) && $service->photos)
                    @foreach ($service->photos as $media)
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
        <script>
            ClassicEditor
                .create( document.querySelector( '#text_editors' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
@endsection
