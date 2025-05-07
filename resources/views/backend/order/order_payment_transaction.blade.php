@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Order Payment Transaction</h6>
                        <br>
                        <p>Grand Total:{{$order->grand_total}}</p>
                        <p>Total Paid:{{$order->total_paid}}</p>
                        <p>Total Pending:{{$order->grand_total-$order->total_paid}}</p>
                    </div>
                    <div class="ms-auto">
                        <a href="#" onclick="payment_modal()" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add Payment</a></div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ORDER CODE</th>
                                <th scope="col">CUSTOMER</th>
                                <th scope="col">DATE</th>
                                <th scope="col">AMOUNT</th>
                                <th scope="col">PAYMENT DETAILS</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @forelse ($order_payment_transaction as $payment)
                            <tr>
                                <td>{{$order->code}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{$payment->created_at}}</td>
                                <td>{{$payment->amount}}</td>
                                <td>{{$payment->transaction_type}}</td>
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
<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
            </div>

                <form class="" action="{{route('order_payment_add')}}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}" />
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Amount <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control mb-3" name="amount" id="amount" min="1" max="{{$order->grand_total-$order->total_paid}}" placeholder="Amount"  required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-primary">Add</button>
                        </div>
                    </div>
                </form>


        </div>
    </div>
</div>


@endsection
@section('script')
<script>
    function payment_modal(){
        $('#payment_modal').modal('show');
    }
</script>
@endsection
