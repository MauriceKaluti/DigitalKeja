
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
@section('title','Landlord Expected Rent Per Building')
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
            
            <th>Landlord Name</th>
            
            <th>Breakdown</th>            
            <th>Date & Time</th>
            <th>Action</th>
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

                        <hr>


                
                        <?php 
                        $leases = $landlord_building->rooms->get();

                        foreach ($leases as $leas) {
                             $l_id = $leas->id;
                        }

                        $tenants = DB::table('tenants')->where('id',$l_id)->get();

                        ?>

                         @foreach($tenants as $tenant)

                         <?php 

                         $t_id = $tenant->phone;

                         $mpesad = DB::table( 'mpesa_transactions' )->where( 'phone_number', '=', $t_id )->sum('amount');

                          ?>

                         @endforeach

                    @endforeach</td>

                    <td>{{$landlord->reference_code}}</td>
                    <td>{{$landlord->created_at}}</td>    
    
                    <td> 

                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.landlord',$landlord->id)}}"><i class="fa fa-eye"></i> check out</a>
                        <br> 
                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.expense',$landlord->id)}}"><i class="fa fa-eye"></i> create b/expense</a> 
                        <br>
                        <a class="btn btn-primary" href="{{route('one.income',$landlord->id)}}"><i class="fa fa-eye"></i> create b/income</a> 

                    </td>
                    
                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
                  <th>Id</th>
            
            <th>Landlord Name</th>
            
            <th>Ref Code</th>            
            <th>Date & Time</th>
            <th>Action</th>
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
