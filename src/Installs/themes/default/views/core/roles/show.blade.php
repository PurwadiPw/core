@extends("default::core.layouts.app")

@section("contentheader_title", "Role View")
@section("contentheader_description", "crud view")
@section("section", "Role View")
@section("sub_section", "View")
@section("htmlheader_title", "Role View")

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
                            <a class="text-white" href="#"><h4 rel="tooltip" data-placement="left" title="{{ $role->name }}" class="name">{{ $role->name }}</h4></a>
                            <p class="desc">
                                <div class="label2 success">{{ $role->display_name }}</div> 
                            </p>
                            <div class="row stats">
                                <div class="col-md-12">{{ $role->description }}</div>
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
                    @core_access("Roles", "edit")
                        <a href="{{ url(config('core.adminRoute') . '/roles/'.$role->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
                    @endcore_access
                    
                    @core_access("Roles", "delete")
                        {{ Form::open(['route' => [config('core.adminRoute') . '.roles.destroy', $role->id], 'method' => 'delete', 'style'=>'display:inline']) }}
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
                    <a href="{{ url(config('core.adminRoute').'/roles') }}" class="btn btn-primary">
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
                                                {{ $role->name }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Display Name :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $role->display_name }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Description :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $role->description }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Parent :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $role->parent }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Depth :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $role->depth }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade in" id="access">
                            <div class="guide1">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label><code>Invisible</code></label>
                                        <input type="text" class="slider slider-warning" id="01" value="1" 
                                        data-slider-min="1" 
                                        data-slider-max="3" 
                                        data-slider-step="1" 
                                        data-slider-orientation="horizontal" 
                                        data-slider-value="1" 
                                        data-slider-selection = "before"
                                        data-slider-handle="round">
                                    </div>
                                    <div class="col-sm-4">
                                        <label><code>Read-Only</code></label>
                                        <input type="text" class="slider slider-primary" id="02" value="2" 
                                        data-slider-min="1" 
                                        data-slider-max="3" 
                                        data-slider-step="1" 
                                        data-slider-orientation="horizontal" 
                                        data-slider-value="2" 
                                        data-slider-selection = "before"
                                        data-slider-handle="round">
                                    </div>
                                    <div class="col-sm-4">
                                        <label><code>Write</code></label>
                                        <input type="text" class="slider slider-success" id="03" value="3" 
                                        data-slider-min="1" 
                                        data-slider-max="3" 
                                        data-slider-step="1" 
                                        data-slider-orientation="horizontal" 
                                        data-slider-value="3" 
                                        data-slider-selection = "before"
                                        data-slider-handle="round">
                                    </div>
                                </div>  
                                <!-- <i class="fa fa-circle gray"></i> Invisible <i class="fa fa-circle orange"></i> Read-Only <i class="fa fa-circle green"></i> Write -->
                            </div>
                            <form action="{{ url(config('core.adminRoute') . '/save_crud_role_permissions/'.$role->id) }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <table class="table table-bordered dataTable no-footer table-access">
                                    <thead>
                                        <tr class="blockHeader">
                                            <th width="30%">
                                                <input class="alignTop" type="checkbox" id="crud_select_all" id="crud_select_all" checked="checked">&nbsp; Cruds
                                            </th>
                                            <th width="14%">
                                                <input type="checkbox" id="view_all" checked="checked">&nbsp; View
                                            </th>
                                            <th width="14%">
                                                <input type="checkbox" id="create_all" checked="checked">&nbsp; Create
                                            </th>
                                            <th width="14%">
                                                <input type="checkbox" id="edit_all" checked="checked">&nbsp; Edit
                                            </th>
                                            <th width="14%">
                                            <input class="alignTop" id="delete_all" type="checkbox"  checked="checked">&nbsp; Delete
                                            </th>
                                            <th width="14%">Field Privileges</th>
                                        </tr>
                                    </thead>
                                    @foreach($cruds_access as $crud)
                                        <tr>
                                            <td><input crud_id="{{ $crud->id }}" class="crud_checkb" type="checkbox" name="crud_{{$crud->id}}" id="crud_{{$crud->id}}" checked="checked">&nbsp; {{ $crud->name }}</td>
                                            <td><input crud_id="{{ $crud->id }}" class="view_checkb" type="checkbox" name="crud_view_{{$crud->id}}" id="crud_view_{{$crud->id}}" <?php if($crud->accesses->view == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td><input crud_id="{{ $crud->id }}" class="create_checkb" type="checkbox" name="crud_create_{{$crud->id}}" id="crud_create_{{$crud->id}}" <?php if($crud->accesses->create == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td><input crud_id="{{ $crud->id }}" class="edit_checkb" type="checkbox" name="crud_edit_{{$crud->id}}" id="crud_edit_{{$crud->id}}" <?php if($crud->accesses->edit == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td><input crud_id="{{ $crud->id }}" class="delete_checkb" type="checkbox" name="crud_delete_{{$crud->id}}" id="crud_delete_{{$crud->id}}" <?php if($crud->accesses->delete == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td>
                                                <a crud_id="{{ $crud->id }}" class="toggle-adv-access btn btn-default btn-sm hide_row"><i class="fa fa-chevron-down"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="tr-access-adv crud_fields_{{ $crud->id }} hide" crud_id="{{ $crud->id }}" >
                                            <td colspan=6>
                                                <table class="table table-bordered">
                                                @foreach (array_chunk($crud->accesses->fields, 3, true) as $fields)
                                                    <tr>
                                                        @foreach ($fields as $field)
                                                            <td><div class="col-md-3"><input type="text" name="{{ $field['colname'] }}_{{ $crud->id }}_{{ $role->id }}" value="{{ $field['access'] }}" data-slider-value="{{ $field['access'] }}" class="slider form-control" data-slider-min="0" data-slider-max="2" data-slider-step="1" data-slider-orientation="horizontal"  data-slider-id="{{ $field['colname'] }}_{{ $crud->id }}_{{ $role->id }}"></div> {{ $field['label'] }} </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <!-- widget footer -->
                                <div class="widget-footer text-right">

                                    <input class="btn btn-success" type="submit" name="Save" value="Simpan">

                                </div>
                                <!-- end widget footer -->
                            </form>
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

@push('scripts')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ Theme::asset('default::js/plugin/bootstrap-tags/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/bootstrap-add-clear/bootstrap-add-clear.min.js') }}"></script>

<script>

    $("#popup_vals_list").hide();
    $("#popup_vals_table").show();

    $("select[name='field_type']").on("change", function() {
        showValuesSection();
    });
    showValuesSection();

    $("input[name='popup_value_type']").on("change", function() {
        showValuesTypes();
    });
    showValuesTypes();

    function showValuesSection() {
        // console.log($("select[name='field_type']").val());
        var ft_val = $("select[name='field_type']").val();
        if(ft_val == 7 || ft_val == 15 || ft_val == 18 || ft_val == 20) {
            $(".values").show();
        } else {
            $(".values").hide();
        }

        $('#length_div').removeClass("hide");
        if(ft_val == 2 || ft_val == 4 || ft_val == 5 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 21 || ft_val == 24 ) {
            $('#length_div').addClass("hide");
        }

        $('#unique_val').removeClass("hide");
        if(ft_val == 1 || ft_val == 2 || ft_val == 3 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 20 || ft_val == 21 || ft_val == 24 ) {
            $('#unique_val').addClass("hide");
        }

        $('#default_val').removeClass("hide");
        if(ft_val == 11) {
            $('#default_val').addClass("hide");
        }
    }

    function showValuesTypes() {
        // console.log($("input[name='popup_value_type']:checked").val());
        if($("input[name='popup_value_type']:checked").val() == "list") {
            $("#popup_vals_list").show();
            $("#popup_vals_table").hide();
        } else {
            $("#popup_vals_list").hide();
            $("#popup_vals_table").show();
        }
    }

    $('#field-form').on('submit', function (e) {
        e.preventDefault();
        frmSubmit('#field-form', '#dt_ajax_fields', '#AddFieldModal');
    });

    $(".hide_row").on("click", function() {
        var val = $(this).attr( "crud_id" );
        var $icon = $(".hide_row[crud_id="+val+"] > i");
        if($('.crud_fields_'+val).hasClass('hide')) {
            $('.crud_fields_'+val).removeClass('hide');
            $icon.removeClass('fa-chevron-down');
            $icon.addClass('fa-chevron-up');
        } else {
            $('.crud_fields_'+val).addClass('hide');
            $icon.removeClass('fa-chevron-up');
            $icon.addClass('fa-chevron-down');
        }
    });

    $("#crud_select_all,  #view_all").on("change", function() {
        $(".crud_checkb").prop('checked', this.checked);
        $(".view_checkb").prop('checked', this.checked);
        $(".edit_checkb").prop('checked', this.checked)
        $(".create_checkb").prop('checked', this.checked);
        $(".delete_checkb").prop('checked', this.checked);
        $("#crud_select_all").prop('checked', this.checked);
        $("#view_all").prop('checked', this.checked);
        $("#create_all").prop('checked', this.checked);
        $("#edit_all").prop('checked', this.checked);
        $("#delete_all").prop('checked', this.checked);
    });
    
    $(".crud_checkb,  .view_checkb").on("change", function() {
        var val = $(this).attr( "crud_id" );
        $("#crud_"+val).prop('checked', this.checked)
        $("#crud_view_"+val).prop('checked', this.checked);
        $("#crud_create_"+val).prop('checked', this.checked)
        $("#crud_edit_"+val).prop('checked', this.checked);
        $("#crud_delete_"+val).prop('checked', this.checked);
    });

    $("#create_all").on("change", function() {
        $(".create_checkb").prop('checked', this.checked);
        if($('#create_all').is(':checked')){
            $(".crud_checkb").prop('checked', this.checked);
            $(".view_checkb").prop('checked', this.checked);
            $("#crud_select_all").prop('checked', this.checked);
            $("#view_all").prop('checked', this.checked);
        }
    });

    $("#edit_all").on("change", function() {
        $(".edit_checkb").prop('checked', this.checked);
        if($('#edit_all').is(':checked')){
            $(".crud_checkb").prop('checked', this.checked);
            $(".view_checkb").prop('checked', this.checked);
            $("#crud_select_all").prop('checked', this.checked);
            $("#view_all").prop('checked', this.checked);
        }
    });

    $("#delete_all").on("change", function() {
        $(".delete_checkb").prop('checked', this.checked);
        if($('#delete_all').is(':checked')){
            $(".crud_checkb").prop('checked', this.checked);
            $(".view_checkb").prop('checked', this.checked);
            $("#crud_select_all").prop('checked', this.checked);
            $("#view_all").prop('checked', this.checked);
        }
    });

    $(".slider").each(function(index) {
        var name = $(this).attr('name');
        var handler = $('input[name='+name+']');
        var value = handler.val();
        switch (value) {
            case '0':
                handler.removeClass("orangeslider-primary");
                handler.removeClass("slider-success");
                handler.addClass("slider-warning");
                break;
            case '1':
                handler.removeClass("slider-warning");
                handler.removeClass("slider-success");
                handler.addClass("slider-primary");
                break;
            case '2':
                handler.removeClass("slider-warning");
                handler.removeClass("slider-primary");
                handler.addClass("slider-success");
                break;
        }
    });

    $('.slider').on('slideStop', function(event) {
        var field = $(this).next().attr("name");
        var value = $(this).data('slider').getValue();

        if(value == 0) {
            $(this).removeClass("slider-primary");
            $(this).removeClass("slider-success");
            $(this).addClass("grayslider-warning");
        } else if(value == 1) {
            $(this).removeClass("slider-warning");
            $(this).removeClass("slider-success");
            $(this).addClass("slider-primary");
        } else if(value == 2) {
            $(this).removeClass("slider-warning");
            $(this).removeClass("slider-primary");
            $(this).addClass("slider-success");
        }
    });

    var url = window.location.href;
    var activeTab = url.substring(url.indexOf("#") + 1);

    if(!activeTab.includes("http") && activeTab.length > 1) {
        $('#widget-tab-1 a[href="#'+activeTab+'"]').tab('show');
    } else {
        $('#widget-tab-1 a[href="#fields"]').tab('show');
    }

    var responsiveHelper_dt_ajax_fields = undefined;
    var breakpointDefinition = {
        tablet : 1024,
        phone : 480
    };
    $('#dt_ajax_fields').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
        "t"+
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth" : true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback" : function() {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_dt_ajax_fields) {
                responsiveHelper_dt_ajax_fields = new ResponsiveDatatablesHelper($('#dt_ajax_fields'), breakpointDefinition);
            }
        },
        "rowCallback" : function(nRow) {
            responsiveHelper_dt_ajax_fields.createExpandIcon(nRow);
        },
        "drawCallback" : function(oSettings) {
            responsiveHelper_dt_ajax_fields.respond();
        }
    });
</script>
@endpush
