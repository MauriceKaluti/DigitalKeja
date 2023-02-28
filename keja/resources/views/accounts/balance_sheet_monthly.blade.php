<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\BlogPost;
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
 
    <ul id="nav_fil" class="nav-pills nav mb-4">
      
    <form method="GET" action="{{ route('monthlyBalance') }}">          
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
 

               <div class="container">
               <div id="printingDiv" class="row">
                 <div align="center">

                          <h2 style="font-weight: bold;">Franro Holdings</h2>
                          <h4 style="font-weight: bold;">Balance Sheet</h4>
                          
                          <h5 style="font-weight: bold;">As At {{ date("F", mktime(0, 0, 0, $monthly_filter, 1)) }} - {{$year_filter}}</h5>
                          
                        </div>
                 <!-- DR -->
                      <div class="col-md-6" style="background-color: silver; height: 300px;">
                   
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
                                            <td><strong>Fixed Assets</strong></td>
                                            <td><strong>Ksh.</strong></td>

                                    </tr>
                                      <tr>
                                          <td>No Particulars</td>
                                            <td>
                                                N/A                                             
                                           </td>
                                    </tr>
                                    <tr>

                                    <td><strong>Current Assets</strong></td>
                                    </tr>
                                          <tr>
                                           <td>MPESA Rent Payments</td>
                                            <td>
                                                 {{$mpesa_balance_months}}                                             
                                           </td>
                                    </tr>
                                            <tr>
                                           <td>MPESA Manual Rent Payments</td>
                                            <td>
                                                 {{$mpesa_manual_balance_months}}                                    
                                           </td>
                                    </tr>

                                    <tr>
                                     <td>Cash Rent Payments</td>
                                    <td>
                                    {{$cash_balance_months}}                                            
                                    </td>
                                    </tr>

                                           <tr>
                                           <td>Bank Rent Payments</td>
                                            <td>
                                                 {{$bank_balance_months}}                                            
                                           </td>
                                    </tr>
                             <?php 
                             $unpaidRent = $expected_rent_utilities - ($mpesa_balance_months+$mpesa_manual_balance_months+$bank_balance_months); 
                             ?>
                                           <tr>
                                           <td>Unpaid Rent</td>
                                            <td>
                                                 {{$unpaidRent}}                                            
                                           </td>
                                    </tr>
                           
                                 
                                   
                                
                                          <tr>
                                        <td><span class="badge badge-primary">Total Assets</span></td>
                                        <td> <span class="badge badge-primary"> {{$mpesa_balance_months + $cash_balance_months + $bank_balance_months+$mpesa_manual_balance_months + $unpaidRent}}</span></td>
                                    </tr>
                                 
                 
                      </tbody>
                  </table>
                </div>

                <!-- End DR -->


                 <!-- CR -->
                  <div class="col-md-6" style="background-color: #ced4da; height: 300px;">
                    <table style="width: 100%;" class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h3><strong>Liabilities(Current & Long Term)</strong></h3>
                            </th>
                        </thead>
                        <tbody>
                      
                                    <tr>
                                        <td colspan="2">
                                            <strong></strong>
                                        </td>
                                    </tr>
                                  
                                    <tr>
                                        <td><strong>Current Liabilities</strong></td>
                                        <td><strong>Ksh.</strong></td>
                                    </tr>
                                 
                                      <tr>
                                        <td>Landlord Income</td>
                                        <td> {{$expected_rent_utilities}}</td>
                                    </tr>
                                    <tr>

                                        <td><strong>Long Term Liabilities</strong></td>
                                    </tr>
                                

                                          <tr>
                                        <td>No Particulars</td>
                                        <td> 0</td>
                                    </tr>
                                   
                                
                                          <tr>
                                        <td><span class="badge badge-primary">Total Liabilities</span></td>
                                        <td> <span class="badge badge-primary"> {{($expected_rent_utilities)}}</span></td>
                                    </tr>
                                 
                              
                 
                      </tbody>
                  </table>
                </div>
                <!-- End DR -->

              </div>
              <br><br>

              <div>

                <p align="center"><button type="button" id="dwnld_btn" onclick="generatePDF2()" class="btn btn-warning"><i class="fa fa-download"></i> Download B/c Sheet {{ date("F", mktime(0, 0, 0, $monthly_filter, 1)) }} - {{$year_filter}} Report</button></p>

<p align="center"><button type="button" id="print_btn" onclick="printpage2()" class="btn btn-success"><i class="fa fa-print"></i> Print B/c Sheet {{ date("F", mktime(0, 0, 0, $monthly_filter, 1)) }} - {{$year_filter}} Report</button></p>

                
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
                   $("#nav_fil").hide();

        document.title = "Balance Sheet As At 2020";
        document.URL   = "www.franroholdings.com";

        window.print();
        // printButton.style.visibility = 'hidden';
                   $("#print_btn").show();
                   $("#dwnld_btn").show();
                   $("#nav_fil").show();



    }
</script>



@endsection
                   

                  
