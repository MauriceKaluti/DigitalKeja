<?php


namespace Innox\Classes\Repository;


use App\DB\Landlord\Landlord;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Contracts\ShouldFilter;

class LandlordRepository implements ShouldFilter
{

    public function filter(array $args = [])
    {
         return app(Pipeline::class)
             ->send(Landlord::query())
             ->through([
                 IdFilter::class,
                 ActiveFilter::class,
                 DateBetweenFilter::class,
             ])
             ->thenReturn()
             ->orderBy('id', 'desc')
             ->get();
    }

    public function store(Request $request)
    {

        try{

            Landlord::create([
                'name'  => $request['name'],
                'email'  => $request['email'],
                'phone_number'  => $request['phone_number'],
                'account_number'  => $request['account_number'],
                'account_name'  => $request['account_name'],
                'bank'  => $request['bank'],
                'address'  => $request['address'],
                'id_no'  => $request['id_no'],
                'commission_type' => $request['commission_type'],
                'commission_value' => $request['commission_value'],

            ]);


            flash('successfully created a new landlord')->success()->important();

            return  redirect()
                ->route('landlord_browse')
                ->send();
        }catch (\Exception $exception)
        {

            flash($exception->getMessage())->error()->important();

            return  back()
                ->withErrors($exception->getMessage())
                ->withInput();

        }

    }

    public function update(Request $request , Landlord $landlord)
    {
        Landlord::updateOrCreate([
            'id' => $landlord->id
        ],[
            'name'  => $request['name'],
            'email'  => $request['email'],
            'phone_number'  => $request['phone_number'],
            'account_number'  => $request['account_number'],
            'account_name'  => $request['account_name'],
            'bank'  => $request['bank'],
            'address'  => $request['address'],
            'id_no'  => $request['id_no'],
            'is_active'  => $request['status'],
            'commission_type' => $request['commission_type'],
            'commission_value' => $request['commission_value'],

        ]);
    }

    public function delete(Landlord $landlord)
    {
        $landlord->delete();
    }
}
