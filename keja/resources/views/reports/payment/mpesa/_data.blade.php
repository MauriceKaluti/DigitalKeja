<div class="table-responsive">

    <table class="table display table-striped" id="example" >
        <thead>
        <tr>
            <th>Tran Code</th>
            <th>Amount</th>
            <th>Reference Code</th>
            <th>Client By</th>
            <th>Date & Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->trans_id }}</td>
                <td>{{ number_format(floatval($payment->trans_amount ) , 2) }}</td>
                <td>{{ $payment->bill_ref_number }}</td>
                <td>{{ $payment->full_name }}</td>
                <td>{{ $payment->created_at }}</td>
            </tr>

        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <td>Total</td>
            <td>{{ number_format($payments->sum('trans_amount') , 2) }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>
