@extends('user_dashboard.layouts.app')
@section('content')
<style>
@media (max-width:767.98px) {
    .rbt-tutor-information {
    display:block;
    text-align: center;
}
.rbt-tutor-information .rbt-tutor-information-left {
    display: inline-grid;
    text-align: left;
}
}
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
    <div class="content-page">
        <h4 class="welcome__usrs mb-3">Welcome  {{Auth::user()->name}}</h4>
        <div class="content">
            <div class="container-fluid">
               <div class="user-bg"></div>
                <div class="row">
                   <div class="col-md-10 container justify-content-center">
                     <div class="user-box">
                          <div class="ribbon"><span></span></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="rbt-tutor-information">
                                    <div class="rbt-tutor-information-left">
                                        <div class="thumbnail rbt-avatars size-lg">
                                            <img src="" onerror="this.onerror=null;this.src='{{asset('backend/img/no-image.png')}}'" class="rounded-circle shadow-sm">
                                        </div>
                                        <div class="tutor-content mb-2">
                                            <h5 class="title">{{Auth::user()->name}}</h5>
                                            <p class="text-white"><i class="uil-phone"></i> <span>{{Auth::user()->phone}}</span></p>
                                            <p class="text-white"><i class="uil-envelope"></i> <span>{{Auth::user()->email}}</span></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                     </div>
                   </div>
                </div>

                <div class="row mt-3 mb-2">
                    <div class="col-md-12">
                        <div class="row user-info">
                            <div class="col-sm-3">
                                <div class="card widget-flat gradient-45deg-red-pink slide-left">
                                    <div class="card-body">
                                        <img src="{{ asset('user_dashboard/images/circle.svg') }}" alt="Wallet Balance">
                                        <h3> <span class="counter-value text-white">{{App\Models\Order::where('user_id',Auth::user()->id)->get()->count()}}</span></h3>
                                        <h5 class="text-white" title="Number of Customers">Total Puja</h5>
                                        <div class="progress"><div class="progress-bar" style="width: 70%"></div></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card widget-flat gradient-45deg-red-pink slide-left">
                                    <div class="card-body">
                                        <img src="{{ asset('user_dashboard/images/circle.svg') }}" alt="Wallet Balance">
                                        <h3> <span class="counter-value text-white">{{App\Models\OneDayOrder::where('user_id',Auth::user()->id)->get()->count()}}</span></h3>
                                        <h5 class="text-white" title="Number of Customers">Total E-Puja</h5>
                                        <div class="progress"><div class="progress-bar" style="width: 70%"></div></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
