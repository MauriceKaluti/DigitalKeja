<div class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Month</th>
            <th>Amount</th>
            <th>Reference Code</th>
            <th>Payment Method</th>
            <th>Served By</th>
            <th>Tenant</th>
            <th>Building</th>
            <th>Receipt</th>
            <th>Date & Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments->groupBy('tenant_account_id') as $tenant =>  $paymentGrouped)

            @foreach($paymentGrouped as $payment)

                <tr>
                    <td width="10%">{{ $payment->created_at->format('Y-m') }}</td>
                    <td>{{ setting('company_currency' , 'shs') .' '. number_format(floatval(str_replace(',','', $payment->amount)) , 2) }}</td>
                    <td>{{ $payment->reference_code }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ $payment->user->name }}</td>
                    
                </tr>
                @endforeach



        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td> Total: </td>
            <td colspan="2">{{ setting('company_currency' , 'shs') .' '. number_format($payments->sum('amount') , 2) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>
