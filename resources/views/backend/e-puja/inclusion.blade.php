@extends('backend.layouts.app')
@section('content')
    <style>
        .imagePreview {
            width: 70px;
            height: 70px;
            border: 1px solid #ccc;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form method="POST" action="{{ route('e_puja_inclusion_add') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                    <input type="hidden" name="inclusion_id" value="@if(!empty($inclusion->id)) {{$inclusion->id}} @endif" />
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Add Inclusion</h6>
                            </div>
                            <div class="ms-auto"><button type="submit"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Save</button></div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Inclusion (English)<span>*</span></label>
                                <input type="text" class="form-control" name="inclusion" id="inclusion" value="@if(!empty($inclusion->id)) {{$inclusion->inclusion}} @endif"
                                    placeholder="Enter Inclusion" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Inclusion (Hindi)<span>*</span></label>
                                <input type="text" class="form-control" name="inclusion_hindi" id="inclusion_hindi" value="@if(!empty($inclusion->id)) {{$inclusion->inclusion_hindi}} @endif"
                                    placeholder="Enter Inclusion" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Price (MRP)<span>*</span></label>
                                <input type="number" class="form-control" name="price" id="price" value="@if(!empty($inclusion->id)){{$inclusion->price}}@endif"
                                    placeholder="Enter Price" required>
                            </div>
                            <div class="col-md-3 mb-3" style="display:none;">
                                <label for="inputProductTitle" class="form-label">Advance<span>*</span></label>
                                <input type="number" class="form-control" name="advance" id="advance" value="0"
                                    placeholder="Enter Advance Amount" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="short_description" class="form-label">Description (English)</label>
                                <textarea class="form-control" name="description_english" id="description">@if(!empty($inclusion->id)) {{$inclusion->description_english}} @endif</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="short_description" class="form-label">Description (Hindi)</label>
                                <textarea class="form-control" name="description_hindi" id="description_hindi">@if(!empty($inclusion->id)) {{$inclusion->description_hindi}} @endif</textarea>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="fileInput" class="uploadButton">
                                    <img class="imagePreview" id="imagePreview_fileInput"
                                    src="@if (!empty($inclusion->image)) {{ uploaded_asset($inclusion->image) }} @else{{ 'https://static.thenounproject.com/png/187803-200.png' }} @endif" alt="Placeholder">
                                </label>
                                <input type="file" class="file_input" id="fileInput" name="image"
                                    onchange="file_add_new('fileInput')" accept="image/*">
                                <small class="text-muted" id="sizeMessage">
                                    Please upload an image with dimensions 500x500 pixels.
                                </small>
                            </div>
                            {{-- <div class="col-md-2 mb-3">
                                <a class="add_button_inclusion btn btn-info" title="Add Variant">Inclusion List</a>
                            </div>
                            <div class="row field_wrapper_inclusion">
                            </div> --}}
                        </div>

                        <!--end row-->
                    </div>
                </form>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Inclusion (English)</th>
                                <th>Price (MRP)</th>
                                <th>Advance</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inclusions as $inclusion)
                                <tr>
                                    <td>{{ $inclusion->inclusion }}</td>
                                    <td>{{ $inclusion->price }}</td>
                                    <td>{{ $inclusion->advance }}</td>
                                    <td><img src="{{ uploaded_asset($inclusion->image) }}" alt="image" width="50px"
                                            height="50px"></td>
                                    <td>
                                        <div class="d-flex order-actions">
                                        <a href="{{ route('e_puja.inclusion', $inclusion->product_id) }}?edit_id={{ $inclusion->id }}"
                                            class="me-2"><i class="bx bxs-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#description_hindi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
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
    {{-- <script>
    $(document).ready(function() {
        var maxField = 30; //Input fields increment limitation
        var addButton = $('.add_button_inclusion'); //Add button selector
        var wrapper = $('.field_wrapper_inclusion'); //Input field wrapper
        var x = 1;

        //Once add button is clicked
        $(addButton).click(function() {
            if (x < maxField) {
                var fieldHTML = '<div class="form-group row product-set">' +
                    '<div class="col-lg-2">' +
                    '<label for="mrp" class="form-label">Inclusion Name (English) <span class="text-danger">*</span></label>' +
                    '<input type="text" name="inclusion[]" class="form-control" placeholder="Enter Inclusion Name" required>' +
                    '</div>' +
                    '<div class="col-lg-2">' +
                    '<label for="mrp" class="form-label">Inclusion Name (Hindi) <span class="text-danger">*</span></label>' +
                    '<input type="text" name="inclusion_hindi[]" class="form-control" placeholder="Enter Inclusion Name" required>' +
                    '</div>' +
                    '<div class="col-lg-2">' +
                    '<label for="price" class="form-label">Price <span class="text-danger">*</span></label>' +
                    '<input type="number" name="inclusion_price[]" class="form-control" placeholder="Enter Price" required>' +
                    '</div>' +
                    '<div class="col-lg-2">' +
                    '<label  class="form-label">Advance <span class="text-danger">*</span></label>' +
                    '<input type="number" name="inclusion_advance[]" class="form-control" placeholder="Enter Advance" required>' +
                    '</div>' +
                    '<div class="col-lg-1">' +
                    '<a href="javascript:void(0);" class="remove_button btn btn-danger remove_button" style="margin-top: 32px; height: 30px; width: 40px; margin-left: 43px;">-</a>' +
                    '</div>' +
                    '</div>';
                $(wrapper).append(fieldHTML);
                x++;
            }
        });

        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('.product-set').remove();
            x--;
        });
    });
</script> --}}
@endsection
