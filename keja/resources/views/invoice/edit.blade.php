@extends('layouts.master')
@section('title', 'edit Invoice')
@section('content')
    <a
        href="{{ route('invoice_show', ['invoice' => $invoice->id ]) }}"
        class="btn btn-sm btn-success"
    > << BACK </a>
    <div class="row">
        <form
            class="form-horizontal"
            method="post"
            action="{{ route('invoice_update' , ['invoice' => $invoice->id]) }}"
        >
            @csrf
            @method('PATCH')

          @foreach($invoice->invoiceItems as $item)
                <div class="form-group">
                    <label for="utility" class="col-md-2 control-label">{{ ucwords(strtolower($item->utility)) }}</label>
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="id[{{ $item->id }}]"
                            value="{{ $item->amount }}"
                            class="form-control col-md-4"

                        >
                    </div>
                </div>
            @endforeach

            <div class="col-md-3">
                <button
                    class="btn btn-sm btn-success"
                >UPDATE</button>
            </div>

        </form>
    </div>
@endsection
