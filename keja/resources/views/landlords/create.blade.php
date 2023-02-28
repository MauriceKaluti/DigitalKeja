@extends('layouts.master')
@section('title') New Landlord @endsection
@section('content')

    <div class="box">
        <div class="box-body">
            <ul class="nav nav-pills">
                <li class=""><a class="btn btn-rounded" href="{{ route('landlord_browse') }}"> Back </a></li>
            </ul>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <form class="form-horizontal" action="{{ route('landlord_store') }}" method="post">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-md-2">Full Name</label>
                        <div class="col-md-4">
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="exampleInputEmail1"
                                   name="name"
                                   value="{{ old('name') }}"
                                   aria-describedby="emailHelp"
                                   placeholder="Enter LandLord Name">


                            @error('name')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong</span>
                            @enderror
                        </div>

                        <label for="exampleInputEmail1" class="col-md-1">ID NO</label>

                        <div class="col-md-4">
                            <input type="text"
                                   class="form-control @error('id_no') is-invalid @enderror"
                                   id="exampleInputEmail1"
                                   name="id_no"
                                   value="{{ old('id_no') }}"
                                   aria-describedby="emailHelp"
                                   placeholder="Enter Landlord IDno">


                            @error('id_no')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-md-2">Email</label>

                        <div class="col-md-4">
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="exampleInputEmail1"
                                name="email"
                                aria-describedby="emailHelp"
                                value="{{ old('email') }}"
                                placeholder="Enter Email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <label for="exampleInputEmail1" class="col-md-1">Phone Number</label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                id="exampleInputEmail1"
                                name="phone_number"
                                aria-describedby="emailHelp"
                                value="{{ old('phone_number') }}"
                                placeholder="Enter Phone Number">

                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>



                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-md-2">Account Name</label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('account_name') is-invalid @enderror"
                                id="exampleInputEmail1"
                                name="account_name"
                                aria-describedby="emailHelp"
                                value="{{ old('account_name') }}"
                                placeholder="Enter Account name">
                            @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>


                        <label for="exampleInputEmail1" class="col-md-1">Account number</label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('account_number') is-invalid @enderror"
                                id="exampleInputEmail1"
                                name="account_number"
                                aria-describedby="emailHelp"
                                value="{{ old('account_number') }}"
                                placeholder="Enter Account number">
                            @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-md-2"> Bank </label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('bank') is-invalid @enderror"
                                id="exampleInputEmail1"
                                name="bank"
                                value="{{ old('bank') }}"
                                aria-describedby="emailHelp"
                                placeholder="Enter Bank Details">
                            @error('bank')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>

                        <label for="exampleInputEmail1" class="col-md-1"> Address </label>

                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control @error('address') is-invalid @enderror"
                                id="exampleInputEmail1"
                                name="address"
                                value="{{ old('address') }}"
                                aria-describedby="emailHelp"
                                placeholder="Address">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-md-2"> Commission Type </label>

                        <div class="col-md-4">
                            <select
                                class="select2 form-control"
                                name="commission_type"
                            >
                                <option value="dynamic">Percentage</option>
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
                                type="text"
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
                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('js')

    <script>

    </script>
@endsection
