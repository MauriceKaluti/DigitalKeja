@extends('layouts.master')
@section('content')

    <div class="row mb-2 align-content-center offset-5">
        @can('browse_tenant')
            <ul class="nav nav-pills">
                <li class="">
                    <a href="{{ route('tenant_view',['tenant' => $tenant->id]) }}" class="btn btn-outline-primary"> Details</a>
                    <a href="{{ route('tenant_browse') }}" class="btn btn-outline-danger"> Back To Tenant List </a>
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
                    <form class="form-horizontal" action="{{ route('tenant_update', ['tenant' => $tenant->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="exampleInputEmail1"
                                   name="name"
                                   value="{{ old('name', $tenant->name) }}"
                                   aria-describedby="emailHelp"
                                   placeholder="Enter Tenant Name">


                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="form-group">
                                <label for="exampleInputEmail1">ID NO</label>
                                <input type="text"
                                       class="form-control @error('id_no') is-invalid @enderror"
                                       id="exampleInputEmail1"
                                       name="id_no"
                                       value="{{ old('id_no' , $tenant->id_no) }}"
                                       aria-describedby="emailHelp"
                                       placeholder="Enter Tenant ID No">


                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <label for="exampleInputEmail1">Email</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="exampleInputEmail1"
                                    name="email"
                                    aria-describedby="emailHelp"
                                    value="{{ old('email', $tenant->email) }}"
                                    placeholder="Enter Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone Number</label>
                                <input
                                    type="text"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    id="exampleInputEmail1"
                                    name="phone_number"
                                    aria-describedby="emailHelp"
                                    value="{{ old('phone_number' , $tenant->phone_number) }}"
                                    placeholder="+2547xx xxx xxx">

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> Address </label>
                                <input
                                    type="text"
                                    class="form-control @error('address') is-invalid @enderror"
                                    id="exampleInputEmail1"
                                    name="address"
                                    value="{{ old('address', $tenant->address) }}"
                                    aria-describedby="emailHelp"
                                    placeholder="Address. e.g P.O BOX 65 (00100), Nairobi">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Status </label>
                                <select
                                    class="form-control"
                                    name="status"
                                    >
                                    <option
                                        @if($tenant->is_active) selected @endif
                                        value="1">Active</option>

                                    <option
                                        @if(! $tenant->is_active) selected @endif
                                        value="0">
                                        Not Active
                                    </option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="card-footer">

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
