@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Bootstrap Validation</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" novalidate>
                                <div class="col-md-6">
                                    <label for="bsValidation1" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="bsValidation1" placeholder="First Name"
                                        value="Jhon" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation2" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="bsValidation2" placeholder="Last Name"
                                        value="Deo" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation3" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="bsValidation3" placeholder="Phone"
                                        required>
                                    <div class="invalid-feedback">
                                        Please choose a username.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation4" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="bsValidation4" placeholder="Email"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation5" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="bsValidation5" placeholder="Password"
                                        required>
                                    <div class="invalid-feedback">
                                        Please choose a password.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="bsValidation6"
                                                name="radio-stacked" required>
                                            <label class="form-check-label" for="bsValidation6">Male</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="bsValidation7"
                                                name="radio-stacked" required>
                                            <label class="form-check-label" for="bsValidation7">Female</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation8" class="form-label">DOB</label>
                                    <input type="date" class="form-control" id="bsValidation8"
                                        placeholder="Date of Birth" required>
                                    <div class="invalid-feedback">
                                        Please select date.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation9" class="form-label">Country</label>
                                    <select id="bsValidation9" class="form-select" required>
                                        <option selected disabled value>...</option>
                                        <option>One</option>
                                        <option>Two</option>
                                        <option>Three</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="bsValidation10" class="form-label">City</label>
                                    <input type="text" class="form-control" id="bsValidation10" placeholder="City"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="bsValidation11" class="form-label">State</label>
                                    <select id="bsValidation11" class="form-select" required>
                                        <option selected disabled value>Choose...</option>
                                        <option>One</option>
                                        <option>Two</option>
                                        <option>Three</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid State.
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="bsValidation12" class="form-label">Zip</label>
                                    <input type="text" class="form-control" id="bsValidation12" placeholder="Zip"
                                        required>
                                    <div class="invalid-feedback">
                                        Please enter a valid Zip code.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation13" class="form-label">Address</label>
                                    <textarea class="form-control" id="bsValidation13" placeholder="Address ..." rows="3" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter a valid address.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bsValidation14" required>
                                        <label class="form-check-label" for="bsValidation14">Agree to terms and
                                            conditions</label>
                                        <div class="invalid-feedback">
                                            You must agree before submitting.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        <button type="reset" class="btn btn-light px-4">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
            <div class="row">
                <div class="col-xl-10 mx-auto">

                    <h6 class="mb-0 text-uppercase">Single Select Examples</h6>
                     <hr/>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="single-select-clear-field" class="form-label">Single select w/ allow clear</label>
                                 <select class="form-select" id="single-select-clear-field" data-placeholder="Choose one thing">
                                     <option></option>
                                     <option>Reactive</option>
                                     <option>Solution</option>
                                     <option>Conglomeration</option>
                                     <option>Algoritm</option>
                                     <option>Holistic</option>
                                 </select>
                             </div>
                        </div>
                    </div>


                    <h6 class="mb-0 text-uppercase">Multiple select</h6>
                     <hr/>
                    <div class="card">
                       <div class="card-body">

                        <div class="mb-4">
                            <label for="multiple-select-field" class="form-label">Basic multiple select</label>
                            <select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple>
                                <option selected>Christmas Island</option>
                                <option selected>South Sudan</option>
                                <option selected>Jamaica</option>
                                <option>Kenya</option>
                                <option>French Guiana</option>
                                <option>Mayotta</option>
                                <option>Liechtenstein</option>
                                <option>Denmark</option>
                                <option>Eritrea</option>
                                <option>Gibraltar</option>
                                <option>Saint Helena, Ascension and Tristan da Cunha</option>
                                <option>Haiti</option>
                                <option>Namibia</option>
                                <option>South Georgia and the South Sandwich Islands</option>
                                <option>Vietnam</option>
                                <option>Yemen</option>
                                <option>Philippines</option>
                                <option>Benin</option>
                                <option>Czech Republic</option>
                                <option>Russia</option>
                            </select>
                        </div>
                       </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <h6 class="mb-0 text-uppercase">Date Time Pickers</h6>
                    <hr/>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Pick a Date</label>
                                <input type="text" class="form-control datepicker" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Time Picker</label>
                                <input type="text" class="form-control time-picker" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date & Time Picker</label>
                                <input type="text" class="form-control date-time" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Format</label>
                                <input type="text" class="form-control date-format" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Range</label>
                                <input type="text" class="form-control date-range" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Inline Calendar</label>
                                <input type="text" class="form-control date-inline" />
                            </div>
                        </div>
                    </div>
                    <h6 class="mb-0 text-uppercase">Input Tags</h6>
                    <hr/>
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Basic</label>
                                    <input type="text" class="form-control" data-role="tagsinput" value="jQuery,Script,Net">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Multi Select</label>
                                    <select multiple data-role="tagsinput">
                                        <option value="Amsterdam">Amsterdam</option>
                                        <option value="Washington">Washington</option>
                                        <option value="Sydney">Sydney</option>
                                        <option value="Beijing">Beijing</option>
                                        <option value="Cairo">Cairo</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h6 class="mb-0 text-uppercase">Checkboxes and radios</h6>
                    <hr/>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">Checked checkbox</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled>
                                <label class="form-check-label" for="flexCheckDisabled">Disabled checkbox</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>
                                <label class="form-check-label" for="flexCheckCheckedDisabled">Disabled checked checkbox</label>
                            </div>
                            <hr/>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">Default radio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">Default checked radio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioDisabled" disabled>
                                <label class="form-check-label" for="flexRadioDisabled">Disabled radio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked disabled>
                                <label class="form-check-label" for="flexRadioCheckedDisabled">Disabled checked radio</label>
                            </div>
                            <hr/>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
                            </div>
                            <div class="form-check-danger form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDanger" checked>
                                <label class="form-check-label" for="flexSwitchCheckCheckedDanger">Checked switch checkbox input</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDisabled" disabled>
                                <label class="form-check-label" for="flexSwitchCheckDisabled">Disabled switch checkbox input</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDisabled" checked disabled>
                                <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Disabled checked switch checkbox input</label>
                            </div>
                            <hr/>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled>
                                <label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                <label class="form-check-label" for="inlineRadio1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
                                <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
