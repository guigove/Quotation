<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data = [], $status = 200) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'code' => $status
            ], $status);
        });

        Response::macro('error', function ($message, $status = 400, $errors = []) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'errors' => $errors,
                'code' => $status
            ], $status);
        });
    }
}
