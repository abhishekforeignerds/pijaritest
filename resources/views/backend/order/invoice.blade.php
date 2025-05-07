<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Invoice | DailyPooja Mala</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- External CSS libraries -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="https://pujariji.com/backend/images/app_setup/1733115218283.png" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('invoice_css/css/style.css')}}">

</head>
<body>

<!-- Invoice 5 start -->
<div class="invoice-5 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix" >
                    <div class="invoice-info clearfix" id="invoice_wrapper" style="border: 1px solid #eee;">
                        <div class="invoice-contant">
                            <div class="invoice-headar">
                                <div class="row">
                                    <div class="col-md-8 col-sm-7">
                                        <div class="invoice-logo">
                                            <!-- logo started -->
                                            <div class="logo">
                                                <img src="https://pujariji.com/backend/images/app_setup/1733115218283.png" alt="logo">
                                            </div>
                                            <!-- logo ended -->
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-5">
                                        <div class="invoice-number-inner">
                                            <h2 class="name">Invoice No: # {{$order->code}}</h2>
                                            <p class="mb-0">Invoice Date: <span>  {{ $order->created_at->format('d-M-Y h:i A') }}</span></p>
                                            @if(!empty(appSetupValue('gst_no')))<p class="mb-0">GST No: <span>  {{ appSetupValue('gst_no') }}</span></p> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-md-8 col-sm-7 mb-30">
                                        <div class="invoice-number">
                                            <h4 class="inv-title-1">Bill From</h4>
                                            <h2 class="name mb-10">Pujari Ji</h2>
                                            <p class="invo-addr-1 mb-0">
                                               {{appSetupValue('address')}} <br/>
                                                +91-{{appSetupValue('contact_number')}}<br/>
                                                https://pujariji.com<br/>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-5 mb-30">
                                        <div class="invoice-number">
                                            <div class="invoice-number-inner">
                                                <h4 class="inv-title-1">Invoice For</h4>
                                                <h2 class="name mb-10">{{$order->user->name}}</h2>
                                                <p class="invo-addr-1 mb-0">
                                                    {{ json_decode($order->shipping_address)->address }} -
                                                    {{ json_decode($order->shipping_address)->pincode }} <br>
                                                    {{ json_decode($order->shipping_address)->city }} ,
                                                    {{ json_decode($order->shipping_address)->state }}<br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-center">
                                <div class="order-summary">
                                    <div class="">
                                        <table class="default-table invoice-table">
                                            <thead>
                                            <tr>

                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Inclusion</th>
                                                <th>Puja Info</th>
                                                <th>Assign Pujari</th>
                                                <th>Pujari Status</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($order->order_detail as $order_detail)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3"><img
                                                                    src="{{$order_detail->product_image}}"
                                                                    alt="" style="height: 56px;"></div>
                                                            <div class="flex-1">
                                                                <h6 class="m-0">{{$order_detail->product_name}}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>₹{{ $order_detail->price }}</td>
                                                    @if(!empty($order_detail->inclusion_price))

                                                    <td>  @foreach(json_decode($order_detail->inclusion_price) as $price) +₹{{$price}}  @endforeach</td>
                                                    @endif
                                                    <td>
                                                     Puja Date : {{$order_detail->date}}<br>
                                                     Puja Time :   {{$order_detail->time}}<br>
                                                     Location  : {{$order_detail->location}}<br>
                                                    </td>
                                                    <td>
                                                        @php $pujari_ji=App\Models\Pujari::find($order_detail->pujari_id); @endphp
                                                        @if(!empty($pujari_ji->name))
                                                         {{App\Models\Pujari::find($order_detail->pujari_id)->name}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                       @if(!empty($order_detail->pujari_status)) {{$order_detail->pujari_status}} @else Pending @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                                                <td><strong>₹  {{$order->grand_total}}</strong></td>
                                            </tr>
                                            @if($order->wallet_discount > 0)
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Wallet Dis.</strong></td>
                                                <td><strong>₹  {{$order->wallet_discount}}</strong></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Grand Total</strong></td>
                                                <td><strong>₹ {{$order->grand_total - $order->wallet_discount}}</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                             Print Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 5 end -->
</body>
</html>
