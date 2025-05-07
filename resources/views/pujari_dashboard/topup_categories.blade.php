@extends('vendor_dashboard.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Top Up Categories List</h6>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category Name</th>
                            <th>Product Comission</th>
                            <th>Product Balance</th>
                            <th>Action</th>
                            <th>Service Comission</th>
                            <th>Service Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendor_categories as $key=>$business_category_ids)
                        @php  $business_category = App\Models\BusinessCategory::where('id',$business_category_ids)->first();   @endphp
                        <tr>
                            <td><input type="hidden" name="business_category[]" value="{{$business_category->id}}" />{{$business_category->name}}</td>
                            <td>{{json_decode($vendor->product_comission_percentage)[$key]}} ({{json_decode($vendor->product_type_comission)[$key]}})</td>
                            <td>{{$vendor_categories_product_balance[$key]}}</td>
                            <td>@if($commissions_product[$key]>0)<a href="#" onclick="payment_modal_product('{{$business_category->id}}')" class="btn btn-outline-primary" >Recharge</a>@endif</td>
                            <td>{{json_decode($vendor->service_comission_percentage)[$key]}} ({{json_decode($vendor->service_type_comission)[$key]}})</td>
                            <td>{{$vendor_categories_service_balance[$key]}}</td>
                            <td>
                                @if($commissions_service[$key]>0)
                                <a href="#" onclick="payment_modal_service('{{$business_category->id}}')" class="btn btn-outline-primary" >Recharge</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Topup Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(env('APP_ENV')=='local')
                  <form class="row g-3" id="vendor_categories_product_fess" name="vendor_categories_fess" method="post" action="{{route('vendor.pay_vendor_categories_product_fess')}}" enctype="multipart/form-data">
                    <input type="hidden" name="payment_details" value="offline" />
                @else
                  <form class="row g-3" id="vendor_categories_product_fess" name="vendor_categories_fess" method="post" action="{{route('vendor.vendor_categories_product_fess_phonepe')}}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="col-md-12">
                        <input type="hidden" id="category_id_product" name="category_id" />
                        <input type="hidden" id="vendor_product_recharge" name="type" value="vendor_product_recharge"/>
                        <label for="topup_category" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="topup_category"
                            placeholder="Topup Category" name="amount" min="100" value="100" required>
                    </div> <hr>
                    <div class="text-center mt-0">
                            <button type="submit" class="btn btn-primary">Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="servicePaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Service Topup Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(env('APP_ENV')=='local')
                 <form class="row g-3" id="vendor_categories_service_fess" name="vendor_categories_fess" method="post" action="{{route('vendor.pay_vendor_categories_service_fess')}}" enctype="multipart/form-data">
                 <input type="hidden" name="payment_details" value="offline" />
                @else
                 <form class="row g-3" id="vendor_categories_service_fess" name="vendor_categories_fess" method="post" action="{{route('vendor.vendor_categories_service_fess_phonepe')}}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="col-md-12">
                        <input type="hidden" id="category_id_service" name="category_id" />
                        <input type="hidden" id="vendor_service_recharge" name="type" value="vendor_service_recharge"/>
                        <label for="topup_category" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="topup_category"
                            placeholder="Topup Category" name="amount" min="100" value="100" required>
                    </div> <hr>
                    <div class="text-center mt-0">
                            <button type="submit" class="btn btn-primary">Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function payment_modal_product(id){
        $('#category_id_product').val(id);
        $('#productPaymentModal').modal('show');
    }
    function payment_modal_service(id){
        $('#category_id_service').val(id);
        $('#servicePaymentModal').modal('show');
    }
</script>
@endsection
