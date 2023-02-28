@extends('layouts.master')
@section('title', $building->name .' Building Rent and Deposit Settings')
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

    <div class="row">
        <div class="col-md-12">
            <div class="card card-white">


                <div class="row mb-2 align-content-center offset-5">
                    @can('read_building')
                        <ul class="nav nav-pills">
                            <li class="">
                                <a href="{{ route('building_read', ['building' => $building->id ]) }}"
                                   class="btn btn-outline-danger"> Back To Building Details </a>
                            </li>
                        </ul>
                    @endcan

                </div>

                <form
                    method="post"
                    action="{{ route('building_setting_store', ['building' => $building->id]) }}"
                    class="form-horizontal">
                    {{ csrf_field() }}
                    @foreach(roomTypes() as $type)

                        <label class="control-label col-md-4 text-uppercase text-center"
                               style="text-align: center"><strong>{{ $type }}</strong></label>
                        <input type="hidden" class="form-control" value="{{ $type }}" name="room_type[]">

                        <div id="utility" style="border-top: 1px solid #000">
                            <div class="utility-row">

                                <div class="form-row mb-2">
                                    <label class="col-md-4 mt-3 control-label"> Rent </label>
                                    <div class="col-md-4 mt-3">
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{ \App\DB\Building\BuildingPricing::getPrice($building->id, $type, "rent",'rent') }}"
                                            name="rent[{{ $type }}][rent]">
                                    </div>
                                </div>

                                <strong style="border-bottom: solid 1px #000">Utilities</strong>
                                @foreach(utilitiesBills() as $utility => $bill)
                                    <div class="form-row mb-2">
                                        <label class="col-md-4 control-label"> {{ $utility }}</label>
                                        <div class="col-md-4">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ \App\DB\Building\BuildingPricing::getPrice($building->id, $type, $utility ,'rent') }}"
                                                   name="rent[{{ $type }}][{{$utility}}]"
                                            >
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="utility-row">


                                <div class="form-row mb-2">
                                    <label class="col-md-4 mt-3 control-label"> Deposit </label>
                                    <div class="col-md-4 mt-3">
                                        <input
                                            type="text"
                                            class="form-control"
                                            value=" {{ \App\DB\Building\BuildingPricing::getPrice($building->id, $type, 'deposit',"deposit") }}"
                                            name="deposit[{{ $type }}][deposit]">
                                    </div>
                                </div>

                                <strong style="border-bottom: solid 1px #000">Utilities</strong>
                                @foreach(utilitiesBills() as $deposit => $bill)
                                    <div class="form-row mb-2">
                                        <label class="col-md-4 control-label"> {{ $deposit }}</label>
                                        <div class="col-md-4">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ \App\DB\Building\BuildingPricing::getPrice($building->id, $type, $deposit,'deposit') }}"
                                                name="deposit[{{ $type }}][{{$deposit}}]"
                                            >
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    @endforeach

                    <div class="form-group form-row">
                        <div class="col-md-4 align-content-center offset-4">
                            <button class="btn btn-outline-success btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
