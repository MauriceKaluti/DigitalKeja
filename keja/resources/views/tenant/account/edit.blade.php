@extends('layouts.master')
@section('title','Add payment for :'. $tenant->name . " of amount: ". $account->total())

@section('content')

    @component('layouts._box')
        <form
            method="post"
            action="{{ route('tenant.pay.update', ['tenant' => $tenant->id, 'account' => $account->id]) }}"
            class="form-horizontal"
            autocomplete="off"
            enctype="multipart/form-data"
        >
            {{ csrf_field() }}

            <div class="form-group">
                @foreach($account->tenantAccountItems as $roomUtility)

                    @if($loop->iteration  % 2 == 0)

                        <div class="form-group">
                    @endif

                <label class="amount control-label @if($loop->iteration  % 2 == 0)col-md-1 @else col-md-2 @endif">{{ ucwords(strtolower( $roomUtility->item))  }}</label>
                <div class="col-md-4">
                    <input
                        type="text"
                        name="amount[{{strtolower( $roomUtility->id)}}]"
                        class="form-control @error('amount') invalid-feedback @enderror"
                        value="{{ $roomUtility->amount }}"
                    >
                </div>
                    @if($loop->iteration  % 2 == 0)
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="modal-footer">
                <div class="form-row">
                    <button class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    @endcomponent

@endsection
@section('js')
    @include('layouts._form-scripts')
    @include('layouts._datepicker')
    <script>
        $('input.date').datepicker({
            endDate: new Date()
        })
        $('input.month_date').datepicker({
            endDate: new Date(),
            format:'yyyy-m'
        })
    </script>
@endsection
