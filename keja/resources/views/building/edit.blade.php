@extends('layouts.master')
@section('title') Update Building @endsection
@section('content')

    <div class="mb-2 align-content-center offset-5">
        @can('browse_building')
            <ul class="nav nav-pills">
                <li class="">
                    <a href="{{ route('building_browse') }}" class="btn btn-outline-primary"> Back To Building </a>
                </li>
            </ul>
        @endcan

    </div>

    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="box box-white">
                <div class="box-heading clearfix">
                    <h4 class="box-title"></h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" action="{{ route('building_update', ['building' => $building->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="form-group">
                            <label for="validationCustom01" class="control-label col-md-2">Building name</label>

                            <div class="col-md-4">
                                <input
                                    name="name"
                                    class="form-control  @error('name') is-invalid @enderror"
                                    value="{{ old('name', $building->name) }}"
                                >
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <label for="validationCustom02" class="col-md-1"> Select Landlords</label>
                            <div class="col-md-4">
                                <select
                                    class="select2 form-control @error('landlord_id') is_invalid @enderror"
                                    name="landlord_id"
                                >
                                    @foreach($landlords as $landlord)
                                        <option
                                            @if($landlord->id === $building->landlord->id) selected @endif
                                            value="{{ $landlord->id }}">{{ $landlord->name }}</option>
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
                                    value="{{ old('location', $building->location) }}"
                                >
                                @error('location')
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
                                    <option value="percentage"
                                            @if($building->getMeta('commission_type',  false)  == 'percentage') selected @endif
                                    >Percentage</option>
                                    <option value="fixed"
                                            @if($building->getMeta('commission_type',  false)  == 'fixed') selected @endif
                                    >Fixed (e.g. 3000) </option>
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
                                    value="{{ $building->getMeta('commission_value',  false) }}"
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
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('extra_js')
    <script>
        $(document).on('click','button#AddRooms', function () {
            $(".appendRoomsHere").empty()
            var roomNo = $("#totalRooms").val();

           var HtmlRooms = '<div class="form-row"><div class="col-md-3 mb-3">' +
               '<label for="validationCustom02"> Room No:</label> <input type="text" name="room_no[]" class="form-control">' +
               '</div><div class="col-md-3 mb-3"><label for="validationCustom02">  Bedrooms:</label> <input type="text" name="bedrooms[]" class="form-control">' +
               '</div><div class="col-md-3 mb-3"><label for="validationCustom02"> Rent:</label> <input type="text" name="rent[]" class="form-control" value="">' +
               '</div><div class="col-md-3 mb-3"><label for="validationCustom02"> Deposit:</label> <input type="text" name="deposit[]" class="form-control" value="">' +
               '</div></div>';

           var toAppend = '';

           for (let i =0 ; i < roomNo  ; i++)
           {
               toAppend += HtmlRooms
           }

           $(".appendRoomsHere").append(toAppend)

        })
    </script>
@endsection
