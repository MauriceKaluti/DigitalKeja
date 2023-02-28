<?php
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
use App\BuildingExpense;

use App\DB\Building\Building;
use App\DB\Building\Room;
?>
@extends('layouts.master')
@section('title') Explore {{$building->name}} Room Payment Breakdown @endsection
@section('content')
@include('layouts.toastr')
<div class="divider"></div>
<?php
// $payoutMonth = $landlord->created_at->format('m/Y');
$payoutMonth = date("m/y");

$landlord = $building->landlord->id;
?>
<div id="printingDiv" class="container-fluid">
   <div class="card shadow-lg keja-round mb-3">
      <div class="card-body">
         <div class="container table-responsive-sm">
            <!-- <h3>Other Payments Made This Month</h3> -->
            <h6 class="text-center mb-3">Building Expected Rent, Deductions & Payout Summary For The Month: {{$payoutMonth}}</h6>
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
                  <?php $buildings = Building::where(
                      "id",
                      $building->id
                  )->get(); ?>
                  @foreach($buildings as $building)
                  <tr>
                     <?php
                     $utilityRent = "rent";

                     $not_vacant = 0;

                     $commission = $building->commission_rate;

                     if ($commission == null) {
                         $commission = 0;
                     }

                     $b_id = $building->id;

                     $expected_rent_utilities = DB::table("room_utilities")
                         ->select("room_utilities.*")
                         ->leftJoin(
                             "rooms",
                             "rooms.id",
                             "=",
                             "room_utilities.room_id"
                         )
                         ->where("rooms.is_vacant", "=", $not_vacant)
                         ->where("rooms.building_id", "=", $b_id)
                         ->where("utility_type", "=", $utilityRent)
                         ->sum("amount");

                     $amount_after_commission =
                         ($commission / 100) * $expected_rent_utilities;

                     $building_deduction = DB::table("building_expenses")
                         ->where("building_id", "=", $b_id)
                         ->sum("expense_amount");
                     $building_payout =
                         $expected_rent_utilities -
                         $amount_after_commission -
                         $building_deduction;
                     ?>
                     <!-- <td style="color: orange; font-weight: bold;">{{$building->id}}</td> -->
                     <td style="color: orange; font-weight: bold;">{{$building->name}}</td>
                     <td style="color: green; font-weight: bold;">{{$expected_rent_utilities}}</td>
                     <td style="color: silver; font-weight: bold;">{{$building->commission_rate}}%</td>
                     <td style="color: silver; font-weight: bold;">{{$amount_after_commission}}</td>
                     <td style="color: #ff00d0; font-weight: bold;">{{$building_deduction}}</td>
                     <td style="color: purple; font-weight: bold;">{{$building_payout}}</td>
                     <?php $total_landlord_rent = $buildings->sum("rent"); ?>
                     @endforeach
                     <?php $total_building_deductions = DB::table(
                         "building_expenses"
                     )
                         ->where("building_id", "=", $building->id)
                         ->sum("expense_amount"); ?>
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
                           <strong>Total Building All Time Collection</strong>
                        </td>
                        <td class="right">Ksh. {{$total_landlord_rent}}</td>
                     </tr>
                     <tr>
                        <td class="left">
                           <strong>Total Building All Time Deductions</strong>
                        </td>
                        <td class="right">Ksh {{$total_building_deductions}}</td>
                     </tr>
                     <tr>
                        <td class="left">
                           <strong>Total Building Payout All Time(Monthly)</strong>
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
   <div class="card shadow-lg keja-round mb-3">
      <div class="card-body">
         <?php $buidling_rooms = Room::where(
             "building_id",
             "=",
             $b_id
         )->get(); ?>
         <h6 class="mb-3 text-center">{{$building->name}} Rooms Rent Payment Stats</h6>
         <div class="row justify-content-center">
            @foreach($buidling_rooms as $room)
            <div class="col-md-2 keja-popup-card text-center" @if(isset($room->lease)) style="height: 200px; margin-right: 20px; margin-bottom: 30px; background-color:#179cf0; border-radius: 30px;" @else style="height: 200px; margin-right: 20px; margin-bottom: 30px; background-color:black; border-radius: 30px;"  @endif>
            <p><span style="background-color: gold;" class="badge keja-round"><i style="color: purple; " class="fa fa-home"></i> {{$room->room_number}}</span> </p>
            <?php
            if (isset($room->lease->tenant->id)) {
                # code...

                $t_phone = $room->lease->tenant->phone_number;
            } else {
                $t_phone = "254700422699";
            }

            if (isset($room->lease->tenant->id)) {
                # code...

                $roomID = $room->lease->room_id;
            } else {
                $roomID = 1;
            }

            $utilityRent = "rent";

            $required_rent = DB::table("room_utilities")
                ->where("room_id", $roomID)
                ->where("utility_type", $utilityRent)
                ->sum("amount");

            $currentMonth = date("m");

            $mpesads = DB::table("mpesa_transactions")
                ->where("mpesa_transactions.MSISDN", "=", $t_phone)
                ->whereRaw("MONTH(created_at) = ?", [$currentMonth])
                ->sum("trans_amount");

// $manuals = DB::table( 'payments' )->where( 'payments.MSISDN', '=', $t_phone )->whereRaw('MONTH(created_at) = ?',[$currentMonth])->sum('trans_amount');
?>
            <!-- <p>{!! $room->tenant_name !!}</p> -->
            @if(isset($room->lease))
            @if(isset($room->lease->tenant->id))
            <p><span class="badge keja-round badge-primary"><i class="fa fa-user"></i> {{$room->lease->tenant->name}}</span></p>
            <!--  <p><span style="background-color: #367FA9;" class="badge keja-round badge-secondary">
               <a style="color: #fff; font-weight: bold; cursor: pointer;" data-id="{{$room->lease->tenant->id}}" class='lease-room'> <i class="fa fa-remove"></i> Detach Tempo</a> 
               </span></p> -->
            <p><span class="badge keja-round" style="background-color: #FF00D0; "><a style="color: #fff;" title="Detach Tenant Forever" href="{{route('unLease',$room->lease->tenant->id)}}"><i class="fa fa-trash"></i> Detach Tenant</a></span></p>
            @endif
            <p class="text-white"><span style="font-weight: bold;">Current Month:</span> Expected: {{$required_rent}} <span style="font-weight: bold;">Paid: {{$mpesads}}</span> </p>
            @if($mpesads == $required_rent)
            <span style="background-color: green;margin-bottom: 30px;" class="badge keja-round badge-secondary">Cleared</span>
            @else
            <span class="badge keja-round badge-danger" style="font-weight: bold;margin-bottom: 30px; background-color: #FF0000;">Blc: {{$required_rent - $mpesads}}</span>
            @endif
            @else
            <span style="background-color: red; margin-bottom: 30px;" class="badge keja-round badge-secondary">Not Leased</span>
            @if(! isset($room->lease->is_active))
            @if($room->is_vacant == 0)
            <p><span class="badge keja-round" style="background-color: green; "><a style="color: #fff;" title="Activate Room" href="{{route('activateRoom',$room->id)}}"><i class="fa fa fa-power-off"></i> Activate Room</a></span></p>
            @else
            <p><span class="badge keja-round" style="background-color: green; "><a style="color: #fff;" title="Activate Room"><i class="fa fa-check-circle"></i> Room Active</a></span></p>
            @can('add_lease_room')
            <p><span style="background-color: #367FA9;" class="badge keja-round badge-secondary">
               <a style="color: #fff; font-weight: bold; cursor: pointer;" href="{{ route('lease_create',['room_id' => $room->id]) }}" > <i class="fa fa-money"></i> Lease Room</a> 
               </span>
            </p>
            @endcan
            @endif
            @endif
            @endif
         </div>
         @endforeach
      </div>
   </div>
</div>
</div>
<p align="center">
   <button id="disburse_btn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
   Update {{$building->name}} Commission Rate
   </button>
</p>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="disModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form
         method="PATCH"
         autocomplete="off"
         action="{{ route('edit.building', $building->id) }}"
         autocapitalize="off"
         class="form-horizontal">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="disModal">Update {{$building->name}} Commssion Rate</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="tenant_phone_number" class="control-label col-md-2">Commssion Update</label>
                  <div class="col-md-4">
                     <input required="" 
                        type="text"
                        name="commission_rate"
                        class="form-control"
                        placeholder="{{$building->commission_rate}}"
                        value="{{$building->commission_rate}}"
                        >
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Update Building Commission</button>
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
   
       document.title = "Rent Payment Receipt";
       document.URL   = "www.codekali.com";
   
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
<script>
   $(document).on('click', 'a.lease-room', function () {
       swal({
           title: "Are you sure?",
           text: "You will detach this tenant from a unit!",
           icon: "warning",
           buttons: true,
           dangerMode: true,
       }).then((willDelete) => {
               if (willDelete) {
                   let uri = "{{  url('tenant/') }}";
                    uri += "/"+$(this).data('id');
                    uri +="/un-lease";
   
                   return window.open(uri)
               } else {
                   swal("You have cancelled detachment!");
               }
           });
   });
</script>
@endsection