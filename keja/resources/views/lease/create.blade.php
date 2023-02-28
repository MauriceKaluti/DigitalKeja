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
    @component('layouts._box')

        <form class="form-horizontal " method="post" action="{{ route('lease_store') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <div class="col-md-6 mb-3">
                    <label class=" control-label">Select Building</label>
                    <div class="col-md-12">
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
                <div class="col-md-6 mb-3">
                    <label class=" control-label">Select Room</label>
                    <div class="col-md-12">
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
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 mb-3">
                    <label class=" control-label">Select Tenant</label>
                    <div class="col-md-12">
                        <select name="tenant_id" class="form-control select2" id="tenant">
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
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

            <div class="box-footer">
                <div class="col-md-6 mb-3">
                    <button class="btn btn-info btn-sm pull-right"><i class="icon-save">Submit</i></button>
                </div>
            </div>

        </form>

    @endcomponent



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
