@extends('layouts.master')
@section('title','Disburse Payment to Landlords')
@section('content')
    <form
        method="post"
        autocomplete="off"
        action="{{ route('landlord_disburse_store') }}"
        autocapitalize="off"
        class="form-horizontal">
        @csrf
        <div class="form-group">
            <label for="landlord" class="control-label col-md-2">{{ trans('general.landlord') }}</label>
            <div class="col-md-4">
                <select
                    name="landlord_id"
                    class="form-control select2"
                >
                    @foreach($landlords as $landlord)
                        <option
                            value="{{ $landlord->id }}"
                        > {{ $landlord->name }}</option>
                    @endforeach
                </select>
            </div>
            <label for="amount" class="control-label col-md-2">{{ trans('general.amount') }}</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="amount"
                    class="form-control @error('amount') invoice-title @enderror"
                    value="{{ old('amount') }}"
                >
            </div>
        </div>





        <div class="form-group">
            <label for="amount" class="control-label col-md-2">{{ trans('general.payment_method') }}</label>
            <div class="col-md-4">
                <select
                    name="payment_method"
                    id="payment_method"
                    class="select2 form-control">
                    @foreach(paymentMethods()  as $method)

                        <option>{{ $method }}</option>
                    @endforeach
                </select>
            </div>

            <label for="reference_no" class="control-label col-md-2">{{ trans('general.reference_no') }}</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="reference_number"
                    class="form-control"
                    value="{{ old('reference_number') }}"
                >
            </div>
        </div>
        <div class="form-group">
            <label for="date" class="control-label col-md-2">{{  trans('general.disburse') .'  ' .trans('general.date') }}</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="disburse_at"
                    class="form-control"
                    id="date"
                    value="{{ old('disburse_at') }}"
                >
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-success">Disburse</button>
        </div>


    </form>
@endsection
@section('js')
    @include('layouts._form-scripts')
    @include('layouts._datepicker')
    <script>
        $('input#date').datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: +1
        });
    </script>
@endsection
