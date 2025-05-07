@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-12 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Add App Setups</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('app_setup.store')}}" method="POST" enctype="multipart/form-data" id="add_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input id="logo" class="form-control" type="file" name="logo" accept="image/*" onchange="validateAndPreviewImage('logo')">
                                <input type="hidden" name="type[]" value="logo">
                                <img id="imagePreview_logo" src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                                     class="mt-2"
                                     alt="Logo"
                                     height="100"
                                     width="100"
                                     onerror="this.onerror=null; this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                     style="object-fit: cover;">
                                    <small class="text-muted" id="sizeMessage">
                                        Please upload an image with dimensions 170x70 pixels.
                                    </small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="favicon" class="form-label">Favicon</label>
                                <input id="favicon" class="form-control" type="file" name="favicon" accept="image/*">
                                <input type="hidden" name="type[]" value="favicon">
                                <img id="img2" src="{{asset('backend/images/app_setup/'.appSetupValue('favicon'))}}" class="mt-2" alt="Favicon" height="50" width="50" onerror="this.onerror=null; this.src='{{asset('backend/images/no-image.jpg')}}'">

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="app_name" class="form-label">App Name</label>
                                <input id="app_name" class="form-control" type="text" name="app_name" placeholder="Enter Name" value="{{appSetupValue('app_name')}}">
                                <input type="hidden" name="type[]" value="app_name">

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input id="contact_number" class="form-control" type="text" name="contact_number" placeholder="Enter Contact Number" value="{{appSetupValue('contact_number')}}">
                                <input type="hidden" name="type[]" value="contact_number">

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email" placeholder="Enter Email" value="{{appSetupValue('email')}}">
                                <input type="hidden" name="type[]" value="email">

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="address" rows="2" placeholder="Enter Full Address">{{appSetupValue('address')}}</textarea>
                                <input type="hidden" name="type[]" value="address">

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">About Footer</label>
                                <textarea id="privacy_policy_editor" name="about-footer" class="form-control" rows="2" placeholder="About Footer">{{appSetupValue('about-footer')}}</textarea>
                                <input type="hidden" name="type[]" value="about-footer">

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">About (Hindi)</label>
                                <textarea id="about_hindi" name="about-hindi" class="form-control" rows="2" placeholder="About Footer Hindi">{{appSetupValue('about-hindi')}}</textarea>
                                <input type="hidden" name="type[]" value="about-hindi">

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gst_no" class="form-label">GST No</label>
                                <input id="gst_no" class="form-control" type="text" name="gst_no" placeholder="Enter GST No" value="{{appSetupValue('gst_no')}}">
                                <input type="hidden" name="type[]" value="gst_no">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="gst_no" class="form-label">Sankalp Message</label>
                                <input id="gst_no" class="form-control" type="text" name="sankalp_message" placeholder="Enter Sankalp Message" value="{{appSetupValue('sankalp_message')}}">
                                <input type="hidden" name="type[]" value="sankalp_message">
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" value="0" type="hidden" name="more_show">
                                    <input class="form-check-input" value="1" type="checkbox" id="more_show" {{appSetupValue('more_show') ? 'checked' : ''}} name="more_show">
                                    <label class="form-check-label" for="more_show">More Show</label>
                                    <input type="hidden" name="type[]" value="more_show">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" value="0" type="hidden" name="kundali_matching_show">
                                    <input class="form-check-input" value="1" type="checkbox" id="kundali_matching_show" {{appSetupValue('kundali_matching_show') ? 'checked' : ''}} name="kundali_matching_show">
                                    <label class="form-check-label" for="kundali_matching_show">Kundali Matching Show</label>
                                    <input type="hidden" name="type[]" value="kundali_matching_show">
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flatpickr">
                                    <span class="input-group-text input-group-addon bg-primary" data-toggle><i class="lni lni-facebook text-white"></i></span>
                                    <input type="text" name="facebook" class="form-control" placeholder="Enter Facebook Link" value="{{appSetupValue('facebook')}}" data-input>
                                    <input type="hidden" name="type[]" value="facebook">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flatpickr">
                                    <span class="input-group-text input-group-addon bg-success" data-toggle><i class="lni lni-whatsapp text-white"></i></span>
                                    <input type="text" class="form-control" name="whats_app_number" placeholder="Enter WhatsApp Number" value="{{appSetupValue('whats_app_number')}}" data-input>
                                    <input type="hidden" name="type[]" value="whats_app_number">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flatpickr">
                                    <span class="input-group-text input-group-addon bg-info" data-toggle><i class="lni lni-twitter text-white"></i></span>
                                    <input type="text" name="twitter" class="form-control" placeholder="Enter Twitter Link" value="{{appSetupValue('twitter')}}" data-input>
                                    <input type="hidden" name="type[]" value="twitter">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flatpickr">
                                    <span class="input-group-text input-group-addon bg-danger" data-toggle><i class="lni lni-instagram text-white"></i></span>
                                    <input type="text" name="instagram" class="form-control" placeholder="Enter Instagram Link" value="{{appSetupValue('instagram')}}" data-input>
                                    <input type="hidden" name="type[]" value="instagram">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flatpickr">
                                    <span class="input-group-text input-group-addon bg-danger" data-toggle><i class="lni lni-youtube text-white"></i></span>
                                    <input type="text" name="youtube" class="form-control" placeholder="Enter Youtube Link" value="{{appSetupValue('youtube')}}" data-input>
                                    <input type="hidden" name="type[]" value="youtube">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flatpickr">
                                    <span class="input-group-text input-group-addon bg-primary" data-toggle><i class="lni lni-linkedin text-white"></i></span>
                                    <input type="text" name="linkedin" class="form-control" placeholder="Enter Linkedin Link" value="{{appSetupValue('linkedin')}}" data-input>
                                    <input type="hidden" name="type[]" value="linkedin">
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3 text-center">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    logo.onchange = evt => {
                const [file] = logo.files
                if (file) {
                    img.src = URL.createObjectURL(file)
                }
            }

            favicon.onchange = evt => {
                const [file] = favicon.files
                if (file) {
                    img2.src = URL.createObjectURL(file)
                }
            }
</script>
<script>
    function validateAndPreviewImage(inputId) {
        const fileInput = document.getElementById(inputId);
        const previewImage = document.getElementById(`imagePreview_${inputId}`);
        const errorMessage = document.getElementById('errorMessage');
        const requiredWidth = 100; // Backend-enforced width
        const requiredHeight = 100; // Backend-enforced height

        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    if (img.width === requiredWidth && img.height === requiredHeight) {
                        // Correct size
                        previewImage.src = e.target.result;
                        errorMessage.style.display = "none";
                    } else {
                        // Incorrect size
                        errorMessage.style.display = "block";
                        previewImage.src = "https://static.thenounproject.com/png/187803-200.png";
                    }
                };
            };

            reader.readAsDataURL(file);
        }
    }
</script>
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#privacy_policy_editor'))
            .catch(error => {
                console.error(error);
            });
            ClassicEditor
            .create(document.querySelector('#about_hindi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#return_policy_editor'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#terms_and_conditions_editor'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#shipping_policy_editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection

@endsection
