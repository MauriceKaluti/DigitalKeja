@extends('layouts.master')
@section('title','Payments')
@section('content')

    <form autocomplete="off">
        <div class="form-group mb-2">
            <label class="mr-2 ml-2">Start Date</label>
            <input name="start_date" class="date" value="{{ old('start_date', request()->has('start_date') ? request('start_date') : '' )  }}">
            <label class="mr-2 ml-2">End Date</label>
            <input name="end_date" class="date" value="{{ old('end_date', request()->has('end_date') ? request('end_date') : '' ) }}">

            @foreach(paymentMethods() as $method)
                <label class="mr-2 ml-2">{{ ucfirst(strtolower($method)) }}</label>
            <input name="payment_method" type="radio" @if(request()->has('payment_method') && request('payment_method') == $method ) checked @endif value="{{ $method }}">
           @endforeach

            <button type="submit" class="ml-2 mr-2 btn btn-info btn-rounded">Get</button>
        </div>
    </form>

    <div class=" divider">
    </div>

    @include('reports.payment._data')
@endsection

@section('js')
    @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>
@endsection
