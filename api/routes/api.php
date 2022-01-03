<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::get('clientes', '\App\Http\Controllers\Api\ClienteApiController@index');
Route::resource('clientes', '\App\Http\Controllers\Api\ClienteController');
