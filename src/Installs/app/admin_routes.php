<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'Core\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Pw\Core\Helpers\CoreHelper::laravel_ver() == 5.4) {
	$as = config('core.adminRoute').'.';
	
	// Routes for Laravel 5.4
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('core.adminRoute'), 'Core\DashboardController@index');
	Route::get(config('core.adminRoute'). '/dashboard', 'Core\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('core.adminRoute') . '/users', 'Core\UsersController');
	Route::get(config('core.adminRoute') . '/user_dt_ajax', 'Core\UsersController@dtajax');
	
	/* ================== Uploads ================== */
	Route::resource(config('core.adminRoute') . '/uploads', 'Core\UploadsController');
	Route::post(config('core.adminRoute') . '/upload_files', 'Core\UploadsController@upload_files');
	Route::get(config('core.adminRoute') . '/uploaded_files', 'Core\UploadsController@uploaded_files');
	Route::post(config('core.adminRoute') . '/uploads_update_caption', 'Core\UploadsController@update_caption');
	Route::post(config('core.adminRoute') . '/uploads_update_filename', 'Core\UploadsController@update_filename');
	Route::post(config('core.adminRoute') . '/uploads_update_public', 'Core\UploadsController@update_public');
	Route::post(config('core.adminRoute') . '/uploads_delete_file', 'Core\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('core.adminRoute') . '/roles', 'Core\RolesController');
	Route::get(config('core.adminRoute') . '/role_dt_ajax', 'Core\RolesController@dtajax');
	Route::post(config('core.adminRoute') . '/save_crud_role_permissions/{id}', 'Core\RolesController@save_crud_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('core.adminRoute') . '/permissions', 'Core\PermissionsController');
	Route::get(config('core.adminRoute') . '/permission_dt_ajax', 'Core\PermissionsController@dtajax');
	Route::post(config('core.adminRoute') . '/save_permissions/{id}', 'Core\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('core.adminRoute') . '/departments', 'Core\DepartmentsController');
	Route::get(config('core.adminRoute') . '/department_dt_ajax', 'Core\DepartmentsController@dtajax');
	
	/* ================== Employees ================== */
	Route::resource(config('core.adminRoute') . '/employees', 'Core\EmployeesController');
	Route::get(config('core.adminRoute') . '/employee_dt_ajax', 'Core\EmployeesController@dtajax');
	Route::post(config('core.adminRoute') . '/change_password/{id}', 'Core\EmployeesController@change_password');
	
	/* ================== Organizations ================== */
	Route::resource(config('core.adminRoute') . '/organizations', 'Core\OrganizationsController');
	Route::get(config('core.adminRoute') . '/organization_dt_ajax', 'Core\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('core.adminRoute') . '/backups', 'Core\BackupsController');
	Route::get(config('core.adminRoute') . '/backup_dt_ajax', 'Core\BackupsController@dtajax');
	Route::post(config('core.adminRoute') . '/create_backup_ajax', 'Core\BackupsController@create_backup_ajax');
	Route::get(config('core.adminRoute') . '/downloadBackup/{id}', 'Core\BackupsController@downloadBackup');
});
