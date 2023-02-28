
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
 
?>

@extends('layouts.master')
@section('title','Mpesa Receipts Reports')
@section('content')
 

    <div class=" divider">
    </div>
<?php 
          // $receiptsA = Payment::with('lease');

          $receipts =MpesaTransaction::get();

 ?>
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
            $receipt_tenant = Tenant::where( 'phone_number', $receipt->MSISDN )->first();
            $receipt_served = 'Self Served - Mpesa';
           
            ?>
                <tr>
                    <td width="10%">{{$receipt->id}}</td>
                    <td>{{$receipt->transaction_type}}</td>
                    @if(!empty($receipt_tenant))
                    <td>{{$receipt_tenant->name}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{$receipt_served}}</td>
                    <td>{{$receipt->trans_id}}</td>
                    <td>{{$receipt->created_at}}</td>
                    <td><a href="{{route('one.mpesa_receipt',$receipt->id)}}"><i class="fa fa-eye"></i>..</a></td>
                    
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
