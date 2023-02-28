 
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Payment\Expense;
use App\BlogPost;
?>

@extends('layouts.master')
@section('title','Profit & Loss Account')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />


    <!-- bootstrap-datepicker plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection


@section('content')

  <ul id="nav_filter" class="nav-pills nav mb-4">
      
    <form method="GET" action="{{ route('monthlyTPL') }}">          
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
                       // $end = (int)date("m");  
                       // var_dump($end); die();              
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
     
                        
    </ul>

 
     <!-- Blance Sheet CR/DR Row -->

         <?php 
            $mpesaIncome = 'Mpesa';
            $cashIncome = 'Cash';
            $bankIncome = 'Bank';
            // $countC = App\DB\Lease\Payment::where('payment_method',$idd)->count();
            // $countC = json_decode(json_encode($countC));
           $mpesas = DB::table("mpesa_transactions")->sum('trans_amount');
           // $mpesas = DB::table("payments")->where('payment_method',$mpesaIncome)->sum('amount');
           $cashes = DB::table("payments")->where('payment_method',$cashIncome)->sum('amount');
           $banks = DB::table("payments")->where('payment_method',$bankIncome)->sum('amount');
           $disburses = DB::table("disburses")->sum('amount');
           $expensez = DB::table("expenses")->sum('amount');


           // $expensezPLs = DB::table("expenses")->get();



           // expected rent
           $deposit = DB::table("rooms")->sum('deposit');
           $expected_rent = DB::table("rooms")->sum('rent');
           $expected_rent_utilities = DB::table("room_utilities")->sum('amount');


           // $mpesas = DB::table("mpesa_transactions")->sum('trans_amount');

            // var_dump($expensezPLs); die();
             
            ?>

               <div class="container">
                 
                 <!-- DR -->
                      <div id="printingDiv" class="col-md-12" style="background-color: #F0E68C; width: 100% height: 100%;">
                        <div align="center">
                          <h2 style="font-weight: bold;">Franro Holdings</h2>
                          <h4 style="font-weight: bold;">Profit & Loss Account</h4>
                          <h5 style="font-weight: bold;">As At {{ date("F", mktime(0, 0, 0, $monthly_filter, 1)) }} - {{$year_filter}}</h5>

                          
                        </div>
                    <table style="width: 100%;" class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h3><strong>Revenues</strong></h3>
                            </th>
                        </thead>
                        <tbody>
                      
                                    <tr>
                                        <td colspan="2">
                                            <strong></strong>
                                        </td>
                                    </tr>
                                  
                                    <tr>
                                            <td><strong>Rental Income</strong></td>
                                            <td ><strong>Ksh.</strong></td>

                                    </tr>
                                      <tr>
                                          <td>MPESA Rent Payments</td>
                                            <td >
                                                {{$mpesa_balance_months}}                                            
                                           </td>
                                    </tr>

                                      <tr>
                                          <td><span style="font-weight: bold;">Add:</span> MPESA Manual Rent Payments</td>
                                            <td>
                                               {{$mpesa_manual_balance_months}}                                            
                                           </td>
                                      </tr>

                                         <tr>
                                          <td><span style="font-weight: bold;">Add:</span> Cash Rent Payments</td>
                                            <td>
                                                {{$cash_balance_months}}                                            
                                           </td>
                                      </tr>

                                          <tr>
                                          <td><span style="font-weight: bold;">Add:</span> Bank Rent Payments</td>
                                            <td>
                                                {{$bank_balance_months}}                                           
                                           </td>
                                      </tr>

                                              <tr>
                                          <td><span style="font-weight: bold;">Add:</span> External Income</td>
                                            <td>
                                                {{$monthly_external_income}}                                           
                                           </td>
                                      </tr>

 
                                          <tr>
                                          <td><strong>Rental Income</strong></td>
                                            <td ><strong>
                                               {{($mpesa_balance_months+ $mpesa_manual_balance_months+ $cash_balance_months + $monthly_external_income)}}  </strong>                                           
                                           </td>
                                    </tr>

                            <tr><td><h3><strong>Expenses</strong></h3></td></tr>
 
                                    <tr>

                                            <td><strong>Less: Rental(External) Expenses</strong></td>
                                    </tr>
                                  @foreach($build_monthly_expenses as $bexpense)

                                          <tr>
                                            <td style="text-align: left">
                                                {{$bexpense->expense_particular}}               
                                           </td>

                                             <td >
                                                {{$bexpense->expense_amount}}               
                                           </td>

                                           
                                          </tr>
                                          
                                        @endforeach

                                    <tr>
                                          <td>Total Monthly Ext. Expenses</td>
                                           <td >
                                                {{$build_monthly_expenses_sum}}               
                                           </td>
                                        </tr>

                                     <tr>
                                     <td><strong>Less: Operating(Internal) Expenses</strong></td>
                                    </tr>


                                    @foreach($monthly_expenses as $expense)

                                          <tr>
                                            <td style="text-align: left">
                                                {{$expense->note}}               
                                           </td>

                                             <td >
                                                {{$expense->amount}}               
                                           </td>
                                           
                                          </tr>
                                          
                                        @endforeach
                                        <tr>
                                          <td>Total Monthly Expenses</td>
                                           <td >
                                                {{$monthly_expenses_sum}}               
                                           </td>
                                        </tr>
                                               <tr>
                                          <td><span style="font-weight: bold;">Less:</span> Disbursments Made</td>
                                            <td >
                                                {{$monthly_disbursments}}                                             
                                           </td>
                                        </tr>
                                          <tr>
                                        <td><span class="badge badge-primary">Net Income</span></td>
                                        <td > <span class="badge badge-primary">{{($mpesa_balance_months+ $mpesa_manual_balance_months+ $cash_balance_months + $monthly_external_income) - ($build_monthly_expenses_sum+$monthly_expenses_sum+$monthly_disbursments)}}</span></td>
                                    </tr>
                 
                      </tbody>
                  </table>
                  <br>
                  <br>
                  <br>
                </div>

                <!-- End Row Div -->
              <div>

                <p align="center"><button type="button" id="dwnld_btn" onclick="generatePDF2()" class="btn btn-warning"><i class="fa fa-download"></i> Download P/L {{ date("F", mktime(0, 0, 0, $monthly_filter, 1)) }} - {{$year_filter}} Account Report</button></p>

                <p align="center"><button type="button" id="print_btn" onclick="printpage3()" class="btn btn-success"><i class="fa fa-print"></i> Print P/L {{ date("F", mktime(0, 0, 0, $monthly_filter, 1)) }} - {{$year_filter}} Account Report</button></p>

                
              </div>
 

              </div>

     <!-- End PL Container -->

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

            <script type="text/javascript">
    function printpage3() {
         var printButton = document.getElementById("printingDiv");
         // printButton.style.visibility = 'hidden';
                   $("#print_btn").hide();
                   $("#dwnld_btn").hide();
                   $("#nav_filter").hide();

        document.title = "TPL As At 2020";
        document.URL   = "www.franroholdings.com";

        window.print();
        // printButton.style.visibility = 'hidden';
                   $("#print_btn").show();
                   $("#dwnld_btn").show();
                   $("#nav_filter").show();



    }
</script>

 
@endsection


