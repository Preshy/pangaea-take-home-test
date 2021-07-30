<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SubscriptionController;

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

// Create a subscription
$router->post('subscribe/{topic}', 'SubscriptionController@subscribeTopic');

// Publish message to topic (server)
$router->post('publish/{topic}', 'PublisherController@publicTopic');
