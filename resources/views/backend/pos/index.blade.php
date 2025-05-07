@extends('backend.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content row">

            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Pos Order List</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <form method="GET" id="pos_form" action="{{ route('admin.pos') }}">
                                <tr>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="daterange" id="daterange"
                                                placeholder="Date Filter" value="{{ request('daterange') }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="search" id="search"
                                                onchange="filter()" placeholder="Search..."
                                                value="{{ request('search') }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">

                                            <select lass="form-control" id="vendor_id" name="vendor_id"  onchange="filter()" data-placeholder="Please Select Vendor...">
                                                <option value="">-- Select Vendor--</option>
                                                @foreach (App\Models\Vendor::all() as $vendor)
                                                <option value="">Select Vendor</option>
                                                    <option value="{{ $vendor->id }}"
                                                        @if (request('vendor_id') == $vendor->id) {{ 'selected' }} @endif>
                                                        {{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <button onclick="filter()" class="btn btn-success">Apply</button>
                                        </div>
                                    </td>
                                    <h5 style="float:right;">Total Amount:{{ $pos_list->sum('grand_total') }}</h5>

                                </tr>
                            </form>
                        </table>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>User Name</th>
                                        <th>Type</th>
                                        <th>Referral Code</th>
                                        <th>Vendor</th>
                                        <th>Business Category</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pos_list as $pos)
                                        <tr>
                                            <td>{{ $pos->created_at }}</td>
                                            <td>{{ $pos->user->name }}</td>
                                            <td>{{ $pos->type }}</td>
                                            <td>{{ $pos->referral_code }}</td>
                                            <td>{{ $pos->vendor->name }} ({{ $pos->vendor->firm_name }})</td>
                                            <td>{{ $pos->business_category->name }}</td>
                                            <td>{{ $pos->grand_total }}</td>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('backend/plugins/select2/js/select2-custom.js') }}"></script>
    <script>
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $(document).ready(function() {
            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                filter();

            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                filter();

            });
        });

        function filter() {
            $('#pos_form').submit();
        }

        $('#vendor_id').select2({});
    </script>
@endsection
