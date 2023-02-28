@extends('layouts.master')
@section('title','Manage Expenses')
@section('content')

    <ul class="nav nav-pills">
        <li>
            <a href="{{ route('payment_expenses') }}"> Back</a>
        </li>
    </ul>
    <form
        method="post"
        action="{{ isset($expense->id) ? route('payment_expenses_update', ['expense' => $expense->id]) : route('payment_expenses_store') }}"
        autocomplete="off"
        class="form-horizontal">
        {{ csrf_field() }}
        @if( isset($expense->id)) {{ method_field('PATCH') }} @endif

        <div class="form-group">
            <label for="amount" class="col-md-2 control-label">{{ trans('general.amount') }}</label>
            <div class="col-md-4">
                <input
                    name="amount"
                    class="form-control"
                    value="{{ old('amount',  $expense->amount) }}"
                >
                @error('amount')<span class="help-block"><strong>{{ $message }}</strong></span> @enderror
            </div>
            <label for="amount" class="col-md-2 control-label">{{ trans('general.type') }}</label>
            <div class="col-md-4">
                <select
                name="type"
                class="form-control select2"
                >
                    <option
                        @if( isset($expense->id) && $expense->type == 'withdraw') selected @endif
                        value="withdraw">
                        Withdraw
                    </option>
                    <option
                        @if( isset($expense->id) && $expense->type == 'deposit') selected @endif
                        value="deposit">
                        Deposit
                    </option>
                </select>
                @error('type')<span class="help-block"><strong>{{ $message }}</strong></span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="amount" class="col-md-2 control-label">{{ trans('general.amount') }}</label>
            <div class="col-md-4">
                <textarea
                    class="form-control"
                    rows="5"
                    cols="10"
                    name="note"
                    placeholder="bought KPLC TOKENS">{{ old('note' , $expense->note) }}</textarea>
                @error('note')<span class="help-block"><strong>{{ $message }}</strong></span> @enderror
            </div>
        </div>

        <button class="btn btn-info"> @if( isset($expense->id)) UPDATE @else SUBMIT @endif</button>

    </form>


@endsection
@section('js')
    @include('layouts._datatable')
    @include('layouts._form-scripts')
    <script>
        $('table').DataTable()
    </script>
@endsection
