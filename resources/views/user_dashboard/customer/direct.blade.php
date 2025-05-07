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
                                                <th scope="col">S.No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Referral ID</th>
                                                <th scope="col">Join Date</th>
                                                <th scope="col">Active Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($directs as $key=>$direct)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$direct->name}}</td>
                                            <td>{{$direct->referral_code}}</td>
                                            <td>{{ $direct->created_at->format('d-M-Y h:i A') }}</td>
                                            <td>{{$direct->active_date ? $direct->active_date :'-'}}</td>
                                            <td>@if($direct->status==1)<p style="color:green;">{{'Active'}}</p>@else<p style="color:red;">{{'InActive'}}</p>@endif</td>
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
