@extends("default::core.layouts.app")

@section("contentheader_title", "Employee")
@section("contentheader_description", "Employee Editing")
@section("section", "Employee")
@section("sub_section", "Editing")
@section("htmlheader_title", "Employee Editing")

@section("content")

    <div id="content">

        <!-- @include('default::core.layouts.partials.page-title') -->

        <section id="widget-grid" class="">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"

                -->
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>@hasSection('htmlheader_title') @yield('htmlheader_title') @endif</h2>

                    <div class="jarviswidget-ctrls" role="menu">
                        <a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" id="module-refresh-form" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">

                        
                        <div class="col-md-8 col-md-offset-2">
                            {!! Form::model($employee, ['route' => ['personel.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'role-edit-form']) !!}
                                @core_input($crud, 'name')
                                @core_input($crud, 'designation')
                                @core_input($crud, 'gender')
                                @core_input($crud, 'mobile')
                                @core_input($crud, 'email')
                                @core_input($crud, 'dept')
                                @core_input($crud, 'city')
                                @core_input($crud, 'address')
                                @core_input($crud, 'about')
                                <div class="form-group">
                                    <label for="role">Role* :</label>
                                    <select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
                                        <?php $roles = App\Modules\Authorization\Models\Role::all(); ?>
                                        @foreach($roles as $role)
                                            @if($role->id != 1 || Entrust::hasRole("SUPER_ADMIN"))
                                                @if($user->hasRole($role->name))
                                                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                                @else
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url('personel/employees') }}">Cancel</a></button>
                                </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->
        </section>
    </div>
@endsection
