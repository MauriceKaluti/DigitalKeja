<?php


namespace Innox\Traits;


use App\DB\Meta;
use App\DB\Tenant\NextOfKin;
use Illuminate\Database\Eloquent\Model;

trait IsKinable
{
    public function kinable()
    {
        return $this->morphOne(NextOfKin::class,'kinable');

    }

    public function saveKinable(NextOfKin $kin)
    {
        return $this->kinable()->save($kin);
    }


    public function createMeta(Model $model , array $args)
    {
        $meta = Meta::create([
            'key' => $args['key'],
            'value' => $args['value']
        ]);

        $model->saveMeta($meta);
    }
}
