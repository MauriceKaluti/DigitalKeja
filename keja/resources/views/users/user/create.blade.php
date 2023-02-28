@extends('layouts.master')
@section('title','Create User')
@section('extra_css')
@endsection

@section('content')

    <div >
        @can('browse_user')
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="{{ route('user_browse') }}" class="btn btn-block"> Back To Users </a>
                </li>
            </ul>
        @endcan

    </div>

    <form class="form-horizontal" action="{{ route('user_store') }}" method="post">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-md-2 control-label">Full Name</label>

                <div class="col-md-4">
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="exampleInputEmail1"
                           name="name"
                           value="{{ old('name') }}"
                           aria-describedby="emailHelp"
                           placeholder="Enter Staff Name">


                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <label for="exampleInputEmail1" class="col-md-2 control-label">Email</label>

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
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-md-2 control-label">Phone Number</label>
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

                <label for="exampleInputEmail1" class="col-md-2 control-label">Password</label>

                <div class="col-md-4">
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="exampleInputEmail1"
                        name="password"
                        aria-describedby="emailHelp"
                        placeholder="Enter Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        <div class="form-group">
                <label for="exampleInputEmail1"  class="col-md-2 control-label">Confirm Password</label>
                <div class="col-md-4">
                    <input
                        type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        id="exampleInputEmail1"
                        name="password_confirmation"
                        aria-describedby="emailHelp"
                        placeholder="Confirm the password">
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="exampleInputEmail1" class="col-md-2 control-label">Select Roles</label>
            <div class="col-md-4">
                <select
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    name="role_id"
                >
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"> {{ $role->name }}</option>
                    @endforeach
                </select>

                @error('role_id')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <script>
        $('#example').dataTable();
    </script>
@endsection
