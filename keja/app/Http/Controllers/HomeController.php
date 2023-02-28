<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Charts\AccountsChart;
use App\Charts\IncomeChart;
use App\DB\Lease\Payment;
use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Landlord\Landlord;
use App\DB\Tenant;
use App\DB\Payment\MpesaTransaction;
use App\Growth;
use App\ExternalIncome;
use App\BuildingExpense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Innox\Classes\Handlers\ExpectedRent;
use Innox\Classes\Handlers\GrowthReport;
use Innox\Classes\Handlers\NumberShorter;
use Innox\Classes\Handlers\Occupancy;
use Innox\Classes\Repository\BuildingRepository;
use Innox\Classes\Repository\LandlordRepository;
use Innox\Classes\Repository\PaymentRepository;
use Innox\Classes\Repository\RoomRepository;
use Innox\Classes\Repository\TenantRepository;
use DB;
use DateTime;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! $request->user()->can('browse_dashboard'))
        {
            accessDenied("Access Denied to Dashboard");

            return redirect()->route('landlord_browse');

        }
        $landlords =  Landlord::count();
        $buildings = Building::count();
        $tenants =  Tenant::count();

        $rent = (new ExpectedRent())
            ->setEndDate(now()->endOfMonth())
            ->setStartDate(now()->startOfMonth())
            ->getInvoices();

        $occupunacy = (new Occupancy())
            ->setEndDate(now()->endOfMonth())
            ->setStartDate(now()->startOfMonth());

       try{
           $ratio =  (100 * $rent->collectedRent()) / $rent->getExpected();
           $occupunacyRatio  = (100 * $occupunacy->getLeases()->count()) / ((new RoomRepository())->filter()->count() );

       } catch(\Exception $e){
           $ratio = 0;
           $occupunacyRatio =0;
       }

        $barChart = $this
            ->growthGraph();

        $pieChart = $this
            ->createPieGraph();
 

            $incomeChart = $this
            ->createIncomeChart();

            $expenseChart = $this
            ->expensesChart();

            $manualsChart = $this
            ->manualsChart();

               $buildingIncomeChart = $this
            ->buildingIncomeChart();

              $buildingExpenseChart = $this
            ->buildingExpenseChart();
             $genderChart = $this
            ->genderChart();

            

        $data = [
            // 'invoices'  => $invoices,
            'buildings'  => $buildings,
            'tenants'  => $tenants,
            'barChart' => $barChart,
            'incomeChart' => $incomeChart,
            'expenseChart' => $expenseChart,
            'manualsChart' => $manualsChart,
            'buildingIncomeChart' => $buildingIncomeChart,
            'buildingExpenseChart' => $buildingExpenseChart,
            'genderChart' => $genderChart,
            'pieChart' => $pieChart,
            'landlords'  => $landlords,
            'ratio'   => $ratio,
            'occupancyratio'  => $occupunacyRatio,
            'units' =>   Room::count()
        ];


        return view('welcome')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function createBarGraph()
    {


        $labels = [];
        $buildingValues = [];
        $income = [];
        $landlordCount = [];

        $growth = (new GrowthReport());


        foreach ($growth->building() as $index => $building) {
            $buildingValues[] = $building->count();
            $labels[] = $index;
        }
        foreach ($growth->landlord() as $index => $landlord) {

            if (! in_array($index ,$labels)){

                array_push($labels, $index);
            }
            $landlordCount[] = $landlord->count();
        }


        $income = [];


        foreach ($growth->income() as $index => $collection) {
            if (! in_array($index ,$labels)){

                array_push($labels, $index);
            }
           // dd($collection);
            $income[] = $collection['amount'];
        }

        $chart = new IncomeChart();
        $chart->labels($labels);


        $chart->dataset('Income', 'bar', $income)->options([
            'backgroundColor' => 'red'
        ]);
        $chart->dataset('LandLords', 'bar', $landlordCount)->options([
            'backgroundColor' => 'blue'
        ]);
        $chart->dataset('Buildings', 'bar', $buildingValues)->options([
            'backgroundColor' => '#2befbe'
        ]);

        return $chart;
    }

    public function createPieGraph()
    {


        $labels = [];

        $income = [];


        foreach ((new GrowthReport())->income() as $index => $collection) {
            $labels[] = $index;
            $income[] = $collection['amount'];
        }


        $chart = new IncomeChart();
        $chart->labels($labels);
        $chart->dataset('Income', 'pie', $income)
            ->backgroundColor(['red','orange','yellow','green','blue','indogo','violet','purple','pink','blue','black','marron']);
        $chart->title('Income');


        return $chart;
    }

    public function growthGraph()
    {
        $growths = Growth::all()->groupBy('key');
        $chart = new IncomeChart();
        $labels = [];

        $income = [];
        foreach ($growths as $key =>  $growth)
        {
            $labels[] = $key;
            $income[] = $growth->sum('value');

        }
        $chart->labels($labels);
        $chart->dataset('Income', 'bar', $income)
            ->backgroundColor(['violet','orange','yellow','green','blue','indigo','purple','pink','blue','black','marron']);
        $chart->title('Growth');

        return $chart;

    }

    public function landlords()
    {
        return response()
            ->json([
                'landlords' => (new LandlordRepository())->filter()->count()
            ]);
    }



    // Accounts Charts


    public function createIncomeChart()
    {

 
 
 

 //  Graph


// $mpesas = MpesaTransaction::select(
//             DB::raw('sum(trans_amount) as totalpaid'), 
//             DB::raw("DATE_FORMAT(created_at,'%m') as monthKey")
//   )


//   ->groupBy('monthKey')
//   ->orderBy('created_at', 'ASC')
//   ->get();


              $mpesas = DB::table('mpesa_transactions')->selectRaw('sum(trans_amount) as totalpaid,
                           MONTH(created_at) as month')
              ->groupBy('month')
              ->get();

   
            // var_dump($mpesas); die();

              $chart = new AccountsChart;


         $labels = [];
         $month = [];

        $income = [0,0,0,0,0,0,0,0,0,0,0,0];


        foreach ($mpesas as $mpesa)
        {
            $key = $mpesa->month;

            $labels[] = $key;

            $income[$mpesa->month-1] = $mpesa->totalpaid;

            $moh = $mpesa->month;


            $dateObj   = DateTime::createFromFormat('!m', $moh);

            $name = $dateObj->format('F');

            $month[] = $name;
 
        }
        $chart->labels($month);
        $chart->dataset('Total Rent Paid (Ksh)', 'line', $income)
             ->backgroundColor(['orange']);
        $chart->title('MPESA Rent Payment Stats');

        return $chart;
    }



// expenses chart

    public function expensesChart()
    {



  $expenses = DB::table('expenses')->selectRaw('sum(amount) as totalpaid,
               MONTH(created_at) as month')
  ->groupBy('month')
  ->get();

   
            // var_dump($expenses); die();

              $chart = new AccountsChart;


         $labels = [];
         $month = [];

        $income = [0,0,0,0,0,0,0,0,0,0,0,0];


        foreach ($expenses as $expense)
        {
            $key = $expense->month;

            $labels[] = $key;

            $income[$expense->month-1] = $expense->totalpaid;

            $moh = $expense->month;


            $dateObj   = DateTime::createFromFormat('!m', $moh);

            $name = $dateObj->format('F');

            $month[] = $name;
 
        }
        $chart->labels($month);
        $chart->dataset('Total Expenses Incurred (Ksh)', 'pie', $income)
            ->backgroundColor(['red','orange','yellow','green','indigo','violet','purple','pink','blue','black','maroon']);
        $chart->title('Internal Expenses Monthly Stats');

        return $chart;
    }


    // manuals chart

    public function manualsChart()
    {

 
   $manuals = Payment::select(
            DB::raw('sum(amount) as totalpaid'), 
            DB::raw("MONTH(created_at) as monthKey")
  )


  ->groupBy('monthKey')
  ->get();
            // var_dump($manuals); die();

              $chart = new AccountsChart;


         $labels = [];
         $month = [];

        $income = [0,0,0,0,0,0,0,0,0,0,0,0];


        foreach ($manuals as $manual)
        {
            $key = $manual->monthKey;

            $labels[] = $key;

            $income[$manual->monthKey-1] = $manual->totalpaid;

            $moh = $manual->monthKey;


            $dateObj   = DateTime::createFromFormat('!m', $moh);

            $name = $dateObj->format('F');

            $month[] = $name;
 
        }
        $chart->labels($month);
        $chart->dataset('Total Rent Collection (Ksh)', 'bar', $income)
            ->backgroundColor(['red','orange','yellow','green','indigo','violet','purple','pink','blue','black','maroon']);
        $chart->title('Manual(Cash & Bank) Payments Monthly Stats');

        return $chart;
    }


        // building income chart

    public function buildingIncomeChart()
    {

 
   $externals = ExternalIncome::select(
            DB::raw('sum(income_amount) as totalpaid'), 
            DB::raw("MONTH(created_at) as monthKey")
  )


  ->groupBy('monthKey')
  ->get();
            // var_dump($manuals); die();

              $chart = new AccountsChart;


         $labels = [];
         $month = [];

        $income = [0,0,0,0,0,0,0,0,0,0,0,0];


        foreach ($externals as $external)
        {
            $key = $external->monthKey;

            $labels[] = $key;

            $income[$external->monthKey-1] = $external->totalpaid;

            $moh = $external->monthKey;


            $dateObj   = DateTime::createFromFormat('!m', $moh);

            $name = $dateObj->format('F');

            $month[] = $name;
 
        }
        $chart->labels($month);
        $chart->dataset('Total Building Extra Income (Ksh)', 'radar', $income)
            ->backgroundColor(['indigo']);
        $chart->title('Building Extra Income Monthly Stats');

        return $chart;
    }



            // building expense chart

    public function buildingExpenseChart()
    {

 
   $bexpenses = BuildingExpense::select(
            DB::raw('sum(expense_amount) as totalpaid'), 
            DB::raw("MONTH(created_at) as monthKey")
  )


  ->groupBy('monthKey')
  ->get();
            // var_dump($bexpenses); die();

              $chart = new AccountsChart;


         $labels = [];
         $month = [];

        $income = [0,0,0,0,0,0,0,0,0,0,0,0];


        foreach ($bexpenses as $bexpense)
        {
            $key = $bexpense->monthKey;

            $labels[] = $key;

            $income[$bexpense->monthKey-1] = $bexpense->totalpaid;

            $moh = $bexpense->monthKey;


            $dateObj   = DateTime::createFromFormat('!m', $moh);

            $name = $dateObj->format('F');

            $month[] = $name;
 
        }
        $chart->labels($month);
        $chart->dataset('Total Building Expenses (Ksh)', 'doughnut', $income)
            ->backgroundColor(['maroon','indigo','violet','purple','pink','orange','blue','green','silver','gold']);
        $chart->title('Building Expenses Monthly Stats');

        return $chart;
    }




            // Gender chart

    public function genderChart()
    {

 
   $genders = Tenant::select(
            DB::raw('count(id) as totalpaid'), 
            DB::raw("gender as genderKey")
  )->where('gender', '!=', null)


  ->groupBy('genderKey')
  ->get();
            // var_dump($genders); die();

              $chart = new AccountsChart;


         $labels = [];
         $gtype = [];

        $t_tenants = [];


        foreach ($genders as $gender)
        {
            $key = $gender->genderKey;

            $labels[] = $key;

            $t_tenants[] = $gender->totalpaid;


            $gtype[] = $key;
 
        }
        $chart->labels($gtype);
        $chart->dataset('Tenant Gender Report', 'doughnut', $t_tenants)
            ->backgroundColor(['maroon','indigo','violet','purple','pink','orange','blue','green','silver','gold']);
        $chart->title('Tenant Gender Stats');

        return $chart;
    }


}
