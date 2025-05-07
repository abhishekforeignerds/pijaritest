@extends('backend.layouts.app')
@section('content')
<style>

.nav-pills-custom .nav-link {
    /* color: #aaa;
    background: #fff; */
    position: relative;
}

.nav-pills-custom .nav-link.active {
    /* color: #45b649;
    background: #fff; */
}


/* Add indicator arrow for the active tab */
@media (min-width: 992px) {
    .nav-pills-custom .nav-link::before {
        content: '';
        display: block;
        border-top: 8px solid transparent;
        border-left: 10px solid #007bff;
        border-bottom: 8px solid transparent;
        position: absolute;
        top: 50%;
        right: -10px;
        transform: translateY(-50%);
        opacity: 0;
    }
}

.nav-pills-custom .nav-link.active::before {
    opacity: 1;
}



body {
    min-height: 100vh;
}

</style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Vendor Report Detail</h6>
                        </div>

                    </div>
                </div>
                <section class="py-5 header">
                    <div class="container py-4">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Tabs nav -->
                                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-3 p-3 shadow active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                        <i class="fa fa-user-circle-o mr-2"></i>
                                        <span class="font-weight-bold small text-uppercase">Order</span></a>

                                    <a class="nav-link mb-3 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                        <i class="fa fa-calendar-minus-o mr-2"></i>
                                        <span class="font-weight-bold small text-uppercase">Pos</span></a>

                                    <a class="nav-link mb-3 p-3 shadow" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                        <i class="fa fa-check mr-2"></i>
                                        <span class="font-weight-bold small text-uppercase">Product</span></a>
                                    </div>
                            </div>


                            <div class="col-md-9">
                                <!-- Tabs content -->
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <tr>
                                                            <th scope="col">ORDER CODE</th>
                                                            <th scope="col">NUM. OF PRODUCTS</th>
                                                            <th scope="col">AMOUNT</th>
                                                        </tr>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (App\Models\Order::where('vendor_id',$vendor->id)->get() as $order)
                                                    <tr>
                                                        <td>{{ $order->code }}</td>
                                                        <td>{{ count($order->order_detail) }}</td>
                                                        {{-- <td>{{ $order->vendor->firm_name }}</td> --}}
                                                        <td>₹{{ $order->grand_total }}</td>
                                                    </tr>
                                                    @empty
                                                        <tr class="footable-empty">
                                                            <td colspan="11">
                                                                <center style="padding: 70px;"><i class="far fa-frown" style="font-size: 100px;"></i><br>
                                                                    <h2>Nothing Found</h2>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade shadow rounded bg-white p-5" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>User Name</th>
                                                        <th>Type</th>
                                                        <th>Referral Code</th>
                                                        <th>Business Category</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (App\Models\Pos::where('vendor_id',$vendor->id)->get() as $pos)
                                                    <tr>
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

                                    <div class="tab-pane fade shadow rounded bg-white p-5" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Category</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(App\Models\Product::where('vendor_id',$vendor->id)->get() as $product)
                                                    <tr>
                                                        <td>{{$product->name}}</td>
                                                        <td>{{$product->category->name}}</td>

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
                </section>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')

@endsection
