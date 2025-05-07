@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
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
                                    <form method="GET" id="pos_form" action="{{ route('pos.index') }}">
                                        <tr>
                                            <td>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" name="daterange"
                                                        id="daterange" placeholder="Date Filter"
                                                        value="{{ request('daterange') }}" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" name="search" id="search"
                                                        onchange="filter()" placeholder="Search..."
                                                        value="{{ request('search') }}" />
                                                </div>
                                            </td>
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
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    </script>
    <script>
        $("#referral_code").keyup(function() {
            var referral_code = $('#referral_code').val();
            if (referral_code.length == 11) {
                $.ajax({
                    type: "GET",
                    async: false,
                    dataType: 'json',
                    url: "{{ route('checkreferral') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        referral_code: referral_code
                    },
                    success: function(response) {

                        if (response.name) {
                            $('#user_name').val(response.name);
                        } else {
                            alert('Invalid Code');
                            $('#referral_code').val('');
                        }
                    }
                });
            }
        });
    </script>
@endsection
