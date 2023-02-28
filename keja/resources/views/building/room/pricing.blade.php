@extends('layouts.master')
@section('title', trans('units.rooms') .' Pricing with similar features')
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

    <form action="{{ route('room_pricing') }}" method="post" role="form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="box-body">

            <div class="form-group">
                <div class="mb-3">
                    <label class="col-md-2 control-label " for="validationCustom01"> {{  trans('general.room') }} Type: </label>

                   <div class="col-md-6">
                       <select
                           name="room_type"
                           class="form-control select2 @error('room_type') is-invalid @enderror"
                           id="roomType">
                           @foreach(roomTypes() as $type)
                               <option

                                   value="{{ $type }}"> {{ $type }}</option>
                           @endforeach
                       </select>
                       @error('room_type')
                       <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                       @enderror
                   </div>
                   </div>
            </div>

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

                            <strong style="border-bottom: solid 1px #000">Utilities</strong>
                            @foreach(utilitiesBills() as $utility => $bill)

                                <div class="form-group mb-2">
                                    <label class="col-md-4 control-label"> {{ $utility }}</label>
                                    <div class="col-md-8">
                                        <input
                                            type="text"
                                            value="0"
                                            class="form-control"
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
                                <label class="col-md-4 mt-3 control-label"> Deposit </label>
                                <div class="col-md-8 mt-3">
                                    <input
                                        type="text"
                                        class="form-control"
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


            @foreach($roomsIds as $room)
                <input type="hidden" name="room_id[]" value="{{ $room }}">
            @endforeach

            <div class="form-row">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
@section('extra_js')
    @include('layouts._form-scripts')
 @endsection
