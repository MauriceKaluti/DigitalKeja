<?php 
   use App\DB\Payment\MpesaTransaction;
   use App\DB\Lease\Payment;
   use Carbon\Carbon;
   ?>
@extends('layouts.master')
@section('content')
<div class="container-fluid">
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
      
      $not_vacant = 0;
      
      $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityRent)->sum('amount');
      
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
   <h6 class="text-site keja-bold"> <i class="fa fa-tachometer"></i> App Dashboard</h6>
   <div class="accordion mb-3" id="kejaSlideHide">
      <div class="accordion-item">
         <h2 class="accordion-header" id="kejaSlideHideHeader">
            <button class="accordion-button shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#kejaSlideHideToggle" aria-expanded="true" aria-controls="kejaSlideHideToggle"><i class="fa fa-line-chart me-1"></i> General Stats
            </button>
         </h2>
         <div id="kejaSlideHideToggle" class="accordion-collapse collapse show" aria-labelledby="kejaSlideHideHeader" data-bs-parent="#kejaSlideHide">
            <div class="accordion-body keja-bg">
               <div class="row">
                  <div class="col-md-3 mb-3">
                     <a href="{{route('landlord_browse')}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-user-tie mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">No Of Landlords</h6>
                              <span class="keja-card-count text-site"><small>Total Landlords:  {{$landlords}}</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View All</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{route('building_browse')}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-building mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Building / Units</h6>
                              <span class="keja-card-count text-site"><small>{{$buildings  .'/'.  $units}}</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View All</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{route('tenant_browse')}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-group mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Tenants</h6>
                              <span class="keja-card-count text-site"><small>{{$tenants}}</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View All</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{route('report_payment', [
                        'start_date' => now()->startOfMonth()->format('Y-m-d') ,
                        'end_date' => now()->endOfMonth()->format('Y-m-d')
                        ])}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-exchange mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Rent Collection Ratio</h6>
                              <span class="keja-card-count text-site"><small>{{number_format($rent_ratio , 2)}}%</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> Collection Report</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{ url('building/browse') }}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-percent mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Occupation Ratio</h6>
                              <span class="keja-card-count text-site"><small>{{number_format($occupancyRatio , 2)}}%</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View Ratio</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{route('room_browse')}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-toggle-on mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Total Active Leases</h6>
                              <span class="keja-card-count text-site"><small>{{$leaseCount}}</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View All</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{route('tenant_browse')}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-mobile mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Total Mpesa Payments</h6>
                              <span class="keja-card-count text-site"><small>{{$mpesaspaidRentCount}}</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View All</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a href="{{url('accounts/receipt_reports')}}">
                        <div class="card keja-popup-card h-100 shadow-lg keja-round">
                           <div class="card-body text-center">
                              <i class="fa fa-money mb-3 fa-2x keja-card-icon text-warning"></i>
                              <h6 class="card-title keja-bold">Total Manual Payments</h6>
                              <span class="keja-card-count text-site"><small>{{$manualspaidRentCount}}</small></span>
                              <div class="mt-2">
                                 <button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i> View All</button>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="accordion mb-3" id="kejaSlideHideX">
      <div class="accordion-item">
         <h2 class="accordion-header" id="kejaSlideHideXHeader">
            <button class="accordion-button shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#kejaSlideHideXToggle" aria-expanded="true" aria-controls="kejaSlideHideXToggle">
            <i class="fa fa-line-chart me-1"></i> Payment Stats
            </button>
         </h2>
         <div id="kejaSlideHideXToggle" class="accordion-collapse collapse show" aria-labelledby="kejaSlideHideXHeader" data-bs-parent="#kejaSlideHideX">
            <div class="accordion-body keja-bg">
               <div class="row">
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">All Time Expected Rent</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{$all_time_rent}}</span>
                           </div>
                           <div align="center">
                              <a href="{{url('accounts/landlords_simplified')}}" href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Landlord E.Rent</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">This Month Expected Rent</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{$expected_rent_utilities}}</span>
                           </div>
                           <div align="center">
                              <a href="{{url('accounts/landlords')}}" class="btn btn-primary"><i class="fa fa-eye"></i> Check Rates</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">All Time Paid Rent</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{($mpesas)+($mpesa_manuals)+($cashes)+($banks)}}</span>
                           </div>
                           <div align="center">
                              <a href="{{url('accounts/mpesa_receipt_reports')}}" class="btn btn-primary"><i class="fa fa-mobile"></i> Mpesa </a> |  <a href="{{url('accounts/receipt_reports')}}" class="btn btn-primary"><i class="fa fa-money"></i> Manual </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">This Month Paid Rent</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{$manualspaidRentCurrent+$mpesaspaidRentCurrent}}</span>  
                           </div>
                           <div align="center">
                              <a href="{{url('accounts/buildings')}}" class="btn btn-primary"><i class="fa fa-university"></i> Building Payment Status</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">All Time Unpaid Rent</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{($all_time_rent) - (($mpesas)+($mpesa_manuals)+($cashes)+($banks))}}</span>
                           </div>
                           <!--   <div align="center">
                              <a href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Single Landlord E.Rent</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">This Month Unpaid Rent</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{($expected_rent_utilities) - ($mpesaspaidRentCurrent +$manualspaidRentCurrent)}}</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">Total Disbursed To L/lords All Time</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{$disburses}}</span>
                           </div>
                           <!--     <div align="center">
                              <a href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check All Unpaid Rooms</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">Total Disbursed To L/lords This Month</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{$manualsDisbursesCurrent}}</span>
                           </div>
                           <!--    <div align="center">
                              <a href="#" class="btn btn-primary"><i class="fa fa-smile-o"></i> Check Single B.Rates</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="accordion mb-3" id="kejaSlideHideZ">
      <div class="accordion-item">
         <h2 class="accordion-header" id="kejaSlideHideZHeader">
            <button class="accordion-button shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#kejaSlideHideZToggle" aria-expanded="true" aria-controls="kejaSlideHideZToggle">
            <i class="fa fa-line-chart me-1"></i> Report Stats
            </button>
         </h2>
         <div id="kejaSlideHideZToggle" class="accordion-collapse collapse show" aria-labelledby="kejaSlideHideZHeader" data-bs-parent="#kejaSlideHideZ">
            <div class="accordion-body keja-bg">
               <div class="row">
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">Total L/lords Owed All Time</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{($all_time_rent) - ($disburses)}}</span>
                           </div>
                           <!--    <div align="center">
                              <a href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check Transactions</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">Total L/lords Owed This Month</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round">Ksh. {{($expected_rent_utilities) - ($manualsDisbursesCurrent)}}</span>
                           </div>
                           <!--    <div align="center">
                              <a href="#" class="btn btn-primary"><i class="fa fa-eye"></i> Check Transactions</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">Expenses/Income</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round"><i class="fa fa-caret-down"></i> Internal Expenses: Ksh. {{$expenses}}</span>
                              <span class="badge badge-warning mb-2 keja-round"><i class="fa fa-caret-down"></i> B. Expenses: Ksh. {{$b_expenses}}</span>
                              <span class="badge badge-warning mb-2 keja-round"><i class="fa fa-caret-up"></i> B. Income: Ksh. {{($b_income)}}</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <small class="text-site keja-bold">Bank Balance</small>
                           <div align="center">
                              <span class="badge badge-warning mb-2 keja-round"><i class="fa fa-caret-up"></i> All Time: Ksh. {{$all_time_rent - ($disburses + $total_expenses)}}</span> 
                              <span class="badge badge-warning mb-2 keja-round"><i class="fa fa-caret-up"></i> This Month: Ksh. {{($mpesaspaidRentCurrent + $manualspaidRentCurrent) - ($manualsDisbursesCurrent + $total_expensesCurrent)}}</span> 
                           </div>
                           <!-- <div align="center">
                              <a href="#" class="btn btn-primary"><i class="fa fa-smile-o"></i> Check Out</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <div align="center">
                              <small class="text-site keja-bold">Explore Landlords</small>
                              <br>
                              <a href="{{url('accounts/landlords')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <div align="center">
                              <small class="text-site keja-bold">Explore Buildings</small>
                              <br>
                              <a href="{{url('accounts/buildings')}}" class="btn btn-primary"><i class="fa fa-eye"></i> All</a>
                              <a href="{{url('accounts/opt_buildings')}}" class="btn btn-primary"><i class="fa fa-eye"></i> Optimised</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <div align="center">
                              <small class="text-site keja-bold">Explore Tenants</small>
                              <br>
                              <a href="{{url('accounts/all_tenants')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">
                     <div class="card keja-round shadow-lg h-100" style="min-height: 150px;">
                        <div class="card-body text-center">
                           <div align="center">
                              <small class="text-site keja-bold">Explore Expenses</small>
                              <br>
                              <a href="{{url('accounts/expenses')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="box">
      <div class="box-body">
         <div class="col-lg-12 col-md-12">
            <div class="box-body box-white">
               <div class="card-body text-center">
                  <h6 class="text-site">Growth Analysis Report </h6>
                  <div id="chart1">
                     {!! $barChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-12">
            <div class="card shadow-lg keja-round">
               <div class="card-body text-center">
                  <h6 class="text-site">Manual Income (Cash/Bank)</h6>
                  <div id="chart1">
                     {!! $manualsChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
         <!-- Accounts Charts -->
         <div class="col-lg-12 col-md-12">
            <div class="box-body box-white">
               <div class="card-body text-center">
                  <h6 class="text-site">Mpesa Income</h6>
                  <div id="chart1">
                     {!! $incomeChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-12">
            <div class="card shadow-lg keja-round">
               <div class="card-body text-center">
                  <h6 class="text-site">Internal Expenses</h6>
                  <div id="chart1">
                     {!! $expenseChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="box">
      <div class="box-body">
         <div class="col-lg-12 col-md-12">
            <div class="box-body box-white">
               <div class="card-body">
                  <h6 class="text-site">Building External Income </h6>
                  <div id="chart1">
                     {!! $buildingIncomeChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-12">
            <div class="card shadow-lg keja-round">
               <div class="card-body">
                  <h6 class="text-site">Building Expenses Report</h6>
                  <div id="chart1">
                     {!! $buildingExpenseChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
         <!-- Report Charts -->
         <div class="col-lg-12 col-md-12">
            <div class="box-body box-white">
               <div class="card-body">
                  <h6 class="text-site">Tenant Gender Report</h6>
                  <div id="chart1">
                     {!! $genderChart->container() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('extra_js')
{!! $pieChart->script() !!}
{!! $barChart->script() !!}
{!! $incomeChart->script() !!}
{!! $expenseChart->script() !!}
{!! $manualsChart->script() !!}
{!! $buildingIncomeChart->script() !!}
{!! $buildingExpenseChart->script() !!}
{!! $genderChart->script() !!}
@endsection