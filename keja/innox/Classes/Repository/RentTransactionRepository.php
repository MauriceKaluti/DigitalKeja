<?php


namespace Innox \Classes\Repository;
use App\DB\Landlord\Landlord;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\UserFilter;
use Modules\RentTransaction\Entities\LandlordTransaction;

Class RentTransactionRepository
{


	public function all(Request $request)
	{
	    return app(Pipeline::class)
            ->send(LandlordTransaction::query())
            ->through([
                IdFilter::class,
                DateBetweenFilter::class,
                UserFilter::class
            ])
            ->thenReturn()
            ->orderBy('month','asc')
            ->get();
	}

	public function store(Request $request , Landlord $landlord)
	{
       try{
           for ($i = 0 ; $i < sizeof($request['amount']) ; $i++)
           {
               $landlord->landlordTransactions()
                   ->create([
                       'transaction_type'  => $request['type'][$i],
                       'user_id'           => $request->user()->id,
                       'reason'            => $request['reason'][$i],
                       'amount'            => $request['amount'][$i],
                       'month'            => $request['month'],
                   ]);
           }
           flash("saved the transactions")
               ->success()
               ->important();

           return back();


       }catch (\Exception $exception)
       {
           flash($exception->getMessage())
               ->error()
               ->important();
           return back();
       }

	}
	public function update(Request $request , LandlordTransaction  $transaction)
	{
	    $transaction->update([
            'transaction_type'  => $request['type'],
            'user_id'           => $request->user()->id,
            'reason'            => $request['reason'],
            'amount'            => $request['amount']
        ]);
	// TODO: Implement update() method.
	}
	public function delete(Request $request, LandlordTransaction  $transaction)
	{
	    $transaction->delete();

	}
}
