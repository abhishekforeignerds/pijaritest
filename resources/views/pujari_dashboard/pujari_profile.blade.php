@extends('pujari_dashboard.layouts.app')
@section('content')
    <style>
        /* Style the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 90%;
            max-width: 1200px;
        }

        /* Close button */
        .close {
            position: absolute;
            top: 10px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    @php $pujari=Auth::guard('pujari')->user(); @endphp
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->logo) }}"
                                        onerror="this.src='{{asset('frontend/assets/images/pandit-ji.png')}}';" alt="Pujari Ji" class="rounded-circle p-1 bg-danger" width="110">
                                        <div class="mt-3">
                                            <h4>{{ $pujari->name }}</h4>
                                            <p class="text-secondary mb-1">{{ $pujari->email }}</p>
                                            <p class="text-muted font-size-sm">{{ $pujari->phone }}</p>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <div style="text-align:center;">
                                        @if ($pujari->verified == 1)
                                            <p style="color:green;"> Verified </p>
                                        @else
                                            <p style="color:red;"> Unverified </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card radius-10">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">Personal Info</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-body">
                                        <form class="row g-3" method="post" action="{{ route('pujari.profile_update') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pujari->id }}" />
                                            <div class="col-md-4">
                                                <label for="Name" class="form-label">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="Name" placeholder="Name"
                                                    name="name" value="{{ $pujari->name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="FatherName" class="form-label">Father Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="FatherName"
                                                    placeholder="Father Name" name="father_name"
                                                    value="{{ $pujari->father_name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="DOB" class="form-label">DOB <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="DOB" placeholder="DOB"
                                                    name="dob" value="{{ $pujari->dob }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Email" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="Email"
                                                    placeholder="Email" name="email" value="{{ $pujari->email }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="tel" class="form-control" id="phone"
                                                    placeholder="Enter Phone" name="phone"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10"
                                                    value="{{ $pujari->phone }}" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="whatsapp" class="form-label">Whatsapp</label>
                                                <input type="tel" class="form-control" id="whatsapp"
                                                    placeholder="Enter Whatsapp" name="whatsapp"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10"
                                                    value="{{ $pujari->whatsapp }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="category" class="form-label">Category<span>*</span></label>
                                                <select id="category" class="form-select select2" aria-label="Category"
                                                    name="category[]" id="category" multiple required>
                                                    <option value="">Select Category</option>
                                                    @foreach (App\Models\Category::get() as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (in_array($category->id, json_decode($pujari->category))) selected @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="city" class="form-label">City<span>*</span></label>
                                                <select class="form-select select2" aria-label="City" name="city[]"
                                                    id="city" onchange="getPincode()" multiple required>
                                                    @foreach (App\Models\ServiceCity::all() as $city)
                                                        <option value="{{ $city->id }}"
                                                            @if (in_array($city->id, json_decode($pujari->city))) selected @endif>
                                                            {{ $city->city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="city" class="form-label">Terth City</label>
                                                <select class="form-select select2" aria-label="City" name="terth_city[]"
                                                    id="terth_city" multiple>
                                                    @foreach (App\Models\TerthPujaCity::all() as $t_city)
                                                        <option value="{{ $t_city->id }}"
                                                            @if (in_array($t_city->id, json_decode($pujari->terth_city))) selected @endif>
                                                            {{ $t_city->city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="pincode" class="form-label">Pincode<span>*</span></label>
                                                <select id="pincode" class="form-select select2" aria-label="Pincode"
                                                    name="pincode[]" id="pincode" multiple required>
                                                    <option value="">Select Pincode</option>
                                                    @foreach (json_decode($pujari->pincode) as $pincode)
                                                        <option value="{{ $pincode }}" selected>{{ $pincode }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="language" class="form-label">Language<span>*</span></label>
                                                <select class="form-select select2" aria-label="Language"
                                                    name="language[]" id="language" multiple required>
                                                    <option value="">Select Language</option>
                                                    @foreach (App\Models\Language::all() as $language)
                                                        <option value="{{ $language->id }}"
                                                            @if (in_array($language->id, json_decode($pujari->language))) selected @endif>
                                                            {{ $language->language }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="Address" class="form-label">Address <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="Address"
                                                    placeholder="Address" name="address" value="{{ $pujari->address }}"
                                                    required>
                                            </div>


                                            <div class="col-md-4">
                                                <label for="Image" class="form-label">Image</label>
                                                <input type="file" class="form-control" id="image"
                                                    placeholder="Image" name="logo">
                                                <img class="mt-2 g_image"
                                                    @isset($pujari)  src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->logo) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                    onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                    height="80px" width="80px">
                                            </div>

                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="card radius-10">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">Account Info</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-body">
                                        <form class="row g-3" method="post" action="{{ route('pujari.bank_update') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pujari->id }}" />
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label for="BankName" class="form-label">Bank Name</label>
                                                    <input type="text" class="form-control" id="BankName"
                                                        placeholder="Bank Name" name="bank_name"
                                                        value="{{ $pujari->bank_name }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="BranchName" class="form-label">Branch Name</label>
                                                    <input type="text" class="form-control" id="BranchName"
                                                        placeholder="Branch Name" name="branch_name"
                                                        value="{{ $pujari->branch_name }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="IFSCcode" class="form-label">IFSC Code</label>
                                                    <input type="text" class="form-control" id="IFSCcode"
                                                        placeholder="IFSC Code" name="ifsc_code"
                                                        value="{{ $pujari->ifsc_code }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="AccountHolderName" class="form-label">Bank Account
                                                        Number</label>
                                                    <input type="number" class="form-control" id="account_number"
                                                        placeholder="Bank Account Number" name="account_number"
                                                        value="{{ $pujari->account_number }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="AccountHolderName" class="form-label">Account Holder
                                                        Name</label>
                                                    <input type="text" class="form-control" id="AccountHolderName"
                                                        placeholder="Account Holder Name" name="account_holder_name"
                                                        value="{{ $pujari->account_holder_name }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="passbook_image" class="form-label">Passbook Image</label>
                                                    <input type="file" class="form-control" id="passbook_image"
                                                        placeholder="Passbook Image" name="passbook_image">
                                                    <img class="mt-2 g_image"
                                                        @isset($pujari)  src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->passbook_image) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                        onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                        height="80px" width="80px">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="checkbook" class="form-label">Checkbook Image</label>
                                                    <input type="file" class="form-control" id="checkbook"
                                                        placeholder="Checkbook Image" name="checkbook_image">
                                                    <img class="mt-2 g_image"
                                                        @isset($pujari)  src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->checkbook_image) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                        onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                        height="80px" width="80px">
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                            class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="card radius-10">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">Education Info</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-body">
                                        <form class="row g-3" method="post"
                                            action="{{ route('pujari.education_update') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pujari->id }}" />
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label for="pan_card" class="form-label">Pan Card Image</label>
                                                    <input type="file" class="form-control" name="pan_card"
                                                        id="pan_card" placeholder="Pan Card" name="pan_card"
                                                        value="{{ $pujari->pan_card }}">

                                                    <img class="mt-2 g_image"
                                                        @isset($pujari)  src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->pan_card) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                        onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                        height="80px" width="80px">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="aadhaar_card" class="form-label">Aadhaar Card
                                                        Image</label>
                                                    <input type="file" class="form-control" name="aadhaar_card"
                                                        id="aadhaar_card" placeholder="Aadhaar Card" name="aadhaar_card"
                                                        value="{{ $pujari->aadhaar_card }}">
                                                    <img class="mt-2 g_image"
                                                        @isset($pujari)   src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->aadhaar_card) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                        onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                        height="80px" width="80px">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="aadhaar_card_back" class="form-label">Aadhaar Card Back
                                                        Image</label>
                                                    <input type="file" class="form-control" name="aadhaar_card_back"
                                                        id="aadhaar_card_back" placeholder="Aadhaar Card Back"
                                                        name="aadhaar_card_back"
                                                        value="{{ $pujari->aadhaar_card_back }}">
                                                    <img class="mt-2 g_image"
                                                        @isset($pujari)  src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $pujari->aadhaar_card_back) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                        onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                        height="80px" width="80px">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="experince" class="form-label">Experince (in years)</label>
                                                    <input type="text" class="form-control" id="experince"
                                                        placeholder="Experince" name="experince"
                                                        value="{{ $pujari->experince }}">
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div id="qualifications-container">

                                                    @foreach (json_decode($pujari->qualification) as $key => $quanlification)
                                                        <div class="qualification-entry">
                                                            <label for="qualification"
                                                                class="form-label">Qualification</label>
                                                            <input type="text" class="form-control"
                                                                name="qualifications[]" placeholder="Enter Qualification"
                                                                value="{{ $quanlification }}">

                                                            <label for="qualification-image" class="form-label">Upload
                                                                Image</label>
                                                            <input type="file" class="form-control"
                                                                name="qualification_images[]">
                                                            <img class="mt-2 g_image"
                                                                @isset($pujari)   @php $image = json_decode($pujari->qualification_image)[$key]; @endphp   src="{{ asset('frontend/pujari/' . $pujari->id . '/' . $image) }}"  @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                                                onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                                                height="80px" width="80px">

                                                            <button type="button" class="btn btn-danger remove-entry"
                                                                style="margin-top: 10px;">Remove</button>
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-success w-50"
                                                    id="add-qualification" style="margin-top: 10px;margin-left: 30%;">+
                                                    Add Qualification</button>
                                            </div>

                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="imageModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>

    </div>
    <!--end page wrapper -->


    <!--Start Modal -->

    <!--End Modal -->
@endsection
@section('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Choose one thing",
                allowClear: true
            });

        });

        function getPincode() {
            var city_id = $('#city').val();
            $.ajax({
                url: "{{ route('pujari.get-pincode') }}", // Laravel route
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

        document.getElementById('add-qualification').addEventListener('click', function() {
            const container = document.getElementById('qualifications-container');

            const newEntry = document.createElement('div');
            newEntry.className = 'qualification-entry';
            newEntry.innerHTML = `
        <label for="qualification" class="form-label">Qualification</label>
        <input type="text" class="form-control" name="qualifications[]" placeholder="Enter Qualification">

        <label for="qualification-image" class="form-label">Upload Image</label>
        <input type="file" class="form-control" name="qualification_images[]">

        <button type="button" class="btn btn-danger remove-entry" style="margin-top: 10px;">Remove</button>
    `;

            container.appendChild(newEntry);

            // Add event listener to the remove button
            newEntry.querySelector('.remove-entry').addEventListener('click', function() {
                container.removeChild(newEntry);
            });
        });

        // Attach event listener to existing remove buttons
        document.querySelectorAll('.remove-entry').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.qualification-entry').remove();
            });
        });


        // Select the modal and close button
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeBtn = document.querySelector('.close');

        // Add click event to all images with the "thumbnail" class
        document.querySelectorAll('.g_image').forEach(image => {
            image.addEventListener('click', () => {
                modal.style.display = 'block';
                modalImage.src = image.src; // Set the modal image source
            });
        });

        // Close the modal when the user clicks the close button
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close the modal when the user clicks outside the image
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
@endsection
