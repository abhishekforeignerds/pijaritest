@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card mt-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <h4 class="page-title">Level Income</h4>
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
                                                <th scope="col">Date</th>
                                                <th scope="col">Income Type</th>
                                                <th scope="col">Referral ID</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($levels as $key=>$level)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$level->created_at->format('d-M-Y h:i A')}}</td>
                                            <td>Level {{$level->level}}</td>
                                            <td>{{App\Models\User::find($level->referral_user_id)->referral_code}}</td>
                                            <td>{{$level->commission}}</td>
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
