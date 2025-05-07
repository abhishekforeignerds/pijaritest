@extends('backend.layouts.app')
@section('content')
<style>
    .table-responsive {
        overflow-x: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .table-responsive::-webkit-scrollbar {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <h6 class="card_title">All Puja List</h6>
                    </div>
                    <div class="col-lg-10">
                        <div class="top_search">
                            <div class="">
                                <select id='category' class="form-control">
                                    <option value=''>Select Category</option>
                                    @foreach (App\Models\Category::get() as $category)
                                    <option value='{{ $category->id }}'>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <select id='searchLocationType' class="form-control">
                                    <option value=''>Select Location Type</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>
                            <div class="">
                                @if (auth()->guard('admin')->user()->can('product-create'))
                                <a href="{{ route('admin_product.create') }}"
                                    class="btn btn-custom radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square">
                                    </i>
                                    Add New Puja
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 px-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Puja Details</th>

                                    <th>Puja Type</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Featured</th>
                                    <th>Upcoming Pooja</th>
                                    <th>Status</th>
                                    @if (auth()->guard('admin')->user()->canany(['product-edit', 'product-view']))
                                    <th>Action</th>
                                    @endif
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />



    @section('script')
    <!-- 1) jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- 2) DataTables next -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer>
        function update_featured(el) {
                if (el.checked) {
                    var status = 1;
                } else {
                    var status = 0;
                }
                $.post('{{ route('admin_product.update_featured') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                }, function(data) {
                    if (data == 1) {

                    } else {

                    }
                });
            }

            function update_upcoming(el) {
                if (el.checked) {
                    var status = 1;
                } else {
                    var status = 0;
                }
                $.post('{{ route('admin_product.update_upcoming') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                }, function(data) {
                    if (data == 1) {

                    } else {

                    }
                });
            }

            function update_status(el) {
                if (el.checked) {
                    var status = 1;
                } else {
                    var status = 0;
                }
                $.post('{{ route('admin_product.update_status') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                }, function(data) {
                    if (data == 1) {

                    } else {

                    }
                });
            }

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
                    //'searching': false, // Remove default Search Control
                    'ajax': {
                        'url': '{{ route('admin_product_get_data') }}',
                        'data': function(data) {
                            // Read values
                            var poojaType = $('#searchPoojaType').val();
                            var city = $('#city').val();
                            var locationType = $('#searchLocationType').val();
                            var category = $('#category').val();

                            // Append to data
                            data.searchByPoojaType = poojaType;
                            data.city = city;
                            data.locationType = locationType;
                            data.category = category;
                        }
                    },
                    'columns': [{
                            data: 'name',
                            // render: function(data, type, row) {
                            //     var sku=row.product_stock[0].sku;
                            //     if(!sku){
                            //         return row.name;
                            //     }
                            //     return row.name + ' <br> Sku:'+sku;
                            // }
                        },

                        {
                            data: 'product_type',
                            render: function(data, type, row) {
                                if (data) {
                                    return data.replace('_', ' '); // Replace underscore with space
                                }
                                return data; // Return original data if null or undefined
                            }
                        },

                        {
                            mRender: function(data, type, row) {
                                return row.category.name
                            }
                        },
                        {
                            data: 'location_type',
                        },
                        {
                            data: 'featured',
                            render: function(data, type, row) {
                                var is_checked = '';
                                if (data == 1) {
                                    is_checked = 'checked';
                                }
                                return '<div class="form-check form-switch"> <input class="form-check-input" onchange="update_featured(this)" value="' +
                                    row.id + '" type="checkbox"  id="flexSwitchCheckChecked" ' +
                                    is_checked +
                                    ' ><label class="form-check-label" for="flexSwitchCheckChecked"></label></div>';
                            }
                        },
                        {
                            data: 'upcoming',
                            render: function(data, type, row) {
                                var is_upcoming_checked = '';
                                if (row.upcoming == 1) {
                                    is_upcoming_checked = 'checked';
                                }
                                return '<div class="form-check form-switch"> <input class="form-check-input" onchange="update_upcoming(this)" value="' +
                                    row.id + '" type="checkbox"  id="flexSwitchCheckChecked" ' +
                                    is_upcoming_checked +
                                    ' ><label class="form-check-label" for="flexSwitchCheckChecked"></label></div>';
                            }
                        },
                        {
                            data: 'status',
                            render: function(data, type, row) {
                                var is_checked = '';
                                if (data == 1) {
                                    is_checked = 'checked';
                                }
                                return '<div class="form-check form-switch"> <input class="form-check-input" onchange="update_status(this)" value="' +
                                    row.id + '" type="checkbox"  id="flexSwitchCheckChecked" ' +
                                    is_checked +
                                    ' ><label class="form-check-label" for="flexSwitchCheckChecked"></label></div>';
                            }
                        },
                        @if (auth()->guard('admin')->user()->canany(['product-edit', 'product-view']))
                            {
                                mRender: function(data, type, row) {

                                    return '<div class="d-flex order-actions">@if (auth()->guard('admin')->user()->can('product-edit'))<a href="{{ route('admin_product_edit', '') }}/' +
                                        row.id +
                                        '" class="me-2" title="Edit"><i class="bx bxs-edit text-info"></i></a><a href="{{ route('admin_package_add', '') }}/' +
                                        row.id +
                                        '" class="me-2" title="Package"><i class="bx bx-plus text-success"></i></a><a href="{{ route('admin_product_package', '') }}/' +
                                        row.id +
                                        '" class="me-2" title="Show Details"><i class="bx bxs-show text-warning"></i></a>@endif</div>'
                                }
                            }
                        @endif
                    ]
                });

                $('#city').change(function() {
                    dataTable.draw();
                });

                $('#searchPoojaType').change(function() {
                    dataTable.draw();
                });

                $('#searchLocationType').change(function() {
                    dataTable.draw();
                });
                $('#category').change(function() {
                    dataTable.draw();
                });

                $('#city').select2({
                    minimumInputLength: 3,
                    allowClear: true,
                    ajax: {
                        url: '{{ route('admin_city.list') }}',
                        dataType: 'json',
                        data: function(params) {
                            return {
                                key: params.term // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true

                    }
                });
            });
    </script>
    @endsection