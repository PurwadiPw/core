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
			"type" => 'module',
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
					"type" => 'crud',
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
		
		// Create Super Admin Role
		$role = new Role;
		$role->name = "DEVELOPER";
		$role->display_name = "Developer";
		$role->description = "Developer Access Role";
		$role->parent = 1;
		$role->dept = $dept->id;
		$role->save();
		
		// Create Super Admin Role
		$role = new Role;
		$role->name = "OPERATOR";
		$role->display_name = "Operator";
		$role->description = "Operator Access Role";
		$role->parent = 1;
		$role->dept = $dept->id;
		$role->save();
		
		// Set Full Access For Super Admin Role
		foreach ($modules as $module) {
			$roles = $role->all();
			foreach ($roles as $row) {
				Crud::setDefaultRoleAccess($module->id, $row->id, "full");
			}
		}
		
		// Create Admin Panel Permission
		$perm = new Permission;
		$perm->name = "ADMIN_PANEL";
		$perm->display_name = "Admin Panel";
		$perm->description = "Admin Panel Permission";
		$perm->save();
		
		$roles = $role->all();
		foreach ($roles as $row) {
			$row->attachPermission($perm);
		}
		
		// Generate Core Default Configurations
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename";
		$laconfig->value_id = "Core 1.0";
		$laconfig->value_en = "Core 1.0";
		$laconfig->save();

		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename_part1";
		$laconfig->value_id = "Lara";
		$laconfig->value_en = "Lara";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename_part2";
		$laconfig->value_id = "Admin 1.0";
		$laconfig->value_en = "Admin 1.0";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sitename_short";
		$laconfig->value_id = "LA";
		$laconfig->value_en = "LA";
		$laconfig->save();

		$laconfig = new CoreConfigs;
		$laconfig->key = "site_description";
		$laconfig->value_id = "Core is a open-source Laravel Admin Panel for quick-start Admin based applications and boilerplate for CRM or CMS systems.";
		$laconfig->value_en = "Core is a open-source Laravel Admin Panel for quick-start Admin based applications and boilerplate for CRM or CMS systems.";
		$laconfig->save();

		// Display Configurations
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "sidebar_search";
		$laconfig->value_id = "1";
		$laconfig->value_en = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_messages";
		$laconfig->value_id = "1";
		$laconfig->value_en = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_notifications";
		$laconfig->value_id = "1";
		$laconfig->value_en = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_tasks";
		$laconfig->value_id = "1";
		$laconfig->value_en = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "show_rightsidebar";
		$laconfig->value_id = "1";
		$laconfig->value_en = "1";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "skin";
		$laconfig->value_id = "skin-white";
		$laconfig->value_en = "skin-white";
		$laconfig->save();
		
		$laconfig = new CoreConfigs;
		$laconfig->key = "layout";
		$laconfig->value_id = "fixed";
		$laconfig->value_en = "fixed";
		$laconfig->save();

		// Admin Configurations

		$laconfig = new CoreConfigs;
		$laconfig->key = "default_email";
		$laconfig->value_id = "test@example.com";
		$laconfig->value_en = "test@example.com";
		$laconfig->save();
		
		$modules = Crud::all();
		foreach ($modules as $module) {
			$module->is_gen=true;
			$module->save();	
		}
	}
}
