@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Product Enquiries</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Pooja</th>
                                        <th>Type</th>
                                        <th>Package</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $data)

                                    <tr>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->phone}}</td>
                                        <td>{{$data->product->name}}</td>
                                        <td>@if($data->product->product_type=='one_day') E-puja @else {{$data->product->product_type}} @endif</td>
                                        <td>{{optional($data->package)->package_name}}</td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$list->links()}}
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
    <script>

    </script>
@endsection
