@extends('vendor_dashboard.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Add New Service</h6>
                            </div>
                            <div class="ms-auto"><button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary radius-30 mt-2 mt-lg-0">Save</button></div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-body row mt-4">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label for="inputServiceTitle" class="form-label">Service Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Service name" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="inputServiceTitle" class="form-label">Thumbnail Image</label>
                                            <input type="file" class="form-control" name="thumbnail" accept="image/*" id="thumbnail"
                                                placeholder="Enter Service title" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="document" class="form-label">Photos</label>
                                            <div class="needsclick dropzone" id="document-dropzone">

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
                                            <select class="form-select" aria-label="Service Category" name="category_id" id="category_id" onchange="get_subcategory()" reuired>
                                                <option >Select Category</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="SubCategory" class="form-label">Service SubCategory <span class="text-danger">*</span></label>
                                            <select class="form-select" aria-label="Service SubCategory" name="subcategory_id" id="subcategory_id" required>
                                                <option selected="">Select SubCategory</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Price" class="form-label">Price <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="Price" name="mrp" placeholder="00.00" value="0" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dPrice" class="form-label">Disconted Price <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="dPrice" name="price" placeholder="00.00" value="0" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputServiceTags" class="form-label">Service Tags</label>
                                            <input type="text" class="form-control" name="tag" id="inputServiceTags"
                                                placeholder="Enter Service Tags" >
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputServiceDescription" class="form-label">Description</label>
                                            <textarea id="text_editor" name="description">
                                            </textarea>
                                        </div><br><br>
                                    </div>
                                </div>
                            </div>
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
		    for (var i = 0; i < data.length; i++) {
		        $('#category_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
            });
        }

        function get_subcategory() {
            var category_id=$('#category_id').val();
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
		        $('#subcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
            });
        }

        $(document).ready(function() {
            get_category();
        });
    </script>
      <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            dictDefaultMessage: "Select File to Upload",
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
                @if (isset($Service) && $Service->photos)
                    @foreach ($Service->photos as $media)
                        var existingFileUrl = "{{ asset('Service/' . $media) }}";
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
                .create( document.querySelector( '#text_editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
@endsection
