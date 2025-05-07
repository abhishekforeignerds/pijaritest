@extends('pujari_dashboard.layouts.app')
@section('content')
<style>
    .welcome__usrs {
    font-size: 18px;
    color: #333;
    text-transform: capitalize;
    margin: 0;
    background-color: #fff;
    padding: 10px 15px 8px;
    box-shadow: 2px 2px 10px -3px rgb(0 0 0 / 15%);
    border-left: 5px solid #AA0A7C;
    border-radius: 4px;
}

</style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <h4 class="welcome__usrs mb-3">Welcome {{Auth::guard('pujari')->user()->name}}</h4>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Puja</p>
                                    <h4 class="my-1 text-info">0</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                        class='bx bxs-cart'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Earn</p>
                                    <h4 class="my-1 text-danger">₹0</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i
                                        class='bx bxs-wallet'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col">
                    <div class="card radius-10 border-start border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Order</p>
                                    <h4 class="my-1 text-success">0</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                        class='bx bxs-bar-chart-alt-2'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Customers</p>
                                    <h4 class="my-1 text-warning">0</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                        class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
@endsection
