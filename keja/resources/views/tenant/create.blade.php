@extends('layouts.master')
@section('content')
<div class="container-fluid">
   <ul class="nav nav-pills mb-3">
   <li class="me-2">
      <a href="{{ route('tenant_browse') }}" class="btn btn-outline-primary w-100 mb-3"><i class="fa fa-users"></i> All Tenants </a>
   </li>
</ul>
   <h3 class="mb-3">Create A New Tenant:</h3>
   <form
      class="form-horizontal"
      action="{{ isset($tenant->id) ? route('tenant_update', ['tenant' => $tenant->id]) : route('tenant_store') }}"
      method="post"
      autocomplete="off" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{   isset($tenant->id) ? method_field('PATCH') : ''}}
      <div class="row">
         <div class="col-md-4 mb-3">
            <label for="kejaInput" class="control-label">Full Name</label>
            <input type="text"
               class="form-control @error('name') is-invalid @enderror"
               id="kejaInput"
               name="name"
               value="{{ old('name' , isset($tenant) ? $tenant->name : '') }}"
               aria-describedby="emailHelp"
               placeholder="Enter Tenant Name">
            @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <label for="kejaInput" class="control-label">ID NO</label>
            <input type="text"
               class="form-control @error('id_no') is-invalid @enderror"
               id="kejaInput"
               name="id_no"
               value="{{ old('id_no', isset($tenant) ? $tenant->id_no : '') }}"
               aria-describedby="emailHelp"
               placeholder="Enter Tenant ID No">
            @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <label for="kejaInput" class="control-label">Email</label>
            <input
               type="email"
               class="form-control @error('email') is-invalid @enderror"
               id="kejaInput"
               name="email"
               aria-describedby="emailHelp"
               value="{{ old('email', isset($tenant) ? $tenant->email : '') }}"
               placeholder="Enter Email">
            @error('email')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <label for="kejaInput" class="control-label">Phone Number</label>
            <input
               type="text"
               class="form-control @error('phone_number') is-invalid @enderror"
               id="kejaInput"
               name="phone_number"
               aria-describedby="emailHelp"
               value="{{ old('phone_number' , isset($tenant) ? $tenant->phone_number : '') }}"
               placeholder="+2547xx xxx xxx">
            @error('phone_number')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <label for="kejaInput" class="control-label"> Address </label>
            <input
               type="text"
               class="form-control @error('address') is-invalid @enderror"
               id="kejaInput"
               name="address"
               value="{{ old('address', isset($tenant) ? $tenant->address : '') }}"
               aria-describedby="emailHelp"
               placeholder="Address. e.g P.O BOX 65 (00100), Nairobi">
            @error('address')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <label for="kejaInput" class="control-label col-md-2"> Status </label>
            <select id="status" 
               class="form-control"
               name="status"
               >
            <option
            @if(isset($tenant) && $tenant->is_active) selected @endif
            value="1">Active
            </option>
            <option
            @if(! isset($tenant)  && $tenant->is_active) selected @endif
            value="0">
            Not Active
            </option>
            </select>
            @error('status')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="col-md-4 mb-3">
            <label for="lease_agreement" class="control-label">Lease Agreeement</label>
            <input type="file" accept="pdf*/image*" 
               id="lease_agreement" 
               name="lease_agreement"
               value="{{ old('lease_agreement', isset($tenant) ? $tenant->lease_agreement : '') }}"
               aria-describedby="Lease Agreeement"
               tile="Upload Tenant Lease Agreeement(PDF/">
            @error('lease_agreement')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
      </div>
      <fieldset class="mt-3">
         <h3 class="mb-3">Next Of Kin:</h3>
         <div class="row">
            <div class="col-md-4 mb-3">
               <label for="kejaInput" class="control-label">Full Name</label>
               <input type="text"
                  class="form-control @error('kin_name') is-invalid @enderror"
                  id="kejaInput"
                  name="kin_name"
                  value="{{ old('kin_name',isset($tenant->kinable->name) ? $tenant->kinable->name : '') }}"
                  aria-describedby="emailHelp"
                  placeholder="Enter Next of Kin Name">
               @error('kin_name')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="col-md-4 mb-3">
               <label for="kejaInput" class="control-label">Phone Number</label>
               <input type="text"
                  class="form-control @error('kin_phone_number') is-invalid @enderror"
                  id="kejaInput"
                  name="kin_phone_number"
                  value="{{ old('kin_phone_number', isset($tenant->kinable->phone_number) ? $tenant->kinable->phone_number : '') }}"
                  aria-describedby="emailHelp"
                  placeholder="Enter Next of Kin Phone No">
               @error('kin_phone_number')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="col-md-4 mb-3">
               <label for="kejaInput" class="control-label">Relation</label>
               <input
                  type="text"
                  class="form-control @error('kin_relation') is-invalid @enderror"
                  id="kejaInput"
                  name="kin_relation"
                  aria-describedby="emailHelp"
                  value="{{ old('kin_relation', isset($tenant->kinable->relation) ? $tenant->kinable->relation : '') }}"
                  placeholder="Enter the tenant relation">
               <input
                  type="hidden"
                  class="form-control @error('kin_id') is-invalid @enderror"
                  id="kejaInput"
                  name="kin_id"
                  aria-describedby="emailHelp"
                  value="{{ old('kin_id', isset($tenant->kinable->id) ? $tenant->kinable->id : '') }}"
                  placeholder="Enter the tenant relation">
               @error('kin_relation')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="col-md-4 mb-3">
               <label for="validationCustom01" class="control-label">Building name</label>
               <select
                  id="building"
                  class="form-control"
                  name="status"
                  >
                  <option value="">Select A Building</option>
                  @foreach($buildings as $index => $building)
                  <option data-rooms="{{ json_encode($building)  }}">{{ $index }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-4 mb-3">
               <label class="control-label">Select Room</label>
               <select
                  class="form-control select2 select2-container--classic"
                  name="room_id"
                  id="room">
                  <option></option>
               </select>
               @error('room')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
      </fieldset>
      <div class="box-footer">
         <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100"> @if(isset($tenant->id)) <i class="fa fa-refresh"></i> Update Tenant @else
        <i class="fa fa-user-plus"></i> Create Tenant @endif</button>
         </div>
      </div>
   </form>
 
</div>
@endsection
@section('extra_js')
@include('layouts._form-scripts')
<script>
   let options = '';
   
   $("select#room").append(options);
   
   $(document).on('change', 'select#building', function () {
       let rooms = $("select#building option:selected").data('rooms');
   
       console.log(rooms)
       let options = '';
       $("select#room").empty();
       for (let i = 0; i < rooms.length; i++) {
   
           console.log(rooms[i]['room_number'])
               options += '<option value="' + rooms[i].id + '">' + rooms[i].room_number + '</option>'
   
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