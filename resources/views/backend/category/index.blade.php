@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <h6 class="card_title">Category List</h6>
                        </div>
                        <div class="col-lg-8">
                            <div class="top_search">
                                @if (auth()->guard('admin')->user()->can('category-create'))
                                    <a href="{{ route('category.create') }}" class="btn btn-custom radius-30 mt-2 mt-lg-0"><i
                                            class="bx bxs-plus-square"></i>
                                        Add New Category
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="small-table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Priority <br><span style="color:red;font-size: 12px;">(Double
                                            Click To Change)</span></th>
                                    <th>Name</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Icon</th>
                                    @if (auth()->guard('admin')->user()->canany(['category-edit', 'category-view']))
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
    <!--end page wrapper -->
@endsection
@section('script')
    <script>
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('category.update_featured') }}', {
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
            $.post('{{ route('category.update_status') }}', {
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
                    'url': '{{ route('category_get_data') }}',
                    'data': function(data) {
                        // Read values
                        var gender = $('#searchByGender').val();
                        var name = $('#searchByName').val();

                        // Append to data
                        data.searchByGender = gender;
                        data.searchByName = name;
                    }
                },
                'columns': [{
                        data: 'priority',
                        render: function(data, type, row) {
                            return '<div  id="' + row.id + '" ondblclick="change_priority(' + row
                                .id + ')" >' + data + '</div>';
                        }
                    },
                    {
                        data: 'name'
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
                    {
                        data: 'full_image_url',
                        render: function(data) {
                            return '<img src="' + data + '" class="product-img-2" /> ';
                        }
                    },
                    @if (auth()->guard('admin')->user()->canany(['category-edit', 'category-view']))
                        {
                            mRender: function(data, type, row) {
                                return '<div class="d-flex order-actions"> @if (auth()->guard('admin')->user()->can('category-edit'))<a href="{{ route('category_edit', '') }}/' +
                                    row.id +
                                    '" class="me-2" title="Edit"><i class="bx bxs-edit text-info"></i></a>@endif</div>'
                            }
                        }
                    @endif
                ]
            });

            $('#searchByName').keyup(function() {
                dataTable.draw();
            });

            $('#searchByGender').change(function() {
                dataTable.draw();
            });
        });

        function change_priority(id) {
            var priority = $('#' + id).text();
            $('#' + id).html('<input type="number" class="form-control" name="priority" id="priority_value' + id +
                '" onchange="update_priority(' + id + ')" value="' + priority + '" >');
        }

        function update_priority(id) {
            var value = $('#priority_value' + id).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('category.update_priority') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    value: value
                },
                success: function(data) {
                    if (data == 1) {
                        location.reload();
                    } else {
                        alert('Incorrect Priority Number.')
                    }
                }
            });
        }
    </script>
@endsection
