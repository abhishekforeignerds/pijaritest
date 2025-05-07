@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Genial Trust Report</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="dates" id="daterange" value=""
                                        placeholder="Select Date" />
                                </div>
                            </td>

                        </tr>
                    </table>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Request Amount</th>
                                    <th scope="col">Genial Amount</th>
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
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
    </script>
    <script>
        function preview() {
            $('#frame').show();
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

        $(document).ready(function() {
            var dataTable = $('#datatable').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                'serverMethod': 'get',
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                'searching': true, // Remove default Search Control
                'ajax': {
                    'url': '{{ route('admin_get_genial_t_report') }}',
                    'data': function(data) {
                        // Read values
                        var gender = $('#searchByGender').val();
                        var name = $('#searchByName').val();
                        var daterange = $('#daterange').val();

                        // Append to data
                        data.daterange = daterange;
                        // Append to data
                        data.searchByGender = gender;
                        data.searchByName = name;
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
                        mRender: function(data, type, row) {
                            return '<span>' + row.user.name + '<br>' + row.user.phone + '<br>' + row
                                .user.referral_code + '<br></span>';
                        }
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'gt_amount'
                    },


                ],
                'columnDefs': [{
                    'targets': [1],
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }]
            });

            $('#searchByName').keyup(function() {
                dataTable.draw();
            });

            $('#searchByGender').change(function() {
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
