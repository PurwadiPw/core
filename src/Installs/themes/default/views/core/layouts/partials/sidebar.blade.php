<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
        <span>
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);" aria-expanded="false">
                    <img src="{{ Theme::asset('default::img/avatars/sunny.png') }}" alt="{{ Auth::user()->name }}" class="online" />
                    <span>
                        {{ Auth::user()->name }} 
                    </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/employees/'.Auth::user()->id.'#general-info') }}">Profil</a>
                    </li>
                    <li>
                        <a href="{{ url(config('core.adminRoute').'/employees/'.Auth::user()->id.'#setting') }}">Edit Password</a>
                    </li>
                </ul>
            </li>
        </span>
    </div>
    <!-- end user info -->

    <nav>
        <ul>
            <li>
                <a href="#" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <?php
            $menuItems = Pw\Core\Models\Menu::where("parent", 0)->where("is_backend", 1)->where("active", 1)->orderBy('hierarchy', 'asc')->get();
            ?>
            @foreach ($menuItems as $menu)
                @if($menu->type == "crud")
                    <?php
                    $temp_crud_obj = Crud::get($menu->id);
                    ?>
                    @core_access($temp_crud_obj->id)
                        @if(isset($crud->id) && $crud->name == $menu->name)
                            <?php echo CoreHelper::print_menu($menu ,true); ?>
                        @else
                            <?php echo CoreHelper::print_menu($menu); ?>
                        @endif
                    @endcore_access
                @else
                    <?php echo CoreHelper::print_menu($menu); ?>
                @endif
            @endforeach
        </ul>
    </nav>

    <span class="minifyme" data-action="minifyMenu">
        <i class="fa fa-arrow-circle-left hit"></i>
    </span>

</aside>