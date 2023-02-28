<?php

namespace App\Observers;

use App\DB\Setting;

class SettingObserver
{
    public function created(Setting $setting)
    {

        \Illuminate\Support\Facades\Cache::put("setting_{$setting->key}", $setting->value);
    }

    public function updated(Setting $setting)
    {

        \Illuminate\Support\Facades\Cache::put("setting_{$setting->key}", $setting->value);
    }
}
