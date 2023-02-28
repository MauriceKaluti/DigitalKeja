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

    <div class=" mb-2 align-content-center offset-5">
        @can('browse_rooms')
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="{{ route('room_browse') }}" class="btn btn-block"> Back To Rooms </a>
                </li>
            </ul>
        @endcan

    </div>

    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card card-white">
                <div class="card-heading clearfix">
                    <h4 class="card-title"></h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('room_store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Building name</label>
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
                                    <label for="validationCustom01"> Room Number:  </label>

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

                            </div>

                            <div class="form-group">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01 control-label"> {{ trans('general.room') }} Type:  </label>

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
                                <div class="form-group">


                                    <div id="utility">

                                        <div class="col-md-6 mt-5">
                                            <div class="utility-row">

                                                <div class="form-group mt-2">
                                                    <label class="col-md-4 mt-3 control-label"> Rent </label>
                                                    <div class="col-md-8 mt-3">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            value="0"
                                                            name="rent[{{ $type }}][rent]">
                                                    </div>
                                                </div>

                                                <strong  style="border-bottom: solid 1px #000 ; margin-left: 12px">Utilities</strong>
                                                @foreach(utilitiesBills() as $utility => $bill)

                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"> {{ $utility }}</label>
                                                        <div class="col-md-6">
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


                                                <div class="form-group mb-2">
                                                    <label class="col-md-6 mt-3 control-label"> Deposit </label>
                                                    <div class="col-md-6 mt-3">
                                                        <input
                                                            type="text"
                                                            class="form-control col-md-12"
                                                            value="0"
                                                            name="deposit[{{ $type }}][deposit]">
                                                    </div>
                                                </div>

                                                <strong style="border-bottom: solid 1px #000">Utilities</strong>
                                                @foreach(utilitiesBills() as $deposit => $bill)
                                                    <div class="form-group mb-2">
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

                                <?php
                                /***
                                 * Create an array for recursive utility bills for rent
                                 */


                                ?>

                                <strong style="border-bottom: solid 1px #000">Tick on Dynamic utility</strong>
                                <span class="danger help-block">Utility that change every month</span>
                                @foreach(utilitiesBills() as $deposit => $bill)
                                    <div class="form-group mb-2">
                                        <label class="col-md-2 control-label"> {{ $deposit }}</label>
                                        <div class="col-md-4">
                                            <input
                                                type="checkbox"
                                                class=""
                                                value="{{ $deposit }}"
                                                name="is_dynamic[]"
                                            >
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-row">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    @include('layouts._form-scripts')
@endsection

