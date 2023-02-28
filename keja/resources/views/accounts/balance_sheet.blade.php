<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use Carbon\Carbon;
?>

@extends('layouts.master')
@section('title','Balance Sheet')
@section('extra_css')

<!-- datatables plugin -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />

<!-- bootstrap-datepicker plugin -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection


@section('content')
 
<!--     <ul class="nav-pills nav mb-4">
      
    <form method="GET" action="{{ route('monthlyBalance') }}">          
        <label>Monthly</label>
        <div class="row">
          <div class="col-md-3">
          <select class="form-control" name="monthly_filter">
               <option disabled selected name="years" value="100">--Select Month--</option>

            @foreach($getMonths as $getMonth)
            <?php $currentYear = (int)date("Y"); ?>
          <option value='{{$getMonth}}'>{{$getMonth}}</option>
         @endforeach
          </select>
        </div>
          <div class="col-md-3">

             <select class="form-control" name="year_filter" id="year">
               <option disabled selected name="years" value="100">--Select Year--</option>
                    <?php 
                       $start = "2015";
                       $end = (int)date("Y");  
                                
                         for($i=$start; $i<=$end; $i++){                  
                            echo '<option class="dropdown-item" value='.$i.'>'.$i.'</option>';
                         }
                   ?>                          
              </select> 
              </div> 
            </div>
        <button class="btn btn-success" type="submit">
           Filter
          </button>
        </form>
     
                        
    </ul> -->

     <!-- Blance Sheet CR/DR Row -->
         
         <?php 
            $mpesaIncome = 'Mpesa';
            $cashIncome = 'Cash';
            $bankIncome = 'Bank';
         
           $mpesas = DB::table("mpesa_transactions")->where( 'created_at', '>', Carbon::now()->subMonths(4))->sum('trans_amount');


           $mpesa_manuals = DB::table("payments")->where('payment_method',$mpesaIncome)->sum('amount');
           $cashes = DB::table("payments")->where('payment_method',$cashIncome)->sum('amount');
           $banks = DB::table("payments")->where('payment_method',$bankIncome)->sum('amount');
           $b_income = DB::table("external_incomes")->sum('income_amount');

           $total_manuals = $mpesa_manuals + $cashes + $banks + $b_income;

           $expenses = DB::table("expenses")->sum('amount');
           $b_expenses = DB::table("building_expenses")->sum('expense_amount');
           
           $total_expenses = $expenses + $b_expenses;
           $expected_rent = DB::table("rooms")->sum('rent');

           $disburses = DB::table("disburses")->sum('amount');
     

           $currentMonth = date('m');


            $paidRent = MpesaTransaction::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('trans_amount');


            $mpesaspaidRentCurrent = DB::table("mpesa_transactions")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->sum('trans_amount');


            $mpesaspaidRentCount = DB::table("mpesa_transactions")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->count('id');


            $manualspaidRentCurrent = DB::table("payments")

            ->whereRaw('MONTH(deposit_at) = ?',[$currentMonth])

            ->sum('amount');


            $manualspaidRentCount = DB::table("payments")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->count('id');



            $manualsDisbursesCurrent = DB::table("disburses")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->sum('amount');


              $expensesCurrent = DB::table("expenses")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->sum('amount');


            $b_expensesCurrent = DB::table("building_expenses")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->sum('expense_amount');


            $b_incomeCurrent = DB::table("external_incomes")

            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])

            ->sum('income_amount');

            
           $total_expensesCurrent = $expensesCurrent + $b_expensesCurrent;

 
           // expected rent
      
          $utilityRent = 'rent';
          $utilityDeposit = 'deposit';

          $not_vacant = 0;

          $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityRent)->sum('amount');

          $deposit = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityDeposit)->sum('amount');

          $all_time_rent = DB::table( 'monthly_rents' )->sum('amount');


$totalrent = $total_manuals + $mpesaspaidRentCurrent;


$totalrentCurrent = $manualspaidRentCurrent + $mpesaspaidRentCurrent;

// var_dump($totalrentCurrent); die();


$leaseCount = DB::table("leases")
            ->where('is_active',1)
  
            ->count('id');

            $roomCount = DB::table("rooms")
             
  
            ->count('id');

            // var_dump($roomCount); die();


            $rent_ratio = (100 * $totalrentCurrent) / $expected_rent_utilities;

          // $rent_ratio =  (100 * $totalrent) / $expected_rent_utilities;

          $occupancyRatio  = (100 * $leaseCount / $roomCount);

           ?>

               <div class="container">
               <div id="printingDiv" class="row">
                                 <div align="center">

                          <h2 style="font-weight: bold;">Franro Holdings</h2>
                          <h4 style="font-weight: bold;">Balance Sheet</h4>
                          <h5 style="font-weight: bold;">As At <?php 

                          $monthh = date('m');
 $m = date("F", mktime(0, 0, 0, $monthh, 1)) ;
                          echo date('d');  echo str_repeat("&nbsp;", 1);  echo $m;  echo str_repeat("&nbsp;", 1); echo date('Y');   ?></h5>

                          
                        </div>
                 <!-- DR -->
                      <div class="col-md-6" style="background-color: silver; height: 400px;">
                   
                    <table class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h3><strong>Assets (Fixed & Current Assets)</strong></h3>
                            </th>
                        </thead>
                        <tbody>
                      
                                    <tr>
                                        <td colspan="2">
                                            <strong></strong>
                                        </td>
                                    </tr>
                                  
                                    <tr>
                                            <td><strong>GL Code.</strong></td>
                                            <td><strong>Particular</strong></td>
                                            <td><strong>Ksh.</strong></td>

                                    </tr>
                                       <tr>

                                            <td><strong>Fixed Assets</strong></td>
                                    </tr>
                                      <tr>
                                          <td>A010201</td>
                                          <td>Furniture & Fittings</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>
                                          <tr>
                                          <td>A010202</td>
                                          <td>Office Chairs & Desks</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>
                                          <tr>
                                          <td>A010203</td>
                                          <td>Computers & Printers</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>
                                            <tr>
                                          <td>A010204</td>
                                          <td>Office Equipment</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>
                                   
                                    <tr>

                                            <td><strong>Current Assets</strong></td>
                                    </tr>
                                          <tr>
                                          <td>A010101</td>
                                           <td>Bank</td>
                                            <td>
                                                 {{($mpesas)+($mpesa_manuals)+($cashes)+($banks)}}                                             
                                           </td>
                                           </tr>

                                           <tr>
                                          <td>A010106</td>
                                           <td>Unpaid Rent</td>
                                            <td>
                                              {{($all_time_rent) - (($mpesas)+($mpesa_manuals)+($cashes)+($banks))}}                                           
                                           </td>
                                        </tr>

                                           <tr>
                                          <td>A010104</td>
                                           <td>Deposits</td>
                                            <td>
                                                 {{$deposit}}                                            
                                           </td>
                                        </tr>

                                             <tr>
                                          <td>A010105</td>
                                           <td>Inventory</td>
                                            <td>
                                                 0                                            
                                           </td>
                                        </tr>

                                             <tr>
                                          <td>A010103</td>
                                           <td>Prepayments</td>
                                            <td>
                                                 0                                            
                                           </td>
                                        </tr>
                                   
                                     <tr>
                                          <td>A010102</td>
                                           <td>Accounts Receivable</td>
                                            <td>
                                                 0                                            
                                           </td>
                                        </tr>

                                          <tr style="margin-top: 30px;">

                                        <td><span class="badge badge-primary">Total Assets</span></td>
                                        <td></td>
                                        <td> <span class="badge badge-primary">  {{($all_time_rent) + $deposit}} </span></td>
                                    </tr>
                                 
                 
                      </tbody>
                  </table>
                </div>

                <!-- End DR -->


                 <!-- CR -->
                  <div class="col-md-6" style="background-color: #ced4da; height: 400px;">
                    <table style="width: 90%;" class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h3><strong>Liabilities and Owner's Equity</strong></h3>
                            </th>
                        </thead>
                        <tbody>
                      
                                    <tr>
                                        <td colspan="2">
                                            <strong></strong>
                                        </td>
                                    </tr>
                                       <tr>
                                            <td><strong>GL Code.</strong></td>
                                            <td><strong>Particular</strong></td>
                                            <td><strong>Ksh.</strong></td>

                                    </tr>
                                  
                                    <tr>
                                        <td><strong>Current Liabilities</strong></td>
                                    </tr>
                                             <tr>
                                          <td>L010104</td>
                                        <td>Landlord Funds</td>
                                        <td> {{($all_time_rent) + $deposit}}</td>
                                    </tr>
                                         <tr>
                                          <td>L010101</td>
                                        <td>Short Term Loans</td>
                                        <td> 0</td>
                                    </tr>
                                          <tr>
                                          <td>L010102</td>
                                        <td>Overdraft</td>
                                        <td> 0</td>
                                    </tr>
                                         <tr>
                                          <td>L010103</td>
                                        <td>Accruals</td>
                                        <td> 0</td>
                                    </tr>
                                    <tr>

                                        <td><strong>Non Current Liabilities</strong></td>
                                    </tr>
                              
                                   <tr>
                                          <td>L010201</td>
                                        <td>Long Term Loan</td>
                                        <td> 0</td>
                                    </tr>
                                   
                                
                                          <tr>
                                        <td><span class="badge badge-primary">Total Liabilities</span></td>
                                        <td></td>
                                        <td> <span class="badge badge-primary"> {{($all_time_rent) + $deposit}}</span></td>
                                    </tr>
                                 
                                    <tr>
                                      <td> <strong>Equity </strong></td>
                                           
                                    </tr>
                                       <tr>
                                        <td>C0101</td>
                                        <td>Capital</td>
                                        <td> 0</td>
                                    </tr>
                                
                        <tr class="red">
                             
                                 <td><span class="badge badge-primary">Total Equity + Liabilities</span></td>
                                 <td></td>
                                        <td> <span class="badge badge-primary"> {{($all_time_rent) + $deposit}}</span></td>
                            
                      
                        </tr>
                      </tbody>
                  </table>
                </div>
                <!-- End DR -->

              </div>
              <br><br>

              <div>

                <p align="center"><button type="button" id="dwnld_btn" onclick="generatePDF2()" class="btn btn-warning"><i class="fa fa-download"></i> Download B/c Sheet</button></p>

<p align="center"><button type="button" id="print_btn" onclick="printpage2()" class="btn btn-success"><i class="fa fa-print"></i> Print B/c Sheet</button></p>

                
              </div>

              </div>

     <!-- End Balance Sheet CR/DR Row + Cont  -->

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>


        <script type="text/javascript">
    function printpage2() {
         var printButton = document.getElementById("printingDiv");
         // printButton.style.visibility = 'hidden';
                   $("#print_btn").hide();
                   $("#dwnld_btn").hide();
                   $("#nav_year").hide();

        document.title = "Balance Sheet As At July 2020";
        document.URL   = "www.franroholdings.com";

        window.print();
        // printButton.style.visibility = 'hidden';
                   $("#print_btn").show();
                   $("#dwnld_btn").show();
                    $("#nav_year").show();


    }
</script>




@endsection
                   

                  
