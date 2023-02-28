<?php
   use App\DB\Payment\MpesaTransaction;
   use App\DB\Lease\Payment;
   use App\DB\Lease\Lease;
   use App\DB\Tenant;
   use App\DB\Landlord\Landlord;
   use App\DB\Building\Building;
   use App\User;
   ?>
@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title','Landlord Breakdown Per Building')
@section('content')
<div class="container-fluid">
   <div class=" divider">
</div>
<div class="table-responsive">
   <table class="row-border table stripe" id="kejaDisplay" style="width:100%">
      <!-- <table class="table display" id="kejaDisplay" > -->
      <thead>
         <tr>
            <th>Id</th>
            <th>Landlord</th>
            <th>Breakdown</th>
          
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($landlords as $landlord)
         <?php
            $landlord_buildings = Building::where( 'landlord_id', $landlord->id )->get();
            $landlord_served = User::where( 'id', $landlord->user_id )->first();
            
            ?>
         <tr>
            <td width="10%">{{$landlord->id}}</td>
            @if(!empty($landlord))
            <td>
<h6>{{$landlord->name}}</h6>
                    <p>{{$landlord->phone_number}}</p>
            <p>{{$landlord->created_at}}</p>
            </td>

            @else
            <td></td>
            @endif
            <td>
               @foreach($landlord_buildings as $landlord_building)
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
               <p style="color: orange; font-weight: bold;">B/Name: {{$landlord_building->name}}</p>
               <p style="color: green; font-weight: bold;">B/Rent: {{$expected_rent_utilities}}</p>
               <p style="color: silver; font-weight: bold;">B/Commission: {{$amount_after_commission}}</p>
               <p style="color: #ff00d0; font-weight: bold;">B/Deductions: {{$building_deduction}}</p>
               <p style="color: purple; font-weight: bold;">B/Payout: {{$building_payout}}</p>
               <?php 
                  $building_rooms = $landlord_building->rooms;
                   ?>

               <h4><span class="badge badge-primary bg-primary keja-round">{{$landlord_building->name}} Rooms</span></h4>

               <div class="row">
               @foreach($building_rooms as $room)
                  <div class="col-4">
                  <?php
                  $r_idd = $room->id;
                  $building_lease = App\DB\Lease\Lease::where( 'room_id', '=', $r_idd )->first();
                  
                   ?>
               @if($building_lease)
               <p>@if(!empty($building_lease->tenant)) {{$building_lease->tenant->name}} @else gss @endif</p>
               <p><span title="Occupied" style="background-color: green;" class="badge"><i class="fa fa-home"></i> {{$room->room_number}}</span> </p>
               @else
               <p><span title="Vacant" style="background-color: red;" class="badge"><i class="fa fa-home"></i> {{$room->room_number}}</span> </p>
               @endif
                  </div>
               @endforeach
               </div>
               <hr>
               @endforeach
            </td>
       
            <td width="200"> 
               <div class="col-md-12">
                  <a class="btn btn-primary btn-sm w-100 mb-3" href="{{route('one.landlord',$landlord->id)}}"><i class="fa fa-money"></i> Pay</a>
               <br> 
               <a class="btn btn-primary btn-sm w-100 mb-3" href="{{route('landlord_read',$landlord->id)}}"><i class="fa fa-university"></i> Buildings</a> 
               <br>
               <a class="btn btn-primary btn-sm w-100 mb-3" href="{{route('landlord_edit',$landlord->id)}}"><i class="fa fa-refresh"></i> Update </a>
               </div> 
            </td>
         </tr>
         @endforeach
      </tbody>
      <tfoot>
         <tr>
            <th>Id</th>
            <th>Landlord</th>
            <th>Breakdown</th>
          
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
<script type="text/javascript">
   function toggleIcon(e) {
   $(e.target)
      .prev('.panel-heading')
      .find(".more-less")
      .toggleClass('glyphicon-plus glyphicon-minus');
   }
   $('.panel-group').on('hidden.bs.collapse', toggleIcon);
   $('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>
@endsection