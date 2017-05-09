<?php

use Illuminate\Http\Request;

Route::get('/content', function (Request $request) {
    // return $request->content();
})->middleware('auth:api');
