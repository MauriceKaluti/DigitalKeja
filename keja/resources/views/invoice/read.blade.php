@extends('layouts.master')
@section('title',' Invoice #'.$invoice->id)
@section('content')


    <div class="clearfix"></div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{ setting('company_name') }}.</strong><br>
                {{ setting('company_address') }}<br>

                Phone: {{ setting('company_tel') }}<br>
                Email: {{ setting('company_email') }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong><a href="{{ route('tenant_view', ['tenant'  => $invoice->lease->tenant->id]) }}">{{ $invoice->lease->tenant->name }}</a></strong>
                <br> Phone Number: {!!  $invoice->lease->tenant->phone_number !!}
                <br> E-mail: {!! $invoice->lease->tenant->email !!}
                <br> Address: {!! $invoice->lease->tenant->address !!}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice: #{{ $invoice->invoice_no }}</b><br>
            <b>Payment Due: </b> {{ now()->addRealDays(5)->format('Y-m-d') }}<br>
            <b>Paybill: </b> {{ env('MPESA_SHORTCODE') }}<br/>
            <b>AccountNo: </b> {{ $invoice->lease->tenant->id_no }}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table display table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Bill</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice->invoiceItems as $index => $invoiceItem)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $invoiceItem->utility }}</td>
                        <td>{{ setting('company_currency') . " ". number_format($invoiceItem->amount , 2) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead">Payment Methods:</p>
            <img src="{{ asset('img/mpesa.png') }}" alt="MPESA">

        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead">Due Date:  {{ now()->addRealDays(5)->format('Y-m-d') }}</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{ setting('company_currency') . " ". number_format($invoice->invoiceItems->sum('amount') , 2) }}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Paid:</th>
                        <td>{{ setting('company_currency') . " ". number_format($invoice->payments->sum('amount') , 2) }}</td>
                    </tr>
                    <tr>
                        <th>Balance:</th>
                        <td>{{ setting('company_currency') . " ". number_format($invoice->balance() , 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            @if($invoice->balance() > 0)
                <a href="{{ route('invoice_payment_create', ['invoice' => $invoice->id]) }}" type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
            </a>
            @endif
            @can('edit_invoices')
                <a href="{{ route('invoice_edit', ['invoice'  => $invoice->id]) }}"
                   type="button" class="btn btn-success"><i class="fa fa-pencil"></i>Edit Invoice</a></li>

            @endcan
        </div>
    </div>


@endsection
