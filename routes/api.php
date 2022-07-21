<?php

use App\Clases\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v2022/megci'], function () {

    Route::post('/actualizarPedido', function (Request $request) {
        //actualizar de la api estatus=Enviado pdf, rastreo, paqueteria, 
        $rules = [  
            'idPedido' => ['required', 'Int'],
            'estatus' => ['Enviado / Pedido', 'string'] ,
            'numeroRastreo' => 'string',
            'paqueteria' => 'string',
            'pdf' => 'string'
        ];
        
        if(!$request->idPedido){ 
            return Tools::jsonResponseError("Definir idPedido",$rules);
        }else{
            $u = DB::table('pedidos')->where('id', $request->idPedido)->update([
                'estatus' => $request->estatus, #  Enviado / Pedido
                'pdf' => $request->pdf,
                'rastreo' => $request->numeroRastreo,
                'paqueteria' => $request->paqueteria
            ]);
            if($u){return Tools::jsonResponseSuccess("Registros Actualizado",[ $u ]); }
            else{ return Tools::jsonResponseError("Error al actualizarl el pedido");}
        }

    });
 
    // return Tools::jsonResponseSuccess("Registros Listados",[ ]);
    
    //return \Tools::jsonResponseError("");

  
    
});
