<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 09/03/17
 * Time: 11:32
 */

$as = config('core.adminRoute').'.';

Route::group([
    'namespace'  => 'Pw\Core\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {

    /* ================== Modules ================== */
    Route::resource(config('core.adminRoute') . '/crud', 'CrudController');
    Route::resource(config('core.adminRoute') . '/crud_fields', 'FieldController');
    Route::get(config('core.adminRoute') . '/crud_generate_crud/{model_id}', 'CrudController@generate_crud');
    Route::get(config('core.adminRoute') . '/crud_generate_migr/{model_id}', 'CrudController@generate_migr');
    Route::get(config('core.adminRoute') . '/crud_generate_update/{model_id}', 'CrudController@generate_update');
    Route::get(config('core.adminRoute') . '/crud_generate_migr_crud/{model_id}', 'CrudController@generate_migr_crud');
    Route::get(config('core.adminRoute') . '/cruds/{model_id}/set_view_col/{column_name}', 'CrudController@set_view_col');
    Route::post(config('core.adminRoute') . '/save_role_crud_permissions/{id}', 'CrudController@save_role_crud_permissions');
    Route::get(config('core.adminRoute') . '/save_crud_field_sort/{model_id}', 'CrudController@save_crud_field_sort');
    Route::post(config('core.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
    Route::get(config('core.adminRoute') . '/crud_fields/{id}/delete', 'FieldController@destroy');
    Route::post(config('core.adminRoute') . '/get_crud_files/{crud_id}', 'CrudController@get_crud_files');

    /* ================== Menu Editor ================== */
    Route::resource(config('core.adminRoute') . '/core_menus', 'MenuController');
    Route::post(config('core.adminRoute') . '/core_menus/update_hierarchy', 'MenuController@update_hierarchy');

    /* ================== Configuration ================== */
    Route::resource(config('core.adminRoute') . '/core_configs', '\App\Http\Controllers\Core\CoreConfigController');

    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('core.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LAController@index'
        ]);
        */
    });
});