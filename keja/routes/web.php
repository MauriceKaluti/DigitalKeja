<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cache', function() {
// Artisan::call('route:cache');
Artisan::call('config:cache');
Artisan::call('view:cache');
Artisan::call('event:clear');
// Artisan::call('optimize');
return "Cached!";
});

Route::get('/clear', function() {

Artisan::call('cache:clear');
Artisan::call('config:cache');
Artisan::call('view:clear');
return "Cleared!";
});


use Innox\Classes\Handlers\AdvantaMessageHandler;
Route::get('/', 'HomeController@index')->middleware('auth')->name('home');
Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');


Auth::routes();

//Route::get('/', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/download-upload/{upload}', 'HomeController@download')->name('download');

Route::group([
    'prefix' => 'user',
    'namespace' => 'User',
    'middleware' => 'auth'

], function () {

    Route::get('/browse','UserController@index')->name('user_browse');
    Route::get('/create','UserController@create')->name('user_create');
    Route::post('/store','UserController@store')->name('user_store');
    Route::get('/{user}/edit','UserController@edit')->name('user_edit');
    Route::patch('/{user}/update','UserController@update')->name('user_update');
    Route::delete('/{id}/delete','UserController@destroy')->name('user_delete');

    Route::group([
        'prefix' => 'role',
        'namespace' => 'Role',
        'middleware' => 'auth'
    ], function () {
        Route::get('/browse','RoleController@index')->name('user_role');
        Route::get('/create','RoleController@create')->name('user_role_create');
        Route::post('/store','RoleController@store')->name('user_role_store');
        Route::get('{role}/edit','RoleController@edit')->name('user_role_edit');
        Route::patch('{role}/update','RoleController@update')->name('user_role_update');
    });

});

Route::group([
    'prefix' => 'landlord',
    'namespace'  => 'Landlord',
    'middleware' => 'auth'
], function (){

    Route::get('/browse', 'LandlordController@index')->name('landlord_browse');
    Route::get('/created', 'LandlordController@create')->name('landlord_create');
    Route::post('/store', 'LandlordController@store')->name('landlord_store');
    Route::get('/{landlord}/view', 'LandlordController@show')->name('landlord_read');
    Route::get('/{landlord}/edit', 'LandlordController@edit')->name('landlord_edit');
    Route::patch('/{landlord}/update', 'LandlordController@update')->name('landlord_update');
    Route::get('/{landlord}/', 'LandlordController@destroy')->name('landlord_delete');

    Route::group(['prefix'  => 'disburse','namespace' => 'Disburse'] , function () {

        Route::get('/list','DisburseController@index')->name('landlord_disburse');
        Route::post('/store','DisburseController@store')->name('landlord_disburse_store');
    });
    Route::group(['prefix'  => 'deductions'] , function () {

        Route::get('/list','DeductionController@index')->name('landlord_deduction');
    });
});


Route::group([
    'prefix'     => 'building',
    'namespace'  => 'Building',
    'middleware' => 'auth'
], function (){

    Route::get('/browse', 'BuildingController@index')->name('building_browse');
    Route::get('/create', 'BuildingController@create')->name('building_create');
    Route::post('/store', 'BuildingController@store')->name('building_store');
    Route::get('/{building}/edit', 'BuildingController@edit')->name('building_edit');
    Route::get('/{building}/', 'BuildingController@destroy')->name('building_delete');
    Route::patch('/{building}/update', 'BuildingController@update')->name('building_update');
    Route::get('/{building}/details', 'BuildingController@show')->name('building_read');
    Route::get('/{building}/destroy', 'BuildingController@destroy')->name('building_destroy');
    Route::get('/{building}/setting', 'BuildingController@settings')->name('building_setting');
    Route::post('/{building}/setting/store', 'BuildingController@storeSettings')->name('building_setting_store');

    // Rooms


    Route::group([
        'prefix'     => 'room',
        'middleware' => 'auth'
    ], function (){

        Route::get('/list', 'RoomController@index')->name('room_browse');
        Route::get('/create', 'RoomController@create')->name('room_create');
        Route::post('/store', 'RoomController@store')->name('room_store');
        Route::get('/{room}/edit', 'RoomController@edit')->name('room_edit');
        Route::get('/{room}/activate', 'RoomController@activate')->name('room_activate');
        Route::get('/{room}/details', 'RoomController@show')->name('room_details');
        Route::patch('/{room}/update', 'RoomController@update')->name('room_update');
        Route::get('/pricing', 'RoomController@pricing')->name('room_pricing');
        Route::post('/pricing', 'RoomController@updatePricing')->name('room_pricing');
        Route::get('/{room}', 'RoomController@destroy')->name('room_delete');
    });
});

// Accounts Routes

Route::group([
    'prefix'     => 'accounts',
    'middleware' => 'auth'
], function (){
Route::get( '/monthly_filter_balance', 'AccountsController@monthlyBalance' )->name( 'monthlyBalance' );

Route::get( '/monthly_filter_tpl', 'AccountsController@monthlyTPL' )->name( 'monthlyTPL' );
Route::get( '/monthly_filter_income', 'AccountsController@incomeStatementMonthly' )->name( 'incomeStatementMonthly' );

    Route::get('/generate_monthly_rent', 'AccountsController@storeMonthlyRent')->name('generate_monthly_rent');
    Route::get('/balance_sheet', 'AccountsController@balanceSheet')->name('balance_sheet');
    Route::get('/charts', 'ChartsController@dashCharts')->name('charts');
    Route::get('/profit_loss', 'AccountsController@profitLoss')->name('profit_loss');
    Route::get('/expenses_summary', 'AccountsController@expenseSummary')->name('expenses_summary');
    Route::get('/income_statement', 'AccountsController@incomeStatement')->name('income_statement');
    Route::get('/monthly_sales', 'AccountsController@monthlySales')->name('monthly_sales');
    Route::get('/receipt_reports', 'AccountsController@receiptReports')->name('receipt_reports');
    Route::get('/landlords', 'AccountsController@landLords')->name('landlords');
    Route::get('/buildings', 'AccountsController@viewBuildings')->name('buildings');
    Route::get('/opt_buildings', 'AccountsController@viewOptBuildings')->name('opt_buildings');
    Route::get('/landlords_simplified', 'AccountsController@viewlandLords')->name('landlords_simplified');
    Route::get('/mpesa_receipt_reports', 'AccountsController@receiptMpesaReports')->name('mpesa_receipt_reports');
    Route::get('account_titles', 'AccountsController@accountTitles')->name('account_titles');
    Route::get('view_account_titles', 'AccountsController@accountTitlesView')->name('view_account_titles');
    Route::post('/storeTitle', 'AccountsController@storeTitle')->name('storeTitle');
    Route::post('/store_entry', 'AccountsController@storeEntry')->name('storeEntry');
    Route::post('/store_title', 'AccountsController@storeEntryTitle')->name('storeEntryTitle');    
    Route::get('/create_journal_entry/{id}', 'AccountsController@createJournalEntry')->name('create_journal_entry');
    Route::get('/view_journals', 'AccountsController@viewJournals')->name('view_journals');
    Route::get('/create_journal_title', 'AccountsController@createJournalTitle')->name('create_journal_title');
    Route::get('/view_journal_titles', 'AccountsController@viewJournalTitles')->name('view_journal_titles');
    Route::get('/income_charts', 'AccountsController@incomeCharts')->name('income_charts');
    Route::get('/expense_charts', 'AccountsController@expenseCharts')->name('expense_charts');
    Route::get( 'print_receipt/{id}', 'AccountsController@printReceipt' )->name( 'one.receipt' );
    Route::get( 'print_mpesa_receipt/{id}', 'AccountsController@printMpesaReceipt' )->name( 'one.mpesa_receipt' );
    Route::get( 'preview_journal_entry/{id}', 'AccountsController@previewJournalEntry' )->name( 'preview_journal_entry' );
    Route::match( [ 'get' ], 'single_tenant/{id}', 'AccountsController@singleTenant' )->name( 'one.tenant' );
    Route::match( ['post','get' ], 'update/{id}', 'AccountsController@editTenant' )->name( 'edit.tenant' );
    Route::match( [ 'get'], 'single_building/{id}', 'AccountsController@singleBuilding' )->name( 'one.building' );
    Route::match( [ 'get', 'post' ], 'edit_building/{id}', 'AccountsController@editBuilding' )->name( 'edit.building' );

    Route::get('/all_tenants', 'AccountsController@allTenants')->name('all_tenants');
    Route::get('/occupants', 'AccountsController@occupants')->name('occupants');
    Route::get('/create_building_expense/{id}', 'AccountsController@createBuildingExpense')->name('one.expense');
    Route::get('/create_building_expe/{id}', 'AccountsController@buildingExpe')->name('one.expe');
    Route::get('/create_building_income/{id}', 'AccountsController@createBuildingIncome')->name('one.income');
    Route::get('/create_building_inc/{id}', 'AccountsController@buildingInc')->name('one.inc');

    Route::post('/storeBuildingExpenses', 'AccountsController@storeBuildingExpenses')->name('storeBuildingExpenses');

    Route::post('/storeBuildingIncome', 'AccountsController@storeBuildingIncome')->name('storeBuildingIncome');

    Route::get( '/tenants_data/getTenantData', 'FrontController@getTenantData' )->name( 'tenants_data.getTenantData' );

    Route::post('/storeBuildingIncome', 'AccountsController@storeBuildingIncome')->name('storeBuildingIncome');

    Route::get( 'delete_lease/{id}', 'AccountsController@unLease' )->name( 'unLease' );
    Route::get( 'activate_room/{id}', 'AccountsController@activateRoom' )->name( 'activateRoom' );

    Route::match( [ 'get' ], 'pay_manual/{id}', 'AccountsController@payManual' )->name( 'payManual' );
     Route::post('/storeManualPayments', 'AccountsController@storeManualPayments')->name('storeManualPayments');

    Route::get( 'landlord/{id}', 'AccountsController@exploreLandlord' )->name( 'one.landlord' );
    Route::get( 'building/{id}', 'AccountsController@exploreBuilding' )->name( 'one.building' );

        Route::get('ajax',function () {
     $landlord_id = Input::get('landlord_id');
       //          return $cat_id;
      $buildings = DB::table('buildings')->where('landlord_id', '=',$landlord_id)->get();
        return Response::json($buildings);
        });

 
});

// End Account Routes

Route::group([
    'prefix'     => 'tenant',
    'namespace'  => 'Tenant',
    'middleware' =>  ['auth']
], function (){

    Route::get('/browse', 'TenantController@index')->name('tenant_browse');
    Route::get('create', 'TenantController@create')->name('tenant_create');
    Route::post('store', 'TenantController@store')->name('tenant_store');
        Route::any('update-agreement/{id}', 'TenantController@updateAgreement' )->middleware('auth')->name( 'agreement.update' );

    Route::group([
        'prefix' => "{tenant}"
    ] , function () {
        Route::get('/edit', 'TenantController@edit')->name('tenant_edit');
        Route::patch('/update', 'TenantController@update')->name('tenant_update');
        Route::get('/view', 'TenantController@show')->name('tenant_view');
        Route::get('/pay/{account}', 'TenantController@pay')->name('tenant.pay');
        Route::get('/pay/edit/{account}', 'TenantController@editRent')->name('tenant.pay.edit');
        Route::post('/pay/update/{account}', 'TenantController@updateRent')->name('tenant.pay.update');
        Route::post('/pay/store/{account}', 'TenantController@storePay')->name('tenant.pay.store');
        Route::get('/un-lease', 'TenantController@unlease')->name('tenant_un_lease');
        Route::get('/destroy', 'TenantController@destroy')->name('tenant_delete');
    });
});


Route::group([
    'prefix'     => 'lease',
    'namespace'  => 'Lease',
    'middleware' =>  ['auth']
], function (){

    Route::get('/browse', 'LeaseController@index')->name('lease_browse');
    Route::get('/create', 'LeaseController@create')->name('lease_create');
    Route::post('/store', 'LeaseController@store')->name('lease_store');
    Route::get('/{lease}/edit', 'LeaseController@edit')->name('lease_edit');
    Route::patch('/{lease}/update', 'LeaseController@update')->name('lease_update');
    Route::get('/{lease}/delete', 'LeaseController@destroy')->name('lease_delete');
});

Route::group([
    'prefix'     => 'invoice',
    'namespace'  => 'Invoice',
    'middleware' =>  ['auth']
], function (){

    Route::get('/browse', 'InvoiceController@index')->name('invoice_browse');
    Route::get('/create', 'InvoiceController@create')->name('invoice_create');
    Route::post('/store', 'InvoiceController@store')->name('invoice_store');
    Route::get('/{invoice}/edit', 'InvoiceController@edit')->name('invoice_edit');
    Route::get('/{invoice}/show', 'InvoiceController@show')->name('invoice_show');
    Route::patch('/{invoice}', 'InvoiceController@update')->name('invoice_update');

    // with invoice id
    Route::group(['prefix' => '{invoice}/payment'] , function () {
        Route::get('/create', 'PaymentController@create')->name('invoice_payment_create');
        Route::post('/store', 'PaymentController@store')->name('invoice_payment_store');
    });

    // without invoice id

});

Route::group([
    'prefix'  => 'reports',
    'namespace'  => 'Report',
    'middleware'  => 'auth'
], function () {
    Route::get('/browse','ReportsController@index')->name('report_browse');
    Route::get('/charts','ReportsController@index')->name('chart.index');
    Route::get('/chartsjournal','ReportsController@index')->name('chart.journal');
    Route::get('/payment','ReportsController@payment')->name('report_payment');
    Route::get('/payment/mpesa','ReportsController@mpesaPayment')->name('report_payment_mpesa');
});

Route::group([
    'prefix'  => 'setting',
    'namespace'  => 'Setting',
    'middleware'  => 'auth'
], function () {
    Route::get('/browse','SettingController@index')->name('setting_browse');
    Route::post('/store','SettingController@store')->name('setting_store');
});




Route::group([
    'prefix' =>  'communication',
    'namespace' => 'Communication'
], function () {
    Route::resource('sms', 'SmsController');

    Route::group([
        'prefix'  => 'expenses'
    ], function () {
        Route::get('/browse', 'ExpensesController@index')->name('payment_expenses');
        Route::get('/create', 'ExpensesController@create')->name('payment_expenses_create');
        Route::post('/store', 'ExpensesController@store')->name('payment_expenses_store');
        Route::get('/{expense}', 'ExpensesController@edit')->name('payment_expenses_edit');
        Route::patch('/{expense}', 'ExpensesController@update')->name('payment_expenses_update');
    });
});



Route::group([
    'prefix' =>  'payment',
    'namespace' => 'Invoice'
], function () {
    Route::get('/', 'PaymentController@index')->name('invoice_payment');

    Route::group([
        'prefix'  => 'expenses'
    ], function () {
        Route::get('/browse', 'ExpensesController@index')->name('payment_expenses');
        Route::get('/create', 'ExpensesController@create')->name('payment_expenses_create');
        Route::post('/store', 'ExpensesController@store')->name('payment_expenses_store');
        Route::get('/{expense}', 'ExpensesController@edit')->name('payment_expenses_edit');
        Route::patch('/{expense}', 'ExpensesController@update')->name('payment_expenses_update');
    });
});

Route::get('test-a', function (){

    try {

        foreach (\App\DB\Building\Room::all() as $room) {

            if (! isset($room->building->id))
            {
                $room->building()->delete();
                $room->delete();
            }
        }

       //return (new AdvantaMessageHandler())->send("254714686511","Test Message");
    }
    catch (Exception $exception)
    {
        return $exception->getMessage();
    }
});
