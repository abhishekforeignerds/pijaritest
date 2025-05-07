@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12 m-auto">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Add Policies</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (isset($policy) && isset($policy->id))
                            <form action="{{ route('policy.update', $policy->id) }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @method('PUT')
                            @else
                                <form action="{{ route('policy.store') }}" method="POST" enctype="multipart/form-data"
                                    class="needs-validation" novalidate>
                        @endif
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Privacy Policy</label>
                                <textarea id="privacy_policy_editor" name="privacy_policy" rows="8">{{ old('privacy_policy', optional($policy)->privacy_policy) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Privacy Policy(Hindi)</label>
                                <textarea id="privacy_policy_editor_hindi" name="privacy_policy_hindi" rows="8">{{ old('privacy_policy_hindi', optional($policy)->privacy_policy_hindi) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Return Policy</label>
                                <textarea id="return_policy_editor" name="return_policy" rows="8">{{ old('return_policy', optional($policy)->return_policy) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Return Policy (Hindi)</label>
                                <textarea id="return_policy_editor_hindi" name="return_policy_hindi" rows="8">{{ old('return_policy_hindi', optional($policy)->return_policy_hindi) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label"> Shipping Policy</label>
                                <textarea id="shipping_policy_editor" name="shipping_policy" rows="8">{{ old('shipping_policy', optional($policy)->shipping_policy) }}</textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Terms & Conditions</label>
                                <textarea id="terms_and_conditions_editor" name="terms_and_conditions" rows="8">{{ old('terms_and_conditions', optional($policy)->terms_and_conditions) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"> Terms & Conditions(Hindi)</label>
                                <textarea id="terms_and_conditions_editor_hindi" name="terms_and_conditions_hindi" rows="8">{{ old('terms_and_conditions_hindi', optional($policy)->terms_and_conditions_hindi) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"> How We Work</label>
                                <textarea id="how_we_work" name="how_we_work" rows="8">{{ old('how_we_work', optional($policy)->how_we_work) }}</textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label"> How We Work (Hindi)</label>
                                <textarea id="how_we_work_hindi" name="how_we_work_hindi" rows="8"> {{ old('how_we_work_hindi', optional($policy)->how_we_work_hindi) }}</textarea>
                            </div>

                            <div class="mb-3 col-md-12">
                                <button class="btn btn-primary" type="submit">Submit</button>
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
        ClassicEditor
            .create(document.querySelector('#privacy_policy_editor'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#privacy_policy_editor_hindi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#return_policy_editor'))
            .catch(error => {
                console.error(error);
            });
            ClassicEditor
            .create(document.querySelector('#return_policy_editor_hindi'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#terms_and_conditions_editor'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#terms_and_conditions_editor_hindi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#shipping_policy_editor'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#how_we_work'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#how_we_work_hindi'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
