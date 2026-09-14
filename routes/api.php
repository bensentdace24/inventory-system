<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustodianController;


Route::apiResource('inventory', InventoryItemController::class);
// New transaction routes
Route::post('withdrawals', [WithdrawalController::class, 'store']);
Route::post('stock-ins', [StockInController::class, 'store']);
Route::post('returns', [ReturnController::class, 'store']);

Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);

Route::get('custodians', [CustodianController::class, 'index']);
Route::post('custodians', [CustodianController::class, 'store']);
// Resulting routes:
// GET    /api/inventory            -> index   (Main Page data table)
// POST   /api/inventory            -> store   (Add New Item)
// GET    /api/inventory/{id}       -> show
// PUT    /api/inventory/{id}       -> update
// DELETE /api/inventory/{id}       -> destroy
