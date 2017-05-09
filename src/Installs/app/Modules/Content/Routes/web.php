<?php

$module = 'content';

Route::group(['as' => $module.'.', 'prefix' => $module, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

    /* ================== Page Content Editor ================== */
    Route::resource('pages_contents', 'PageContentController');
    Route::get('pages_contents_dt_ajax', 'PageContentController@dtajax');
    Route::get('pages_contents_page_ajax', 'PageContentController@pageajax');
    Route::post('pages_contents/openTab', 'PageContentController@openTab');

	/* ================== Uploads ================== */
	Route::resource('uploads', 'UploadsController');
	Route::post('upload_files', 'UploadsController@upload_files');
	Route::get('uploaded_files', 'UploadsController@uploaded_files');
	Route::post('uploads_update_caption', 'UploadsController@update_caption');
	Route::post('uploads_update_filename', 'UploadsController@update_filename');
	Route::post('uploads_update_public', 'UploadsController@update_public');
	Route::post('uploads_delete_file', 'UploadsController@delete_file');
});
