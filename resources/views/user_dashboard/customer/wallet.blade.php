@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <h4 class="page-title">Wallet Transaction</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Transaction Type</th>
                                                <th scope="col">Details</th>
                                                <th scope="col">Balance</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($wallet_transactions as $transaction_history)
                                        <tr>
                                            <td><span>{{ $transaction_history->created_at->format('d-M-Y h:i A') }}</span>
                                            </td>
                                            <td><span>{{ $transaction_history->amount }}</span></td>
                                            <td><span>{{ ucFirst($transaction_history->transaction_type) }}</span>
                                            </td>
                                            <td><span>{{ $transaction_history->transaction_detail }}</span></td>
                                            <td> <span>{{ $transaction_history->balance }}</span></td>
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
