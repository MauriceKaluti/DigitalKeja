
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
@section('title','Landlord Single Payout Breakdown & Reports')
@section('content')
 

<div class=" divider">
</div>
<?php 
// $payoutMonth = $landlord->created_at->format('m/Y');
$payoutMonth = date('m/y');
 ?>
 

<div id="printingDiv" class="container">
  <div class="card">
<div class="card-header">

<br><br>
  <span class="float-right"> <strong></strong> <span style="background-color: green;" class="badge badge-primary">Payout ID <strong>FRPY-{{$landlord->id}}</strong> </span></span>
  <br><br>
  <span class="float-right"> <strong></strong> <span style="background-color: #FF9800;" class="badge badge-primary">Payout Breakdown Report For {{$landlord->name}} | Month: {{$payoutMonth}}</span></span>

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
<strong>Landlord</strong>
</div>
<div>Name: {{$landlord->name}}</div>
<div>ID No: {{$landlord->id_no}}</div>
<div>Email: {{$landlord->email}}</div>
<div>Phone: {{$landlord->phone_number}}</div>
</div>



</div>
 


<div class="container table-responsive-sm">
    <!-- <h3>Other Payments Made This Month</h3> -->

    <h3><span class="float-right"> <strong></strong> <span style="background-color: #708090;" class="badge badge-primary">Building Expected Rent, Deductions & Payout Summary For The Month: {{$payoutMonth}}</span></span></h3>
<table style="width: 100%;" class="table table-striped">
<thead>
<tr>
<!-- <th>#</th> -->
<!-- <th>Tenant</th> -->
<th>B/Name</th>
<th>B/Rent (Occupied)</th>
<th>C/Rate(%)</th>
<th>C/Amount</th>
<th>B/Deduction</th>
<th>B/Payout</th>
</tr>
</thead>
<tbody>
<?php 
 $landlord_buildings = Building::where( 'landlord_id', $landlord->id )->get();

 ?>
 @foreach($landlord_buildings as $landlord_building)
<tr>

                        <?php 

                        $utilityRent = 'rent';

                        $not_vacant = 0;

                      
                        $commission = $landlord_building->commission_rate;

                         if ($commission == null) {
                           $commission = 0;
                        } 

                        $b_id = $landlord_building->id;

                        $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where( 'rooms.building_id', '=', $b_id )->where('utility_type', '=', $utilityRent)->sum('amount');

                        $amount_after_commission = ($commission/100) * $expected_rent_utilities;

                        $building_deduction = DB::table("building_expenses")->where( 'building_id', '=', $b_id )->sum('expense_amount');
                        $building_payout = $expected_rent_utilities - $amount_after_commission - $building_deduction;

                        ?>
                        <!-- <td style="color: orange; font-weight: bold;">{{$landlord_building->id}}</td> -->
                        <td style="color: orange; font-weight: bold;">{{$landlord_building->name}}</td>
                        <td style="color: green; font-weight: bold;">{{$expected_rent_utilities}}</td>
                        <td style="color: silver; font-weight: bold;">{{$landlord_building->commission_rate}}%</td> 
                        <td style="color: silver; font-weight: bold;">{{$amount_after_commission}}</td> 

                        <td style="color: #ff00d0; font-weight: bold;">{{$building_deduction}}</td> 
    
                        <td style="color: purple; font-weight: bold;">{{$building_payout}}</td>

                        <?php 
                        $total_landlord_rent = $landlord_buildings->sum('rent');

                         ?>


                    @endforeach

 <?php 
$total_building_deductions = DB::table('building_expenses')->where( 'landlord_id', '=', $landlord->id )->sum('expense_amount');


  ?>

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
<td class="right">Ksh. {{$total_landlord_rent}}</td>
</tr>
<tr>
<td class="left">
<strong>Deductions</strong>
</td>
<td class="right">Ksh {{$total_building_deductions}}</td>
</tr>
 
<tr>
<td class="left">
<strong>Total Payout(Monthly)</strong>
</td>
<td class="right">
<strong>Ksh. {{$total_landlord_rent - $total_building_deductions}}</strong>
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
<p align="center"><button type="button" id="dwnld_btn" onclick="generatePDF()" class="btn btn-warning"><i class="fa fa-download"></i> Download Landlord Payout</button></p>

<p align="center"><button type="button" id="print_btn" onclick="printpage()" class="btn btn-success"><i class="fa fa-print"></i> Print Landlord Payout</button></p>


<!-- Disburse Modal -->
<p align="center">
<button id="disburse_btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#disburseModal">
  Disburse to {{$landlord->name}}
</button>
</p>

<!-- Modal -->
<div class="modal fade" id="disburseModal" tabindex="-1" role="dialog" aria-labelledby="disModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
              <form
        method="post"
        autocomplete="off"
        action="{{ route('landlord_disburse_store') }}"
        autocapitalize="off"
        class="form-horizontal">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disModal">Disburse to {{$landlord->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  


        <div class="form-group">
            <label for="landlord" class="control-label col-md-2">{{ trans('general.landlord') }}</label>
            <div class="col-md-4">
                  <input
                    type="text"
                    readonly="readonly"
                    name="landlord_id"
                    class="form-control"
                    placeholder="{{$landlord->name}}"
                    value="{{$landlord->id}}"
                >
            </div>
            <label for="amount" class="control-label col-md-2">{{ trans('general.amount') }}</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="amount"
                    class="form-control @error('amount') invoice-title @enderror"
                    value="{{$total_landlord_rent}}"
                >
            </div>
        </div>

        <div class="form-group">
            <label for="amount" class="control-label col-md-2">{{ trans('general.payment_method') }}</label>
            <div class="col-md-4">
                <select 
                style="display:block; width:100%;padding:0;border-width:0; border-color: red!important;"
                    name="payment_method"
                    id="payment_method"
                    class="select2 form-control">
                    @foreach(paymentMethods()  as $method)

                        <option>{{ $method }}</option>
                    @endforeach
                </select>
            </div>

            <label for="reference_no" class="control-label col-md-2">{{ trans('general.reference_no') }}</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="reference_number"
                    class="form-control"
                    value="{{ old('reference_number') }}"
                >
            </div>
        </div>
        <div class="form-group">
            <label for="date" class="control-label col-md-2">{{  trans('general.disburse') .'  ' .trans('general.date') }}</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="disburse_at"
                    class="form-control"
                    id="date"
                    value="{{ old('disburse_at') }}"
                >
            </div>
        </div>
      <!--   <div class="box-footer">
            <button class="btn btn-success">Disburse</button>
        </div> -->


   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Disburse</button>
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
 
