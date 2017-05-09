<?php

$module = 'content';

Route::group(['as' => $module.'.', 'prefix' => $module, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Uploads ================== */
	Route::resource('uploads', 'UploadsController');
	Route::post('upload_files', 'UploadsController@upload_files');
	Route::get('uploaded_files', 'UploadsController@uploaded_files');
	Route::post('uploads_update_caption', 'UploadsController@update_caption');
	Route::post('uploads_update_filename', 'UploadsController@update_filename');
	Route::post('uploads_update_public', 'UploadsController@update_public');
	Route::post('uploads_delete_file', 'UploadsController@delete_file');
});
