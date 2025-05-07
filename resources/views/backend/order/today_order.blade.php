@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Today's Order List</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 mb-3">
                            <input id="search" class="form-control" type="text" placeholder="Search..">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:99%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">ORDER CODE</th>
                                    <th scope="col" class="text-center">CUSTOMER</th>
                                    <th scope="col" class="text-center">PRODUCT NAME</th>
                                    <th scope="col" class="text-center">QUANTITY</th>
                                    <th scope="col" class="text-center">AMOUNT</th>
                                    <th scope="col" class="text-center">DELIVER BY</th>
                                    <th scope="col" class="text-center">DATE</th>
                                    <th scope="col" class="text-center">STATUS</th>
                                    @if(auth()->guard('admin')->user()->canany(['order-view']))  <th scope="col" class="text-center">ACTION</th> @endif
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @forelse ($today_order as $order)
                                <tr>
                                    <td class="text-center">{{  $order->order_detail->order->code }}</td>
                                    <td class="text-center">{{  $order->order_detail->order->user->name }}</td>
                                    <td class="text-center">{{  $order->order_detail->product_name }}</td>
                                    <td class="text-center">{{ $order->quantity }}</td>
                                    <td class="text-center">₹{{ $order->order_detail->price*$order->quantity }}</td>
                                    <td>
                                         <select class="form-select" name="delivery_boy_id" id="delivery_boy_id_{{$order->id}}">
                                                        <option value="">Select  Delivery Person</option>
                                                        @foreach ($delivery_boy as $person)
                                                        <option value="{{$person->id}}"
                                                            @if ($order->delivery_boy_id == $person->id) selected @endif>{{$person->name}}
                                                        </option>
                                                        @endforeach
                                         </select>
                                    </td>
                                    <td class="text-center">{{ $order->date }}</td>
                                    <td class="text-center">
                                        <select class="form-select" name="status" id="status_{{$order->id}}">
                                            <option value="">Select Status</option>
                                            <option value="confirmed"
                                                @if ($order->status == 'confirmed') {{ 'selected' }} @endif>Confirmed
                                            </option>
                                            <option value="shipped"
                                                @if ($order->status == 'shipped') {{ 'selected' }} @endif>Shipped
                                            </option>
                                            <option value="delivered"
                                                @if ($order->status == 'delivered') {{ 'selected' }} @endif>Delivered
                                            </option>
                                            <option value="cancelled"
                                                @if ($order->status == 'cancelled') {{ 'selected' }} @endif>Cancelled
                                            </option>
                                        </select>
                                    </td>
                                    <td>

                                            <button class="mybtn" onclick="update_status('{{$order->id}}')" title="Save">
                                                <i class="bx bxs-save"></i>
                                            </button>

                                    </td>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#search").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
    </script>

<script>
    function update_status(id) {
        var status = $('#status_'+id).val();
        var delivery_boy_id=$('#delivery_boy_id_'+id).val();

        if(status && delivery_boy_id){
            $.post('{{route("status.update")}}', {
                _token: '{{ csrf_token() }}',
                order_subscrition_id: id,
                delivery_boy_id:delivery_boy_id,
                status: status
            }, function(data) {
                alert('Status Updated Sucessfully');
            });
       }else{
        alert('Please Select Both Status And Delivery Boy');
       }
    }
</script>
@endsection
