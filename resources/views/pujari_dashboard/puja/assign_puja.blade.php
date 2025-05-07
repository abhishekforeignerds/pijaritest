@extends('pujari_dashboard.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Puja List</h6>
                        </div>
                        {{-- <div class="ms-auto"><a href="{{route('pujari_create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Pujari</a></div> --}}
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
                                    <select class="form-select" aria-label="Payment Status" name="payment_status"  id="payment_status_{{$puja->id}}" onchange="update_payment_status('{{$puja->id}}')" >
                                    <option>Select Payment Status</option>
                                    <option value="accepted" @if($puja->pujari_status=='accepted') selected @endif>Accepted</option>
                                    <option value="completed" @if($puja->pujari_status=='completed') selected @endif >Completed</option>
                                    <option value="decline"  @if($puja->pujari_status=='decline') selected @endif>Decline</option>
                                </select>
                            </td>
                                  <td>


                                    <div class="d-flex order-actions">

                                        <a href="{{route('pujari.assign_puja_show',$puja->id)}}" class="" title="Show"><i class="bx bxs-show"></i></a>

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
    <script>

        function update_payment_status(id){
            var status = $('#payment_status_'+id).val();
            $.post('{{route("payment_status_update")}}', {
                    _token: '{{ csrf_token() }}',
                    order_id: id,
                    status: status
                }, function(data) {
                    alert('Status Updated Sucessfully');
                });

        }

    </script>
@endsection
