<?php

Route::group(['prefix' => 'DummySlug'], function () {
    Route::get('/', function () {
        dd('Ini adalah index dari module DummyName. Silahkan bikin duniamu!');
    });
});
