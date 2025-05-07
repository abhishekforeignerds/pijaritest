@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            @if (auth()->guard('admin')->user()->can('service_city-create'))
                <div class="col-4">
                    <div class="card radius-10">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <h6 class="card_title">{{ !empty($language->id) ? 'Edit' : 'Add' }} Language City</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="language" method="post" action="{{ route('language.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if (!empty($language->id))
                                    <input type="hidden" name="id" value="{{ $language->id }}" />
                                @endif
                                <div class="col-md-12 mb-3">
                                    <label for="bsValidation1" class="form-label">Language<span>*</span></label>
                                    <input type="text" class="form-control" name="language" id="bsValidation1"
                                        placeholder="language"
                                        value="@if (!empty($language->language)) {{ $language->language }} @endif" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit"
                                            class="btn btn-primary px-4">{{ !empty($language->id) ? 'Update' : 'Submit' }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-8">
                <div class="card radius-10">
                    <div class="card-header">
                        <form id="search_form" method="GET" action="{{ route('admin.language') }}">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <h6 class="card_title">Language List</h6>
                                </div>
                                <div class="col-lg-8">
                                    <div class="top_search">
                                        <input class="form-control" type="text" name="q"
                                            value="{{ request('q') }}" placeholder="Search By Language">
                                        <button type="submit" class="btn btn-custom radius-30 mt-2 mt-lg-0"><i
                                                class="bx bxs-zoom-in me-0"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>

                                        <th>Language</th>
                                        <th>Status</th>
                                        @if (auth()->guard('admin')->user()->canany(['service_city-edit', 'service_city-delete']))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languages as $language)
                                        <tr>

                                            <td>{{ $language->language }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" onchange="update_status(this)"
                                                        value="{{ $language->id }}" type="checkbox"
                                                        id="flexSwitchCheckChecked"
                                                        @if ($language->status == 'active') {{ 'checked' }} @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                </div>
                                            </td>
                                            @if (auth()->guard('admin')->user()->canany(['service_city-edit', 'service_city-delete']))
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        @if (auth()->guard('admin')->user()->can('service_city-edit'))
                                                            <a href="{{ route('language.edit', $language->id) }}"
                                                                class="me-2" title="Edit"><i
                                                                    class="bx bxs-edit text-info"></i></a>
                                                        @endif
                                                        @if (auth()->guard('admin')->user()->can('service_city-delete'))
                                                            <a href="javascript:void(0);" class="me-2"
                                                                onclick="confirmDelete('{{ route('language.delete', $language->id) }}')"
                                                                title="Delete"><i class="bx bxs-trash text-danger"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $languages->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        function update_status(el) {
            if (el.checked) {
                var status = 'active';
            } else {
                var status = 'inactive';
            }
            $.post('{{ route('language.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        function filter() {
            $('#search_form').submit();
        }
    </script>
@endsection
