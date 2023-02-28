<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
use App\BuildingExpense;
 
use App\DB\Building\Building;
 
?>
@extends('layouts.master')
@section('title','Add payment for :'. $tenant->name . " of amount: ". $amount)

@section('content')

@include('layouts.toastr')


    @component('layouts._box')
        <form
            method="post"
            action="{{ route('storeManualPayments')}}"
            class="form-horizontal"
            autocomplete="off"
            enctype="multipart/form-data"
        >
            {{ csrf_field() }}

            <?php 

            $lease = Lease::where( 'tenant_id', $tenant->id )->first();

            ?>

            <input type="hidden" value="{{$tenant->id}}" name="tenant_id">
            <input type="hidden" value="{{$lease->id}}" name="lease_id">

            <div class="form-group">

                      @if(isset($tenant->lease))
        

                @foreach($tenant->lease->room->utilities->where('utility_type','rent') as $roomUtility)

                    @if($loop->iteration  % 2 == 0)

                        <div class="form-group">
                    @endif




                <label class="amount control-label @if($loop->iteration  % 2 == 0)col-md-1 @else col-md-2 @endif">{{ ucwords(strtolower( $roomUtility->utility))  }}</label>
                <div class="col-md-4">
                    <input
                        type="text"
                        name="amount[{{strtolower( $roomUtility->utility)}}]"
                        class="form-control @error('amount') invalid-feedback @enderror"
                        value="0"
                    >
                </div>
                    @if($loop->iteration  % 2 == 0)
                        </div>
                    @endif
                @endforeach
                 @else

                    @endif
            </div>
            <div class="form-group">
                <label class="amount control-label col-md-2">Payment Method</label>
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
                            <label class="deposit_at control-label col-md-1">Deposit Date</label>
                <div class="col-md-4">
                    <input
                        type="text"
                        name="deposit_at"
                        class="form-control date"
                        value="{{ old('deposit_at') }}"
                    >
                </div>
            </div>

            <div class="form-group">
  
                <label class="amount control-label col-md-2">Amount</label>
                <div class="col-md-4">
                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        value="{{ old('amount') }}"
                    >
                </div>
               <label class="amount control-label col-md-1">Reference Number</label>
                <div class="col-md-4">
                    <input
                        type="text"
                        name="reference_code"
                        class="form-control @error('reference_code') invalid-feedback @enderror"
                        value="{{ old('reference_code') }}"
                    >
                </div>
            </div>

            <div class="form-group">

                <label class="amount control-label col-md-2">Month</label>
                <div class="col-md-4">
                    <input
                        type="text"
                        name="month"
                        class="form-control month_date @error('month') invalid-feedback @enderror"
                         
                    >
                </div>

                <label class="amount control-label col-md-1">Upload Receipt</label>
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
