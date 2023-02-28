<div class="table-responsive">
    <table id="example" class="display table table-info" style="width: 100%;">
        <thead>
        <tr>
            <th>Month</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Reason</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td> {{ $transaction->month }} </td>
                <td> {{ $transaction->transaction_type }} </td>
                <td> {{ $transaction->amount }} </td>
                <td> {{ $transaction->reason }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
