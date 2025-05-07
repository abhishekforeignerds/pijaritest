<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            /* padding-bottom: 40px; */

        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .logo img {
    height: 30px;
    margin-top: 8px;
}
        .name {
    font-size: 18px;
    margin-bottom: 5px;
    font-weight: 500;
    text-transform: uppercase;
    color: #262525;
}
.mb-0 {
    margin-bottom: 0 !important;
}
p {
    margin-top: 0;
    margin-bottom: 1rem;
}
.invoice-headar {
    padding: 20px 0;
    border-bottom: solid 1px #ebeaea;
}
.inv-title-1 {
    color: #ff1f1f;
    font-weight: 400;
    margin-bottom: 5px;
}

.invo-addr-1 {
    font-size: 14px;
    margin-bottom: 20px;
    line-height: 23px;
}
.invoice-top {
    padding: 20px 0;
    border-bottom: solid 1px #ebeaea;
}
.order-summary {
    padding: 20px 0;
    border-bottom: solid 1px #ebeaea;
}
.table-outer {
    overflow-y: hidden;
    overflow-x: auto;
}
.default-table {
    position: relative;
    background: #ffffff;
    border: 0;
    border-radius: 5px;
    overflow: hidden;
    width: 100%;

}
.default-table thead {
    background: #F5F7FC;
    border-radius: 8px;
    color: #ffffff;
}
.default-table thead th {
    position: relative;
    padding: 5px 20px 10px;
    font-size: 15px;
    font-weight: 500;
    white-space: nowrap;
    color: #262525;
}
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top invoice-headar">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <div class="invoice-logo">
                                    <!-- logo started -->
                                    <div class="logo">
                                        <img src="https://dailypoojamala.in/backend/images/app_setup/1717669525172.png" alt="logo">
                                    </div>
                                    <!-- logo ended -->
                                </div>
                            </td>
                            <td>
                                <div class="invoice-number-inner">
                                    <h2 class="name">Invoice No: # {{$order->code}}</h2>
                                    <p class="mb-0">Invoice Date: <span>  {{ $order->created_at->format('d-M-Y h:i A') }}</span></p>
                                    <p class="mb-0">GST No: <span>  {{ appSetupValue('gst_no') }}</span></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information invoice-top">
                <td colspan="2" class="">
                    <table >
                        <tr>
                            <td>
                                <div class="invoice-number">
                                    <h4 class="inv-title-1">Bill From</h4>
                                    <h2 class="name mb-10">Daily Pooja Mala</h2>
                                    <p class="invo-addr-1 mb-0">
                                       {{appSetupValue('address')}} <br/>
                                        +91-{{appSetupValue('contact_number')}}<br/>
                                        https://dailypoojamala.in<br/>
                                    </p>
                                </div>
                            </td>
                            <td>
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
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <div class="invoice-center">
            <div class="order-summary">
                <div class="table-outer">
                    <table class="default-table invoice-table" style="border: solid 1px #f3f2f2;">
                        <thead>
                        <tr>
                            <th style="border: solid 1px #f3f2f2;">Image</th>
                            <th style="border: solid 1px #f3f2f2;">Item</th>
                            <th style="border: solid 1px #f3f2f2;">MRP</th>
                            <th style="border: solid 1px #f3f2f2;">Qty</th>
                            <th style="border: solid 1px #f3f2f2;">Amount</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->order_detail as $order_detail)
                            <tr>
                                <td style="border: solid 1px #f3f2f2;">
                                    <div class="me-3"><img src="{{$order_detail->product_image}}" style="height: 56px;" alt="Product Image"></div>
                                </td>
                                <td style="border: solid 1px #f3f2f2;">{{$order_detail->product_name}}</td>
                                <td style="border: solid 1px #f3f2f2;">{{ $order_detail->price }}</td>
                                @php $qty=App\Models\OrderSubscription::where('product_variant_id',$order_detail->variant_id)->where('order_detail_id',$order_detail->id)->get()->sum('quantity'); @endphp
                                <td style="border: solid 1px #f3f2f2;">{{ $qty }}</td>
                                <td style="border: solid 1px #f3f2f2;">{{ $order_detail->price * $qty }}</td>
                            </tr>
                            @endforeach
                        <tr>
                            <td colspan="4" style="text-align: right;" style="border: solid 1px #f3f2f2;"><strong>Total:</strong></td>
                            <td style="border: solid 1px #f3f2f2;"><strong>Rs  {{$order->grand_total}}</strong></td>
                        </tr>

                        <tr>
                            <td style="border: solid 1px #f3f2f2;" colspan="4" style="text-align: right;"><strong>Wallet Dis.</strong></td>
                            <td style="border: solid 1px #f3f2f2;"><strong>Rs  {{$order->wallet_discount}}</strong></td>
                        </tr>
                        <tr>
                            <td style="border: solid 1px #f3f2f2;" colspan="4" style="text-align: right;"><strong>Grand Total</strong></td>
                            <td style="border: solid 1px #f3f2f2;"><strong>Rs {{$order->grand_total - $order->wallet_discount}}</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="invoice-bottom">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="terms-conditions mb-30">
                        <h3 class="inv-title-1 mb-10">Terms & Conditions</h3>
                        <p>* Exchange and other policies are mentioned on the website.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="payment-method mb-30">


                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
