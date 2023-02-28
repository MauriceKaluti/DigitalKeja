<form class="form-horizontal" action="{{ route('room_store') }}" method="post">
    {{ csrf_field() }}


    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="validationCustom01">Building name</label>

            <select class="form-control" name="building_id">
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}"
                    >

                        {{ $building->name .' ( '. $building->landlord->name .' )' }}
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

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="validationCustom01"> Room Type:  </label>

            <select
                name="room_type"
                class="form-control @error('room_type') is-invalid @enderror"
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

        <div class="col-md-4 mb-3">
            <label for="validationCustom01"> BedRooms:  </label>
            <input
                name="bedrooms"
                class="form-control  @error('bedrooms') is-invalid @enderror"
                value="{{ old('bedrooms' , 0) }}"
            >
            @error('bedrooms')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="validationCustom01"> Rent:  </label>

            <input
                name="rent"
                class="form-control  @error('rent') is-invalid @enderror"
                value="{{ old('rent') }}"
            >
            @error('rent')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

        </div>
        <div class="col-md-4 mb-3">
            <label for="validationCustom02"> Deposit </label>

            <input type="text"
                   name="deposit"
                   value="{{ old('deposit') }}"
                   class="form-control @error('deposit') is_invalid @enderror"
            >
            @error('deposit')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="validationCustom02"> Deposit Period </label>

            <input type="text"
                   name="deposit_period"
                   value="{{ old('deposit_period') }}"
                   class="form-control @error('deposit_period') is_invalid @enderror"
            >
            @error('deposit_period')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>


</form>

