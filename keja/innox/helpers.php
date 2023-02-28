<?php

use App\DB\Building\RoomUtility;

if (!function_exists('getActiveParentRoute')) {
    function getActiveParentRoute($prefix)
    {

        return explode('/', \Illuminate\Support\Facades\Route::current()->uri())[0] == $prefix ? true : false;
    }
}
if (!function_exists('getActiveRoute')) {
    function getActiveRoute($route)
    {

        return $route == url()->current() ? "active" : "";
    }
}
if (!function_exists('accessDenied')) {
    function accessDenied($message = "Access Denied Talk to System Admin")
    {
        return flash($message)->error()->important();
    }
}
if (!function_exists('setting')) {
    function setting($key, $default = '')
    {

        if (\Illuminate\Support\Facades\Cache::has('setting_'. $key))
        {
            return \Illuminate\Support\Facades\Cache::get("setting_{$key}");
        }
        $setting = \App\DB\Setting::where('key', $key)->first();
        if (isset($setting->value)) {
            $default = $setting->value;

        }
        \Illuminate\Support\Facades\Cache::add("setting_{$key}", $default);
        return $default;
    }
}
if (!function_exists('room_utility')) {
    function room_utility($roomId, $type, $utility, $default = 0)
    {

        $setting = RoomUtility::where(['room_id' => $roomId, 'utility_type' => $type, 'utility' => $utility])->first();

        if (isset($setting->amount)) {
            $default = $setting->amount;
        }
        return $default;
    }
}
if (!function_exists('roomTypes')) {
    function roomTypes()
    {
        return [
            'Single rooms',
            'Double rooms',
            'Shops',
            'Bedsitters',
            'One bedrooms',
            'Two bedrooms',
            'Three bedrooms',
            'Four bedrooms',
            'Five bedrooms',
            'Own compound',
            'Open ground',
            'Car wash',
            'Garage',
            'Offices',
        ];
    }
}
if (!function_exists('utilitiesBills')) {
    function utilitiesBills()
    {
        return [
            'water' => 0,
            'security' => 0,
            'garbage collections' => 0,
            'electricity' => 0,
            'caretaker' => 0
        ];
    }
}
if (!function_exists('paymentMethods')) {
    function paymentMethods()
    {
        $methods  =  [
            'Mpesa',
            'Cash',
            'Bank'
        ];

        if(! setting('allow_cash_payment', false))
        {
            $methods = array_diff($methods , ['Cash']);
        }
        return $methods;

    }
}

if (!function_exists('skins')) {
    function skins()
    {
        return [
            'green',
            'blue',
            'black',
            'purple',
            'red',
            'yellow',
            'red-light',
            'green-light',
            'blue-light',
            'yellow-light',
            'purple-light',
            'purple',
            'black-light',
        ];

    }
}


if ( ! function_exists('mpesa_security'))
{
    function mpesa_security()
    {

        $publicKey = storage_path('app'. DIRECTORY_SEPARATOR.'cert.cer');
        $plaintext = "YOUR_PASSWORD";

        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        echo base64_encode($encrypted);
    }
}
