@extends('layouts.master')
@section('title','All reports')

@section('content')
<div class="row">
    {!!
    \Innox\Classes\Handlers\ReportCard::build()
    ->setTitle('Payment report')
    ->setValue(0)
    ->setUri( route('report_payment'))
    ->card()
     !!}

    {!!
    \Innox\Classes\Handlers\ReportCard::build()
    ->setTitle('Mpesa Payment report')
    ->setValue(0)
    ->setUri(  route('report_payment_mpesa') )
    ->card()
     !!}

</div>




@endsection
