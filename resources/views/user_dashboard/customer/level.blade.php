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
                                    <div class="col-md-12 col-12">
                                        <h4 class="page-title">Direct Team</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th scope="col">Level No</th>
                                                <th scope="col">Income</th>
                                                <th scope="col">Total Team</th>
                                                <th scope="col">My Income</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($levels as $key=>$level)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$level}}</td>
                                            <td>{{App\Models\Comission::where('user_id',Auth::user()->id)->where('level',$key+1)->get()->count()}}</td>
                                            <td>{{App\Models\Comission::where('user_id',Auth::user()->id)->where('level',$key+1)->get()->sum('commission')}}</td>
                                            <td><a href="{{route('customer.level_team_member',$key+1)}}">View</a></td>
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
