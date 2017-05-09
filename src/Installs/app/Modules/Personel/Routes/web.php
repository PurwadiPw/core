<?php

$module = 'personel';

Route::group(['as' => $module.'.', 'prefix' => $module, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Employees ================== */
	Route::resource('employees', 'EmployeesController');
	Route::get('employee_dt_ajax', 'EmployeesController@dtajax');
	Route::post('change_password/{id}', 'EmployeesController@change_password');

	/* ================== Departments ================== */
	Route::resource('departments', 'DepartmentsController');
	Route::get('department_dt_ajax', 'DepartmentsController@dtajax');

	/* ================== Organizations ================== */
	Route::resource('organizations', 'OrganizationsController');
	Route::get('organization_dt_ajax', 'OrganizationsController@dtajax');
});
