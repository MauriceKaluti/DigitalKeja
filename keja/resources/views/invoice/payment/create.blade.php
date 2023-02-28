@extends('layouts.master')
@section('title','Add payment for :'. $invoice->lease->tenant->name)

@section('content')


    <ul class="nav nav-pills mb-2">
        <li>
            <a href="{{ route('invoice_show', ['invoice' => $invoice->id]) }}" class="btn btn-outline-primary">Back</a>
        </li>
    </ul>
    <form
        method="post"
        action="{{ route('invoice_payment_store', ['invoice' => $invoice->id]) }}"
        class="form-horizontal"
        autocomplete="off"
        enctype="multipart/form-data"
    >
        {{ csrf_field() }}
        <div class="form-group">
            <label class="amount control-label col-md-2">Amount</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="amount"
                    class="form-control @error('amount') invalid-feedback @enderror"
                    value="{{ old('amount') }}"
                >
            </div>
            <label class="amount control-label col-md-1">Payment Method</label>
            <div class="col-md-4">
                <select
                    name="payment_method"
                    class="form-control select2"

                >
                    @foreach(paymentMethods() as $method)
                        <option value="{{ $method }}">{{ $method }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="amount control-label col-md-2">Reference Number</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="reference_code"
                    class="form-control @error('reference_code') invalid-feedback @enderror"
                    value="{{ old('reference_code') }}"
                >
            </div>
            <label class="amount control-label col-md-1">Deposit Date</label>
            <div class="col-md-4">
                <input
                    type="text"
                    name="deposit_at"
                    class="form-control date @error('deposit_at') invalid-feedback @enderror"
                    value="{{ old('deposit_at') }}"
                >
            </div>
        </div>

        <div class="form-group">
            <label class="amount control-label col-md-2">Upload Receipt</label>
            <div class="col-md-4">
                <input
                    type="file"
                    name="receipt"
                    class="form-control @error('receipt') invalid-feedback @enderror"
                    value="{{ old('receipt') }}"
                >
            </div>
        </div>
        <div class="modal-footer">
            <div class="form-row">
                <button class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>

@endsection
@section('js')
    @include('layouts._form-scripts')
    @include('layouts._datepicker')
    <script>
        $('input.date').datepicker({
            maxDate: 0
        })
    </script>
@endsection
