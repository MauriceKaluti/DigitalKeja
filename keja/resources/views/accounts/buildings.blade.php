
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\DB\Landlord\Landlord;
use App\DB\Building\Building;
use App\DB\Building\Room;
use App\User;
 
?>

@extends('layouts.master')
@section('title','Building Current Payment Status')
@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 


    <div class=" divider">
    </div>
<?php 

  // $receiptsA = Payment::with('lease');

  $landlords =Landlord::get();

 ?>
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>
            
            <th>Building Name vs Owner</th>
            
            <th>Breakdown</th>            
         
            <th>Action</th>

        </tr>
        </thead>
        <tbody>

      
           @foreach($landlord_buildings as $landlord_building)

        
                <tr>
                    <td width="10%">{{$landlord_building->id}}</td>
                    @if(!empty($landlord_building->landlord->name))
                    <td>{{$landlord_building->name}} <br><br> <span class="badge badge-secondary">{{$landlord_building->landlord->name}}</span></td>
                    @else
                    <td></td>
                    @endif

                    <td>

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

                        <h4 align="center" style="color: orange; font-weight: bold;"><i style="font-size: 15px;" class="fa fa-home"></i> B/Breakdown</h4>
                        <p style="color: green; font-weight: bold;">B/Rent: {{$expected_rent_utilities}}</p>
                        <p style="color: silver; font-weight: bold;">B/Commission: {{$amount_after_commission}}</p> 

                        <p style="color: #ff00d0; font-weight: bold;">B/Deductions: {{$building_deduction}}</p> 
    
                        <p style="color: purple; font-weight: bold;">B/Payout: {{$building_payout}}</p>

                        <hr>
                        <hr>



                        <?php 



                        $buidling_rooms = Room::where( 'building_id', '=', $b_id )->get();

                         ?>

                         <h4 style="font-weight: bold;">{{$landlord_building->name}} Rooms</h4>

                         @foreach($buidling_rooms as $room)

                          <p><span style="background-color: gold;" class="badge"><i style="color: purple;" class="fa fa-home"></i> {{$room->room_number}}</span> </p>
                         

                     


                            <?php
                        if (isset($room->lease->tenant->id)) {
                            # code...

                         $t_phone = $room->lease->tenant->phone_number;

                        }else{
                          $t_phone = "254700422699";
                        }

                              if (isset($room->lease->tenant->id)) {
                            # code...


                          $roomID = $room->lease->room_id;


                        }else{

                          $roomID = 1;
                        }
                  


                        $utilityRent = 'rent';

                        $required_rent = DB::table("room_utilities")->where( 'room_id', $roomID )->where( 'utility_type', $utilityRent )->sum('amount');

                        $currentMonth = date('m');


                        $mpesads = DB::table( 'mpesa_transactions' )->where( 'mpesa_transactions.MSISDN', '=', $t_phone )->whereRaw('MONTH(created_at) = ?',[$currentMonth])->sum('trans_amount');

                         ?>
                          <!-- <p>{!! $room->tenant_name !!}</p> -->

                              @if(isset($room->lease))


                              @if(isset($room->lease->tenant->id))

                          <p><span class="badge"><i class="fa fa-user"></i> {{$room->lease->tenant->name}}</span></p>
                     
                        @endif

                          <p><span style="font-weight: bold;">Current Month:</span> Expected: {{$required_rent}} <span style="font-weight: bold;">Paid: {{$mpesads}}</span> </p>
 
                          @if($mpesads == $required_rent)

                          <span style="background-color: green;" class="badge badge-secondary">Cleared</span>

                          @else

                          <span style="font-weight: bold;">Blc: {{$required_rent - $mpesads}}</span>

                          @endif


                          @else
                          <span style="background-color: red;" class="badge badge-secondary">Not Leased</span>


@endif
                        <hr>

                         @endforeach
 

                   </td>

                 
    
                    <td> 

                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.building',$landlord_building->id)}}"><i class="fa fa-eye"></i> Breakdown</a>
                        <br> 
                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.expe',$landlord_building->id)}}"><i class="fa fa-eye"></i> Building Expense</a> 
                        <br>
                        <a class="btn btn-primary" href="{{route('one.inc',$landlord_building->id)}}"><i class="fa fa-eye"></i> Building Income</a> 
                        <br>
                        <br>
                        <a class="btn btn-primary" href="{{route('building_read',$landlord_building->id)}}"><i class="fa fa-eye"></i> Building Tenants</a> 


                    </td>
                    
                </tr>
              
 @endforeach


        </tbody>
        <tfoot>
        <tr>
    <th>Id</th>
            
            <th>Landlord Name</th>
            
            <th>Breakdown</th>            
         
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
