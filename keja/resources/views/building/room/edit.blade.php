@extends('layouts.master')
@section('title') Edit {{ trans('general.room') }} @endsection
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
            margin-top: 20px;
        }

    </style>
@endsection
@section('content')

        @can('browse_landlords')
            <ul class="nav nav-pills">
                <li class="">
                    <a href="{{ route('landlord_read',['landlord' => $room->building->landlord->id]) }}" class="btn btn-outline-danger"> Back to {{ trans('general.landlord') }} {{ trans('general.details') }} </a>
                </li>
            </ul>
        @endcan

    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card card-white">
                <div class="card-heading clearfix">
                    <h4 class="card-title"></h4>
                </div>
                <div class="card-body">

                    <form class="form-horizontal" action="{{ route('room_update', ['room' => $room->id]) }}" method="post">
                        {{ csrf_field() }}

                        {{ method_field('PATCH') }}

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Building name</label>

                                <select class="form-control" name="building_id">
                                    @foreach($buildings as $building)
                                       @if(isset($building->landlord->name))
                                            <option value="{{ $building->id }}"
                                                    @if($room->building->id == $building->id) selected @endif
                                            >

                                                {{ $building->name .' ( '. $building->landlord->name .' )' }}
                                            </option>

                                        @endif
                                    @endforeach
                                </select>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                        </div>


                        <div class="form-group">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01"> {{ trans('general.room') }} Type:  </label>

                                <select
                                    name="room_type"
                                    class="form-control @error('room_type') is-invalid @enderror"
                                    id="roomType">
                                    @foreach(roomTypes() as $type)
                                        <option
                                            @if($room->getMeta('room_type') == $type) selected @endif
                                            value="{{ $type }}" > {{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('room_type')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-4 mb-3">
                                <label for="room_number">{{ trans('general.room')  }} Number</label>
                                <input type="text"
                                       class="form-control"
                                       name="room_number"
                                       value="{{ old('room_number',  $room->room_number)  }}">
                            </div>
                        </div>

                        <div class="form-row">


                            <div id="utility" style="border-top: 1px solid #000">
                                <div class="utility-row">

                                    <div class="form-group mb-2">
                                        <label class="col-md-4 mt-3 control-label"> Rent </label>
                                        <div class="col-md-4 mt-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ room_utility($room->id, 'rent', "rent") }}"
                                                name="rent[{{ $type }}][rent]">
                                        </div>
                                    </div>

                                    <strong style="border-bottom: solid 1px #000">Utilities</strong>
                                    @foreach(utilitiesBills() as $utility => $bill)

                                        <div class="form-group mb-2">
                                            <label class="col-md-4 control-label"> {{ $utility }}</label>
                                            <div class="col-md-4">
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ room_utility($room->id, 'rent', $utility) }}"
                                                       name="rent[{{ $type }}][{{$utility}}]"
                                                >
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="utility-row">


                                    <div class="form-group mb-2">
                                        <label class="col-md-4 mt-3 control-label"> Deposit </label>
                                        <div class="col-md-4 mt-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ room_utility($room->id, 'deposit', "deposit") }}"
                                                name="deposit[{{ $type }}][deposit]">
                                        </div>
                                    </div>

                                    <strong style="border-bottom: solid 1px #000">Utilities</strong>
                                    @foreach(utilitiesBills() as $deposit => $bill)
                                        <div class="form-group mb-2">
                                            <label class="col-md-4 control-label"> {{ $deposit }}</label>
                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ room_utility($room->id, 'deposit', $deposit) }}"
                                                    name="deposit[{{ $type }}][{{$deposit}}]"
                                                >
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>

                       <?php
                        /***
                         * Create an array for recursive utility bills for rent
                         */


                        ?>

                        <strong style="border-bottom: solid 1px #000">Tick on Dynamic utility</strong>
                        <span class="danger help-block">Utility that change every month</span>
                        @foreach(utilitiesBills() as $deposit => $bill)
                            <div class="form-group mb-2">
                                <label class="col-md-4 control-label"> {{ $deposit }}</label>
                                <div class="col-md-4">
                                    <input
                                        type="checkbox"
                                        class="checkbox"
                                        value="{{ $deposit }}"
                                        @if( $room->getMeta('is_dynamic_'.$deposit, false) ) checked @endif
                                        name="is_dynamic[]"
                                    >
                                </div>
                            </div>
                        @endforeach

                        <div class="form-row">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
