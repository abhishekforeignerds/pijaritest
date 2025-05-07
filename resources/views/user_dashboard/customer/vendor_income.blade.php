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
                                            <h4 class="page-title">Vendor Income</h4>
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
                                                <th scope="col">Vendor Name</th>
                                                <th scope="col">Vendor Code</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($datas as $key=>$data)
                                        @php  $vendor=App\Models\Vendor::where('id',$data->vendor_id)->first(); @endphp
                                        @if($vendor->status==1)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$vendor->name}}</td>
                                            <td>{{$vendor->vendor_code}}</td>
                                            <td>200</td>
                                        </tr>
                                        @endif
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
