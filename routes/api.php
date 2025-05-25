<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\CacheLockController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\JobBatchController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OauthAccessTokenController;
use App\Http\Controllers\OauthAuthCodeController;
use App\Http\Controllers\OauthClientController;
use App\Http\Controllers\OauthDeviceCodeController;
use App\Http\Controllers\OauthRefreshTokenController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidosItemController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProdutoVarianteController;
use App\Http\Controllers\ProdutoVarianteEstoqueController;
use App\Http\Controllers\ProdutosEstoqueController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
// CRUD:START
Route::apiResource('cache', CacheController::class);
Route::apiResource('cache-lock', CacheLockController::class);
Route::apiResource('coupons', \App\Http\Controllers\CouponController::class);
Route::apiResource('job-batch', JobBatchController::class);
Route::apiResource('job', JobController::class);
Route::apiResource('oauth-access-token', OauthAccessTokenController::class);
Route::apiResource('oauth-auth-code', OauthAuthCodeController::class);
Route::apiResource('oauth-client', OauthClientController::class);
Route::apiResource('oauth-device-code', OauthDeviceCodeController::class);
Route::apiResource('oauth-refresh-token', OauthRefreshTokenController::class);
Route::apiResource('pedido', PedidoController::class);
Route::get('pedidos/{pedido}/approve', [PedidoController::class,'approve']);
Route::get('pedidos/{pedido}/cancel', [PedidoController::class,'cancel']);
Route::apiResource('pedidos-item', PedidosItemController::class);
Route::apiResource('produtos', ProdutoController::class);
Route::apiResource('produto-variante', ProdutoVarianteController::class);
Route::apiResource('produto-variante-estoque', ProdutoVarianteEstoqueController::class);
Route::apiResource('produtos-estoque', ProdutosEstoqueController::class);
Route::apiResource('session', SessionController::class);
Route::apiResource('user', UserController::class);
Route::apiResource('checkout', CheckoutController::class);
Route::post('checkout/discount', [CheckoutController::class,'aplicarDesconto']);
Route::post('checkout/webhook', [CheckoutController::class,'webhook']);
Route::post('checkout/sendMail', [CheckoutController::class,'sendMail']);
// CRUD:END
