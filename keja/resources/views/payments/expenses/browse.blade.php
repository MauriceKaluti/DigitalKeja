@extends('layouts.master')
@section('title','Manage Expenses')
@section('content')

    <ul class="nav-pills nav" style="display: inline-block">
        <li><a href="{{ route('payment_expenses_create') }}"> Create</a></li>
        <li class="nav-item"><a class="btn btn-warning" href="{{ route('payment_expenses') }}"> All Expenses </a></li>
    </ul>

    <form autocomplete="off">
        <div class="form-group mb-2">
            <label class="mr-2 ml-2">Start Date</label>
            <input name="start_date" class="date" value="{{ old('start_date', request()->has('start_date') ? request('start_date') : '' )  }}">
            <label class="mr-2 ml-2">End Date</label>
            <input name="end_date" class="date" value="{{ old('end_date', request()->has('end_date') ? request('end_date') : '' ) }}">

            @foreach(['deposit','withdraw'] as $method)
                <label class="mr-2 ml-2">{{ ucfirst(strtolower($method)) }}</label>
                <input name="expense_type" type="radio" @if(request()->has('expense_type') && request('expense_type') == $method ) checked @endif value="{{ $method }}">
            @endforeach

            <button type="submit" class="ml-2 mr-2 btn btn-info btn-rounded">Get</button>
        </div>
    </form>

    <div class=" divider">
    </div>

    <div class="clearfix divider"></div>
            <div class="table-responsive">
                <table class="table-striped table display" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>User Responsible</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $expense)
                        <tr>
                            <td> {{ $expense->id}}</td>
                            <td> {{ $expense->created_at->format($date_format) }}</td>
                            <td> {{ $expense->user->name }}</td>
                            <td> {{ number_format($expense->amount , 2) }}</td>
                            <td> {{ $expense->type }}</td>
                            <td> {{ $expense->note }}</td>
                            <td>
                                @component('layouts._button')
                                    <li><a href="{{ route('payment_expenses_edit', ['expense' => $expense->id]) }}"> Edit</a> </li>
                                @endcomponent
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        @php $result = ($expenses->where('type','deposit')->sum('amount')
                         -
                        $expenses->where('type','withdraw')->sum('amount')) @endphp
                        <th colspan="3"> @if(request()->has('expense_type')) Total @else Balance @endif: </th>
                        <th colspan="4">{{ setting('company_currency') .'  '.
                        number_format( $result  < 1 ? (-1 * $result) : $result , 2) }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

@endsection
@section('js')
    @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>
@endsection
