<?php

namespace App\Providers;

use App\Http\Middleware\CheckToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteMiddlewareServiceProvider extends ServiceProvider
{
   
    // public function register()
    // {
    //     // Mendaftarkan middleware untuk rute tertentu
    //     Route::middleware('check.token', \App\Http\Middleware\CheckToken::class);
    // }
    /**
     * Daftarkan middleware rute khusus di sini.
     *
     * @return void
     */
    public function boot()
    {
        // Daftarkan middleware khusus rute menggunakan alias
        $this->app['router']->aliasMiddleware('check.token', \App\Http\Middleware\CheckToken::class);
    }
}
