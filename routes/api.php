<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Mail;

Route::get('/health', function (Mail $mailer) {
    try {
        // DB check
        DB::connection()->getPdo();
        $dbStatus = 'OK';
    } catch (\Throwable $e) {
        $dbStatus = 'ERROR: ' . $e->getMessage();
    }

    Route::options('/{any}', function () {
        return response()->noContent(Response::HTTP_NO_CONTENT);
    })->where('any', '.*');


    return response()->json([
        'app'    => config('app.name'),
        'env'    => config('app.env'),
        'php'    => PHP_VERSION,
        'db'     => $dbStatus,
        // 'queue'  => $queueStatus,
        'time'   => now()->toDateTimeString(),
        'status' => 'OK'
    ]);
});

Route::apiResource('appointments', AppointmentController::class);
Route::apiResource('contacts', ContactController::class);

