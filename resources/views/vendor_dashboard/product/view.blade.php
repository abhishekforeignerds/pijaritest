@extends('vendor_dashboard.layouts.app')
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
            width: 100px;
            height: 100px;
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

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">View Product</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-body row mt-4">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label for="inputProductTitle" class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter product name" value="{{ $product->name }}" required>
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
                                            <label for="Category" class="form-label">Product Category <span class="text-danger">*</span></label>
                                            <select class="form-select" aria-label="Product Category" name="category_id"
                                                id="category_id" onchange="get_subcategory()" required>
                                                <option>Select Category</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="SubCategory" class="form-label">Product SubCategory <span class="text-danger">*</span></label>
                                            <select class="form-select" aria-label="Product SubCategory"
                                                name="subcategory_id" id="subcategory_id" required>
                                                <option selected="">Select SubCategory</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputProductTags" class="form-label">Product Tags</label>
                                            <input type="text" class="form-control" name="tag" id="inputProductTags"
                                                placeholder="Enter Product Tags" value="{{ $product->tag }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputProductDescription" class="form-label">Description</label>
                                            <textarea id="text_editors" name="description">{{ $product->description }}
                                            </textarea>
                                        </div><br><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 border border-3 p-4 rounded">
                                <div class="field_wrapper">
                                    @foreach($product->product_stock as $key => $product_stock)

                                    <div class="form-group row">
                                        <input type="hidden" name="product_stock_id[]" value="{{$product_stock->id}}" />
                                        <div class="col-lg-2">
                                            <label for="color" class="form-label">Color (optional)</label>
                                            <input type="text" id="color" name="color_old[]" class="form-control" value="{{$product_stock->color}}"
                                                placeholder="Enter Color">
                                            <span class="form-text">eg : red,green,blue</span>

                                        </div>
                                        <div class="col-lg-2">
                                            <label for="s_w" class="form-label">Size/Weight <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="s_w" name="s_w_old[]" class="form-control" value="{{$product_stock->s_w}}"
                                                placeholder="Enter Size/Weight" required>
                                            <span class="form-text">eg : 1L,1KG,L,M,S,32,34</span>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">MRP (₹) <span class="text-danger">*</span></label>
                                            <input type="text" placeholder="" data-a-sign="₹ " id="mrp" value="{{$product_stock->mrp}}"
                                                name="mrp_old[]" class="form-control autonumber" required>

                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Sell Price (₹) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" placeholder="" data-a-sign="₹ " id="sell_price" value="{{$product_stock->price}}"
                                                name="sell_price_old[]" class="form-control autonumber" required>

                                        </div>
                                        <div class="col-lg-2">
                                            <label for="qty" class="form-label">Qty <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="qty" name="qty_old[]" class="form-control" value="{{$product_stock->quantity}}"
                                                placeholder="Enter Qty" required>
                                            <span class="form-text">eg : 10</span>
                                        </div>
                                        <div class="col-lg-1 mb-2">
                                            <label for="fileInput_{{$key+1}}" class="uploadButton">
                                                <img class="imagePreview" id="imagePreview_fileInput_{{$key+1}}"
                                                    src="@if(!empty($product_stock->thumbnail)) {{ $product_stock->full_image_url }} @else {{'https://seller.grocito.com/d.png'}} @endif" alt="Placeholder">
                                            </label>
                                            <input type="file" class="file_input" id="fileInput_{{$key+1}}" name="thumbnail_old[]"
                                                onchange="file_add_new('fileInput_{{$key+1}}')" accept="image/*" >
                                        </div>

                                            @if($key==0)
                                            <a class="add_button btn btn-primary" style="margin-top: 32px; height: 30px;width: 40px;margin-left: 32px;"
                                            title="Add Variant">+</a>
                                            @else
                                            <a href="javascript:void(0);" class="remove_button btn btn-danger" style="margin-top: 32px; height: 30px;width: 40px;margin-left: 32px;"> - </a>
                                           @endif


                                    </div>
                                    @endforeach
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
            $.get('{{ route('get_category_by_vendor') }}', {
                _token: '{{ csrf_token() }}',
                vendor_id: vendor_id
            }, function(data) {
                $('#category_id').html(null);
                $('#category_id').append($('<option>', {
                    value: '',
                    text: 'Select Category'
                }));

                for (var i = 0; i < data.length; i++) {
                    var checked = '';
                    if (data[i].id == '{{ $product->category_id }}') {
                        checked = 'selected';
                    }
                    $('#category_id').append('<option value="' + data[i].id + '" ' + checked + ' >' + data[i].name +
                        '</option>');
                }
            });
        }

        function get_subcategory() {
            var category_id = $('#category_id').val();
            $.get('{{ route('get_sub_category_by_category') }}', {
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
                    if (data[i].id == '{{ $product->subcategory_id }}') {
                        checked = 'selected';
                    }
                    $('#subcategory_id').append('<option value="' + data[i].id + '" ' + checked + ' >' + data[i]
                        .name + '</option>');
                }
            });
        }

        $(document).ready(function() {
            get_category();

            var category_id = "{{ $product->category_id}}";
            $.get('{{ route('get_sub_category_by_category') }}', {
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
                    if (data[i].id == '{{ $product->subcategory_id }}') {
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
     <script>
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var x = 1;

            //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    var fieldHTML ='<div class="form-group row"><div class="col-lg-2"><label for="color" class="form-label">Color</label><input type="text" id="color" name="color[]" class="form-control" placeholder="Enter Color"></div><div class="col-lg-2"><label for="s_w" class="form-label">Size/Weight  <span class="text-danger">*</span></label><input type="text" id="s_w" name="s_w[]" class="form-control" placeholder="Enter Size/Weight" required></div><div class="col-lg-2"><label class="form-label">MRP (₹)  <span class="text-danger">*</span></label><input type="text" placeholder="" data-a-sign="₹ " id="mrp" name="mrp[]" class="form-control autonumber" required></div><div class="col-lg-2"><label class="form-label">Sell Price (₹)  <span class="text-danger">*</span></label><input type="text" placeholder="" data-a-sign="₹ " id="sell_price" name="sell_price[]" class="form-control autonumber" required></div><div class="col-lg-2"><label for="qty" class="form-label">Qty  <span class="text-danger">*</span></label><input type="text" id="qty" name="qty[]" class="form-control" placeholder="Enter Qty" required></div><div class="col-lg-1 mb-2"><label for="fileInput'+x+'" class="uploadButton"><img class="imagePreview" id="imagePreview_fileInput'+x+'" src="https://seller.grocito.com/d.png" alt="Placeholder"></label><input type="file"  class="file_input" id="fileInput'+x+'" name="thumbnail[]" onchange="file_add('+x+')"  accept="image/*" required></div><a href="javascript:void(0);" class="remove_button btn btn-danger" style="margin-top: 32px;height:30px;width:40px;margin-left:43px;">-</a></div>'; //New input field html
                   //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                    x++;
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

        });
    </script>
    <script>
        function file_add(id) {
            var file = $('#fileInput'+id).get(0).files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function() {
                    $("#imagePreview_fileInput"+ id).attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

        function file_add_new(id) {
            var file = $('#'+id).get(0).files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function() {
                    $("#imagePreview_"+ id).attr("src", reader.result);
                }
                reader.readAsDataURL(file);
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
