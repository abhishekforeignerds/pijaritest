@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-12 m-auto">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <!-- Back Arrow with Route -->
                            <a href="{{ route('our_pujari.index') }}" class="btn btn-link">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                        <div>
                            <h6 class="card_title">{{ !empty($data->id) ? 'Edit' : 'Add' }} Pujari Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post"
                        action="{{ !empty($data->id) ? route('our_pujari.update', $data->id) : route('our_pujari.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (!empty($data->id))
                        @method('PUT')
                        @endif
                        <div class="form-body row mt-4">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bsValidation1" class="form-label">Name<span>*</span></label>
                                            <input type="text" class="form-control" name="name" id="bsValidation1"
                                                placeholder="Enter Name" value="{{ old('name', $data->name ?? '') }}">
                                            @error('name')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bsValidation2" class="form-label">Name
                                                (Hindi)<span>*</span></label>
                                            <input type="text" class="form-control" name="name_hindi" id="bsValidation2"
                                                placeholder="Enter Name"
                                                value="{{ old('name_hindi', $data->name_hindi ?? '') }}">
                                            @error('name_hindi')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bsValidation1" class="form-label">city
                                                <span>*</span></label>
                                            <input type="text" class="form-control" name="city" id="bsValidation1"
                                                placeholder="Enter City" value="{{ old('city', $data->city ?? '') }}">
                                            @error('city')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bsValidation1" class="form-label">city
                                                (Hindi)<span>*</span></label>
                                            <input type="text" class="form-control" name="city_hindi" id="bsValidation1"
                                                placeholder="Enter City Hindi"
                                                value="{{ old('city_hindi', $data->city_hindi ?? '') }}">
                                            @error('city_hindi')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bsValidation1"
                                                class="form-label">Experience<span>*</span></label>
                                            <input type="text" class="form-control" name="exp" id="bsValidation1"
                                                placeholder="Enter City Hindi"
                                                value="{{ old('exp', $data->exp ?? '') }}">
                                            @error('exp')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bsValidation2" class="form-label">Image <span>*</span></label>
                                            <input type="file" class="form-control" id="Icon" name="image">
                                            <img id="frame" src="{{ !empty($data->image) ? $data->image : '' }}"
                                                style="{{ !empty($data->image) ? 'display:block' : 'display:none' }}"
                                                width="100px" height="100px" />
                                            @error('image')
                                            <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-custom">
                                        {{ !empty($data->id) ? 'Update' : 'Submit' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection