@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-3">
                            <h6 class="mb-0">View Pujari</h6>
                        </div>
                        <div class="col-lg-9">
                            @include('backend.pujari.pujari_nav')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0"  id="datatable" >
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Order Code</th>
                                    <th>Product Name</th>
                                    <th>Package Name</th>
                                    <th>City</th>
                                    <th>Language</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assign_puja as $key=>$puja)
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td>{{$puja->order->code}}</td>
                                  <td>{{$puja->product_name}}</td>
                                  <td>{{$puja->package_name}}</td>
                                  <td>{{$puja->city}}</td>
                                  <td>{{$puja->language}}</td>
                                  <td>{{$puja->date}} {{$puja->time}}</td>
                                  <td>
                                        {{$puja->pujari_status}}
                                  </td>
                                  <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{route('admin.order_show',$puja->id)}}" class="" title="Show"><i class="bx bxs-show"></i></a>
                                    </div>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')

@endsection
