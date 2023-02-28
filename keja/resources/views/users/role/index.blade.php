@extends('layouts.master')
@section('title','Create Roles')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />
@endsection

@section('content')

    <ul class="nav nav-pills mb-3">
        @can('add_role')
            <li class="active">
                <a href="{{ route('user_role_create') }}" class="btn btn-success">  New Role </a>
            </li>
        @endcan
    </ul>

    <div class="row">

        <div class="col-md-12">
            <div class="card card-white">
                <div class="card-heading clearfix">
                    <h4 class="card-title">Manage Users Permissions</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example" class="table-striped display table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                @can('edit_role')<th>Actions</th> @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    @can('edit_role')
                                        <td><a class="label label-primary" href="{{ route('user_role_edit',['role' => $role->id]) }}">Edit</a> </td>
                                    @endcan
                                </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <script>
        $('#example').dataTable();
    </script>
@endsection
