@extends('layouts.master')
@section('title','Manage Invoices')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />


    <!-- bootstrap-datepicker plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection


@section('content')

    <ul class="nav-pills nav mb-4">

        <li class="mr-2">
            <a href="{{ route('invoice_browse',['payment_status' => 'paid']) }}" class="btn btn-outline-success"> {{ __('general.paid') }} </a>
        </li>
        <li class="mr-2">
            <a href="{{ route('invoice_browse' ,['payment_status' => 'partially paid'] ) }}" class="btn btn-outline-warning">{{ __('general.partially_paid') }} </a>
        </li>
        <li class="mr-2">
            <a href="{{ route('invoice_browse',['payment_status' => 'un paid'] ) }}" class="btn btn-outline-danger"> {{ __('general.un_paid') }}  </a>
        </li>
    </ul>

    <form autocomplete="off" class="mt-3">
        <div class="form-row mb-2">
            <label class="mr-2 ml-2">{{ __( trans('general.start') .' '. trans('general.date') ) }} </label>
            <input name="start_date" class="date" value="{{ old('start_date', request()->has('start_date') ? request('start_date') : '' )  }}">
            <label class="mr-2 ml-2">{{ __( trans('general.end') .' '. trans('general.date') ) }}</label>
            <input name="end_date" class="date" value="{{ old('end_date', request()->has('end_date') ? request('end_date') : '' ) }}">
            <label class="mr-2 ml-2">{{ __( trans('general.end') .' '. trans('general.date') ) }}</label>
            <label for="exampleInputEmail1" class="mr-2 ml-2"> Status </label>
            <select
                name="payment_status"
            >
                <option
                    @if(request()->has('payment_status') && request('payment_status') == 'paid') selected @endif
                value="paid"
                >Paid</option>

                <option
                    @if(request()->has('payment_status') && request('payment_status') == 'partially paid') selected @endif
                    value="partially paid">
                    Partially Paid
                </option>
                <option
                    @if(request()->has('payment_status') && request('payment_status') == 'un paid') selected @endif
                    value="un paid">Un Paid</option>
            </select>

            <button type="submit" class="ml-2 mr-2 btn btn-outline-primary">{{ trans('general.get') }}</button>
        </div>
    </form>
    <div class="row">

        <div class="col-md-12">
            <div class="box box-white">
                <div class="box-heading clearfix">
                    <h4 class="box-title">Manage Invoices</h4>
                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table id="example" class="display table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Tenant</th>

                            </tr>
                            </thead>
                            <tbody>

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
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <script>

        $('input.date').datepicker();

        $(function () {

            var table = $('table#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('invoice_browse') }}",
                columns: [

                    {data: 'tenant', name: 'tenant'},

                ]
            });

        });
    </script>
@endsection
