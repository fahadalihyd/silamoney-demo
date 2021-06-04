@extends('layouts.app')
@section('content')   

<div class="row justify-content-center">
     <div class="col-md-8">
        <h3 class="text-center">Transactions of {{ $user->handel }}</h3>
        <table class="table table-light">
            <tbody>
                <tr>
                    <th>Transaction ID</th>
                    <th>Transaction Type</th>
                    <th>Destination Handel</th>
                    <th>Sila Amount</th>
                    <th>Bank Account Name</th>
                    <th>Status</th>
                </tr>
                @if (!empty($transactions))
                    @foreach ($transactions->transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transactionId }}</td>
                            <td>{{ $transaction->transactionType }}</td>
                            <td>{{ $transaction->destinationHandle ?? "N/A" }}</td>
                            <td>{{ $transaction->silaAmount ?? "" }}</td>
                            <td>{{ $transaction->bankAccountName ??""  }}</td>
                            <td>{{ $transaction->status  }}</td>
                        </tr>  
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection