@extends('layouts.master')
@section('title') New Building @endsection
@section('content')

    @can('browse_building')
        <ul class="nav nav-pills">
            <li class="">
                <a href="{{ route('building_browse') }}" class="btn btn-outline-primary btn-rounded"> Back To
                    Building </a>
            </li>
        </ul>
    @endcan

    <div class="box box-white">
        <div class="box-heading"></div>
        <div class="box box-body">

            <form class="form-horizontal form-bordered" action="{{ route('building_store') }}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="validationCustom01" class="control-label col-md-2">Building name</label>

                    <div class="col-md-4">
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

                    <label for="validationCustom02" class="col-md-1"> Select landlords </label>
                    <div class="col-md-4">
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

                <div class="form-group">

                    <label for="validationCustom01" class="control-label col-md-2"> Location </label>
                    <div class="col-md-4">
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

                    <label for="validationCustom01"
                           class="control-label col-md-1"> {{ trans('general.no_of_units') }}  </label>

                    <div class="col-md-4">
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

                <div class="form-group">
                    <label for="exampleInputEmail1" class="col-md-2 control-label"> Commission Type </label>

                    <div class="col-md-4">
                        <select
                            class="select2 form-control"
                            name="commission_type"
                        >
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed (e.g. 3000) </option>
                        </select>
                        @error('commission_type')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <label for="exampleInputEmail1" class="col-md-1"> Commission Value </label>

                    <div class="col-md-4">
                        <input
                            type="number"
                            class="form-control @error('commission_value') is-invalid @enderror"
                            id="exampleInputEmail1"
                            name="commission_value"
                            value="{{ old('commission_value') }}"
                            aria-describedby="emailHelp"
                            placeholder="e.g. 7 0r 3000">
                        @error('commission_value')
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>

                </div>


                <div class="box-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>


            </form>

        </div>
    </div>

@endsection



@section('extra_js')
    @include('layouts._form-scripts')
    <script>
        $(document).on('click', 'button#AddRooms', function () {
            $(".appendRoomsHere").empty();
            var roomNo = $("#totalRooms").val();

            var toAppend = '';

            for (let i = 1; i <= roomNo; i++) {
                toAppend += '<div class="timeline-comment" style="border-bottom: 1px solid #FF0000"></div><div class="form-row"><div class="col-md-3 mb-3">' +
                    '<label for="validationCustom02"> Room No:</label> <input type="text" name="room_no[]"  value="' + i + '"class="form-control">' +
                    '</div><div class="col-md-3 mb-3"><label for="validationCustom02">Room Type:</label> <select name="room_type" class="form-control @error('room_type') is-invalid @enderror" id="roomType"> @foreach(roomTypes() as $type) <option value="{{ $type }}" > {{ $type }}</option> @endforeach </select>' +
                    '</div><div class="col-md-3 mb-3"><label for="validationCustom02">No Bedrooms:</label> <input type="text" name="bedrooms[]" value="0" class="form-control">' +
                    '</div><div class="col-md-3 mb-3"><label for="validationCustom02"> Rent:</label> <input type="text" name="rent[]" class="form-control" value="">' +
                    '</div>@foreach(utilitiesBills() as $key => $bill)<div class="col-md-3 mb-3"> <label for="validationCustom02"> {{ ucwords($key) }} Deposit:</label> <input type="text" name="room_{{$key}}[]" class="form-control" value="0"></div> @endforeach' +
                    '</div>';
            }

            $(".appendRoomsHere").append(toAppend)

        })
    </script>
@endsection
