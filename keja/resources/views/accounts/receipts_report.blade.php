
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
 
?>

@extends('layouts.master')
@section('title','Receipts Reports')
@section('content')
 

    <div class=" divider">
    </div>
 
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Tenant Name</th>
            <th>Served By</th>
            <th>Ref Code</th>            
            <th>Date & Time</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)

            <?php
            $receipt_tenant = Tenant::where( 'id', $receipt->tenant_id )->first();
            $receipt_served = User::where( 'id', $receipt->user_id )->first();
           
            ?>
                <tr>
                    <td width="10%">{{$receipt->id}}</td>
                    <td>{{$receipt->payment_method}}</td>
                    @if(!empty($receipt_tenant))
                    <td>{{$receipt_tenant->name}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{$receipt_served->name}}</td>
                    <td>{{$receipt->reference_code}}</td>
                    <td>{{$receipt->created_at}}</td>
                    @if(!empty($receipt_tenant))
                    
                    <td><a href="{{route('one.receipt',$receipt->id)}}"><i class="fa fa-print"></i> Print</a></td>
                     @else
                    <td></td>
                    @endif
                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
        <th>Id</th>
            <th>Title</th>
            <th>Tenant Name</th>
            <th>Served By</th>
            <th>Ref Code</th>            
            <th>Date & Time</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>

 





@endsection

@section('js')
    @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>
 
@endsection
