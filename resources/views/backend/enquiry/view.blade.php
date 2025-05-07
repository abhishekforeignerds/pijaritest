@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-6 m-auto">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">{{ !empty($enquiry->id) ? 'View' : 'Add' }} Enquiry</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="bsValidation1" placeholder="Name"
                                value="@if (!empty($enquiry->name)) {{ $enquiry->name }} @endif" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="bsValidation1" placeholder="email"
                                value="@if (!empty($enquiry->email)) {{ $enquiry->email }} @endif" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="bsValidation1" placeholder="phone"
                                value="@if (!empty($enquiry->phone)) {{ $enquiry->phone }} @endif" disabled>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="bsValidation1" class="form-label">Message</label>
                            <textarea class="form-control" name="message" placeholder="Message" id="bsValidation1" disabled>{{ $enquiry->message }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
