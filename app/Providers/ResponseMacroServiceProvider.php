<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        // Success Api
        Response::macro('success', function ($data = []) {
            return Response::json([
                'message' => "Success",
                'errors'  => false,
                'data' => $data,
                'status' => 200
            ],200);
        });

        // Error Api
        Response::macro('error', function ($message, $data = [], $status = 400) {
            return Response::json([
                'message' => $message,
                'errors'  => true,
                'data' => $data,
                'status' => $status
            ],$status);
        });

        // Missing arguments response
        Response::macro('missing', function ($missing) {
            return Response::json([
                'message' => "Missing arguments",
                'errors'  => true,
                'data' => $missing,
                'status' => 400
            ],400);
        });
    }

}