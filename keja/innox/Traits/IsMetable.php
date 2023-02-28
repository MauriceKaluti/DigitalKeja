<?php


namespace Innox\Traits;


use App\DB\Meta;
use Illuminate\Database\Eloquent\Model;

trait IsMetable
{
    public function metable()
    {
        return $this->morphMany(Meta::class,'metable');

    }

    public function saveMeta(Meta $meta)
    {
        return $this->metable()->save($meta);
    }
    public function deleteMeta(Meta $meta)
    {
        return $this->metable()->delete($meta);
    }

    public function getMeta($key , $default = '')
    {
        if (\Illuminate\Support\Facades\Cache::has('meta_'. $key))
        {
            return \Illuminate\Support\Facades\Cache::get("metable_{$key}");
        }
        $setting = $this->metable()->where('key', $key)->first();
        if (isset($setting->value)) {
            $default = $setting->value;

        }

        \Illuminate\Support\Facades\Cache::put("meta_{$key}", $default);
        return $default;

    }


    public function createMeta(Model $model , array $args)
    {
        $meta = Meta::create([
            'key' => $args['key'],
            'value' => $args['value']
        ]);

        \Illuminate\Support\Facades\Cache::put("meta_{$meta->key}", $meta->value);
        $model->saveMeta($meta);
    }
}
