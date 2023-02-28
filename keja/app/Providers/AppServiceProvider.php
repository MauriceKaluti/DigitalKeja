<?php

namespace App\Providers;

use App\DB\Building\Building;
use App\DB\Building\Room;
use App\DB\Lease\Payment;
use App\DB\Payment\MpesaTransaction;
use App\DB\Setting;
use App\DB\Tenant;
use App\Observers\Mpesa;
use App\Observers\PaymentObserver;
use App\Observers\SettingObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        // somewhere in a service provider

        Gate::after(function ($user, $ability) {
            return $user->hasRole('Super Admin'); // note this returns boolean
        });

        Relation::morphMap([
            'room'   => Room::class,
            'building'  => Building::class,
            'tenant'    => Tenant::class
        ]);


        $asset_v = config('system.version', 1);
        View::share('asset_v', $asset_v);
        view()->composer('*', function ($view) {

            $date_format = 'd-m-Y H:i';

            return $view->with('date_format', $date_format);
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // OBSERVERS

        Setting::observe(SettingObserver::class);
        Payment::observe(PaymentObserver::class);
        MpesaTransaction::observe(Mpesa::class);
    }
}
