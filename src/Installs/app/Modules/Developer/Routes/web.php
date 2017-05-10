<?php

$module = 'developer';

Route::group(['as' => $module.'.', 'prefix' => $module, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

    /* ================== Modules ================== */
    Route::resource('modules', 'ModuleController');
    Route::post('act_module/{act}/{slug}', 'ModuleController@act_module');

    /* ================== Cruds ================== */
    Route::resource('cruds', 'CrudController');
    Route::resource('crud_fields', 'FieldController');
    Route::get('crud_generate_crud/{model_id}', 'CrudController@generate_crud');
    Route::get('crud_generate_migr/{model_id}', 'CrudController@generate_migr');
    Route::get('crud_generate_update/{model_id}', 'CrudController@generate_update');
    Route::get('crud_generate_migr_crud/{model_id}', 'CrudController@generate_migr_crud');
    Route::get('cruds/{model_id}/set_view_col/{column_name}', 'CrudController@set_view_col');
    Route::post('save_role_crud_permissions/{id}', 'CrudController@save_role_crud_permissions');
    Route::get('save_crud_field_sort/{model_id}', 'CrudController@save_crud_field_sort');
    Route::post('check_unique_val/{field_id}', 'FieldController@check_unique_val');
    Route::get('crud_fields/{id}/delete', 'FieldController@destroy');
    Route::post('get_crud_files/{crud_id}', 'CrudController@get_crud_files');

    /* ================== Menu Editor ================== */
    Route::resource('menus', 'MenuController');
    Route::post('menus/update_hierarchy', 'MenuController@update_hierarchy');

    /* ================== Page Editor ================== */
    Route::resource('pages', 'PageController');
    Route::get('pages_dt_ajax', 'PageController@dtajax');
    Route::post('pages/openTab', 'PageController@openTab');

    /* ================== Configuration ================== */
    Route::resource('configs', '\App\Http\Controllers\Core\CoreConfigController');

});
