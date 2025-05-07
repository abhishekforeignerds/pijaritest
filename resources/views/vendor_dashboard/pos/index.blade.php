@extends('vendor_dashboard.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">{{ !empty($pos->id) ? 'Edit' : 'Add' }} POS</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="pos" name="pos" method="post"
                            action="{{ route('pos.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (!empty($pos->id))
                                <input type="hidden" name="id" value="{{ $pos->id }}" />
                            @endif
                            <div class="col-md-12">
                                <label for="bsValidation1" class="form-label">Business Category <span class="text-danger">*</span></label>
                                <select class="form-select mb-3" aria-label="Default select example" name="business_category_id" required>
									<option value="">Select Business Catgeory</option>
                                    @foreach(App\Models\BusinessCategory::whereIn('id',json_decode(Auth::guard('vendor')->user()->business_category))->get() as $business_category)
									<option value="{{$business_category->id}}" @if (!empty($pos->business_category_id)) @if($business_category->id==$pos->business_category_id) {{'selected'}} @endif @endif>{{$business_category->name}}</option>
                                    @endforeach
								</select>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation1" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-select mb-3" aria-label="Default select example" name="type" required>
									<option value="product" @if (!empty($pos->type)) @if($pos->type=='product') {{'selected'}} @endif @endif>Product</option>
                                    <option value="service" @if (!empty($pos->type)) @if($pos->type=='service') {{'selected'}} @endif @endif>Service</option>
								</select>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation1" class="form-label">User Referral Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="referral_code" id="referral_code"
                                    placeholder="User Referral Code" maxlength="11" onKeyPress="if(this.value.length==11) return false;"
                                    value="@if (!empty($pos->referral_code)) {{ $pos->referral_code }} @endif" required>
                            </div>

                            <div class="col-md-12">
                                <label for="bsValidation1" class="form-label">User Name</label>
                                <input type="text" class="form-control" name="user_name" id="user_name"
                                    placeholder="User Name"
                                    value="" required readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation1" class="form-label">Total Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="grand_total" id="grand_total"
                                    placeholder="Total Amount"
                                    value="" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4" onclick="return confirm('Are you sure you want to submit order?');">{{ !empty($pos->id) ? 'Update' : 'Submit' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
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
                            <form method="GET" id="pos_form" action="{{route('pos.index')}}">
                            <tr>
                                <td>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Date Filter"
                                            value="{{request('daterange')}}" />
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="search" id="search" onchange="filter()" placeholder="Search..."
                                            value="{{request('search')}}" />
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
                                        <th>Referral Code</th>
                                        <th>Business Category</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pos_list as $pos)
                                    <tr>
                                        <td>{{$pos->created_at }}</td>
                                        <td>{{$pos->user->name }}</td>
                                        <td>{{$pos->type}}</td>
                                        <td>{{$pos->referral_code}}</td>
                                        <td>{{$pos->business_category->name}}</td>
                                        <td>{{$pos->grand_total}}</td>
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

        function filter(){
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
                    }else{
                        alert('Invalid Code');
                        $('#referral_code').val('');
                    }
                }
            });
        }else{
            $('#user_name').val('');
        }
    });
</script>
@endsection
