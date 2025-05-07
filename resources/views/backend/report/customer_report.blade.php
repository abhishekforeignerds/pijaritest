@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Customer Report</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td>
                                <div class="mb-3">
                                    <select id='searchStatus' class="form-control">
                                        <option value=''>-- Select Status--</option>
                                        <option value='paid'>Paid</option>
                                        <option value='unpaid'>UnPaid</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3">
                                    <select id='searchBankStatus' class="form-control">
                                        <option value=''>-- Bank Details--</option>
                                        <option value='1'>Yes</option>
                                        <option value='0'>No</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="dates" id="daterange"
                                        value="" placeholder="Select Date" />
                                </div>
                            </td>
                        </tr>

                    </table>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Join Date</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Prime</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Refferal Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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

    <script>
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('customer.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }


        $(document).ready(function() {
            var dataTable = $('#datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print', 'pageLength'
                ],
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                'serverMethod': 'get',
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                "ordering": true,
                //'searching': false, // Remove default Search Control
                'ajax': {
                    'url': '{{ route('admin_get_customer_report') }}',
                    'data': function(data) {
                        // Read values
                        var status = $('#searchStatus').val();
                        var bank_status = $('#searchBankStatus').val();
                        var daterange = $('#daterange').val();

                        // Append to data
                        data.searchStatus = status;
                        data.searchBankStatus = bank_status;
                        data.daterange = daterange;
                    }
                },
                'columns': [{
                        data: 'created_at',
                        render: function(data, type, row) {
                            const d = Date.parse(data);
                            var nd = new Date(d);
                            const year = nd.getFullYear();
                            const month = (nd.getMonth() + 1).toString().padStart(2,
                            '0'); // Adding 1 to the month and padding with zeros if needed
                            const day = nd.getDate().toString().padStart(2,
                            '0'); // Padding with zeros if needed
                            const hours = nd.getHours().toString().padStart(2,
                            '0'); // Adding hours and padding with zeros if needed
                            const minutes = nd.getMinutes().toString().padStart(2,
                            '0'); // Adding minutes and padding with zeros if needed
                            const seconds = nd.getSeconds().toString().padStart(2, '0');
                            const amPm = hours >= 12 ? 'PM' : 'AM';
                            const formattedHours = (hours % 12 || 12).toString().padStart(2,
                            '0'); // Convert to 12-hour format
                            return `${day}-${month}-${year} ${formattedHours}:${minutes} ${amPm}`;
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        mRender: function(data, type, row) {
                            if (row.designation) {
                                return row.designation.toUpperCase().replace('_', ' ');
                            }
                            return '';
                        }
                    },
                    {
                        mRender: function(data, type, row) {
                            var p = row.prime;
                            var pr = '';
                            if (p == 1) {
                                pr = 'Prime';
                            }
                            return pr;
                        }
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'referral_code'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (row.status == 1) {
                              return  '<p style="color:green;">Paid</p>';
                            }
                            if (row.status == 0) {
                              return  '<p style="color:red;">UnPaid</p>';
                            }
                        }
                    }
                ]
            });

            $('#searchStatus').change(function() {
                dataTable.draw();
            });
            $('#searchBankStatus').change(function() {
                dataTable.draw();
            });

            $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                dataTable.draw();
            });

            $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                dataTable.draw();
            });
        });
    </script>
@endsection
