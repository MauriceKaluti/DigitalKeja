
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
use App\BuildingExpense;
 
use App\DB\Building\Building;
 
?>

@extends('layouts.master')
@section('title','Tenant Single Payment History & Report')
@section('content')
 
@include('layouts.toastr')


<div class=" divider">
</div>
<?php 
// $payoutMonth = $tenant->created_at->format('m/Y');
$payoutMonth = 'All Time';
 ?>
 

<div id="printingDiv" class="container">
  <div class="card">
<div class="card-header">

<br><br>
  <span class="float-right"> <strong></strong> <span style="background-color: green;" class="badge badge-primary">Payout ID <strong>FRPY-{{$tenant->id}}</strong> </span></span>
  <br><br>
  <span class="float-right"> <strong></strong> <span style="background-color: #FF9800;" class="badge badge-primary">Payment Report For {{$tenant->name}} | Period: {{$payoutMonth}}</span></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h6 class="mb-3">From:</h6>
<div>
<strong>Accounts MD</strong>
</div>
<div>Franro Holdings</div>
<div>00100, Nairobi</div>
<div>Email: info@franroholdings.com</div>
<div>Phone: +254 722 362 432</div>
</div>

<div class="col-sm-6">
<h6 class="mb-3">To:</h6>
<div>
<strong>Tenant</strong>
</div>
<div>Name: {{$tenant->name}}</div>
<div>ID No: {{$tenant->id_no}}</div>
<div>Email: {{$tenant->email}}</div>
<div>Phone: {{$tenant->phone_number}}</div>
</div>



</div>
 


<div class="container table-responsive-sm">
    <!-- <h3>Other Payments Made This Month</h3> -->

    <h3><span class="float-right"> <strong></strong> <span style="background-color: #708090;" class="badge badge-primary">Payment Breakdown Report For {{$tenant->name}} | MPESA</span></span></h3>
<table style="width: 100%;" class="table table-striped">
<thead>
<tr>
<!-- <th>#</th> -->
<!-- <th>Tenant</th> -->
<th>Mpesa ID</th>
<th>Phone</th>
<th>Transaction</th>
<th>Amount</th>
<th>Created At</th>
</tr>
</thead>
<tbody>
<?php 
 $mpesa_payments = MpesaTransaction::where( 'MSISDN', $tenant->phone_number )->get();

 ?>
 @foreach($mpesa_payments as $mpesa_payment)
<tr>
 
  <td style="color: orange; font-weight: bold;">{{$mpesa_payment->trans_id}}</td>
  <td style="color: silver; font-weight: bold;">{{$mpesa_payment->MSISDN}}</td> 
  <td style="color: silver; font-weight: bold;">{{$mpesa_payment->transaction_type}}</td> 
  <td style="color: silver; font-weight: bold;">{{$mpesa_payment->trans_amount}}</td> 
  <td style="color: silver; font-weight: bold;">{{$mpesa_payment->created_at}}</td> 



 


@endforeach

 

 </tr>
</tbody>
</table>
</div>    
<div class="row">
<div class="col-lg-4 col-sm-5">

</div>

<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear">
<tbody>
<tr>
<td class="left">
<strong>Subtotal Payout</strong>
</td>
<td class="right">Ksh. 0</td>
</tr>
<tr>
<td class="left">
<strong>Deductions</strong>
</td>
<td class="right">Ksh 0</td>
</tr>
 
<tr>
<td class="left">
<strong>Total Payout(Monthly)</strong>
</td>
<td class="right">
<strong>Ksh. 0</strong>
</td>
</tr>
</tbody>
</table>

</div>

</div>

</div>
</div>
</div>

<div id="editor"></div>
<p align="center"><button type="button" id="dwnld_btn" onclick="generatePDF()" class="btn btn-warning"><i class="fa fa-download"></i> Download {{$tenant->name}} Payment Report</button></p>

<p align="center"><button type="button" id="print_btn" onclick="printpage()" class="btn btn-success"><i class="fa fa-print"></i> Print {{$tenant->name}} Payment Report</button></p>


<!-- Disburse Modal -->
<p align="center">
<button id="disburse_btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
  Update {{$tenant->name}} Phone Number
</button>
</p>

<p align="center">

  <button style="border-color: transparent;" type="button" >
                                <span  class="badge badge-primary">Currently Leased</span> 

                                  @if(isset($tenant->lease))
                                <?php 

                                $lease = Lease::where( 'tenant_id', $tenant->id )->first();

                                 ?>

                              
        
                                <form action="{{route('unLease',$lease->tenant_id)}}" method="POST">
                                        {{csrf_field()}}
                                         
                                         <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i> Unlease {{$tenant->name}}</button>
                                    </form>

                              

                                @else

                                 <span style="background-color: #00ff77;" class="badge badge-primary">Not Leased</span> 

        @endif
  </button>
  
     

</p>
 
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="disModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
              <form
        method="PATCH"
        autocomplete="off"
        action="{{ route('edit.tenant', $tenant->id) }}"
        autocapitalize="off"
        class="form-horizontal">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disModal">Update {{$tenant->name}} Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  


        <div class="form-group">
            <label for="tenant_phone_number" class="control-label col-md-2">Phone Update</label>
            <div class="col-md-4">
                  <input
                    type="text"
                    name="phone_number"
                    class="form-control"
                    placeholder="{{$tenant->phone_number}}"
                    value="{{$tenant->phone_number}}"
                >
            </div>

                     <label for="gender" class="control-label col-md-2">Gender Update</label>
            <div class="col-md-4">
            

                <select name="gender"
                    class="form-control"
                   >
                   @if($tenant->gender)
                    <option value="{{$tenant->gender}}">{{$tenant->gender}}</option>
                    @else
                    <option>Select Gender</option>
                    @endif

                    @if($tenant->gender == 'Female')
                  <option value="Male">Male</option>
                  @elseif($tenant->gender == 'Male')
                  <option value="Female">Female</option>
                  @else
                  <option value="Male">Male</option>

                  <option value="Female">Female</option>
                  @endif
                </select>
            </div>
       
        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Tenant Info</button>
      </div>
    </div>
     </form>
  </div>
</div>

@endsection

@section('js')
    @include('layouts._form-scripts')

    @include('layouts._datepicker')
 

    <script type="text/javascript">
    function printpage() {
         var printButton = document.getElementById("printingDiv");
         // printButton.style.visibility = 'hidden';
                   $("#print_btn").hide();
                   $("#dwnld_btn").hide();
                   $("#disburse_btn").hide();

        document.title = "Receipt For Payment";
        document.URL   = "www.franroholdings.com";

        window.print();
        // printButton.style.visibility = 'hidden';
                   $("#print_btn").show();
                   $("#dwnld_btn").show();
                   $("#disburse_btn").show();


    }
</script>

    <script>
        $('input#date').datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: +1
        });
    </script>
@endsection
 
