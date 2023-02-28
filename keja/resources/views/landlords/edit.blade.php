@extends('layouts.master')
@section('title') New Landlord @endsection
@section('content')
<div class="box">

    <div class="box-body">
        @can('browse_landlords')
            <ul class="nav nav-pills">
                <li class="">
                    <a href="{{ route('landlord_browse') }}" class="btn btn-outline-primary"> Back To Landlords </a>
                </li>
            </ul>
        @endcan

    </div>
</div>

    <div class="box">
        <div class="box-body">
            <div class="">
                <div class="col-md-12">
                    <div class="card card-white">
                        <div class="card-heading clearfix">
                            <h4 class="card-title"></h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('landlord_update', ['landlord' => $landlord->id]) }}"
                                  method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}



                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="col-md-2">Full Name</label>
                                        <div class="col-md-4">
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="exampleInputEmail1"
                                                   name="name"
                                                   value="{{ old('name' , $landlord->name) }}"
                                                   aria-describedby="emailHelp"
                                                   placeholder="Enter LandLord Name">


                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>

                                        <label for="exampleInputEmail1" class="col-md-1">ID NO</label>

                                        <div class="col-md-4">
                                            <input type="text"
                                                   class="form-control @error('id_no') is-invalid @enderror"
                                                   id="exampleInputEmail1"
                                                   name="id_no"
                                                   value="{{ old('id_no' , $landlord->id_no) }}"
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
                                                value="{{ old('email' , $landlord->email) }}"
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
                                                value="{{ old('phone_number' , $landlord->phone_number) }}"
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
                                                value="{{ old('account_name' , $landlord->account_name) }}"
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
                                                value="{{ old('account_number', $landlord->account_number) }}"
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
                                                value="{{ old('bank', $landlord->bank) }}"
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
                                                value="{{ old('address', $landlord->address) }}"
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
                                        <label for="exampleInputEmail1" class="col-md-2"> Status </label>
                                        <div class="col-md-4">
                                            <select
                                                class="form-control"
                                                name="status"
                                            >
                                                <option
                                                    @if($landlord->is_active) selected @endif
                                                value="1">Active
                                                </option>

                                                <option
                                                    @if(! $landlord->is_active) selected @endif
                                                value="0">
                                                    Not Active
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                        <button type="submit" class="btn btn-success">UPDATE</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
