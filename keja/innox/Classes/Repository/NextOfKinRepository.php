<?php


namespace Innox\Classes\Repository;


use App\DB\Tenant\NextOfKin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Innox\Classes\QueryFilter\ActiveFilter;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;

class NextOfKinRepository
{


    public function filter(array $args = [])
    {
        return app(Pipeline::class)
            ->send(NextOfKin::query())
            ->through([
                IdFilter::class,
                DateBetweenFilter::class,
            ])
            ->thenReturn()
            ->get();
    }

    public function create(Request $request)
    {

        return  NextOfKin::create([
            'name'  => $request['kin_name'],
            'phone_number'   => $request['kin_phone_number'],
            'relation'   => $request['kin_relation'],
        ]);

    }
    public function update($id ,Request $request)
    {

        $kin = NextOfKin::where('id', $id)->first();
        $kin->update([
            'name'  => $request['kin_name'],
            'phone_number'   => $request['kin_phone_number'],
            'relation'   => $request['kin_relation'],
        ]);

        return $kin;
    }
    public function attachKinable(Model $model , NextOfKin $kin)
    {

        return  $model->saveKinable($kin);

    }
}
