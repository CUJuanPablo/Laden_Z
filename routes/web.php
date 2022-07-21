<?php
 
use Illuminate\Support\Facades\Route; 
 
Route::get('/dashboard', function () { return view('dashboard'); })->middleware('auth');

Route::get('/','\Modules\Auth\Controllers\LoginController@create')->name('login')->middleware('guest'); 
Route::get('/resetPassword','\Modules\Auth\Controllers\LoginController@reset');
Route::post('/login','\Modules\Auth\Controllers\LoginController@store');
Route::post('/logout','\Modules\Auth\Controllers\LoginController@destroy');
Route::post('/resetPassword', '\Modules\Auth\Controllers\LoginController@resetPassword')->middleware('guest')->name('password.reset');
Route::get('/newPassword/{id}/{token}', '\Modules\Auth\Controllers\LoginController@newPasswordShow')->middleware('guest');
Route::post('/newPassword', '\Modules\Auth\Controllers\LoginController@newPassword')->middleware('guest');

Route::get('/perfil','\Modules\Perfil\Controllers\PerfilController@show')->middleware('auth');
Route::get('/cupones','\Modules\Cupones\Controllers\CuponesController@show')->middleware('auth');

Route::get('/monedero','\Modules\Monedero\Controllers\MonederoController@show')->middleware('auth');
Route::get('/red','\Modules\Red\Controllers\RedController@show')->middleware('auth');


Route::group(['prefix'=>'pedidos'], function () {
    Route::get('/','\Modules\Pedidos\Controllers\PedidosController@show')->middleware('auth');
    Route::get('/nuevoPedido','\Modules\Pedidos\Controllers\PedidosController@nuevoPedidoShow')->middleware('auth');

    Route::get('/productos/{producto}','\Modules\Pedidos\Controllers\PedidosController@BuscadorProductos');
    Route::get('/producto/{producto}','\Modules\Pedidos\Controllers\PedidosController@BuscadorProducto');
    Route::post('/CrearPedido','\Modules\Pedidos\Controllers\PedidosController@CrearPedido');
    Route::get('/getPedidos','\Modules\Pedidos\Controllers\PedidosController@getPedidos');
    Route::post('/subirPago','\Modules\Pedidos\Controllers\PedidosController@subirPago');
    Route::get('/verComprobante','\Modules\Pedidos\Controllers\PedidosController@verComprobante');
});