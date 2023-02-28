@extends('layouts.master')
@section('title','Create a journal entry')
@section('content')
    <section class="content">
        <div class="row">
            <div class="box box-info">
                <div class="box-heading">
                    <h4 class="box-title"></h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('chart.journal.store') }}">
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-md-2">Debit</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="debit_account">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-md-2"> Amount</label>
                            <div class="col-md-4">
                               <input type="number" name="debit_amount" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Credit</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="credit_account">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-md-2"> Amount</label>
                            <div class="col-md-4">
                               <input type="number" name="credit_amount" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2"> Transaction Date</label>
                            <div class="col-md-4">
                               <input type="text" name="transaction_date" class="form-control date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2"> Comments</label>
                            <div class="col-md-10">
                               <textarea class="form-control" name="comment" rows="7"></textarea>
                            </div>

                        </div>

                        <div class="box-footer justify-content-around" style="align-content: center">
                            <button class="btn btn-sm btn-success align-content-center text-center col-lg-offset-6">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    @include('layouts._form-scripts')
    @include('layouts._datepicker')
    <script>
        $('.date').datepicker({
            endDate: new Date()
        })
    </script>
@endsection
