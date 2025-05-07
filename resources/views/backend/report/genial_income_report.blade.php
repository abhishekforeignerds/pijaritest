@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Genial Income Report</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">

                    <table>
                        <tr>
                            <td>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="dates" id="daterange"
                                        value=""placeholder="Select Date" />
                                </div>
                            </td>


                            @php $data=App\Models\GenialIncome::where('id', '>', 0)->get(); @endphp
                            <p style="float:right;font-size:18px;">Genail Amount:{{$data->sum('genial_amount')}}</h5>
                            <p style="float:right;font-size:18px;">Order Amount:{{$data->sum('order_amount')}}</h5>

                        </tr>
                    </table>


                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User Details</th>
                                    <th>Vendor</th>
                                    <th>Order Id</th>
                                    <th>Order Amount</th>
                                    <th>Genial Amount</th>
                                    <th>Genial Percent</th>
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
    </script>
    <script>


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
                    'url': '{{ route('admin_get_genial_income_report') }}',
                    'data': function(data) {
                        // Read values
                        var daterange = $('#daterange').val();

                        // Append to data
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
                        mRender: function(data, type, row) {
                            return '<span> Name:'+row.user.name+'<br>Phone:'+row.user.phone+'<br>Referral Code:'+row.user.referral_code+'<br></span>';
                        }
                    },
                    {
                        data: 'vendor_id'
                    },
                    {
                        data: 'order_id'
                    },
                    {
                        data: 'order_amount'
                    },
                    {
                        data: 'genial_amount'
                    },
                    {
                        data: 'genial_percent'
                    },

                ],
                'columnDefs': [{
                    'targets': [1],
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }]
            });

            $('#searchStatus').change(function() {
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
