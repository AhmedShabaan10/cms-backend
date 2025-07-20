<?php



use App\Http\Controllers\UiController\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UiController\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);


});

