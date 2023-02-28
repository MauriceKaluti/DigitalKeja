
<?php 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\BlogPost;
use Carbon\Carbon;
?>



@extends('layouts.master')

@section('content')


    <div class="row">
        {!!
          \Innox\Classes\Handlers\ReportCard::build()
           ->setTitle('No Of Landlords')
           ->setValue($landlords)
           ->setBgColor('bg-green')
           ->setUri( route('landlord_browse'))
           ->card()
     !!}
        {!!
            \Innox\Classes\Handlers\ReportCard::build()
              ->setTitle('Building / Units')
              ->setValue($buildings  .'/'.  $units )
              ->setUri( route('building_browse'))
              ->setBgColor('bg-red')
              ->card()
          !!}

        {!!
            \Innox\Classes\Handlers\ReportCard::build()
              ->setTitle('Tenants')
              ->setValue($tenants )
              ->setUri( route('tenant_browse'))
              ->setBgColor('bg-orange')
              ->card()
          !!}

        {!!
            \Innox\Classes\Handlers\ReportCard::build()
              ->setTitle('Rent collection ratio')
              ->setBgColor('bg-aqua')
              ->setValue(number_format($ratio , 2) .'<sup> % </sup>' )
              ->setUri( route('report_payment', [
                'start_date' => now()->startOfMonth()->format('Y-m-d') ,
                'end_date' => now()->endOfMonth()->format('Y-m-d')
                ]) )
              ->card()
          !!}

        {!!
            \Innox\Classes\Handlers\ReportCard::build()
              ->setTitle('Occupation ratio')
              ->setBgColor('bg-blue')
              ->setValue(number_format($occupancyratio , 2) .'<sup> % </sup>' )
              ->setUri( route('lease_browse') )
              ->card()
          !!}

    </div>

    <!-- General Stats -->


         <?php 
            $mpesaIncome = 'Mpesa';
            $cashIncome = 'Cash';
            $bankIncome = 'Bank';
            // $countC = App\DB\Lease\Payment::where('payment_method',$idd)->count();
            // $countC = json_decode(json_encode($countC));
           $mpesas = DB::table("payments")->where('payment_method',$mpesaIncome)->sum('amount');
           $cashes = DB::table("payments")->where('payment_method',$cashIncome)->sum('amount');
           $banks = DB::table("payments")->where('payment_method',$bankIncome)->sum('amount');


           $expenses = DB::table("expenses")->sum('amount');
           // $monthrent = \Carbon\Carbon::today()->subDays(1);

//            $paidRent = Payment::whereMonth(
//     'created_at', '=', Carbon\Carbon::now()->subMonth()->month
// );
// $paidRentf = Carbon::now()->startOfMonth()->toDateString();
// $paidRent = Payment::where('created_at', $paidRentf)->sum('amount');
           // $paidRent = Carbon::now();


$currentMonth = date('m');

$paidRent = MpesaTransaction::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('trans_amount');

$paidRentCurrent = DB::table("payments")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->sum('amount');

// var_dump($paidRent); die();


           $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

            $revenueLastMonth = Payment::whereBetween('created_at',[$fromDate,$tillDate])->get();

           // expected rent
           $deposit = DB::table("rooms")->sum('deposit');
           $expected_rent = DB::table("rooms")->sum('rent');


           // $active = 1;
           // $roomIDD = DB::table("leases")->where('active', '=', $roomIDD)->get('room_id');


          // $res = ProductsAttribute::where( 'id', '=', $id )->update( $data );
          

           // $expected_rent_utilities = DB::table("room_utilities")->where('room_id',$roomIDD, '=', $active)->get();


           // $expected_rent_utilities = DB::table("room_utilities")->where('room_id', '=', $roomIDD)->get();

           $utilityRent = 'rent';
           // $expected_rent_utilities = DB::table("room_utilities")->where('utility', '=', $utilityRent)->sum('amount');

          $not_vacant = 0;

          $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityRent)->sum('amount');

            

 

           // $mpesas = DB::table("mpesa_transactions")->sum('trans_amount');

             
            ?>

        <div class="box">
        <div class="box-body">
                <div class="card card-white">
                    <div class="card-heading clearfix">
                        <h4 class="card-title">Revenue & Expenses Quick Stats</h4>
                    </div>
                    <div class="card-body">
<div class="col-md-12">
                      <div class="row">

                        <div class="col-md-3">
                        <div class="panel" style="width: 100%; background-color: #ffe28e;">
 
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">All Time Expected Rent</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{$expected_rent_utilities}}</span>
    </div>
    <div align="center">
    <a href="{{url('landlords/browse')}}" style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Landlord E.Rent</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">

<div class="panel" style="width: 100%; background-color: #ffe28e;">
 
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">This Month Expected Rent</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{$expected_rent_utilities}}</span>
    </div>
<!--     <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check Transactions</a>
  </div> -->
  </div>
</div>
</div>

<div class="col-md-3">
 <div class="panel" style="width: 100%; background-color: #ffe28e;">
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">All Time Paid Rent</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{($expected_rent_utilities)-($paidRent)}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check All Unpaid Rooms</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">
<div class="panel" style="width: 100%; background-color: #ffe28e;">
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">This Month Paid Rent</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
      <div class="row">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{0.3*$expected_rent_utilities}}</span> Vs  <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{0.3*$paidRent}}</span>
    </div>
    </div>


    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-smile-o"></i> Check Single B.Rates</a>
    </div>
  </div>
</div>
</div>

</div>

<!-- end row 1 -->


<div class="row">

  <div class="col-md-3">
  <div class="panel" style="width: 100%; background-color: #fc9cf1;">
 
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">All Time Unpaid Rent</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{$expected_rent_utilities}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Single Landlord E.Rent</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">

<div class="panel" style="width: 100%; background-color: #9af9e8;">
 
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">This Month Unpaid Rent</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{$paidRent}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check Transactions</a>
  </div>
  </div>
</div>
</div>

<div class="col-md-3">
 <div class="panel" style="width: 100%; background-color: #849aa3;">
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Total Disbursed To L/lords All Time</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{($expected_rent_utilities)-($paidRent)}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check All Unpaid Rooms</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">
<div class="panel" style="width: 100%; background-color: #f4a395;">
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Total Disbursed To L/lords This Month</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
      <div class="row">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{0.3*$expected_rent_utilities}}</span> Vs  <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{0.3*$paidRent}}</span>
    </div>
    </div>


    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-smile-o"></i> Check Single B.Rates</a>
    </div>
  </div>
</div>
</div>

</div>

<!-- end row 2 -->


<div class="row">

  <div class="col-md-3">
  <div class="panel" style="width: 100%; background-color: #d8f774;">
 
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Total L/lords Owed All Time</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{$expected_rent_utilities}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Single Landlord E.Rent</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">

<div class="panel" style="width: 100%; background-color: #8095fc;">
 
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Total L/lords Owed This Month</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{$paidRent}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check Transactions</a>
  </div>
  </div>
</div>
</div>

<div class="col-md-3">
 <div class="panel" style="width: 100%; background-color: #c5f7ad;">
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">L/lords Payout After Commission</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{($expected_rent_utilities)-($paidRent)}}</span>
    </div>
    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check Individual L/lord</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">
<div class="panel" style="width: 100%; background-color: #b48fc9;">
  <div class="panel-body">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Bank Balance</h5>
    <div align="center" style="margin-top: 10px; margin-bottom: 10px;">
      <div class="row">
    <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{0.3*$expected_rent_utilities}}</span> Vs  <span style="font-size: 15px; background-color: #f1b500;" class="badge badge-primary">Ksh. {{0.3*$paidRent}}</span>
    </div>
    </div>


    <div align="center">
    <a style="font-weight: bold; font-size: 12px;" href="#" class="btn btn-primary"><i class="fa fa-smile-o"></i> Check Out</a>
    </div>
  </div>
</div>
</div>

</div>


<!-- end row 3 -->


 <div class="row">

<div class="col-md-3">
<div class="panel" style="width: 100%; background-color: #ffe28e;">
 
  <div class="panel-body">
    <div align="center">

    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Explore Landlords</h5>
 <br>
    
    <a style="font-weight: bold; font-size: 12px;" href="{{url('accounts/landlords')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">

<div class="panel" style="width: 100%; background-color: #ffe28e;">
 
  <div class="panel-body">
    <div align="center">
    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Explore Buildings</h5>
 <br>
    <a style="font-weight: bold; font-size: 12px;" href="{{url('accounts/buildings')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>

    <a style="font-weight: bold; font-size: 12px;" href="{{url('accounts/opt_buildings')}}" class="btn btn-primary"><i class="fa fa-eye"></i> Opt.</a>
  </div>
  </div>
</div>
</div>

<div class="col-md-3">
 <div class="panel" style="width: 100%; background-color: #ffe28e;">
  <div class="panel-body">
    <div align="center">

    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Explore Tenants</h5>
 <br>
    
    <a style="font-weight: bold; font-size: 12px;" href="{{url('accounts/all_tenants')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
  </div>
  </div>
</div>
</div>


<div class="col-md-3">
<div class="panel" style="width: 100%; background-color: #ffe28e;">
  <div class="panel-body">
    <div align="center">

    <h5 style="font-weight: bold; font-size: 12px;" class="panel-title">Explore Expenses</h5>
 <br>
    
    <a style="font-weight: bold; font-size: 12px;" href="{{url('accounts/expenses')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
  </div>
  </div>
</div>
</div>

</div>

<!-- end row 4 -->
                    </div>
                </div>
            </div>

        </div>

    </div>



    <!-- End General Stats -->

    <div class="box">
        <div class="box-body">


            <div class="col-lg-7 col-md-12">
                <div class="box-body box-white">
                    <div class="card-heading clearfix">
                        <h4 class="card-title">Income </h4>
                    </div>
                    <div class="card-body">
                        <div id="chart1">
                            {!! $barChart->container() !!}
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
                            {!! $pieChart->container() !!}
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
                          {!! $incomeChart->container() !!}
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
    {!! $pieChart->script() !!}
    {!! $barChart->script() !!}
    {!! $incomeChart->script() !!}
@endsection
