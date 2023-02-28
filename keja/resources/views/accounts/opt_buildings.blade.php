
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
            
            <th>Building/Landlord Name</th>
            
            <th>Breakdown</th>            
         
            <th>Action</th>
            <th>Action2</th>

        </tr>
        </thead>
        <tbody>

           @foreach($landlord_buildings as $landlord_building)

        
                <tr>
                    <td width="10%">{{$landlord_building->id}}</td>
                    @if(!empty($landlord_building->landlord->name))
                    <td><span style="background-color: #FF00D0;" class="badge badge-secondary"><i class="fa fa-university"></i> {{$landlord_building->name}} </span> / <span class="badge badge-secondary">{{$landlord_building->landlord->name}}</span></td>
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

                        <p style="color: orange; font-weight: bold;"><i style="font-size: 15px;" class="fa fa-list"></i> Building Breakdown</p>
                        <p style="color: green; font-weight: bold;">B/Rent: {{$expected_rent_utilities}}</p>
                        <p style="color: silver; font-weight: bold;">B/Commission: {{$amount_after_commission}}</p> 

                        <p style="color: #ff00d0; font-weight: bold;">B/Deductions: {{$building_deduction}}</p> 
    
                        <p style="color: purple; font-weight: bold;">B/Payout: {{$building_payout}}</p>
 

                   </td>
    
                    <td> 

                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.building',$landlord_building->id)}}"><i class="fa fa-eye"></i> Check Out</a>
                        <br> 
                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.expe',$landlord_building->id)}}"><i class="fa fa-eye"></i> Create B/Expense</a> 
                        <br>
                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.inc',$landlord_building->id)}}"><i class="fa fa-eye"></i> Create B/Income</a> 
                    <br>
                   
                         @can('read_building')
                         <a class="btn btn-primary" href="{{ route('building_read',['building' => $landlord_building->id]) }}"><i class="fa fa-user"></i> Check Tenants</a>
                    @endcan
                   
                    </td>
                    <td> @can('browse_rooms')
                         <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{ route('room_browse',['building_id' => $landlord_building->id]) }}"><i class="fa fa-home"></i> Check Rooms</a>
                    @endcan
                    <br>
                     @can('add_rooms')
                        <a style="margin-bottom: 10px;" class="btn btn-primary"  href="{{ route('room_create',['building' => $landlord_building->id]) }}"><i class="fa fa-plus"></i> {{ __('Create New Room') }}</a>
                    @endcan
                    <br>
                    @can('edit_building')
                        <a style="margin-bottom: 10px;" class="btn btn-primary"  href="{{ route('building_edit',['building' => $landlord_building->id]) }}"><i class="fa fa-edit"></i> {{ __('Update Building Info') }}</a>
                    @endcan
                    <br>
                    @can('delete_building')
                        <a style="margin-bottom: 10px;" class="btn btn-primary"  href="{{ route('building_delete',['building' => $landlord_building->id]) }}"><i class="fa fa-trash"></i> {{ __('Delete Building') }}</a>
                    @endcan</td>
                    
                </tr>
              
 @endforeach


        </tbody>
        <tfoot>
        <tr>
    <th>Id</th>
            
            <th>Landlord Name</th>
            
            <th>Breakdown</th>            
         
            <th>Action</th>
            <th>Action 2</th>

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
