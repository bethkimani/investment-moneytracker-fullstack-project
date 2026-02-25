<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;

Route::apiResource('users', UserController::class);
Route::apiResource('users.wallets', WalletController::class)->shallow();
Route::apiResource('wallets.transactions', TransactionController::class)->shallow();
