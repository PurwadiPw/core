<?php

use Illuminate\Http\Request;

Route::get('/developer', function (Request $request) {
    // return $request->developer();
})->middleware('auth:api');
