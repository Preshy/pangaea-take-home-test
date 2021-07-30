<?php

use Illuminate\Http\Request;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('test/{num}', function(Request $request) {
    if($request->isJson()) {
        return response()->json(['status' => 'ok', 'message' => 'Data received', 'data' => $request->all()], 200);
    } else {
        return response()->json(['status' => 'error', 'message' => 'Data not received', 'data' => $request->all()], 400);
    }
});