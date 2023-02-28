@extends('layouts.master')
@section('title','Mpesa Payment Report')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />
@endsection
@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="card card-white">
                <div class="card-body">

                    <div class="mb-2">

                        <button type="button" class="btn-outline-primary">Download PDF</button>
                        <button type="button" class="btn-outline-primary">Download Excel</button>
                    </div>

                    @include('reports.payment.mpesa._data')
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
