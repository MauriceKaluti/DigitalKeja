<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\DB\Landlord\Landlord;
use App\DB\Building\Building;
use App\User;
?>

@extends('layouts.master')
@section('title','Landlord Breakdown Per Building')
@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 
  <div class=" divider">
  </div>
 
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>
            
            <th>Landlord Name</th>
            
            <th>Breakdown</th>            
            <th>Phone</th>
            <th>Created At</th>
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
                    <td>{{$landlord->name}}</td>
                    @else
                    <td></td>
                    @endif

                    <td>@foreach($landlord_buildings as $landlord_building)

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



                        $buidling_rooms = DB::table( 'rooms' )->where( 'rooms.building_id', '=', $b_id )->get();

                         ?>

                         @foreach($buidling_rooms as $room)


                        <?php

                        $r_idd = $room->id;
                        $buidling_leases = DB::table( 'leases' )->where( 'leases.room_id', '=', $r_idd )->get();

                         ?>


                          <p><span class="badge"><i class="fa fa-home"></i> {{$room->room_number}}</span> </p>

                         @foreach($buidling_leases as $lease)

                        <?php

                        $t_idd = $lease->tenant_id;
                        $tenants = DB::table( 'tenants' )->where( 'tenants.id', '=', $t_idd )->get();

                         ?>


                         @foreach($tenants as $tenant)

                            <?php

                        $t_phone = $tenant->phone_number;

                        $currentMonth = date('m');

                        $mpesads = DB::table( 'mpesa_transactions' )->where( 'mpesa_transactions.MSISDN', '=', $t_phone )->whereRaw('MONTH(created_at) = ?',[$currentMonth])->sum('trans_amount');

                         ?>
                          <p>{{$tenant->name}}</p>
                          <p>{{$mpesads}}</p>

                         @endforeach                     


                         @endforeach


                         @endforeach
 
                        <hr>

                    @endforeach</td>

                    <td>{{$landlord->phone_number}}</td>
                    <td>{{$landlord->created_at}}</td>    
    
                    <td> 

                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.landlord',$landlord->id)}}"><i class="fa fa-money"></i> Disburse</a>
                        <br> 
                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('landlord_read',$landlord->id)}}"><i class="fa fa-university"></i> Check Buildings</a> 
                        <br>
                        <a class="btn btn-primary" href="{{route('landlord_edit',$landlord->id)}}"><i class="fa fa-refresh"></i> Update Landlord Info</a> 

                    </td>
                    
                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
          <th>Id</th>
            
            <th>Landlord Name</th>
            
            <th>Breakdown</th>            
            <th>Phone</th>
            <th>Created At</th>
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
