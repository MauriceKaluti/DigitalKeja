
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
@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title','Building Current Payment Status')
@section('content')

    <div class=" divider">
    </div>
<?php 

  // $receiptsA = Payment::with('lease');

  $landlords =Landlord::get();

 ?>
   <div  class="table-responsive">

    <table class="row-border stripe table" id="kejaDisplay" style="width:100%">
        <thead>
        <tr>
            <th>Id</th>
            
            <th>Building/Landlord Name</th>
            
            <th>Breakdown</th>            
         
            <th>Action</th>

        </tr>
        </thead>
        <tbody>

           @foreach($landlord_buildings as $landlord_building)

        
                <tr>
                    <td width="10%">{{$landlord_building->id}}</td>
                    @if(!empty($landlord_building->landlord->name))
                    <td><span style="background-color: #FF00D0;" class="badge badge-warning"><i class="fa fa-university"></i> {{$landlord_building->name}} </span> / <span class="badge badge-warning">{{$landlord_building->landlord->name}}</span></td>
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
                    <div class="row">
                    <div class="col-md-4">
                       <p style="color: green; font-weight: bold;">B/Rent: {{$expected_rent_utilities}}</p>
                   </div>
                    <div class="col-md-4">
                        <p style="color: silver; font-weight: bold;">B/Commission: {{$amount_after_commission}}</p> 
                   </div>

                    <div class="col-md-4">
                        <p style="color: #ff00d0; font-weight: bold;">B/Deductions: {{$building_deduction}}</p> 
                   </div>
    
                    <div class="col-md-4">
                        <p style="color: purple; font-weight: bold;">B/Payout: {{$building_payout}}</p>
                    </div>
 
                   </div>

                   </td>
    
                    <td> 

                    <div class="row">
                    <div class="col-6">
                        <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm" href="{{route('one.building',$landlord_building->id)}}"><i class="fa fa-eye"></i> Check Out</a>
                       </div>
                    <div class="col-6">
                        <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm" href="{{route('one.expe',$landlord_building->id)}}"><i class="fa fa-eye"></i> Expenses</a> 
                       </div>
                       </div>


                    <div class="row">
                        <div class="col-6">
                        <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm" href="{{route('one.inc',$landlord_building->id)}}"><i class="fa fa-eye"></i> Income</a> 
                       </div>
                   
                        <div class="col-6">
                         @can('read_building')
                         <a class="btn btn-primary w-100 btn-sm" href="{{ route('building_read',['building' => $landlord_building->id]) }}"><i class="fa fa-users"></i> Tenants</a>
                        @endcan
                       </div>
                    </div>
                   @can('browse_rooms')
                         <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm" href="{{ route('room_browse',['building_id' => $landlord_building->id]) }}"><i class="fa fa-home"></i> Check Rooms</a>
                    @endcan
                    <br>
                     @can('add_rooms')
                        <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm"  href="{{ route('room_create',['building' => $landlord_building->id]) }}"><i class="fa fa-plus"></i> {{ __('Create New Room') }}</a>
                    @endcan
                  
                        <div class="row">
                        <div class="col-6">
                    @can('edit_building')
                        <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm"  href="{{ route('building_edit',['building' => $landlord_building->id]) }}"><i class="fa fa-edit"></i> {{ __('Update') }}</a>
                    @endcan
                    </div>
                        <div class="col-6">
                    @can('delete_building')
                        <a style="margin-bottom: 10px;" class="btn btn-primary w-100 btn-sm"  href="{{ route('building_delete',['building' => $landlord_building->id]) }}"><i class="fa fa-trash"></i> {{ __('Delete') }}</a>
                    @endcan
                    </div>
                    </div>
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
