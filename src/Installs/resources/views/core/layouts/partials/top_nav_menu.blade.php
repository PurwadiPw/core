<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
	<ul class="nav navbar-nav">
		<li><a href="{{ url(config('core.adminRoute')) }}">Dashboard</a></li>
		<?php
		$menuItems = Pw\Core\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
		?>
		@foreach ($menuItems as $menu)
			@if($menu->type == "crud")
				<?php
				$temp_crud_obj = Crud::get($menu->name);
				?>
				@core_access($temp_crud_obj->id)
					@if(isset($crud->id) && $crud->name == $menu->name)
						<?php echo CoreHelper::print_menu_topnav($menu ,true); ?>
					@else
						<?php echo CoreHelper::print_menu_topnav($menu); ?>
					@endif
				@endcore_access
			@else
				<?php echo CoreHelper::print_menu_topnav($menu); ?>
			@endif
		@endforeach
	</ul>
	@if(CoreConfigs::getByKey('sidebar_search'))
	<form class="navbar-form navbar-left" role="search">
		<div class="form-group">
			<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
		</div>
	</form>
	@endif
</div><!-- /.navbar-collapse -->