@extends("default::core.layouts.app")

@section("contentheader_title", "Crud View")
@section("contentheader_description", "crud view")
@section("section", "Crud View")
@section("sub_section", "View")
@section("htmlheader_title", "Crud View")

@section("content")
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="profile2 no-content-padding">
            @if(isset($crud->is_gen) && $crud->is_gen)
            <div class="bg-success clearfix">
            @else
            <div class="bg-danger clearfix">
            @endif
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="profile-icon text-primary"><i class="fa {{$crud->fa_icon}}"></i></div>
                        </div>
                        <div class="col-md-9">
                            <a class="text-white" href="{{ url('/'.$crud->module.'/'.snake_case($crud->name)) }}"><h4 rel="tooltip" data-placement="left" title="Open {{ $crud->model }} Crud" class="name">{{ $crud->label }}</h4></a>
                            <div class="row stats">
                                <div class="col-md-12">{{ Crud::itemCount($crud->name) }} Items</div>
                            </div>
                            <p class="desc">@if(isset($crud->is_gen) && $crud->is_gen) <div class="label2 success">Crud Sudah di Generate</div> @else <div class="label2 danger" style="border:solid 1px #FFF;">Crud Belum di Generate</div> @endif</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dats1" rel="tooltip" data-placement="left" title="Controller"><i class="fa fa-anchor"></i> {{ $crud->controller }}</div>
                    <div class="dats1" rel="tooltip" data-placement="left" title="Model"><i class="fa fa-database"></i> {{ $crud->model }}</div>
                    <div class="dats1" rel="tooltip" data-placement="left" title="View Column Name"><i class="fa fa-eye"></i>
                        @if($crud->view_col!="")
                            {{$crud->view_col}}
                        @else
                            Belum di tentukan
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    @if($crud->view_col != "")
                        @if(isset($crud->is_gen) && $crud->is_gen)
                            <div class="dats1 text-center"><a rel="tooltip" data-placement="left" title="Update Crud" class="btn btn-sm btn-success" style="border-color:#FFF;" id="generate_update" href="#"><i class="fa fa-refresh"></i> Update Crud</a></div>
                            <div class="dats1 text-center"><a rel="tooltip" data-placement="left" title="Update Migration File" class="btn btn-sm btn-success" style="border-color:#FFF;" id="update_migr" href="#"><i class="fa fa-database"></i> Update Migration</a></div>
                        @else
                            <div class="dats1 text-center"><a rel="tooltip" data-placement="left" title="Generate Migration + CRUD + Crud" class="btn btn-sm btn-success" style="border-color:#FFF;" id="generate_migr_crud" href="#"><i class="fa fa-cube"></i> Generate Migration + CRUD</a></div>

                            <div class="dats1 text-center"><a rel="tooltip" data-placement="left" title="Generate Migration File" class="btn btn-sm btn-success" style="border-color:#FFF;" id="generate_migr" href="#"><i class="fa fa-database"></i> Generate Migration</a></div>
                        @endif
                    @else
                        <div class="dats1 text-center">Untuk menggenerate CRUD atau Migration, tentukan <strong>View Column</strong> dengan menggunakan ikon <i class='fa fa-eye'></i>pada kolom Action</div>
                    @endif
                </div>

                <div class="col-md-1 actions">
                    <button crud_name="{{ $crud->name }}" crud_id="{{ $crud->id }}" rel="tooltip" data-placement="left" title="Hapus Module" class="btn btn-default btn-delete btn-xs delete_crud"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false">
            <header>

                <div class="widget-toolbar pull-left">
                    <a href="{{ url('developer/crud') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="widget-toolbar pull-left">
                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#AddFieldModal">
                        <i class="fa fa-plus"></i> Tambah Field
                    </a>
                </div>
                <ul id="widget-tab-1" class="nav nav-tabs pull-right">

                    <li class="active">
                        <a data-toggle="tab" href="#fields">
                            <i class="fa fa-lg fa-bars"></i>
                            <span class="hidden-mobile hidden-tablet"> Crud Field </span>
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
                                <table id="dt_ajax_fields" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Label</th>
                                        <th>Column</th>
                                        <th>Type</th>
                                        <th>Unique</th>
                                        <th>Default</th>
                                        <th>Min</th>
                                        <th>Max</th>
                                        <th>Required</th>
                                        <th>Values</th>
                                        <th class="text-center"><i class="fa fa-cogs"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($crud->fields as $field)
                                        <tr>
                                            <td class="text-center">{{ $field['id'] }}</td>
                                            <td>{{ $field['label'] }}</td>
                                            <td>{{ $field['colname'] }}</td>
                                            <td>{{ $ftypes[$field['field_type']] }}</td>
                                            <td>@if($field['unique']) <span class="text-danger">True</span>@endif </td>
                                            <td>{{ $field['defaultvalue'] }}</td>
                                            <td>{{ $field['minlength'] }}</td>
                                            <td>{{ $field['maxlength'] }}</td>
                                            <td>@if($field['required']) <span class="text-danger">True</span>@endif </td>
                                            <td><?php echo CoreHelper::parseValues($field['popup_vals']) ?></td>
                                            <td class="text-center">
                                                <a href="{{ url('developer/crud_fields/'.$field['id'].'/edit') }}" class="btn btn-edit-field btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;" id="edit_{{ $field['colname'] }}"><i class="fa fa-edit"></i></a>
                                                <a href="{{ url('developer/crud_fields/'.$field['id'].'/delete') }}" class="btn btn-edit-field btn-danger btn-xs" style="display:inline;padding:2px 5px 3px 5px;" id="delete_{{ $field['colname'] }}"><i class="fa fa-trash"></i></a>
                                                @if($field['colname'] != $crud->view_col)
                                                    <a href="{{ url('developer/cruds/'.$crud->id.'/set_view_col/'.$field['colname']) }}" class="btn btn-edit-field btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;" id="view_col_{{ $field['colname'] }}"><i class="fa fa-eye"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
                            <form action="{{ url('developer/save_role_crud_permissions/'.$crud->id) }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <table class="table table-bordered dataTable no-footer table-access">
                                    <thead>
                                    <tr class="blockHeader">
                                        <th width="14%" class="text-center">
                                            <input class="alignTop" type="checkbox" id="role_select_all" >&nbsp; Roles
                                        </th>
                                        <th width="14%">
                                            <input type="checkbox" id="view_all" >&nbsp; View
                                        </th>
                                        <th width="14%">
                                            <input type="checkbox" id="create_all" >&nbsp; Create
                                        </th>
                                        <th width="14%">
                                            <input type="checkbox" id="edit_all" >&nbsp; Edit
                                        </th>
                                        <th width="14%">
                                            <input class="alignTop" type="checkbox" id="delete_all" >&nbsp; Delete
                                        </th>
                                        <th width="14%">Field Privileges</th>
                                    </tr>
                                    </thead>
                                    @foreach($roles as $role)
                                        <tr class="tr-access-basic" role_id="{{ $role->id }}">
                                            <td><input class="role_checkb" type="checkbox" name="crud_{{ $role->id }}" id="crud_{{ $role->id }}" checked="checked"> {{ $role->name }}</td>

                                            <td><input class="view_checkb" type="checkbox" name="crud_view_{{$role->id}}" id="crud_view_{{$role->id}}" <?php if($role->view == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td><input class="create_checkb" type="checkbox" name="crud_create_{{$role->id}}" id="crud_create_{{$role->id}}" <?php if($role->create == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td><input class="edit_checkb" type="checkbox" name="crud_edit_{{$role->id}}" id="crud_edit_{{$role->id}}" <?php if($role->edit == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td><input class="delete_checkb" type="checkbox" name="crud_delete_{{$role->id}}" id="crud_delete_{{$role->id}}" <?php if($role->delete == 1) { echo 'checked="checked"'; } ?> ></td>
                                            <td>
                                                <a role_id="{{ $role->id }}" class="toggle-adv-access btn btn-default btn-sm hide_row"><i class="fa fa-chevron-down"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="tr-access-adv crud_fields_{{ $role->id }} hide" role_id="{{ $role->id }}" >
                                            <td colspan=6>
                                                <table class="table table-bordered">
                                                    @foreach (array_chunk($crud->fields, 3, true) as $fields)
                                                        <tr>
                                                            @foreach ($fields as $field)
                                                                <td><div class="col-md-3"><input type="text" name="{{ $field['colname'] }}_{{ $role->id }}" value="{{ $role->fields[$field['id']]['access'] }}" data-slider-value="{{ $role->fields[$field['id']]['access'] }}" class="slider form-control" data-slider-min="0" data-slider-max="2" data-slider-step="1" data-slider-orientation="horizontal"  data-slider-id="{{ $field['colname'] }}_{{ $role->id }}"></div> {{ $field['label'] }} </td>
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

    <div class="modal fade" id="AddFieldModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah field pada CRUD {{ $crud->model }}</h4>
                </div>
                {!! Form::open(['route' => 'developer.crud_fields.store', 'id' => 'field-form']) !!}
                {{ Form::hidden("crud_id", $crud->id) }}
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="label">Field Label :</label>
                            {{ Form::text("label", null, ['class'=>'form-control', 'placeholder'=>'Field Label', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'required' => 'required']) }}
                        </div>

                        <div class="form-group">
                            <label for="colname">Column Name :</label>
                            {{ Form::text("colname", null, ['class'=>'form-control', 'placeholder'=>'Column Name (lowercase)', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'data-rule-banned-words' => 'true', 'required' => 'required']) }}
                        </div>

                        <div class="form-group">
                            <label for="field_type">UI Type:</label>
                            {{ Form::select("field_type", $ftypes, null, ['class'=>'select2', 'required' => 'required', 'style' => 'width:100%']) }}
                        </div>

                        <div id="unique_val">
                            <div class="form-group">
                                <label for="unique">Unique:</label>
                                {{ Form::checkbox("unique", "unique", false, []) }}
                                <div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
                            </div>
                        </div>

                        <div id="default_val">
                            <div class="form-group">
                                <label for="defaultvalue">Default Value :</label>
                                {{ Form::text("defaultvalue", null, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
                            </div>
                        </div>

                        <div id="length_div">
                            <div class="form-group">
                                <label for="minlength">Minimum :</label>
                                {{ Form::number("minlength", null, ['class'=>'form-control', 'placeholder'=>'Minimum Value']) }}
                            </div>

                            <div class="form-group">
                                <label for="maxlength">Maximum :</label>
                                {{ Form::number("maxlength", null, ['class'=>'form-control', 'placeholder'=>'Maximum Value']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="required">Required:</label>
                            {{ Form::checkbox("required", "required", false, []) }}
                            <div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
                        </div>

                        <div class="values">
                            <div class="form-group">
                                <label for="popup_vals">Values :</label>
                                <div class="radio" style="margin-bottom:20px;">
                                    <label>{{ Form::radio("popup_value_type", "table", true) }} From Table</label>
                                    <label>{{ Form::radio("popup_value_type", "list", false) }} From List</label>
                                </div>
                                <div id="popup_vals_table">
                                    {{ Form::select("popup_vals_table", $tables, "", ['class'=>'select2 form-control', 'rel' => '']) }}
                                </div>
                            </div>

                            <div class="form-group" id="popup_vals_list">
                                <input name="popup_vals_list[]" class="form-control tagsinput" value="Satu,Dua,Tiga" data-role="tagsinput" data-placeholder="Add Multiple values (Press Enter to add)">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
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

    $("#generate_migr_crud").on("click", function() {
        var $fa = $(this).find("i");
        $fa.removeClass("fa-cube");
        $fa.addClass("fa-refresh");
        $fa.addClass("fa-spin");
        $.ajax({
            url: "{{ url('developer/crud_generate_migr_crud') }}/"+{{ $crud->id }},
            method: 'GET',
            success: function( data ) {
                $fa.removeClass("fa-refresh");
                $fa.removeClass("fa-spin");
                $fa.addClass("fa-check");
                // console.log(data);
                location.reload();
            }
        });
    });

    $("#generate_migr").on("click", function() {
        var $fa = $(this).find("i");
        $fa.removeClass("fa-database");
        $fa.addClass("fa-refresh");
        $fa.addClass("fa-spin");
        $.ajax({
            url: "{{ url('developer/crud_generate_migr') }}/"+{{ $crud->id }},
            method: 'GET',
            success: function( data ) {
                $fa.removeClass("fa-refresh");
                $fa.removeClass("fa-spin");
                $fa.addClass("fa-check");
                // console.log(data);
                location.reload();
            }
        });
    });

    $("#generate_update").on("click", function() {
        var $fa = $(this).find("i");
        $fa.removeClass("fa-database");
        $fa.addClass("fa-refresh");
        $fa.addClass("fa-spin");
        $.ajax({
            url: "{{ url('developer/crud_generate_update') }}/"+{{ $crud->id }},
            method: 'GET',
            success: function( data ) {
                $fa.removeClass("fa-refresh");
                $fa.removeClass("fa-spin");
                $fa.addClass("fa-check");
                // console.log(data);
                location.reload();
            }
        });
    });

    $(".hide_row").on("click", function() {
        var val = $(this).attr( "role_id" );
        var $icon = $(".hide_row[role_id="+val+"] > i");
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

    $("#role_select_all,  #view_all").on("change", function() {
        $(".role_checkb").prop('checked', this.checked);
        $(".view_checkb").prop('checked', this.checked);
        $(".edit_checkb").prop('checked', this.checked)
        $(".create_checkb").prop('checked', this.checked);
        $(".delete_checkb").prop('checked', this.checked);
        $("#role_select_all").prop('checked', this.checked);
        $("#view_all").prop('checked', this.checked);
        $("#create_all").prop('checked', this.checked);
        $("#edit_all").prop('checked', this.checked);
        $("#delete_all").prop('checked', this.checked);
    });

    $("#create_all").on("change", function() {
        $(".create_checkb").prop('checked', this.checked);
        if($('#create_all').is(':checked')){
            $(".role_checkb").prop('checked', this.checked);
            $(".view_checkb").prop('checked', this.checked);
            $("#role_select_all").prop('checked', this.checked);
            $("#view_all").prop('checked', this.checked);
        }
    });

    $("#edit_all").on("change", function() {
        $(".edit_checkb").prop('checked', this.checked);
        if($('#edit_all').is(':checked')){
            $(".role_checkb").prop('checked', this.checked);
            $(".view_checkb").prop('checked', this.checked);
            $("#role_select_all").prop('checked', this.checked);
            $("#view_all").prop('checked', this.checked);
        }
    });

    $("#delete_all").on("change", function() {
        $(".delete_checkb").prop('checked', this.checked);
        if($('#delete_all').is(':checked')){
            $(".role_checkb").prop('checked', this.checked);
            $(".view_checkb").prop('checked', this.checked);
            $("#role_select_all").prop('checked', this.checked);
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
    // console.log(activeTab);

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
