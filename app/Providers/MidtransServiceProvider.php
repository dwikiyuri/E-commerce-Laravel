<?php

namespace App\Providers;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\ServiceProvider;

class MidtransServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Inisialisasi konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($params)
    {
        return Snap::createTransaction($params);
    }
}
