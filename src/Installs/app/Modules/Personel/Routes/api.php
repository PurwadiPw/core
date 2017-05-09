<?php

use Illuminate\Http\Request;

Route::get('/personel', function (Request $request) {
    // return $request->personel();
})->middleware('auth:api');
