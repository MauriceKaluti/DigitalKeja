<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use Datatables;
use App\AccountTitle;
use Innox\Classes\Repository\TenantRepository;
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
use App\MonthlyRent;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

 function allTenantsList(Request $request)
    {
  
       $data = DB::table('tenants')
         ->orderBy('id', 'desc')
         ->get();

      $total_row = $data->count();
      if($total_row > 0)
      { 
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td> <a href="'.route('one.tenant', $row->id).'">View</a></td>
        </tr>
        ';

       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     
    }

     function getTenantData(Request $request)
    {
return Datatables::of(Tenant::query())->make(true);
}
    function getTenantDatad(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
  
       $data = DB::table('products')
         ->orderBy('id', 'desc')
         ->get();
     
      $total_row = $data->count();
      if($total_row > 0)
      { 
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td> <a href="'.route('one.product', $row->id).'">View</a></td>
         <td> <img src="'.url('images/productimages/medium',$row->image_alt).'"></td>
        </tr>
        ';

       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }


   public function storeMonthlyRent(Request $request)
    {
     
 
$all_leases = Lease::get()->where('is_active', '=', 1);



foreach ($all_leases as $lease) {

$leaseID = $lease->id;

$tenantID = $lease->tenant_id;

$rid = $lease->room_id;


if (!isset($lease->room->rent)) {

$roomRent = 0;
  
}else{

$roomRent = $lease->room->rent;

}

if (!isset($lease->room->building->id)) {

$bid = 999;
  
}else{

$bid = $lease->room->building->id;

}


if (!isset($lease->room->building->landlord->id)) {

$lid = 999;
  
}else{

$lid = $lease->room->building->landlord->id;

}




// var_dump($roomRent); die();

            $montlyRent = new MonthlyRent;
            $montlyRent->lease_id = $leaseID;
            $montlyRent->tenant_id = $tenantID;
            $montlyRent->building_id = $bid;
            $montlyRent->room_id = $rid;
            $montlyRent->landlord_id = $lid;
            $montlyRent->generate_month = '2020-09-01 00:00:00';
            $montlyRent->amount = $roomRent;
          

            $montlyRent->save();
}
 
            


        return redirect()->back()->with('adminsuccess', 'Admin Added Successfully');
            
            
   


 
 }

 


         public function storeManualPayments(Request $request)
    {
        // save 

        $manuals = Payment::create( $request->all());

        $depo_date = $request->deposit_at; 


        $date = new \Datetime($depo_date);


        $manualsdate = $date->format('Y-m-d H:i:s');
 
        // dd($manuals); die();

        $manuals->deposit_at = $manualsdate;
 
        $manuals->save(); 

        // redirect to same page        

        return redirect()->back()->with('titlesuccess', 'Manual Payment Created Successfully!'); 

    }

 // manual payments

        public function payManual($id)
    {

      $tenant =  DB::table('tenants')->where('id', '=', $id)->first();

      // required amount

      if (isset($tenant->lease)) {
      
          $roomID = $tenant->lease->room->id;

          }else{

          $roomID = 1;

          }

        $utilityRent = 'rent';

        $amount = DB::table("room_utilities")->where( 'room_id', $roomID )->where( 'utility_type', $utilityRent )->sum('amount');

        return view('tenant.account.pay')
            ->with([
                'tenant' => $tenant,
                'amount' => $amount
            ]);
    }
 



    public function activateRoom($id){


        DB::table('rooms')->where( 'id', '=', $id)->update(['is_vacant' => 1]);
        

  
        return back()->with('titlesuccess', 'Room Activated Successfully!');
    }

    public function unLease($id){

    // echo $tenant_id;

    //   $tenant = Tenant::where('tenant_id',$tenant_id)->first();

    // $id = $tenant->id;

      $lease =  DB::table('leases')->where('tenant_id', '=', $id)->first();

       $rid = $lease->room_id;


        DB::table('rooms')->where( 'id', '=', $rid)->update(['is_vacant' => 1]);


        DB::table('leases')->where('tenant_id', '=', $id)->delete();




        return back()->with('titlesuccess', 'Tenant Unleased Successfully!');
    }

     public function allTenants()
    {
        //

       $tenants = DB::table('tenants')->get();



        return view('accounts.all_tenants', compact('tenants'));
    }



     public function occupants()
    {
      // $occupants = (new TenantRepository())->occupants();

       $occupants = DB::table('leases')->get();


        return view('accounts.occupants', compact('occupants'));
    }

      public function monthlyBalance(Request $request)
    {
        //particulars

           $expenses = DB::table("expenses")->sum('amount');

           // expected rent
           $deposit = DB::table("rooms")->sum('deposit');
           $expected_rent = DB::table("rooms")->sum('rent');

            $utilityRent = 'rent';

          $not_vacant = 0;
          
             $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityRent)->sum('amount');

             // monthly calcs
      $getMonths = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        $monthly_filter = $request->input('monthly_filter');
        $year_filter = $request->input('year_filter');
        
        // var_dump($monthly_filter); die();

        // mpesa monthly


        $mpesa_balance_months = DB::table('mpesa_transactions')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('mpesa_transactions.trans_amount');

        // cash monthly
        $mpesaIncome = 'Mpesa';
        $cashIncome = 'Cash';
        $bankIncome = 'Bank';
         $cash_balance_months = DB::table("payments")->where('payment_method',$cashIncome)
         ->whereMonth('created_at', $monthly_filter)
         ->whereYear('created_at', '=', $year_filter)
         ->sum('amount');

        // bank monthly

        $bank_balance_months = DB::table("payments")->where('payment_method',$bankIncome)
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('amount');

        // bank monthly

        $mpesa_manual_balance_months = DB::table("payments")->where('payment_method',$mpesaIncome)
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('payments.amount');
        

        // echo "<pre>"; print_r($mpesa_balance_months); die;

        return view('accounts.balance_sheet_monthly', compact('mpesa_balance_months','expenses','deposit','expected_rent','expected_rent_utilities','getMonths','mpesa_manual_balance_months','bank_balance_months','cash_balance_months','monthly_filter','year_filter'));
    }


          public function monthlyTPL(Request $request)
    {
        //particulars


        // expected rent
        $deposit = DB::table("rooms")->sum('deposit');
        $expected_rent = DB::table("rooms")->sum('rent');

        $utilityRent = 'rent';

        $not_vacant = 0;
          
       $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityRent)->sum('amount');

        // monthly calcs
        $getMonths = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        $monthly_filter = $request->input('monthly_filter');
        $year_filter = $request->input('year_filter');
        
        // var_dump($monthly_filter); die();

        // expenses monthly


          $build_monthly_expenses =DB::table('building_expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->get();

        $build_monthly_expenses_sum =DB::table('building_expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('building_expenses.expense_amount');

             $monthly_expenses =DB::table('expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->get();

        $monthly_expenses_sum =DB::table('expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('expenses.amount');

        $monthly_disbursments = DB::table('disburses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('disburses.amount');

         $monthly_external_income = DB::table('external_incomes')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('external_incomes.income_amount');

        

        // mpesa monthly

        $mpesa_balance_months = DB::table('mpesa_transactions')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('mpesa_transactions.trans_amount');

        // cash monthly
        $mpesaIncome = 'Mpesa';
        $cashIncome = 'Cash';
        $bankIncome = 'Bank';
         $cash_balance_months = DB::table("payments")->where('payment_method',$cashIncome)
         ->whereMonth('created_at', $monthly_filter)
         ->whereYear('created_at', '=', $year_filter)
         ->sum('amount');

        // bank monthly

        $bank_balance_months = DB::table("payments")->where('payment_method',$bankIncome)
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('amount');

        // bank monthly

        $mpesa_manual_balance_months = DB::table("payments")->where('payment_method',$mpesaIncome)
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('payments.amount');
        

        // echo "<pre>"; print_r($mpesa_balance_months); die;

        return view('accounts.profit_loss_monthly', compact('mpesa_balance_months','monthly_expenses','build_monthly_expenses','build_monthly_expenses_sum','monthly_disbursments','monthly_expenses_sum','deposit','expected_rent','monthly_external_income','expected_rent_utilities','getMonths','mpesa_manual_balance_months','bank_balance_months','cash_balance_months','monthly_filter','year_filter'));
    }

      public function balanceSheet()
    {
        //

       $balance_months = MpesaTransaction::select(
       DB::raw('sum(trans_amount) as `sums`'),
       DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
       DB::raw('max(created_at) as createdAt')
)
      ->where("created_at", ">", \Carbon\Carbon::now()->subMonths(6))
      ->orderBy('createdAt', 'desc')
      ->groupBy('months')
      ->get();

      // var_dump($balance_months); die();

      $getMonths = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        return view('accounts.balance_sheet', compact('balance_months','getMonths'));
    }

          public function profitLoss()
    {
        //
      $getMonths = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        return view('accounts.profit_loss', compact('getMonths'));
    }

          public function expenseSummary()
    {
        //

        return view('accounts.expense_summary');
    }

          public function monthlySales()
    {
        //

        return view('accounts.monthly_sales');
    }

    public function incomeStatement()
    {
        //

            // monthly calcs
        $getMonths = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        

         return view('accounts.income_statement', compact('getMonths'));

      }

          public function incomeStatementMonthly(Request $request)
    {
        //

            // monthly calcs
        $getMonths = ["01","02","03","04","05","06","07","08","09","10","11","12"];

        $monthly_filter = $request->input('monthly_filter');
        $year_filter = $request->input('year_filter');

        
    $utilityRent = 'rent';

        $not_vacant = 0;
          
       $expected_rent_utilities = DB::table( 'room_utilities' )->select( 'room_utilities.*')->leftJoin( 'rooms', 'rooms.id', '=', 'room_utilities.room_id' )->where( 'rooms.is_vacant', '=', $not_vacant )->where('utility_type', '=', $utilityRent)->sum('amount');

          $build_monthly_expenses =DB::table('building_expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->get();

        $build_monthly_expenses_sum =DB::table('building_expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('building_expenses.expense_amount');

        $monthly_expenses =DB::table('expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->get();

        $monthly_expenses_sum =DB::table('expenses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('expenses.amount');

        $monthly_disbursments = DB::table('disburses')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('disburses.amount');

         $monthly_external_income = DB::table('external_incomes')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('external_incomes.income_amount');

        

        // mpesa monthly

        $mpesa_balance_months = DB::table('mpesa_transactions')
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('mpesa_transactions.trans_amount');

        // cash monthly
        $mpesaIncome = 'Mpesa';
        $cashIncome = 'Cash';
        $bankIncome = 'Bank';
         $cash_balance_months = DB::table("payments")->where('payment_method',$cashIncome)
         ->whereMonth('created_at', $monthly_filter)
         ->whereYear('created_at', '=', $year_filter)
         ->sum('amount');

        // bank monthly

        $bank_balance_months = DB::table("payments")->where('payment_method',$bankIncome)
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('amount');

        // bank monthly

        $mpesa_manual_balance_months = DB::table("payments")->where('payment_method',$mpesaIncome)
        ->whereMonth('created_at', $monthly_filter)
        ->whereYear('created_at', '=', $year_filter)
        ->sum('payments.amount');


          return view('accounts.income_statement_monthly', compact('mpesa_balance_months','monthly_expenses','build_monthly_expenses','build_monthly_expenses_sum','monthly_disbursments','monthly_expenses_sum','monthly_external_income','expected_rent_utilities','getMonths','mpesa_manual_balance_months','bank_balance_months','cash_balance_months','monthly_filter','year_filter'));
    }

          public function accountTitles()
    {
        //

        return view('accounts.account_titles');
    }

        public function storeTitle(Request $request)
    {
        // save 

        $titles = AccountTitle::create( $request->all());
 
 
        $titles->save(); 

        // redirect to same page        

        return redirect()->back()->with('titlesuccess', 'Account Title Created Successfully'); 

    }


            public function storeBuildingExpenses(Request $request)
    {
        // save 

        $building_expenses = BuildingExpense::create( $request->all());
 
 
        $building_expenses->save(); 

        // redirect to same page        

        return redirect()->back()->with('building_expense_success', 'Building Expense Created Successfully'); 

    }



            public function storeBuildingIncome(Request $request)
    {
        // save 

        $building_income = ExternalIncome::create( $request->all());
 
 
        $building_income->save(); 

        // redirect to same page        

        return redirect()->back()->with('building_income_success', 'Building External Income Created Successfully'); 

    }


            public function storeEntry(Request $request)
    {

        $entries = JournalEntry::get();

        // save 

        $entry = JournalEntry::create( $request->all());
 
 
        $entry->save(); 


        // redirect to same page        

        return redirect()->back()->with('entrysuccess', 'Single Journal Entry Created Successfully'); 

    }


    // journal titles/items

     public function storeEntryTitle(Request $request)
    {
        // save 

        $entry_title = JournalTitle::create( $request->all());
 
 
        $entry_title->save(); 


        // redirect to same page        

        return redirect()->back()->with('journal_titlesuccess', 'Journal Title Created Successfully'); 

    }

          public function accountTitlesView()
    {
        //

                $titles = AccountTitle::get();

        return view('accounts.view_titles', compact( 'titles' ) );

       
    }

 

      public function createJournalTitle()
    {
        //

        $journal_titles = JournalTitle::get();

        $accountTitlesList = AccountTitle::get();
        return view('accounts.create_journal_title', compact('accountTitlesList','journal_titles'));

    }



     public function createBuildingExpense( $id = null ) {

        $landlord = Landlord::where( 'id', $id )->first();
      

        $all_buildings = Building::where('landlord_id', $id)->get();
        $landlords = Landlord::get();

        return view('accounts.create_building_expense', compact('all_buildings','landlords','landlord'));

    }

   
     public function createBuildingIncome( $id = null ) {

        $landlord = Landlord::where( 'id', $id )->first();

        $all_buildings = Building::get();
        $landlords = Landlord::get();
        return view('accounts.create_external_income', compact('all_buildings','landlords','landlord'));

    }


              public function journalTitlesView()
    {
        //

                $journal_titles = JournalTitle::get();

        return view('accounts.create_journal_title', compact( 'journal_titles' ) );

       
    }




    public function createJournalEntry( $id = null ) {

        $journal_name = JournalTitle::where( 'id', $id )->first();

        $accountTitlesList = AccountTitle::get();

        // $journal_entries = JournalEntry::where('title_id','=',$id)->orderBy('id','DESC')->get();

        $journal_entries = DB::table('journal_entries')->where('title_id','=',$id)->orderBy('id', 'DESC')->get();


 
        // var_dump($journal_name); die(); 

        return view('accounts.create_journal', compact('journal_name','accountTitlesList','journal_entries'));
    }



             public function viewJournals()
    {

             //



        $journal_entries = JournalEntry::get();


 
        // var_dump($journal_name); die(); 

        return view('accounts.view_journals', compact('journal_entries'));

    }

             public function incomeCharts()
              
    {
        //

        return view('accounts.income_charts');
    }

             public function expenseCharts()
    {
        //

        return view('accounts.expense_charts');
    }

    public function receiptReports()
    {
        //     
          $receipts =Payment::orderBy('id','DESC')->get();

          // var_dump($receipts); die;

        return view('accounts.receipts_report',compact('receipts'));
    }

        public function landLords()
    {
        //  

  $landlords =Landlord::get();


        return view('accounts.landlords',compact('landlords'));
    }


  public function disburseLandlords()
    {
        //     

        return view('accounts.disburse_landlords');
    }

            public function viewlandLords()
    {
        //     

        return view('accounts.landlords_simplified');
    }

    public function viewBuildings()
    {
        // 

            $landlord_buildings = Building::get();


        return view('accounts.buildings', compact('landlord_buildings'));
    }

 public function viewOptBuildings()
    {
    
    //     

    $landlord_buildings = Building::get();


        return view('accounts.opt_buildings', compact('landlord_buildings'));
    }


     public function singleBuilding()
    {
        //     

        return view('accounts.explore_building');
    }
     public function singleTenant($id=null)
    {
        //     


         $tenant = Tenant::where( 'id', $id )->first();

        return view( 'accounts.explore_tenant', compact('tenant'));
    }

 
 


     public function viewExpenses()
    {
        //     

        return view('accounts.expenses');
    }




        public function receiptMpesaReports()
    {
        //     

          $receipts =MpesaTransaction::orderBy('id','DESC')->get();


        return view('accounts.mpesa_receipts_report',compact('receipts'));
    }
    

     public function exploreLandlord( $id = null ) {

        $landlord = Landlord::where( 'id', $id )->first();

        return view( 'accounts.explore_landlord', compact('landlord'));

     }

          public function exploreBuilding( $id = null ) {

         $building = Building::where( 'id', $id )->first();

        return view( 'accounts.explore_building', compact('building'));

     }



    public function buildingExpe( $id = null ) {

        $building = Building::where( 'id', $id )->first();

        return view( 'accounts.create_building_expe', compact('building'));

     }


    public function buildingInc( $id = null ) {

        $building = Building::where( 'id', $id )->first();

        return view( 'accounts.create_external_inc', compact('building'));

     }

    // Show receipt in print receipt blade file(front view)

    public function printReceipt( $id = null ) {

        $receipt = Payment::where( 'id', $id )->first();
  

        $receipts = Payment::all();
 
        $receipt_tenant = Tenant::where( 'id', $receipt->tenant_id )->first();
        $receipt_served = User::where( 'id', $receipt->user_id )->first();

        // Getting only tenant related receipts without the current one


        // current month payments
        $currentMonthPayments = date('m');
        $payment_data = DB::table("payments")
            ->whereRaw('MONTH(created_at) = ?',[$currentMonthPayments])
            ->get();
            // print_r($payment_datas); die();

            // var_dump($payment_datas); die();  


        $relatedReceipts = Payment::where( 'id', '!=', $id )->where( [ 'tenant_id' => $receipt->tenant_id ] )->get();



        return view( 'accounts.print_receipt', compact( 'receipt', 'receipts', 'relatedReceipts','receipt_tenant','receipt_served','payment_data') );
    }

    

        // Show receipt in print receipt blade file(front view)

    public function printMpesaReceipt( $id = null ) {

        $mpesa_receipt = MpesaTransaction::where( 'id', $id )->first();
  

        $mpesa_receipts = MpesaTransaction::all();
 
        $mpesa_receipt_tenant = Tenant::where( 'phone_number', $mpesa_receipt->MSISDN )->first();

        $mpesa_receipt_served = 'Mpesa Transacted';

        // Getting only tenant related mpesa_receipts without the current one


        // current month payments
        $currentMonthMpesaPayments = date('m');
        $mpesa_payment_data = DB::table("mpesa_transactions")
            ->whereRaw('MONTH(created_at) = ?',[$currentMonthMpesaPayments])
            ->get();
            // print_r($payment_datas); die();

            // var_dump($payment_datas); die();  


        $relatedmpesa_receipts = MpesaTransaction::where( 'id', '!=', $id )->where( [ 'MSISDN' => $mpesa_receipt->MSISDN ] )->get();



        return view( 'accounts.print_mpesa_receipt', compact( 'mpesa_receipt', 'mpesa_receipts', 'relatedmpesa_receipts','mpesa_receipt_tenant','mpesa_receipt_served','mpesa_payment_data') );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function editTenant( $id, Request $request ) {

    Tenant::where( 'id', '=', $id)->update(['phone_number' => $request->get('phone_number'), 'gender' => $request->get('gender')]);

    return back()->with('tenant_edit_success','Tenant Info Updated Successfully!');
  }


    public function editBuilding( $id, Request $request ) {

    Building::where( 'id', '=', $id)->update(['commission_rate' => $request->get('commission_rate')]);

    return back()->with('building_edit_success','Building Info Updated Successfully!');
  }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
