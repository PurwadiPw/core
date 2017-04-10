<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it -->

            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                <img src="{{ Theme::asset('default::img/avatars/sunny.png') }}" alt="me" class="online" />
                <span>
                    john.doe
                </span>
                <i class="fa fa-angle-down"></i>
            </a>

        </span>
    </div>
    <!-- end user info -->

    <nav>
        <ul>
            <li>
                <a href="#" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li>
                <a href="#" title="Dashboard"><i class="fa fa-lg fa-fw fa-desktop"></i> <span class="menu-item-parent">Developer</span></a>
                <ul>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/module') }}" title="Module"><span class="menu-item-parent">Module</span></a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/crud') }}" title="Crud"><span class="menu-item-parent">Crud</span></a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/core_menus') }}" title="Menu"><span class="menu-item-parent">Menu</span></a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/core_pages') }}" title="Pages"><span class="menu-item-parent">Pages</span></a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/core_configs') }}" title="Pengaturan"><span class="menu-item-parent">Pengaturan</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" title="Dashboard"><i class="fa fa-lg fa-fw fa-shield"></i> <span class="menu-item-parent">Authorization</span></a>
                <ul>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/users') }}" title="Users"><span class="menu-item-parent">Users</span></a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/roles') }}" title="Roles"><span class="menu-item-parent">Roles</span></a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/permissions') }}" title="Permissions"><span class="menu-item-parent">Permissions</span></a>
                    </li>
                </ul>
            </li>
            <?php
            $menuItems = Pw\Core\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
            ?>
            @foreach ($menuItems as $menu)
                @if($menu->type == "crud")
                    <?php
                    $temp_crud_obj = Crud::get($menu->id);
                    ?>
                    @core_access($temp_crud_obj->id)
                        @if(isset($crud->id) && $crud->name == $menu->name)
                            <?php //echo CoreHelper::print_menu($menu ,true); ?>
                        @else
                            <?php //echo CoreHelper::print_menu($menu); ?>
                        @endif
                    @endcore_access
                @else
                    <?php //echo CoreHelper::print_menu($menu); ?>
                @endif
            @endforeach
        </ul>
    </nav>

    <span class="minifyme" data-action="minifyMenu">
        <i class="fa fa-arrow-circle-left hit"></i>
    </span>

</aside>