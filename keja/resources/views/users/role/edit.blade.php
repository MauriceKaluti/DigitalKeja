@extends('layouts.master')
@section('title','Update Role: '. $role->name)
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />
@endsection

@section('content')

        <ul class="nav nav-pills">
            <li class="active">
                <a href="{{ route('user_role') }}" class="btn btn-rounded btn-block"> Back To Roles </a>
            </li>
        </ul>
        <form class="form-horizontal" action="{{ route('user_role_update', ['role' => $role->id]) }}" method="post">
                        {{ csrf_field() }}

                        {{ method_field('patch') }}

                        <div class="form-group">
                            <label for="exampleInputEmail1" class="control-label col-md-2">Role Name</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control col-md-4"
                                       id="exampleInputEmail1"
                                       name="name"
                                       value="{{ $role->name }}"
                                       aria-describedby="emailHelp"
                                       placeholder="Enter Role Name">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="permission" class="col-md-2 control-label">Select Permissions</label>
                            <div class="col-md-10">
                                @foreach($permissions->groupBy('module') as $module => $permissionGroups)
                                    <h4 class="" style="border-bottom: 1px solid #cccccc">
                                        <b>{{ str_replace("_"," ",  ucwords(strtolower($module))) }} Permissions</b>
                                    </h4>


                                    @foreach($permissionGroups->chunk(4) as $permissionChunked)

                                        <div class="col-md-12">
                                            @foreach($permissionChunked as $permission)
                                                <div class="col-md-6" style="margin-bottom: 10px">
                                                    <input
                                                        id="permission"
                                                        type="checkbox"
                                                        name="permission_id[]"
                                                        class="checkbox-inline"
                                                        value="{{ $permission->id }}"
                                                        @if(in_array($permission->id , $role->getAllPermissions()->pluck('id')->toArray()))
                                                        checked
                                                        @endif
                                                    >
                                                    {{ str_replace("_"," ",  ucwords(strtolower($permission->name))) }}
                                                </div>
                                            @endforeach

                                        </div>

                                    @endforeach

                                @endforeach
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
