<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// PG01: 商品一覧画面
Route::get('/products', [ProductController::class, 'index']);

// PG05: 商品検索
Route::get('/products/search', [ProductController::class, 'index']);

// PG04: 商品登録画面の表示と保存処理
Route::get('/products/register', [ProductController::class, 'create']);
Route::post('/products/register', [ProductController::class, 'store']);

// PG02: 商品詳細画面
Route::get('/products/detail/{productId}', [ProductController::class, 'show']);

// PG03: 商品更新処理
Route::patch('/products/{productId}/update', [ProductController::class, 'update']);

// PG06: 商品削除処理
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy']);
