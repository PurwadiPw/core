<?php

use Illuminate\Http\Request;

Route::get('/authorization', function (Request $request) {
    // return $request->authorization();
})->middleware('auth:api');
