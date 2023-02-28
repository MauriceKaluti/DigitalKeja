
<?php 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\BlogPost;
use Carbon\Carbon;
?>



@extends('layouts.master')

@section('content')

 
    <div class="box">
        <div class="box-body">


            <div class="col-lg-7 col-md-12">
                <div class="box-body box-white">
                    <div class="card-heading clearfix">
                        <h4 class="card-title">Income </h4>
                    </div>
                    <div class="card-body">
                        <div id="chart1">
                            {!! $revenue_chart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="card card-white">
                    <div class="card-heading clearfix">
                        <h4 class="card-title">Total Revenue</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart1">
                          
                        </div>
                    </div>
                </div>
            </div>



            <!-- Accounts Charts -->
                        <div class="col-lg-7 col-md-12">
                <div class="box-body box-white">
                    <div class="card-heading clearfix">
                        <h4 class="card-title">Income Payments </h4>
                    </div>
                    <div class="card-body">
                        <div id="chart1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="card card-white">
                    <div class="card-heading clearfix">
                        <h4 class="card-title">Total Revenue</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Account Charts -->
        </div>

    </div>



@endsection
@section('extra_js')
    {!! $revenue_chart->script() !!}
@endsection
