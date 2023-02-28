@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title',$building->name.' Details')
@section('content')
<div class="container-fluid">
   <ul class="nav nav-pills mb-2">
    @can('edit_building')
   <li>
      <a class="btn btn-outline-primary" href="{{ url('accounts/building' ,['building' => $building->id]) }}"><i class="fa fa-building"></i> 3D Rooms
      </a>
   </li>
   @endcan
   @can('edit_building')
   <li>
      <a class="btn btn-outline-primary" href="{{ route('building_edit' ,['building' => $building->id]) }}"><i class="fa fa-edit"></i> Edit building
      </a>
   </li>
   @endcan
   @can('delete_building')
   <li>
      <a class="btn btn-outline-primary" href="{{ route('building_delete' ,['building' => $building->id]) }}"><i class="fa fa-trash"></i> Delete building
      </a>
   </li>
   @endcan
   <li>
      <a href="{{ url('accounts/opt_buildings') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-arrow-left"></i> Back to
      Buildings <i class="fa fa-university"></i></a>
   </li>
   <li>
      <a href="{{ url('accounts/buildings') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-home"></i> Explore Buildings </a>
   </li>
   <li>
      <a href="{{ route('building_browse') }}" class="btn btn-outline-primary btn-rounded"> : <i class="fa fa-user"></i> Occupation Ratio </a>
   </li>
   <li>
      <a href="{{ url('building/create') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-plus"></i> Create
      Building</a>
   </li>
   </ul>
   <div class="row">
      <div class="col-md-3">
         <div class="box box-primary">
            <div class="box-body box-profile">
               <div class="timeline-item-header">
                  <div class="timeline-comment">
                     <p><strong>Name</strong>: {{ $building->name }}</p>
                  </div>
               </div>
               <div class="timeline-item-post">
                  <div class="timeline-comment">
                     <p><strong>No of Room</strong>: {{ $building->total_rooms }}</p>
                  </div>
                  <div class="timeline-comment">
                     <p><strong>Land Lord</strong>: {{ $building->landlord->name }}</p>
                  </div>
                  <div class="timeline-comment">
                     <p><strong>Location</strong>: {{ $building->location }}</p>
                  </div>
                  <div class="timeline-comment">
                     <p><strong> % Occupied</strong>: {{ $building->occupied() }}</p>
                  </div>
                  @foreach(utilitiesBills() as $utility => $bill)
                  <div class="timeline-comment">
                     <p><strong>{{ $utility }}</strong>: {{ $building->getMeta($utility) }}</p>
                  </div>
                  @endforeach
                  <div class="timeline-comment">
                     <p><strong> Bill are Recursive?</strong>:
                        {{ $building->getMeta('bills_inclusive', false) ? "Yes" : "No" }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="box box-primary">
            <div class="box-body box-profile">
               <?php 
                  $utilityRent = 'rent';
                  
                  $not_vacant = 0;
                  
                  
                  $commission = $building->commission_rate;
                  
                   if ($commission == null) {
                     $commission = 0;
                  } 
                  
                  $b_id = $building->id;
                  
                  $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where( 'rooms.building_id', '=', $b_id )->where('utility_type', '=', $utilityRent)->sum('amount');
                  
                  $amount_after_commission = ($commission/100) * $expected_rent_utilities;
                  
                  $building_deduction = DB::table("building_expenses")->where( 'building_id', '=', $b_id )->sum('expense_amount');
                  
                  $building_payout = $expected_rent_utilities - $amount_after_commission - $building_deduction;
                  
                  
                  ?>
               <div class="timeline-item-header">
                  <div class="timeline-comment">
                     <p><strong>Commission Rate</strong>: <span class="badge badge-primary"> {{ $building->commission_rate }}%</span></p>
                     <p><strong>Commission Earning</strong>: <span class="badge badge-primary">Ksh. {{ $amount_after_commission }}</span></p>
                     <a target="_blank" class="btn btn-primary" href="{{route('one.building',$building->id)}}"><span class="fa fa-edit"></span> Click To Edit Commission</a>
                  </div>
                  <hr>
                  <div class="timeline-comment">
                     <p><strong>Expected Rent</strong>: <span class="badge badge-primary">Ksh. {{ $expected_rent_utilities }}</span></p>
                  </div>
                  <div class="timeline-comment">
                     <p><strong>Deductions</strong>: <span class="badge badge-primary">Ksh. {{ $building_deduction }}</span></p>
                  </div>
                  <hr>
                  <div class="timeline-comment">
                     <p><strong>Building Payout</strong>: <span class="badge badge-primary">Ksh. {{ $building_payout }}</span></p>
                     <a target="_blank" class="btn btn-primary" href="{{route('one.landlord',$building->landlord->id)}}"><i class="fa fa-money"></i> Pay Landlord Now</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-9 row">
         <div class="nav-tabs-custom">
           @include('livewire.room' , ['rooms' => $building->rooms])
         </div>
      </div>
   </div>
</div>
@endsection
@section('extra_css')
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />
@endsection
@section('extra_js')
<script>
   $('table.tenant-table').dataTable();
</script>
@endsection