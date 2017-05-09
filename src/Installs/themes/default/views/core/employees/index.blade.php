@extends("default::core.layouts.app")

@section("contentheader_title", "Employees")
@section("contentheader_description", "Employees Listing")
@section("section", "Employees")
@section("sub_section", "Listing")
@section("htmlheader_title", "Employees Listing")

@section("addButton")
    <div class="widget-toolbar">
        <a href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-plus"></i> Add @hasSection('section') @yield('section') @endif
        </a>
    </div>
@endsection

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

                    @hasSection('addButton')
                        @yield('addButton')
                    @endif

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

                        <div class="custom-scroll table-responsive">
                            <table id="dt_ajax" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr class="success">
                                    @foreach( $listing_cols as $col )
                                    <th>{{ $crud->fields[$col]['label'] or ucfirst($col) }}</th>
                                    @endforeach
                                    @if($show_actions)
                                    <th>Actions</th>
                                    @endif
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">@hasSection('section') Add @yield('section') @endif()</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        {!! Form::open(['route' => 'personel.employees.store', 'id' => 'employees-add-form', 'class' => '']) !!}
                            @core_input($crud, 'name')
                            @core_input($crud, 'designation')
                            @core_input($crud, 'gender')
                            @core_input($crud, 'mobile')
                            @core_input($crud, 'email')
                            @core_input($crud, 'dept')
                            @core_input($crud, 'city')
                            @core_input($crud, 'address')
                            @core_input($crud, 'about')
                            @core_input($crud, 'date_birth')
                            <div class="form-group">
                                <label for="role">Role* :</label>
                                <select name="role" style="width:100%" class="form-control" required>
                                    <?php $roles = App\Modules\Authorization\Models\Role::all(); ?>
                                    @foreach($roles as $role)
                                        @if($role->id != 1)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submitButton" class="btn btn-primary" id="employees-add-submit">
                        Save
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('scripts')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ Theme::asset('default::js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/bootstrap-add-clear/bootstrap-add-clear.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>

<script>

    var responsiveHelper_dt_ajax = undefined;
    var breakpointDefinition = {
        tablet : 1024,
        phone : 480
    };
    /* TABLETOOLS */
    $('#dt_ajax').dataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ url('personel/employee_dt_ajax') }}",
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
        "t"+
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "oTableTools": {
            "aButtons": [
                "copy",
                "csv",
                "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "{{ CoreConfigs::getByKey('sitename') }}_PDF",
                    "sPdfMessage": "{{ CoreConfigs::getByKey('sitename') }} PDF Export",
                    "sPdfSize": "letter"
                },
                {
                    "sExtends": "print",
                    "sMessage": "Generated by {{ CoreConfigs::getByKey('sitename') }} <i>(press Esc to close)</i>"
                }
            ],
            "sSwfPath": "{{ Theme::asset('default::js/plugin/datatables/swf/copy_csv_xls_pdf.swf') }}"
        },
        "autoWidth" : true,
        "preDrawCallback" : function() {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_dt_ajax) {
                responsiveHelper_dt_ajax = new ResponsiveDatatablesHelper($('#dt_ajax'), breakpointDefinition);
            }
        },
        "rowCallback" : function(nRow) {
            responsiveHelper_dt_ajax.createExpandIcon(nRow);
        },
        "drawCallback" : function(oSettings) {
            responsiveHelper_dt_ajax.respond();
        },
        @if($show_actions)
        columnDefs: [ { orderable: false, targets: [-1] }],
        @endif
    });
    /* END TABLETOOLS */

    $('#module-refresh-form').on('click', function(){
        $('#dt_ajax').dataTable()._fnAjaxUpdate();
    });

    $('#employees-add-submit').on('click', function(){
        $('#employees-add-form').submit();
    });

    $('#employees-add-form-').bootstrapValidator({
        feedbackIcons : {
            valid : 'glyphicon glyphicon-ok',
            invalid : 'glyphicon glyphicon-remove',
            validating : 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            form.submit();
        },
        fields : {
            name : {
                validators : {
                    notEmpty : {
                        message : 'The full name is required and cannot be empty'
                    }
                }
            },
            designation : {
                validators : {
                    notEmpty : {
                        message : 'The designation is required and cannot be empty'
                    }
                }
            },
            gender : {
                validators : {
                    notEmpty : {
                        message : 'The gender is required and cannot be empty'
                    }
                }
            },
            mobile : {
                validators : {
                    notEmpty : {
                        message : 'The full mobile is required and cannot be empty'
                    }
                }
            },
            email : {
                validators : {
                    notEmpty : {
                        message : 'The email address is required and cannot be empty'
                    },
                    emailAddress : {
                        message : 'The email address is not valid'
                    }
                }
            },
            dept : {
                validators : {
                    notEmpty : {
                        message : 'The departement is required and cannot be empty'
                    }
                }
            },
            city : {
                validators : {
                    notEmpty : {
                        message : 'The city is required and cannot be empty'
                    }
                }
            },
            address : {
                validators : {
                    notEmpty : {
                        message : 'The address is required and cannot be empty'
                    }
                }
            },
            about : {
                validators : {
                    notEmpty : {
                        message : 'The about is required and cannot be empty'
                    }
                }
            },
            date_birth : {
                validators : {
                    notEmpty : {
                        message : 'The date of birth is required and cannot be empty'
                    }
                }
            },
        }
    });
</script>
@endpush
