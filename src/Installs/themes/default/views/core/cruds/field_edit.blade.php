@extends("default::core.layouts.app")

@section("contentheader_title", "Crud Field")
@section("contentheader_description", "Crud Field Editing")
@section("section", "Crud Field")
@section("sub_section", "Editing")
@section("htmlheader_title", "Crud Field Editing")

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
                            {!! Form::model($field, ['route' => ['developer.crud_fields.update', $field->id ], 'method'=>'PUT', 'id' => 'field-edit-form']) !!}
                                {{ Form::hidden("module_id", $crud->id) }}
                                
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
                                    {{ Form::select("field_type", $ftypes, null, ['class'=>'form-control', 'required' => 'required']) }}
                                </div>
                                
                                <div id="unique_val">
                                    <div class="form-group">
                                        <label for="unique">Unique:</label>
                                        {{ Form::checkbox("unique", "unique") }}
                                        <div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="defaultvalue">Default Value :</label>
                                    {{ Form::text("defaultvalue", null, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
                                </div>
                                
                                <div id="length_div">
                                    <div class="form-group">
                                        <label for="minlength">Minimum :</label>
                                        {{ Form::number("minlength", null, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="maxlength">Maximum :</label>
                                        {{ Form::number("maxlength", null, ['class'=>'form-control', 'placeholder'=>'Default Value']) }}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="required">Required:</label>
                                    {{ Form::checkbox("required", "required") }}
                                    <div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
                                </div>
                                
                                <div class="form-group values">
                                    <label for="popup_vals">Values :</label>
                                    <?php
                                    $default_val = "";
                                    $popup_value_type_table = false;
                                    $popup_value_type_list = false;
                                    if(starts_with($field->popup_vals, "@")) {
                                        $popup_value_type_table = true;
                                        $default_val = str_replace("@", "", $field->popup_vals);
                                    } else if(starts_with($field->popup_vals, "[")) {
                                        $popup_value_type_list = true;
                                        $default_val = json_decode($field->popup_vals);
                                    }
                                    ?>
                                    <div class="radio" style="margin-bottom:20px;">
                                        <label>{{ Form::radio("popup_value_type", "table", $popup_value_type_table) }} From Table</label>
                                        <label>{{ Form::radio("popup_value_type", "list", $popup_value_type_list) }} From List</label>
                                    </div>
                                    {{ Form::select("popup_vals_table", $tables, $default_val, ['class'=>'form-control', 'rel' => '']) }}
                                    
                                    <select class="form-control popup_vals_list" rel="taginput" multiple="1" data-placeholder="Add Multiple values (Press Enter to add)" name="popup_vals_list[]">
                                        @if(is_array($default_val))
                                            @foreach ($default_val as $value)
                                                <option selected>{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    
                                    <?php
                                    // print_r($tables);
                                    ?>
                                </div>
                                
                                <br>
                                <div class="form-group">
                                    {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url('developer/cruds/'.$crud->id) }}">Cancel</a></button>
                                </div>
                            {!! Form::close() !!}
                            
                            @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif
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
@push('scripts')
<script>
$(function () {
    $("select.popup_vals_list").show();
    $("select.popup_vals_list").next().show();
    $("select[name='popup_vals_table']").hide();
    
    function showValuesSection() {
        var ft_val = $("select[name='field_type']").val();
        if(ft_val == 7 || ft_val == 15 || ft_val == 18 || ft_val == 20) {
            $(".form-group.values").show();
        } else {
            $(".form-group.values").hide();
        }
        
        $('#length_div').removeClass("hide");
        if(ft_val == 2 || ft_val == 4 || ft_val == 5 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 21 || ft_val == 24 ) {
            $('#length_div').addClass("hide");
        }
        
        $('#unique_val').removeClass("hide");
        if(ft_val == 1 || ft_val == 2 || ft_val == 3 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 20 || ft_val == 21 || ft_val == 24 ) {
            $('#unique_val').addClass("hide");
        }
    }

    $("select[name='field_type']").on("change", function() {
        showValuesSection();
    });
    showValuesSection();

    function showValuesTypes() {
        console.log($("input[name='popup_value_type']:checked").val());
        if($("input[name='popup_value_type']:checked").val() == "list") {
            $("select.popup_vals_list").show();
            $("select.popup_vals_list").next().show();
            $("select[name='popup_vals_table']").hide();
        } else {
            $("select[name='popup_vals_table']").show();
            $("select.popup_vals_list").hide();
            $("select.popup_vals_list").next().hide();
        }
    }
    
    $("input[name='popup_value_type']").on("change", function() {
        showValuesTypes();
    });
    showValuesTypes();

    $.validator.addMethod("data-rule-banned-words", function(value) {
        return $.inArray(value, ['files']) == -1;
    }, "Column name not allowed.");
});
</script>
@endpush
