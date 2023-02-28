<?php


namespace Innox\Classes\Repository;

use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Meta;
use Illuminate\Support\Facades\DB;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\LandlordFilter;
use Innox\Contracts\ShouldFilter;

use App\DB\Payment\Expense;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\ExpenseTypeFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\QueryFilter\UserFilter;

class ExpensesRepository
{
    public function all()
    {
         return app(Pipeline::class)
             ->send(Expense::query())
             ->through([
                 IdFilter::class,
                 UserFilter::class,
                 ExpenseTypeFilter::class,
                 DateBetweenFilter::class
             ])
             ->thenReturn()
             ->get();
    }
    public function filter(array $args = [])
    {
       $filter = [
           IdFilter::class,
           LandlordFilter::class,
           DateBetweenFilter::class,
       ];
       if (isset($args['active']))
       {
           $filter[] = ActiveFilter::class;
       }

       return  app(Pipeline::class)
           ->send(Building::query())
           ->through($filter)
           ->thenReturn()
           ->get();
    }
    public function store(Request $request)
    {
        return Expense::create([
            'amount'  => $request['amount'],
            'user_id'  => $request->user()->id,
            'note'    => $request['note'],
            'type'   => $request['type']
        ]);
    }
    public function update(Request $request , Expense $expense)
    {
        return $expense->update([
            'amount'  => $request['amount'],
            'user_id'  => $request->user()->id,
            'note'    => $request['note'],
            'type'   => $request['type']
        ]);
    }

}
