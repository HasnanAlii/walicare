<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class MidtransConfig
{
    public static function init()
    {
        // Log::info('MIDTRANS CONFIG', [
        //     'serverKey' => env('MIDTRANS_SERVER_KEY'),
        //     'isProduction' => env('MIDTRANS_IS_PRODUCTION'),
        // ]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', true);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
