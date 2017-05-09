<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 11:32
 */


/* ================== Change Language ================== */
Route::group(['namespace'  => 'Pw\Core\Controllers', 'middleware' => 'web'], function(){
    Route::get('language/{lang}', 'LangController@language')->where('lang', '[A-Za-z_-]+');
});

$as = config('core.adminRoute').'.';

Route::group([
    'namespace'  => 'Pw\Core\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {
    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('core.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'CoreController@index'
        ]);
        */
    });
});