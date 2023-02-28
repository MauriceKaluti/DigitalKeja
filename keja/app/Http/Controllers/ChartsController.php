<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Charts\AccountsChart;

use App\AccountTitle;

use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Building\Building;
use App\DB\Landlord\Landlord;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
use App\JournalEntry;
use App\JournalTitle;
use App\BuildingExpense;
use App\ExternalIncome;
use DB;


class ChartsController extends Controller
{
    //


    // Charts


  public function dashCharts () {

    //donut chart per year
 

   // Colors

   $borderColors = [
    "rgba(255, 99, 132, 1.0)",
    "rgba(22,160,133, 1.0)",
    "rgba(255, 205, 86, 1.0)",
    "rgba(51,105,232, 1.0)",
    "rgba(244,67,54, 1.0)",
    "rgba(34,198,246, 1.0)",
    "rgba(153, 102, 255, 1.0)",
    "rgba(255, 159, 64, 1.0)",
    "rgba(233,30,99, 1.0)",
    "rgba(205,220,57, 1.0)"
];


    $fillColors = [
        "rgba(255, 99, 132, 0.2)",
        "rgba(22,160,133, 0.2)",
        "rgba(255, 205, 86, 0.2)",
        "rgba(51,105,232, 0.2)",
        "rgba(244,67,54, 0.2)",
        "rgba(34,198,246, 0.2)",
        "rgba(153, 102, 255, 0.2)",
        "rgba(255, 159, 64, 0.2)",
        "rgba(233,30,99, 0.2)",
        "rgba(205,220,57, 0.2)"

    ];

// Chart 1
 $zero = 0;
 
   $mpesas =  MpesaTransaction::where('trans_amount', '!=', $zero)->sum('trans_amount');

   


  $revenue_chart = new AccountsChart;
  $revenue_chart->title('Revenue Flow Breakdown Chart (Ksh)');
  $revenue_chart->minimalist(true);
  $revenue_chart ->labels(['All Time']);
  $revenue_chart->dataset('Revenue Flow', 'bar', [$mpesas])
  ->color($borderColors)
  ->backgroundcolor($borderColors);
 


 

   return view('accounts.charts', [ 'revenue_chart' => $revenue_chart ] );
    }

    
}
