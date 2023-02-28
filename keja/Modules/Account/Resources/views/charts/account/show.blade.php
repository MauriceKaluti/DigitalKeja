@extends('layouts.master')
@php
$parentName = isset($parent->id) ? $parent->name . ' / ' : " ";
    @endphp
@section('title', $chart->name .' / ' . $parentName.'  '  . $account->name )
@section('content')

    <div class="box box-body">
        <a href="{{ route('account.create') }}" class="box-title btn btn-success">Create</a>
        <a href="{{ route('chart.show' ,['chart'  => $chart->id]) }}" class="btn btn-primary mb-5">back</a>
    </div>

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h6 class="text-center">Chart Name</h6>

                    <h3 class="profile-username text-center">{{ $chart->name }}</h3>
                    <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">
                            <b>Account Name</b> <a class="pull-right"> {{ $account->name }}</a>

                        </li>
                        <li class="list-group-item">
                            <b>GlCode</b> <a class="pull-right"> {{ $account->glcode }}</a>

                        </li>

                        <li class="list-group-item">
                            <b>Parent Account</b> <a class="pull-right"> {{ isset($account->parent->id) ? $account->parent->name : null  }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Children Accounts</b> <a class="pull-right"> {{ $account->children->count() }}</a>

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
                    <li class="active"><a href="#accounts" data-toggle="tab">Children Accounts</a></li>
                    <li><a href="#edit" data-toggle="tab">Edit Accounts</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="accounts">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">

                                <div class="table-responsive">
                                    <table id="example" class="display table" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th width="20%">Name</th>
                                            <th>GlCode </th>
                                            <th width="20%">Children Accounts </th>
                                            <th width="20%">Parent Account </th>
                                            <th>Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($account->children as $account)
                                            <tr>
                                                <td>{{ $account->name }}</td>
                                                <td>{{ $account->glcode }}</td>
                                                <td>{{ $account->children->count() }}</td>
                                                <td>{{ isset($account->parent->name) ? $account->parent->name : null }}</td>
                                                <td>
                                                    @component('layouts._button')
                                                        @can('read_invoices')
                                                            <li>
                                                                <a href="{{ route('chart.account.show',['chart' => $chart->id , 'account' => $account->id]) }}">View</a>
                                                            </li>
                                                        @endcan
                                                    @endcomponent
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.post -->
                        </div>
                    </div>

                    <div class="tab-pane" id="edit">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <form class="form-horizontal" action="{{ route('chart.account.update', ['account' => $account->id ,'chart' => $chart->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    @method('PATCH')
                                    <input type="hidden" name="account_id" value="{{ $account->id }}">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="col-md-2">Chart Of Account </label>
                                            <div class="col-md-4">

                                                <select
                                                    class="select2 form-control"
                                                    name="chart_id"
                                                >
                                                    @foreach($charts as $chart)
                                                        <option
                                                            value="{{ $chart->id }}"
                                                            @if($chart->id == $account->chart->d) selected @endif
                                                        >{{ $chart->name }}</option>
                                                    @endforeach

                                                </select>


                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>

                                            <label for="exampleInputEmail1"
                                                   class="col-md-2"> {{ __('Parent') }} </label>

                                            <div class="col-md-4">

                                                <select
                                                    class="select2 form-control"
                                                    name="parent_id"
                                                >
                                                    <option value=""> -Select parent-</option>
                                                    @foreach($parents as $parent)
                                                        <option
                                                            @if( isset($account->parent->id) && $parent->id == $account->parent->id) selected
                                                            @endif
                                                            value="{{ $parent->id }}"
                                                        >{{ $parent->name }}</option>
                                                    @endforeach

                                                </select>


                                                @error('id_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="has_children" class="col-md-2">{{ __('Has Children') }}</label>

                                            <div class="col-md-4">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input @error('has_children') is-invalid @enderror"
                                                    id="has_children"
                                                    name="has_children"
                                                    aria-describedby="emailHelp"
                                                    @if($account->has_children) checked @endif
                                                    placeholder="Has children">
                                                @error('has_children')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="allow_manual_entry"
                                                   class="col-md-2">{{ __('Allow Manual Entry') }}</label>

                                            <div class="col-md-4">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input @error('allow_manual_entry') is-invalid @enderror"
                                                    id="allow_manual_entry"
                                                    name="allow_manual_entry"
                                                    aria-describedby="allow_manual_entry"


                                                    @if($account->allow_manual_entry) checked @endif
                                                    placeholder="Has children">
                                                @error('allow_manual_entry')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label for="glcode" class="col-md-2">{{ __('GLCODE') }}</label>

                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control @error('glcode') is-invalid @enderror"
                                                    id="glcode"
                                                    name="glcode"
                                                    aria-describedby="glcode"
                                                    value="{{ $account->glcode }}"
                                                    placeholder="Enter Account glcode">
                                                @error('glcode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>


                                            <label for="account_name" class="col-md-2">{{ __('Account Name') }}</label>

                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="account_name"
                                                    name="name"
                                                    aria-describedby="emailHelp"
                                                    value="{{ $account->name}}"
                                                    placeholder="Enter Account Name">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label for="description" class="col-md-2"> Description </label>

                                            <div class="col-md-10">
                                                <textarea
                                                    type="text"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    id="description"
                                                    name="description"
                                                    rows="4"
                                                    aria-describedby="description"
                                                    placeholder="e.g. 7 0r 3000">{!! $account->description !!}</textarea>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="card-footer">

                                            <button type="submit" class="btn btn-primary"> Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>

    </div>



@endsection
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}"/>
@endsection
@section('extra_js')
    @include('layouts._form-scripts')
    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    @include('layouts._datepicker')
    <script>
        $('#example').dataTable();
        $('table.tenant-table , table.disburse-table ,  table.payment-report-table').dataTable();
        $("input.date").datepicker()
        $('a.sidebar-toggle').trigger('click')
    </script>
@endsection
