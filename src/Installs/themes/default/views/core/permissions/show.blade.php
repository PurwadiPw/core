@extends("default::core.layouts.app")

@section("contentheader_title", "Permission View")
@section("contentheader_description", "crud view")
@section("section", "Permission View")
@section("sub_section", "View")
@section("htmlheader_title", "Permission View")

@section("content")
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="profile2 no-content-padding">
            <div class="bg-success clearfix">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="profile-icon text-primary"><i class="fa fa-users"></i></div>
                        </div>
                        <div class="col-md-9">
                            <a class="text-white" href="#"><h4 rel="tooltip" data-placement="left" title="{{ $permission->name }}" class="name">{{ $permission->name }}</h4></a>
                            <p class="desc">
                                <div class="label2 success">{{ $permission->display_name }}</div> 
                            </p>
                            <div class="row stats">
                                <div class="col-md-12">{{ $permission->description }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dats1" rel="tooltip" data-placement="left" title="Controller"><i class="fa fa-anchor"></i>AAA</div>
                    <div class="dats1" rel="tooltip" data-placement="left" title="Model"><i class="fa fa-database"></i>BBB</div>
                    <div class="dats1" rel="tooltip" data-placement="left" title="View Column Name"><i class="fa fa-eye"></i>CCC</div>
                </div>

                <div class="col-md-4">
                </div>

                <div class="col-md-1 actions">
                    @core_access("Permissions", "edit")
                        <a href="{{ url('authorization/permissions/'.$permission->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
                    @endcore_access
                    
                    @core_access("Permissions", "delete")
                        {{ Form::open(['route' => ['authorization.permissions.destroy', $permission->id], 'method' => 'delete', 'style'=>'display:inline']) }}
                            <button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
                        {{ Form::close() }}
                    @endcore_access
                </div>
            </div>
        </div>

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false">
            <header>

                <div class="widget-toolbar pull-left">
                    <a href="{{ url(config('core.adminRoute').'/permissions') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <ul id="widget-tab-1" class="nav nav-tabs pull-right">

                    <li class="active">
                        <a data-toggle="tab" href="#fields">
                            <i class="fa fa-lg fa-bars"></i>
                            <span class="hidden-mobile hidden-tablet"> General Info </span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#access">
                            <i class="fa fa-lg fa-key"></i>
                            <span class="hidden-mobile hidden-tablet"> Access </span>
                        </a>
                    </li>

                </ul>
            </header>

            <!-- widget div-->
            <div>

                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->

                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body no-padding">

                    <!-- widget body text-->

                    <div class="tab-content no-padding">
                        <div class="tab-pane fade in active" id="fields">

                            <div class="custom-scroll table-responsive">
                                <div class="panel infolist">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Name :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $permission->name }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Display Name :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $permission->display_name }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Description :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $permission->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade in" id="access">

                            <div class="panel infolist">
                                <form action="{{ url(config('core.adminRoute').'/save_permissions/'.$permission->id) }}"  method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="panel-default panel-heading">
                                        <h4>Permissions for Roles</h4>
                                    </div>
                                    <div class="panel-body">
                                        @foreach ($roles as $role)
                                            <div class="form-group">
                                                <label for="ratings_innovation" class="col-md-2">{{ $role->display_name }} :</label>
                                                <div class="col-md-10 fvalue star_class">
                                                    <?php
                                                    $query = DB::table('permission_role')->where('permission_id', $permission->id)->where('role_id', $role->id);
                                                    ?>
                                                    @if($query->count() > 0)
                                                        <input type="checkbox" name="permi_role_{{ $role->id }}" value="1" checked>
                                                    @else
                                                        <input type="checkbox" name="permi_role_{{ $role->id }}" value="1">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        <div class="form-group">
                                            <label for="ratings_innovation" class="col-md-2"></label>
                                            <div class="col-md-10 fvalue star_class">
                                                <input class="btn btn-success" type="submit" value="Save">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- end widget body text-->

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->
    </div>
    <!-- END MAIN CONTENT -->
@endsection
