@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row mt-3 mb-2">
                    <div class="col-md-12">
                        @php
                            if(!empty(App\Models\UserGbMonth::where('user_id',Auth::user()->id)->latest()->first()->gv)){
                              $total_gb_user =  App\Models\UserGbMonth::where('user_id',Auth::user()->id)->latest()->first();
                            }else{
                                $total_gb_user=[];
                            }
                            $total_income=0;
                        @endphp
                        <div class="row user-info">
                            <div class="col-sm-12">
                                <div class="card widget-flat slide-right">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <table class="table table-striped table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <tr>
                                                    <th scope="col">User ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Percentage</th>
                                                    <th scope="col">Previous Income</th>
                                                    <th scope="col">Royality Income</th>
                                                </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{Auth::user()->referral_code}}</td>
                                                <td>{{Auth::user()->name}}</td>
                                                <td>@if(!empty($total_gb_user->gv)){{findRange($total_gb_user->gv)}}@endif</td>
                                                <td>@if(!empty($total_gb_user->gv) && (!empty($user_pp_histroy)))
                                                    {{round($total_gb_user->amount_transfer,2)}}

                                                    @endif
                                                </td>
                                                <td>@if(!empty(App\Models\UserWallet::where('user_id', Auth::user()->id)->where('transaction_detail','LIKE', '%Royality income%')->latest()->first()->amount))
                                                    {{round(App\Models\UserWallet::where('user_id', Auth::user()->id)->where('transaction_detail','LIKE', '%Royality income%')->latest()->first()->amount,2);}}
                                                    @endif
                                                  </td>
                                            </tr>

                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <h4 class="page-title">Transaction</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th scope="col">Sr No</th>
                                                <th scope="col">User ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Percentage</th>
                                                <th scope="col">Leg Wise Income</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($user_list as $key=>$list)
                                        @php

                                         $total_gb = !empty(App\Models\UserGbMonth::where('user_id',$list->id)->whereBetween('created_at', [$firstDayLastMonthg, $lastDayLastMonthg])->sum('gv')) ? App\Models\UserGbMonth::where('user_id',$list->id)->whereBetween('created_at', [$firstDayLastMonthg, $lastDayLastMonthg])->sum('gv') : [] ;
                                        @endphp
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$list->referral_code}}</td>
                                            <td>{{$list->name}}</td>
                                            <td>  @if(!empty($total_gb)){{findRange($total_gb)}}@endif</td>
                                            <td>
                                                @if(!empty($total_gb) && !empty($total_gb_user->gv))
                                                @php $total_a=($total_gb*25)*((findRange($total_gb_user->gv)-findRange($total_gb)))/100; @endphp
                                                {{$total_a}}
                                                @php $total_income=$total_income+$total_a; @endphp
                                                @else
                                                0
                                                @endif
                                            </td>
                                        </tr>
                                        @php  @endphp
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
                                <div class="d-flex justify-content-center mt-3">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <h4 class="page-title"></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-centered mb-0">
                                    @php $all_total_income=0; @endphp
                                    <thead>
                                        <tr>
                                            <th scope="col">Total Leg Income</th>
                                            <th scope="col">{{round($total_income,2)}}</th>
                                        </tr>
                                            <tr>
                                                <th scope="col">Self PP Income</th>
                                                <th scope="col">@if(!empty($total_gb_user->gv)){{$user_pp_histroy*25*findRange($total_gb_user->gv)/100}}   @php $all_total_income=$all_total_income+($user_pp_histroy*25*findRange($total_gb_user->gv)/100); @endphp @endif</th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Royality Income</th>
                                                <th scope="col">@if(!empty(App\Models\UserWallet::where('user_id', Auth::user()->id)->where('transaction_detail','LIKE', '%Royality income%')->latest()->first()->amount))
                                                    {{round(App\Models\UserWallet::where('user_id', Auth::user()->id)->where('transaction_detail','LIKE', '%Royality income%')->latest()->first()->amount,2);}}
                                                    @php $all_total_income=$all_total_income+round(App\Models\UserWallet::where('user_id', Auth::user()->id)->where('transaction_detail','LIKE', '%Royality income%')->latest()->first()->amount,2); @endphp
                                                    @else
                                                    0
                                                    @endif
                                                  </th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Total Income</th>
                                                <th scope="col">{{round($all_total_income+$total_income,2)}}</th>
                                            </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
