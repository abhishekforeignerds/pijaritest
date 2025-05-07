@extends('backend.layouts.app')
@section('content')

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form method="POST" action="{{route('temple_puja.package_update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}" />
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Add Package of {{$product->name}}</h6>
                            </div>
                            <div class="ms-auto"><button type="submit"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Save</button></div>
                        </div>
                    </div>
                    <div class="card-body p-4">

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Package Name (English)<span>*</span></label>
                                <input type="text" class="form-control" name="package_name" id="package_name"  placeholder="Enter Package Name" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Package Name (Hindi)<span>*</span></label>
                                <input type="text" class="form-control" name="package_name_hindi" id="package_name_hindi"  placeholder="Enter Package Name" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Price (MRP)<span>*</span></label>
                                <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Sell Price<span>*</span></label>
                                <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Sell Price" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">Advance<span>*</span></label>
                                <input type="number" class="form-control" name="advance" id="advance" placeholder="Enter Advance Amount" required>
                            </div>
                            @if($product->product_type=='one_day')
                            <div class="col-md-3 mb-3">
                                <label for="inputProductTitle" class="form-label">No Of People<span>*</span></label>
                                <input type="number" class="form-control" name="no_of_people" id="no_of_people" placeholder="Enter No Of People" required>
                            </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <label for="short_description" class="form-label">Description (English)</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="short_description" class="form-label">Description (Hindi)</label>
                                <textarea class="form-control" name="description_hindi" id="description_hindi"></textarea>
                            </div>

                            <div class="col-md-2 mb-3">
                            <a class="add_button_inclusion btn btn-primary"
                            title="Add Variant">+ Add Inclusion</a>
                            </div>
                            <div class="row field_wrapper_inclusion">
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
</script>
@endsection
