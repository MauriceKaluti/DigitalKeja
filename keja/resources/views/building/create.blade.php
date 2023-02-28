@extends('layouts.master')
@section('title') New Building @endsection
@section('content')
<div class="container-fluid">
   @can('browse_building')
<ul class="nav nav-pills">
   <li class="mb-3">
      <a href="{{ route('building_browse') }}" class="btn btn-outline-primary btn-rounded"> <i class="fa fa-angle-left"></i> Back To
      Building </a>
   </li>
</ul>
@endcan
<div class="box box-white">
   <div class="box-heading"></div>
   <div class="box box-body">
      <form class="form-horizontal form-bordered" action="{{ route('building_store') }}" method="post">
         {{ csrf_field() }}
 <div class="row mb-3">
            <div class="col-md-4 mb-3">
            <div class="form-group">
               <label for="kejaInput" class="control-label">Building Name</label>
               <input
                  name="name"
                  class="form-control  @error('name') is-invalid @enderror"
                  value="{{ old('name') }}"
                  >
               @error('name')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <div class="form-group">
               <label for="kejaInput"> Select Landlord</label>
               <select
                  class="select2 form-control @error('landlord_id') is_invalid @enderror"
                  name="landlord_id"
                  >
                  @foreach($landlords as $landlord)
                  <option value="{{ $landlord->id }}">{{ $landlord->name }}</option>
                  @endforeach
               </select>
               @error('landlord_id')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <div class="form-group">
               <label for="kejaInput" class="control-label"> Location </label>
               <input
                  name="location"
                  class="form-control  @error('location') is-invalid @enderror"
                  value="{{ old('location') }}"
                  >
               @error('location')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <div class="form-group">
               <label for="kejaInput"
                  class="control-label"> {{ trans('general.no_of_units') }}  </label>
               <input
                  name="no_of_units"
                  class="form-control  @error('location') is-invalid @enderror"
                  value="{{ old('no_of_units') }}"
                  >
               @error('no_of_units')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <div class="form-group">
               <label for="kejaInput"> Commission Rate </label>
               <input oninput="checkValue(this);"
                  type="text"
                  maxlength="3"
                  class="entered_rate form-control @error('commission_rate') is-invalid @enderror"
                  name="commission_rate"
                  value="{{ old('commission_rate') }}"
                  placeholder="e.g. 7 0r 3000">
               @error('commission_rate')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
               <div class="row" id="ribbon">
                  <!--Div to show exceeded balance --> 
               </div>
            </div>
         </div>
 </div>
         <div class="box-footer">
            <div class="form-group col-md-4">
               <button type="submit" class="btn-create btn btn-primary w-100"><i class="fa fa-plus"></i> Create Tenant</button>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
@endsection
@section('extra_js')
@include('layouts._form-scripts')
<script type="text/javascript">
   $(document).ready(function() {
   
   
   $(".entered_rate").keyup(function() { 
   
   var entered_rate=$(this).val();
   var stdrate=100;
   
   
   
   if(entered_rate>stdrate){
   $('.btn-create').prop('disabled', true);
   // $('.btn-create').prop('hidden', true);
   var exceed_label = '<span class="label label-danger" style="margin:12px">Rate Entered Exceeds Standard(100%)</span>'
   $("#ribbon").html(exceed_label);
   }
   else{
   $('.btn-create').prop('disabled', false);
   // $('.btn-create').prop('hidden', false);
   $("#ribbon").html(" ");
   }
   
   
   }); 
   
   
   });
   
   
</script>
<script>
   $(document).on('click', 'button#AddRooms', function () {
       $(".appendRoomsHere").empty();
       var roomNo = $("#totalRooms").val();
   
       var toAppend = '';
   
       for (let i = 1; i <= roomNo; i++) {
           toAppend += '<div class="timeline-comment" style="border-bottom: 1px solid #FF0000"></div><div class="form-row"><div class="col-md-3 mb-3">' +
               '<label for="kejaInput"> Room No:</label> <input type="text" name="room_no[]"  value="' + i + '"class="form-control">' +
               '</div><div class="col-md-3 mb-3"><label for="kejaInput">Room Type:</label> <select name="room_type" class="form-control @error('room_type') is-invalid @enderror" id="roomType"> @foreach(roomTypes() as $type) <option value="{{ $type }}" > {{ $type }}</option> @endforeach </select>' +
               '</div><div class="col-md-3 mb-3"><label for="kejaInput">No Bedrooms:</label> <input type="text" name="bedrooms[]" value="0" class="form-control">' +
               '</div><div class="col-md-3 mb-3"><label for="kejaInput"> Rent:</label> <input type="text" name="rent[]" class="form-control" value="">' +
               '</div>@foreach(utilitiesBills() as $key => $bill)<div class="col-md-3 mb-3"> <label for="kejaInput"> {{ ucwords($key) }} Deposit:</label> <input type="text" name="room_{{$key}}[]" class="form-control" value="0"></div> @endforeach' +
               '</div>';
       }
   
       $(".appendRoomsHere").append(toAppend)
   
   })
</script>
@endsection