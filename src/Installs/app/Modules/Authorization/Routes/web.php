<?php

$module = 'authorization';

Route::group(['as' => $module.'.', 'prefix' => $module, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Users ================== */
	Route::resource('users', 'UsersController');
	Route::get('user_dt_ajax', 'UsersController@dtajax');

	/* ================== Roles ================== */
	Route::resource('roles', 'RolesController');
	Route::get('role_dt_ajax', 'RolesController@dtajax');
	Route::post('save_crud_role_permissions/{id}', 'RolesController@save_crud_role_permissions');

	/* ================== Permissions ================== */
	Route::resource('permissions', 'PermissionsController');
	Route::get('permission_dt_ajax', 'PermissionsController@dtajax');
	Route::post('save_permissions/{id}', 'PermissionsController@save_permissions');
});
