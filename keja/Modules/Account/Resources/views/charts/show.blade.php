@extends('layouts.master')
@section('title',$chart->name.' Details')
@section('content')

  <div class="box box-body">
      <a href="{{ route('account.create') }}" class="box-title btn btn-success">Create</a>
      <a href="{{ route('chart.index') }}" class="btn btn-primary mb-5">back</a>
  </div>

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">


                    <h4 class="text-center text-capitalize">{{ __('chart name') }}</h4>
                    <h3 class=" text-center">{{ $chart->name }}</h3>
                    <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">
                            <b>Accounts</b> <a class="pull-right"> {{ $chart->accounts->count() }}</a>

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

                    <li class="active"><a href="#accounts" data-toggle="tab"> Accounts</a></li>

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
                                        @php $accounts = $chart->firstLevelChildren->count() ? $chart->firstLevelChildren : $chart->accounts  @endphp

                                        @foreach($accounts as $account)
                                            <tr>
                                                <td>{{ $account->name }}</td>
                                                <td>{{ $account->glcode }}</td>
                                                <td>{{ $account->children->count() }}</td>
                                                <td>{{ isset($account->parent->name) ? $account->parent->name : null }}</td>
                                                <td>
                                                    @component('layouts._button')
                                                        @can('read_invoices')
                                                            <li> <a href="{{ route('chart.account.show',['chart' => $chart->id , 'account' => $account->id]) }}">View</a></li>
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
