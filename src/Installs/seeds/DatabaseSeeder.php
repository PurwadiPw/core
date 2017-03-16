<?php

use Illuminate\Database\Seeder;

use Pw\Core\Models\Crud;
use Pw\Core\Models\CrudFields;
use Pw\Core\Models\CrudFieldTypes;
use Pw\Core\Models\Menu;
use Pw\Core\Models\CoreConfigs;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		/* ================ Core Seeder Code ================ */
		
		// Generating Module Menus
		$modules = Crud::all();
		$teamMenu = Menu::create([
			"name" => "Team",
			"url" => "#",
			"icon" => "fa-group",
			"type" => 'custom',
			"parent" => 0,
			"hierarchy" => 1
		]);
		foreach ($modules as $module) {
			$parent = 0;
			if($module->name != "Backups") {
				if(in_array($module->name, ["Users", "Departments", "Employees", "Roles", "Permissions"])) {
					$parent = $teamMenu->id;
				}
				Menu::create([
					"name" => $module->name,
					"url" => $module->name_db,
					"icon" => $module->fa_icon,
					"type" => 'module',
					"parent" => $parent
				]);
			}
		}
		
		// Create Administration Department
	   	$dept = new Department;
		$dept->name = "Administration";
		$dept->tags = "[]";
		$dept->color = "#000";
		$dept->save();
		
		// Create Super Admin Role
		$role = new Role;
		$role->name = "SUPER_ADMIN";
		$role->display_name = "Super Admin";
		$role->description = "Full Access Role";
		$role->parent = 1;
		$role->dept = $dept->id;
		$role->save();
		
		// Set Full Access For Super Admin Role
		foreach ($modules as $module) {
			Crud::setDefaultRoleAccess($module->id, $role->id, "full");
		}
		
		// Create Admin Panel Permission
		$perm = new Permission;
		$perm->name = "ADMIN_PANEL";
		$perm->display_name = "Admin Panel";
		$perm->description = "Admin Panel Permission";
		$perm->save();
		
		$role->attachPermission($perm);
		
		// Generate Core Default Configurations
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename";
		$laconfig->value = "Core 1.0";
		$laconfig->save();

		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename_part1";
		$laconfig->value = "Lara";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename_part2";
		$laconfig->value = "Admin 1.0";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename_short";
		$laconfig->value = "LA";
		$laconfig->save();

		$laconfig = new CoreConfigs;
		$laconfig->key = "site_description";
		$laconfig->value = "Core is a open-source Laravel Admin Panel for quick-start Admin based applications and boilerplate for CRM or CMS systems.";
		$laconfig->save();

		// Display Configurations
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sidebar_search";
		$laconfig->value = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_messages";
		$laconfig->value = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_notifications";
		$laconfig->value = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_tasks";
		$laconfig->value = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_rightsidebar";
		$laconfig->value = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "skin";
		$laconfig->value = "skin-white";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "layout";
		$laconfig->value = "fixed";
		$laconfig->save();

		// Admin Configurations

		$laconfig = new CoreConfigs;
		$laconfig->key = "default_email";
		$laconfig->value = "test@example.com";
		$laconfig->save();
		
		$modules = Crud::all();
		foreach ($modules as $module) {
			$module->is_gen=true;
			$module->save();	
		}
	}
}
