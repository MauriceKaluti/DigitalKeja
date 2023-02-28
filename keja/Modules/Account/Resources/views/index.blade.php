@extends('layouts.master')
@section('title','Charts of account')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />

@endsection
@section('content')


    <div class="row">

        <div class="col-md-12">

            @can('view_chart')
                <a href="{{ route('account.create') }}" class="box-title btn btn-primary">Create</a>

            @endcan
            <div class="box box-white">
                <div class="box-heading clearfix">

                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>GLCode</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($charts as $chart)
                                <tr>
                                    <td>{{ $chart->name }}</td>
                                    <td>{{ $chart->glcode }}</td>
                                    <td>
                                        @component('layouts._button')
                                            @can('read_invoices')
                                                <li> <a href="{{ route('chart.show',['chart' => $chart->id]) }}">View</a></li>
                                            @endcan
                                        @endcomponent
                                    </td>
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

    <!-- datepicker -->

    <script>
        $('#example').dataTable();
    </script>
@endsection
