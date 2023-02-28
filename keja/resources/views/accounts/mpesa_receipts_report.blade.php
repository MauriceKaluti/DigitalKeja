<?php
   use App\DB\Payment\MpesaTransaction;
   use App\DB\Lease\Payment;
   use App\DB\Lease\Lease;
   use App\DB\Tenant;
   use App\User;
    
   ?>
@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title','Mpesa Receipts Reports')
@section('content')
<div class="container-fluid">
   <div class="table-responsive">
   <table class="table display" id="kejaDisplay" >
      <thead>
         <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Tenant Name</th>
            <th>Served By</th>
            <th>Ref Code</th>
            <th>Date & Time</th>
            <th>View</th>
            <th>Update</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($receipts as $receipt)
         <?php
            $mpesatenje = $receipt->MSISDN;
            
            // $mpesatenj = "+".$mpesatenje;
            
            $trim_phone = substr($mpesatenje, 3);
            
            $ten_phone = "0".$trim_phone;
            
            $receipt_tenant = Tenant::where( 'phone_number', $mpesatenje )->first();
            
            $mpesa_tenant = Tenant::where( 'phone_number', $ten_phone )->first();
            
            $receipt_served = 'Self Served - Mpesa';
            
            $tenje = $receipt->MSISDN;
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
            @if(empty($receipt_tenant))
            <td>
               <a >
                  <i class="fa fa-frown-o"></i> No Match  
            </td>
            @else
            <td><a href="{{route('one.mpesa_receipt',$receipt->id)}}"><i class="fa fa-eye"></i> View</a></td>
            @endif
            @if(!empty($mpesa_tenant))
            <td><a style="color: #ffc85b;" href="{{route('one.tenant',$mpesa_tenant->id)}}"><i class="fa fa-refresh"></i> Update  
            </td>
            @else
            <td style="color: green;"></td>
            @endif
            @if( empty($mpesa_tenant) && empty($receipt_tenant) )
            <td style="color: green;">Confirm</td>
            @else
            <td style="color: green;"></td>
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
            <th>View</th>
            <th>Update</th>
            <th>Action</th>
         </tr>
      </tfoot>
   </table>
</div>
</div>
@endsection
@section('js')
@include('layouts._datepicker')
<script>
   $('input.date').datepicker()
</script>
@endsection