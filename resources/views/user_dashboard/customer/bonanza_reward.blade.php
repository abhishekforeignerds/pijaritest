@extends('user_dashboard.layouts.app')
@section('content')

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-9 col-9">
                                        <h4 class="page-title">Bonanza Reward</h4>
                                    </div>
                                    <div class="col-md-3 col-3">
                                        <div class="float-end">
                                         Direct:{{$direct}},
                                         Team:{{getTotalTeamCount(Auth::user()->id)-count(App\Models\User::where('referral_by',Auth::user()->referral_code)->where('status',1)->get())+$direct}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>NOTE: THE LAST DATE FOR RECEVING THIS BONANZA GIFT IS 31 DEC,2024</p>
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Reward</th>
                                            <th scope="col">Direct</th>
                                            <th scope="col">Team</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($bonanza_reward as $key=>$reward)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $reward->reward }}</td>
                                                <td>{{ $reward->direct }}</td>
                                                <td>{{ $reward->team }}</td>
                                                <td>@if($reward->id==$selected_reward)<p style="color:green;">{{'Active'}}</p>@else<p style="color:red;">{{'InActive'}}</p>@endif</td>
                                            </tr>
                                        @empty
                                            <tr class="footable-empty">
                                                <td colspan="11">
                                                    <center style="padding: 70px;"><i class="far fa-frown"
                                                            style="font-size: 100px;"></i><br>
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
