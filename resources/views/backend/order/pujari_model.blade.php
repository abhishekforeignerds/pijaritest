<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div>
                        <div class="table-responsive">
                            <table class="table table-centered border mb-0 table">
                                <thead class="bg-light">
                                    <tr>
                                        <th colspan="2">Order Detail Summary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Total :</th>
                                        <td>₹{{ $order_detail->price }}</td>
                                    </tr>
                                    @php  $total_inclusion=0;  @endphp
                                    @if(!empty($order_detail->inclusion_price))
                                    <tr>
                                        <th scope="row">Total Inclusion:</th>
                                        <td>@foreach(json_decode($order_detail->inclusion_price) as $price)
                                            @php $total_inclusion=$total_inclusion+$price; @endphp
                                             +₹{{$price}}
                                             @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">Grand Total :</th>
                                        <td>₹{{$order_detail->price + $total_inclusion }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pandit Ji Comission :</th>
                                        <td><input type="number" name="comission" id="comission" onchange="company_amount()" ></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Company Amount :</th>
                                        <td><input type="number" id="company_amount" name="company_amount" id="company_amount" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" onclick="pujari_comission('{{$pujari_ji_id}}','{{$order_detail->id}}')">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
