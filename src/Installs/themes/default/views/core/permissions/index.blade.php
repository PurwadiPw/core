@extends("default::core.layouts.app")

@section("contentheader_title", "Permissions")
@section("contentheader_description", "Permissions Listing")
@section("section", "Permissions")
@section("sub_section", "Listing")
@section("htmlheader_title", "Permissions Listing")

@section("addButton")
@core_access("Permissions", "create")
    <div class="widget-toolbar">
        <a href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-plus"></i> Tambah Permision
        </a>
    </div>
@endcore_access
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

    @core_access("Permissions", "create")
    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">@hasSection('section') Tambah @yield('section') @endif()</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['action' => '\App\Http\Controllers\Core\PermissionsController@store', 'id' => 'permission-add-form', 'class' => 'smart-form']) !!}
                                <section>
                                    <label class="input">
                                       @core_input($crud, 'name')
                                    </label>
                                </section>
                                <section>
                                    <label class="input">
                                        @core_input($crud, 'display_name')
                                    </label>
                                </section>
                                <section>
                                    <label class="input">
                                        @core_input($crud, 'description')
                                    </label>
                                </section>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="permission-add-submit">
                        Save
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endcore_access
@endsection

@push('scripts')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ Theme::asset('default::js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/bootstrap-add-clear/bootstrap-add-clear.min.js') }}"></script>

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
        "ajax": "{{ url(config('core.adminRoute') . '/permission_dt_ajax') }}",
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
    $('#permission-add-submit').on('click', function(){
       $('#permission-add-form').submit();
    });
    $('#permission-add-form').on('submit', function(e){
        e.preventDefault();
        var frm = $(this);
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize()
        }).done(function(data) {
            if (data.ok == true){
                var status = 'Berhasil!!';
                var color = "#659265";
                $('#dt_ajax').dataTable()._fnAjaxUpdate();
                $('#addModal').modal('hide');
            }else{
                var status = 'Gagal!!';
                var color = "#C46A69";
            }
            $.smallBox({
                title: "Ooops!!",
                content: "<i class='fa fa-clock-o'></i> <i>"+data.msg+"</i>",
                color: color,
                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                timeout: 4000
            });
        }).fail(function(data) {
            console.log(data);
            $.smallBox({
                title: "Ooops!!",
                content: "<i class='fa fa-clock-o'></i> <i>Something went wrong...</i>",
                color: "#C46A69",
                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                timeout: 4000
            });
        });
    });
</script>
@endpush
