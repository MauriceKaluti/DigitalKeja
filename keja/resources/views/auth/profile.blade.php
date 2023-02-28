@extends('layouts.master')
@section('title', $user->name.' Profile')

@section('content')

<div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{ asset('storage/'. setting('company_logo')) }}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">{{ $user->roles->first()->name }}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>E-Mail</b> <a class="pull-right">{{ $user->email }}</a>
                            </li>

                        </ul>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                        <li><a href="#payment" data-toggle="tab">Payment Received</a></li>
                    </ul>
                    <div class="tab-content">


                        <div class="active tab-pane" id="settings">
                            <form class="form-horizontal" action="{{ route('user_update', ['user' => auth()->id()]) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <label for="inputName"  class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" name="email"  value="{{ $user->email }}" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Phone Number</label>

                                    <div class="col-sm-10">
                                        <input type="tel" name="phone_number"  value="{{ $user->phone_number }}" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">

                                        <input type="password" name="password" class="form-control" id="inputName" placeholder="password  ">
                                        <span class="help-block">
                                            <p>Leave empty to keep it the same</p>
                                        </span>
                                    </div>
                                </div>
                                @can('edit_user')
                                <div class="form-group">
                                    <label for="exampleInputEmail1"  class="col-sm-2 control-label">Select Roles</label>

                                    <div class="col-sm-10">


                                        <select
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="role_id"
                                        >
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}"
                                                        @if( $user->hasRole($role->name)) selected @endif
                                                > {{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endcan

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="payment">
                            <form autocomplete="off">
                                <div class="form-row mb-2">
                                    <label class="mr-2 ml-2">Start Date</label>
                                    <input name="start_date" class="date" value="{{ old('start_date', request()->has('start_date') ? request('start_date') : '' )  }}">
                                    <label class="mr-2 ml-2">End Date</label>
                                    <input name="end_date" class="date" value="{{ old('end_date', request()->has('end_date') ? request('end_date') : '' ) }}">
                                    <label class="mr-2 ml-2">Mpesa</label>
                                    <input name="payment_method" type="radio" @if(request()->has('payment_method') && request('payment_method') == 'mpesa' ) checked @endif value="mpesa">
                                    <label class="mr-2 ml-2">Cash</label>
                                    <input name="payment_method" type="radio" @if(request()->has('payment_method') && request('payment_method') == 'cash') checked @endif value="cash">

                                    <button type="submit" class="ml-2 mr-2 btn btn-primary">Get</button>
                                </div>
                            </form>
                            @include('reports.payment._data')
                        </div>

                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>

@endsection
@section('extra_css')
    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}"/>

    <!-- bootstrap-datepicker plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection
@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script>
        $('input.date').datepicker();
        $('#example').DataTable();
    </script>
@endsection
