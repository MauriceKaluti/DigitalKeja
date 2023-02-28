@extends('layouts.master')
@section('title','Create New Room Lease')
@section('content')
<?php
   $rid = '';
   if (request()->has('room_id'))
   {
     $rid = request('room_id');
   }
   // var_dump($rid); die();
?>
<div class="container-fluid">
   <form class="form-horizontal " method="post" action="{{ route('lease_store') }}">
      {{ csrf_field() }}
      <div class="row">
         <div class="col-md-4 mb-3">
            <div class="form-group">
               <label class=" control-label">Select Building</label>
               <select class="form-control select2" name="building_id" @if(! isset($room->id)) id="building" @endif >
               @foreach($buildings as $building)
               <optgroup >
                  <option name="{{ $building->name }}">{{ $building->name }}</option>
               </optgroup>
               @endforeach
               </select>
               @error('building_id')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class=" control-label">Select Room</label>
            <?php  $rum = DB::table("rooms")->where( 'id', '=', $rid )->first(); ?>
            <select class="form-control" name="room_id" id="room">
               @if($rum)
               <option value="{{ $rum->id }}"> {{ $rum->room_number }}
               </option>
               @endif
            </select>
            @error('room')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <div class="form-group">
               <label class=" control-label">Select Tenant</label>
               <select name="tenant_id" class="form-control select2" id="tenant">
                  @foreach($tenants as $tenant)
                  @if(isset($tenant->lease))
                  @else 
                  <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                  @endif
                  @endforeach
               </select>
               @error('tenant_id')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
      </div>
      <div class="col-md-3 mb-3">
         <button class="btn btn-primary w-100"><i class="fa fa-save me-1"></i>Lease Room</button>
      </div>
   </form>
</div>
@endsection
@section('extra_js')
@include('layouts._form-scripts')
<script>
   $(document).on('change', 'select#building', function () {
       let rooms = $("select#building option:selected").data('rooms')
       let options = '';
       $("select#room").empty();
       for (let i = 0; i < rooms.length; i++) {
           if ( rooms[i].is_vacant) {
               options += '<option value="' + rooms[i].id + '" data-bedrooms="' + rooms[i].bedrooms + '" data-rent="' + rooms[i].rent + '" data-deposit="' + rooms[i].deposit + '">' + rooms[i].room_number + '</option>'
           }
       }
       $("select#room").append(options);
   })
   
   
   $(document).on('change', 'select#room', function () {
       let rent = $("select#room option:selected").data('rent')
       let deposit = $("select#room option:selected").data('deposit')
       let bedrooms = $("select#room option:selected").data('bedrooms')
   
       var formatter = new Intl.NumberFormat('en-US', {
           style: 'currency',
           currency: 'KES',
       });
   
       $("span#deposit").empty()
       $("span#rent").empty();
       $("span#bedrooms").empty();
       $("span#rent").text(formatter.format(rent))
       $("span#deposit").text(formatter.format(deposit))
       $("span#bedrooms").text(bedrooms)
   })
</script>
@endsection