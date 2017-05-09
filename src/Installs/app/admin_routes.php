<?php

/* ================== Homepage ================== */
// Route::get('/', 'HomeController@index');
// Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', '\App\Modules\Content\Http\Controllers\UploadsController@get_file');

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

	/* ================== Backups ================== */
	Route::resource(config('core.adminRoute') . '/backups', 'Core\BackupsController');
	Route::get(config('core.adminRoute') . '/backup_dt_ajax', 'Core\BackupsController@dtajax');
	Route::post(config('core.adminRoute') . '/create_backup_ajax', 'Core\BackupsController@create_backup_ajax');
	Route::get(config('core.adminRoute') . '/downloadBackup/{id}', 'Core\BackupsController@downloadBackup');
});
