@extends('backend.layouts.app')
@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-12">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Testimonials</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($review as $data)
                                <tr>
                                    <td>{{ $data->userData->name }}</td>
                                    <td>{{ $data->Product->name }}</td>
                                    <td>{{ $data->rating }}</td>
                                    <td>{{ $data->review }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" onchange="update_status(this)"
                                                value="{{ $data->id }}" type="checkbox" id="flexSwitchCheckChecked" @if
                                                ($data->status == 1) {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:void(0);" class="me-2"
                                                onclick="confirmDelete('{{ route('review.delete', $data->id) }}')">
                                                <i class="bx bxs-trash text-danger"></i>
                                            </a>
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
    </div>
</div>
<!--end page wrapper -->
@endsection
@section('script')
<script>
    function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('review.status_update') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }
</script>
@endsection