
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use Carbon\Carbon;
?>

@extends('layouts.master')
@section('title','Income Statement')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />


    <!-- bootstrap-datepicker plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection


@section('content')


<!--    <ul id="nav_filter" class="nav-pills nav mb-4">
      
    <form method="GET" action="{{ route('incomeStatementMonthly') }}">          
        <label>Monthly</label>
        <div class="row">
          <div class="col-md-3">
          <select class="form-control" name="monthly_filter">
               <option disabled selected name="years" value="100">--Select Month--</option>
            
            @foreach($getMonths as $getMonth)
            <?php $currentYear = (int)date("Y"); ?>
          <option value='{{$getMonth}}'>{{ date("F", mktime(0, 0, 0, $getMonth, 1)) }}</option>
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

               <div class="row">

                              <div align="center">

                          <h2 style="font-weight: bold;">Franro Holdings</h2>
                          <h4 style="font-weight: bold;">Income Statement</h4>
                          <h5 style="font-weight: bold;">For the year ended 2020</h5>

                          
                        </div>
                 
                 <!-- DR -->
                      <div class="col-md-6" style="background-color: silver; height: 900px;">

                     
                    <table style="width: 90%;" class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h1>Income</h1>
                            </th>
                        </thead>
                        <tbody>
                      
                                    <tr>
                                        <td colspan="2">
                                            <strong></strong>
                                        </td>
                                    </tr>
                             
                                      <tr>
                                            <td><strong>GL Code</strong></td>
                                            <td><strong>Particular</strong></td>
                                            <td ><strong>Ksh.</strong></td>

                                    </tr>


                                         
                                      <tr>
                                          <td>Y0101</td>
                                          <td>Commission</td>
                                            <td>
                                                {{0.12 * $all_time_rent}}                                            
                                           </td>
                                    </tr>

                                       <tr>
                                          <td>Y0102</td>
                                          <td>Fines</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>

                                       <tr>
                                          <td>Y0103</td>
                                          <td>Interest</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>
                                       <tr>
                                          <td>Y0104</td>
                                          <td>Other Incomes</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>

                                   
                                
                                          <tr>
                                        <td><span class="badge badge-primary">Total Income</span></td>
                                        <td></td>
                                        <td > <span class="badge badge-primary">{{0.12 * $all_time_rent}}</span></td>
                                    </tr>
                                 
                 
                      </tbody>
                  </table>
                </div>

                <!-- End DR -->


                 <!-- CR -->
                  <div class="col-md-6" style="background-color: #ced4da; height: 900px;">
                    <table style="width: 90%;" class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h1>Expenses</h1>
                            </th>
                        </thead>
                        <tbody>
                      
                                    <tr>
                                        <td colspan="2">
                                            <strong></strong>
                                        </td>
                                    </tr>
                                  
                                 <tr>
                                            <td><strong>GL Code</strong></td>
                                            <td><strong>Particular</strong></td>
                                            <td ><strong>Ksh.</strong></td>

                                    </tr>
                                 
                                  
                                        <tr>

                                            <td><strong>Administrative Costs</strong></td>
                                    </tr>
                                          <tr>
                                          <td>X010101</td>
                                           <td>Registration Licence</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>

                                           <tr>
                                          <td>X010102</td>
                                           <td>Trading Licence</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>


                                           <tr>
                                          <td>X010103</td>
                                           <td>Legal Cost</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                            <tr>
                                          <td>X010104</td>
                                           <td>Bad Debts</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                            <tr>
                                          <td>X010105</td>
                                          <td>Audit & Accountancy</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>


                                     <tr>
                                     <td><strong>Operating Costs</strong></td>
                                   </tr>
                                             <tr>
                                          <td>X010201</td>
                                          <td>Transport</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010203</td>
                                          <td>Water</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010204</td>
                                          <td>Internet</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010202</td>
                                          <td>Rent</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010206</td>
                                          <td>Electricity</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                               <tr>
                                          <td>X010205</td>
                                          <td>Telephone & Communication</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                          <tr>
                                          <td>X010209</td>
                                          <td>Stationery</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                         <tr>
                                          <td>X010207</td>
                                          <td>System Maintenance</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                          <tr>
                                          <td>X010208</td>
                                          <td>Cleaning</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                        <tr>
                                          <td>X010211</td>
                                          <td>Furniture Repair</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                       <tr>
                                          <td>X010210</td>
                                          <td>Motor Repairs</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010212</td>
                                          <td>Insurance</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010213</td>
                                          <td>Miscellaneous</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                                                            <tr>

                                            <td><strong>Human Resource Costs</strong></td>
                                    </tr>
                                          <tr>
                                          <td>X010301</td>
                                           <td>Salaries & Wages</td>
                                            <td>
                                                0                                             
                                           </td>
                                    </tr>

                                           <tr>
                                          <td>X010302</td>
                                           <td>Statutory Contribution</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>


                                           <tr>
                                          <td>X010303</td>
                                           <td>Bonuses & Commission</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                            <tr>
                                          <td>X010304</td>
                                           <td>Staff Allowances</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                    


                                     <tr>
                                     <td><strong>Marketing Costs</strong></td>
                                   </tr>
                                             <tr>
                                          <td>X010401</td>
                                          <td>Office Shirts</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010404</td>
                                          <td>Sinage</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010402</td>
                                          <td>Brochures & Calendars</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010405</td>
                                          <td>Campaigns</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010406</td>
                                          <td>Advertisements</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                               <tr>
                                          <td>X010403</td>
                                          <td>Office Branding</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                    <tr>
                                     <td><strong>Finance Costs</strong></td>
                                   </tr>
                                             <tr>
                                          <td>X010501</td>
                                          <td>Interest Cost</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>

                                               <tr>
                                          <td>X010502</td>
                                          <td>Capital Acquisition</td>
                                            <td >
                                                0                                            
                                           </td>
                                         </tr>
                                
                        <tr class="red">
                             
                                 <td><span class="badge badge-primary">Total Expenses</span></td>
                                 <td></td>
                                        <td > <span class="badge badge-primary">  0</span></td>
                            
                      
                        </tr>
                      </tbody>
                  </table>
                </div>
                <!-- End DR -->

              </div>

     <!-- End Balance Sheet CR/DR Row -->

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <script>

        $('input.date').datepicker();

        $(function () {

            var table = $('table#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('invoice_browse') }}",
                columns: [

                    {data: 'tenant', name: 'tenant'},

                ]
            });

        });
    </script>
@endsection
