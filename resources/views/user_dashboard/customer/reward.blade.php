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
                                        <h4 class="page-title">Reward</h4>
                                    </div>
                                    <div class="col-md-3 col-3">
                                        <div class="float-end">
                                            @if(Auth::user()->pp > 1)
                                            Total GP :{{Auth::user()->total_gv}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Reward</th>
                                            <th scope="col">Total GP</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($rewards as $key=>$reward)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $reward->reward }}</td>
                                                <td>{{ $reward->total_gp }}</td>
                                                <td>
                                                    @if(Auth::user()->pp > 1)
                                                   @if($reward->id==$selected_reward)
                                                     <p style="color:green;">{{'Active'}}</p>
                                                     <form method="post" action="{{route('acheive_reward')}}">
                                                        @csrf
                                                        <input type="hidden" name="reward_id" value="{{ $reward->id }}" />
                                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary">Get Reward</button>
                                                     </form>
                                                   @else
                                                    <p style="color:red;">{{'InActive'}}</p>
                                                   @endif
                                                   @endif
                                                </td>
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
                                <br>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-9 col-9">
                                            <h4 class="page-title">Achive Reward</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <table class="table table-striped table-centered mb-0">
                                        <thead>
                                            <tr>
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Reward</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($achive_reward as $key=>$a_reward)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $a_reward->rewardData->reward }}</td>
                                                    <td>{{ $a_reward->date }}</td>
                                                    <td>
                                                       <p style="color:green;">{{'Achived'}}</p>
                                                    </td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
