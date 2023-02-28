@extends('layouts.master')
@section('title') {{ trans('general.new') }} {{ trans('general.room') }} @endsection
@section('extra_css')
<style>
   #utility {
   display: grid;
   grid-template-columns: 50% 50%;
   margin-bottom: 10px;
   }
   #utility .utility-row {
   border-bottom: 1px solid #000;
   margin-bottom: 10px;
   }
</style>
@endsection
@section('content')
<div class="container-fluid">
   @can('browse_rooms')
   <ul class="nav nav-pills">
      <li class="active">
         <a href="{{ route('room_browse') }}" class="btn btn-block"> Back To Rooms </a>
      </li>
   </ul>
   @endcan
   <div class="card shadow-lg keja-round">
      <div class="card-heading clearfix">
         <h4 class="card-title"></h4>
      </div>
      <div class="card-body">
         <form class="form-horizontal" action="{{ route('room_store') }}" method="post">
            {{ csrf_field() }}
            <div class="box-body">
               <h5 class="mb-3 keja-bold">Room Details</h5>
               <div class="row">
                  <div class="col-md-4 mb-3">
                     <label for="kejaInput">Building name</label>
                     <select class="form-control select2" name="building_id">
                        @foreach($buildings as $building)
                        <option value="{{ $building->id }}"
                           >
                           {{ $building->name }}
                        </option>
                        @endforeach
                     </select>
                     @error('building_id')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="kejaInput"> Room Number:  </label>
                     <input
                        name="room_number"
                        class="form-control  @error('room_number') is-invalid @enderror"
                        value="{{ old('room_number') }}"
                        >
                     @error('room_number')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="kejaInput control-label"> {{ trans('general.room') }} Type:  </label>
                     <select
                        name="room_type"
                        class="form-control select2 @error('room_type') is-invalid @enderror"
                        id="roomType">
                        @foreach(roomTypes() as $type)
                        <option value="{{ $type }}" > {{ $type }}</option>
                        @endforeach
                     </select>
                     @error('room_type')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group">
                  <div class="form-group mb-3">
                     <div id="utility">
                        <div class="col-md-6 mt-5">
                           <div class="utility-row">
                              <h5 class="mb-3 keja-bold">Utilities</h5>
                              @foreach(utilitiesBills() as $utility => $bill)
                              <div class="row">
                                 <label class="col-md-6 control-label"> Rent </label>
                                 <div class="col-md-6 mb-3">
                                    <input
                                       type="text"
                                       class="form-control"
                                       value="0"
                                       name="rent[{{ $type }}][rent]">
                                 </div>
                                 <label class="col-md-6 control-label"> {{ $utility }}</label>
                                 <div class="col-md-6 mb-3">
                                    <input
                                       type="text"
                                       value="0"
                                       class="form-control col-md-12"
                                       name="rent[{{ $type }}][{{$utility}}]"
                                       >
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="utility-row">
                              <h5 class="mb-3 keja-bold">Rent & Utility Deposits</h5>
                              @foreach(utilitiesBills() as $deposit => $bill)
                              <div class="row mb-2">
                                 <label class="col-md-4 control-label"> Deposit </label>
                                 <div class="col-md-8 mb-3">
                                    <input
                                       type="text"
                                       class="form-control col-md-12"
                                       value="0"
                                       name="deposit[{{ $type }}][deposit]">
                                 </div>
                                 <label class="col-md-4 control-label"> {{ $deposit }}</label>
                                 <div class="col-md-8">
                                    <input
                                       type="text"
                                       value="0"
                                       class="form-control"
                                       name="deposit[{{ $type }}][{{$deposit}}]"
                                       >
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="mb-3">
                     <h5 class="keja-bold">Check On Dynamic Utility</h5>
                     <small>Utility that change every month</small>
                  </div>
                  @foreach(utilitiesBills() as $deposit => $bill)
                  <div class="row mb-2">
                     <div class="col-md-4">
                        <input
                           type="checkbox"
                           class=""
                           value="{{ $deposit }}"
                           name="is_dynamic[]"
                           >
                        <label class="col-md-4 control-label"> {{ $deposit }}</label>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
            <div class="col-md-4">
               <button type="submit" class="btn btn-primary w-100">Create Room</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('js')
@include('layouts._form-scripts')
@endsection