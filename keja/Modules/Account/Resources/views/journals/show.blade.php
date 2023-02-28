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

            <a href="{{ route('chart.journal') }}" class="box-title btn btn-primary">Back</a>

            <div class="box box-white">
                <div class="box-heading clearfix">

                </div>
                <div class="box-body">



                    <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>GLCode</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Payment Ref</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($journals as $journal)
                                <tr>
                                    <td>{{ $journal->created_at }}</td>
                                    <td>{{ $journal->account->name }}</td>
                                    <td>{{ $journal->account->glcode }}</td>
                                    <td>{{ number_format($journal->debit , 2) }}</td>
                                    <td>{{ number_format($journal->credit , 2) }}</td>
                                    <td>{{ isset($journal->payment->reference_code ) ? $journal->payment->reference_code  : 'Excepted'  }}</td>
                                    <td>{{ $journal->narration }}</td>
                                    <td>
                                        @component('layouts._button')

                                            <li> <a href="{{ route('chart.journal.show',['journal' => $journal->id]) }}">View</a></li>

                                        @endcomponent
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>Totals</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{ number_format($journals->sum('debit') , 2) }}</td>
                                <td>{{ number_format($journals->sum('credit') , 2) }}</td>
                                <td> -- </td>
                                <td> -- </td>
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
