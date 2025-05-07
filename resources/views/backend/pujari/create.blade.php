@extends('backend.layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Pujari Add</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        <form class="row g-3" id="vendor_regiter" name="vendor_regiter" method="post" action="{{route('pujari.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                                <label for="Name" class="form-label">Name<span>*</span></label>
                                <input type="text" class="form-control" id="Name"
                                    placeholder="Name" name="name" value="{{old('name')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="Email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="Email"
                                    placeholder="Email" name="email" value="{{old('email')}}">
                                    @if ($errors->has('email'))
                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label for="city" class="form-label">City<span>*</span></label>
                                <select class="form-select select2" aria-label="City" name="city[]" id="city" onchange="getPincode()" multiple required>
                                    <option value="">Select City</option>
                                    @foreach (App\Models\ServiceCity::all() as $city)
                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="pincode" class="form-label">Pincode<span>*</span></label>
                                <select id="pincode" class="form-select select2" aria-label="Pincode" name="pincode[]" id="pincode" multiple required>
                                    <option value="">Select Pincode</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="language" class="form-label">Language<span>*</span></label>
                                <select class="form-select select2" aria-label="Language" name="language[]"
                                    id="language" multiple required>
                                    <option value="">Select Language</option>
                                    @foreach (App\Models\Language::all() as $language)
                                        <option value="{{ $language->id }}">{{ $language->language }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="Address"
                                    placeholder="Address" name="address" value="{{old('address')}}">
                            </div>
                            {{-- <div class="col-md-4">
                                <label for="BankName" class="form-label">Bank Name</label>
                                <input type="text" class="form-control" id="BankName"
                                    placeholder="Bank Name" name="bank_name" value="{{old('bank_name')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="BranchName" class="form-label">Branch Name</label>
                                <input type="text" class="form-control" id="BranchName"
                                    placeholder="Branch Name" name="branch_name" value="{{old('branch_name')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="AccountHolderName" class="form-label">Bank Account Number</label>
                                <input type="number" class="form-control" id="account_number"
                                    placeholder="Bank Account Number" name="account_number" value="{{old('account_number')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="AccountHolderName" class="form-label">Account Holder
                                    Name</label>
                                <input type="text" class="form-control" id="AccountHolderName"
                                    placeholder="Account Holder Name" name="account_holder_name" value="{{old('account_holder_name')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="IFSCcode" class="form-label">IFSC Code</label>
                                <input type="text" class="form-control" id="IFSCcode"
                                    placeholder="IFSC Code" name="ifsc_code" value="{{old('ifsc_code')}}">
                            </div> --}}
                            <div class="col-md-4">
                                <label for="Logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="Logo"
                                    placeholder="Logo" name="logo">
                            </div>

                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone<span>*</span></label>
                                <input type="tel" class="form-control" id="phone"
                                    placeholder="Enter Phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" value="{{old('phone')}}" >
                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            </div>
                            <div class="col-12">
                                <div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "Choose one thing",
                allowClear: true
            });

            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
            comission_table_show();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('backend/plugins/select2/js/select2-custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
        $(function() {
            $("form[name='vendor_regiter']").validate({

                    rules: {

                        name: "required",

                        phone: "required",
                        password: {
                            required: true,
                            minlength: 6
                        }
                    },

                    messages: {
                        name: "Please enter your Name",
                        email: {
                            required: "Please enter the email address  ",
                            email: "Please enter a valid email address"
                        },
                    phone: "Please enter phone",
                    password: {
                        required: "Please provide password",
                        minlength: "Your password must be at least 5 characters long"
                    },

                },

                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
    <script>
            // $(document).on('keypress', '.select2-search__field', function() {
            //     $(this).val($(this).val().replace(/[^\d].+/, ""));
            //     if ((event.which < 48 || event.which > 57)) {
            //         event.preventDefault();
            //     }
            // });

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
                        `<option value="${city.pincode}">${city.pincode}</option>`
                    );
                });
            },
            error: function(xhr) {
                console.log("Error:", xhr);
            }
        });
    }

            $('#pincode_select').select2({
                minimumInputLength: 3,
                allowClear: true,
                ajax: {
                    url: '{{route('admin_pincode.list')}}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            key: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true

                }
            });
            function get_pincode(){
               var pincode = $('#pincode_select').val();
               $.get('{{ route('admin.get_pincode') }}', {
                    _token: '{{ csrf_token() }}',
                    pincode: pincode
                }, function(data) {
                    console.log(data);
                    $('#city').val(data.city);
                    $('#state').val(data.state);
                });
            }

            function comission_table_show() {
        var business_category = $('#multiple-select-clear-field').val();
        $.get('{{ route('vendor_comission_percentage_add') }}', {
            _token: '{{ csrf_token() }}',
            business_category: business_category,
        }, function(data) {
            $('#comission_table').empty();
            $('#comission_table').html(data);
        });
    }
    </script>
@endsection
