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
                                                    <th scope="col">Designation</th>
                                                    <th scope="col">Level Percentage</th>
                                                    <th scope="col">Previous Commission</th>
                                                    <th scope="col">Previous GP</th>
                                                    <th scope="col">Previous PP</th>
                                                    <th scope="col">Current PP</th>
                                                    <th scope="col">Current GP</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{Auth::user()->referral_code}}</td>
                                                <td>{{Auth::user()->name}}</td>
                                                <td>{{Auth::user()->designation}}</td>
                                                <td>@if(!empty($total_gb_user->gv)){{findRange($total_gb_user->gv)}}@endif</td>
                                                <td>@if(!empty($total_gb_user->gv)){{round($total_gb_user->amount_transfer,2)}}@endif</td>
                                                <td>{{$total_gb_last_month}}</td>
                                                <td>{{$user_total_pp_last_month}}</td>
                                                <td>{{Auth::user()->pp}}</td>
                                                <td>{{Auth::user()->gb}}</td>
                                                <td>{{Auth::user()->gb+Auth::user()->pp}}</td>
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
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th scope="col">User ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Designation</th>
                                                <th scope="col">Level Percentage</th>
                                                <th scope="col">Previous Commission Amount</th>
                                                <th scope="col">Previous GP</th>
                                                <th scope="col">Current PP</th>
                                                <th scope="col">Current GP</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($user_list as $list)
                                        @php

                                         $total_gb = !empty(App\Models\UserGbMonth::where('user_id',$list->id)->latest()->first()->gv) ? App\Models\UserGbMonth::where('user_id',$list->id)->latest()->first() : [] ;
                                         $total_gb_last_month_current_user = App\Models\UserGbMonth::where('user_id',$list->id)->whereBetween('created_at', [$firstDayLastMonthg, $lastDayLastMonthg])->sum('gv');

                                        @endphp
                                        <tr>
                                            <td>{{$list->referral_code}}</td>
                                            <td>{{$list->name}}</td>
                                            <td>{{$list->designation}}</td>
                                            <td>@if(!empty($total_gb)){{findRange($total_gb->gv)}}@endif</td>
                                            <td>@if(!empty($total_gb)){{round($total_gb->amount_transfer,2)}}@endif</td>
                                            <td>{{$total_gb_last_month_current_user}}</td>
                                            <td>{{$list->pp}}</td>
                                            <td>{{$list->gb}}</td>
                                            <td>{{$list->gb+$list->pp}}</td>
                                            <td><div class="float-end">
                                                <a class="rbt-btn btn-md" href="{{route('customer.gv_histroy',$list->id)}}">View</a>
                                            </div></td>
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
