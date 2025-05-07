@extends('backend.layouts.app')
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
        <div class="page-content dash">
            {{-- <h4 class="welcome__usrs mb-3">Welcome To Pujari Ji, {{Auth::guard('admin')->user()->name}}</h4> --}}
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('admin_product.index') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Puja</p>
                                        <h5 class="my-1 text-secondary">{{ App\Models\Product::get()->count() }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                            class='bx bxs-cart'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('e_puja.index') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total E-Puja</p>
                                        <h5 class="my-1 text-secondary">
                                            {{ App\Models\Product::where('product_type', 'one_day')->get()->count() }}</h5>
                                        {{-- <h4 class="my-1 text-info">{{ App\Models\Pujari::get()->count() }}</h4> --}}
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                            class='bx bx-cog'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('admin.terth_city') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Teerth Puja</p>
                                        <h5 class="my-1 text-secondary">
                                            {{ App\Models\Product::where('product_type', 'temple')->get()->count() }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                            class='bx bx-flag'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('admin_product.index') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total All Puja</p>
                                        <h5 class="my-1 text-secondary">
                                            {{ App\Models\Product::where('product_type', 'all')->get()->count() }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                        <i class='bx bx-cart-alt'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('admin.orders') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Orders</p>
                                        <h5 class="my-1 text-secondary">{{ App\Models\Order::get()->count() }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                            class='bx bxs-wallet'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Current Week Sale</p>
                                    <h5 class="my-1 text-secondary">₹ {{ $totalSalesWeekMonth }}</h5>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                        class='bx bxs-wallet'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Sales Amount</p>
                                    <h5 class="my-1 text-secondary">₹ {{ $totalSales }}</h5>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                        class='bx bxs-bar-chart-alt-2'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary"> This Month Sale</p>
                                    <h5 class="my-1 text-secondary">₹ {{ $totalSalesCurrentMonth }}</h5>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                        class='bx bx-bar-chart-square'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('e_puja.index') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Today Puja</p>
                                        <h5 class="my-1 text-secondary">{{ $today_puja }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                        <i class='bx bxs-calendar-plus'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('pujari_list') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Pujaris</p>
                                        <h5 class="my-1 text-secondary">{{ App\Models\Pujari::get()->count() }}</h5>
                                        {{-- <h4 class="my-1 text-info">{{ App\Models\Pujari::get()->count() }}</h4> --}}
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                        <i class='bx bxs-user'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('enquiry.index') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Enquiries</p>
                                        <h5 class="my-1 text-secondary">{{ App\Models\Enquiry::get()->count() }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                        <i class='bx bx-message-dots'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <a href="{{ route('customer_list') }}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Customers</p>
                                        <h5 class="my-1 text-secondary">{{ App\Models\User::get()->count() }}</h5>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                            class='bx bxs-group'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!--end row-->
            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">E-Puja Sales Graph (Last 30 Days) – Amount</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                        style="color: #cb5911"></i>Sales</span>
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                        style="color: #ffc107"></i>Cutomer</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Customer Graph (Last 30 Days)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">

                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                        style="color: #ffc107"></i>Cutomer</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Sale Graph (Last 30 Days)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">

                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                        style="color: #cb5911"></i>Sale</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart4"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Convert Collection to an array using ->toArray()
        var month_name = {!! json_encode($last_thirty_days_amount->keys()->toArray()) !!};
        var amount = {!! json_encode($last_thirty_days_amount->values()->toArray()) !!};

        $(function() {
            "use strict";

            var ctx = document.getElementById("chart1").getContext('2d');

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#ffc107');
            gradientStroke1.addColorStop(1, '#cb5911');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: month_name, // Dates
                    datasets: [{
                        label: 'Amount',
                        data: amount,
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        borderRadius: 20,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.8,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script>
        // Convert Collection to an array using ->toArray()
        var month_name = {!! json_encode($last_thirty_days_puja_amount->keys()->toArray()) !!};
        var earnings = {!! json_encode($last_thirty_days_puja_amount->values()->toArray()) !!};

        $(function() {
            "use strict";

            var ctx = document.getElementById("chart2").getContext('2d');

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#ffc107');
            gradientStroke1.addColorStop(1, '#cb5911');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: month_name, // Dates
                    datasets: [{
                        label: 'Earnings',
                        data: earnings, // Total earnings per day
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        borderRadius: 20,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.8,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script>
        // Convert Collection to an array using ->toArray()
        var month_name = {!! json_encode($last_thirty_days_customer->keys()->toArray()) !!};
        var customer = {!! json_encode($last_thirty_days_customer->values()->toArray()) !!};

        $(function() {
            "use strict";

            var ctx = document.getElementById("chart3").getContext('2d');

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#ffc107');
            gradientStroke1.addColorStop(1, '#cb5911');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: month_name, // Dates
                    datasets: [{
                        label: 'Customer',
                        data: customer, // Total customer per day
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        borderRadius: 20,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.8,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script>
        // Convert Collection to an array using ->toArray()
        var month_name = {!! json_encode($last_thirty_days_sale->keys()->toArray()) !!};
        var sale = {!! json_encode($last_thirty_days_sale->values()->toArray()) !!};

        $(function() {
            "use strict";

            var ctx = document.getElementById("chart4").getContext('2d');

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#ffc107');
            gradientStroke1.addColorStop(1, '#cb5911');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: month_name, // Dates
                    datasets: [{
                        label: 'Sale',
                        data: sale, // Total sale per day
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        borderRadius: 20,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.8,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    {{-- <canvas id="chart1" width="400" height="200"></canvas>
    <canvas id="chart2" width="400" height="200"></canvas>
    <canvas id="chart3" width="400" height="200"></canvas>
    <canvas id="chart4" width="400" height="200"></canvas> --}}
@endsection
