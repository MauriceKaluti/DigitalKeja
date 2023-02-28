@extends('layouts.master')
@section('title','Journal Entries')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />

@endsection
@section('content')

    <div class="row">

        <div class="col-md-12">

            <a href="{{ route('chart.journal.create') }}" class="box-title btn btn-primary">Create</a>

            <div class="box box-white">
                <div class="box-heading clearfix">

                </div>
                <div class="box-body">

                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-1 control-label"> Account</label>
                            <div class="col-md-4">
                                <select class="select2" name="account_id">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary">Pull</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $debit = 0; $credit = 0?>
                            @foreach($journals as $index => $journal)
                                <?php
                                $debit += $journal->sum('debit');
                                $credit += $journal->sum('credit')
                                ?>
                                <tr>

                                    <td>{{ $index }}</td>
                                    <td>{{ number_format($journal->sum('debit') , 2) }}</td>
                                    <td>{{ number_format($journal->sum('credit') , 2) }}</td>
                                    <td>
                                        @component('layouts._button')

                                                <li> <a href="{{ route('chart.journal.show',['account' => request('account_id')]) }}">View</a></li>

                                        @endcomponent
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>Totals</td>

                                <td>{{ number_format($debit , 2) }}</td>
                                <td>{{ number_format($credit, 2) }}</td>

                                <td> -- </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('extra_js')

    @include('layouts._form-scripts')
    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <!-- datepicker -->

    <script>
        $('#example').dataTable();
    </script>
@endsection
