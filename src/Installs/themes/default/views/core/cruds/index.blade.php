@extends("default::core.layouts.app")

@section("contentheader_title", "Crud")
@section("contentheader_description", "crud listing")
@section("section", "Crud")
@section("sub_section", "Listing")
@section("htmlheader_title", "Crud Listing")

@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('js/plugin/iconpicker/fontawesome-iconpicker.min.css') }}">
@endpush

@section("addButton")
    <div class="widget-toolbar">
        <a href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-plus"></i> Tambah @hasSection('section') @yield('section') @endif
        </a>
    </div>
@endsection

@section("content")

    <div id="content">

        @include('default::core.layouts.partials.page-title')

        <section id="widget-grid" class="">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
                        <a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" id="crud-btn-refresh" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>

                    @hasSection('addButton')
                        @yield('addButton')
                    @endif

                    <div class="widget-toolbar" id="btn-dt_ajax">
                        <a href="javascript:void(0);" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Hapus Multiple
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
                    <div class="widget-body no-padding">

                        <div class="custom-scroll table-responsive">
                            <form action="{{ url(config('core.adminRoute').'/crud') }}" method="post" id="frm-dt_ajax">
                                <table id="dt_ajax" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                    <tr>
                                        <th><input name="select_all" value="1" id="select-all" type="checkbox"></th>
                                        <th class="text-center">ID</th>
                                        <th>Nama</th>
                                        <th>Module</th>
                                        <th>Tabel</th>
                                        <th>Item</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                </table>
                            </form>
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
                    <h4 class="modal-title" id="myModalLabel">@hasSection('section') Tambah @yield('section') @endif()</h4>
                </div>
                {!! Form::open(['route' => config('core.adminRoute') . '.crud.store', 'id' => 'crud-form-add']) !!}
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <label>Module :</label>
                            <select name="module" style="width:100%" class="select2" required>
                                <option value="">-- Pilih Module --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module['slug'] }}">{{ $module['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Crud Name :</label>
                            {{ Form::text("name", null, ['class'=>'form-control', 'placeholder'=>'Crud Name', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>50, 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            <label for="name">Table Name :</label>
                            {{ Form::text("table", null, ['class'=>'form-control', 'placeholder'=>'Table Name', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>50, 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="FontAwesome Icon" name="icon" type="text" value="fa-cube"  data-rule-minlength="1" required>
                                <span class="input-group-addon"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">@hasSection('section') Hapus @yield('section') @endif()</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus @hasSection('section') Hapus @yield('section') @endif() <b id="crudNameStr" class="text-danger"></b> ?</p>
                    <p>Beberapa file berikut akan dihapus:</p>
                    <div id="crudDeleteFiles"></div>
                    <p class="text-danger">Catatan: File migration tidak akan dihapus tetapi diubah.</p>
                </div>
                <div class="modal-footer">
                    {{ Form::open(['route' => [config('core.adminRoute') . '.crud.destroy', 0], 'id' => 'crud-form-del', 'method' => 'delete', 'style'=>'display:inline']) }}
                    <button class="btn btn-danger btn-delete pull-left" type="submit">Yes</button>
                    {{ Form::close() }}
                    <a data-dismiss="modal" class="btn btn-default pull-right" >No</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('scripts')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ Theme::asset('default::js/plugin/iconpicker/fontawesome-iconpicker.min.js') }}"></script>

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
    /* DATATABLE */
    var table = $('#dt_ajax').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route(config('core.adminRoute').'.crud.index') }}",
        "columns": [
            {data: 'id', name: 'id', className: 'text-center'},
            {data: 'id', name: 'id', className: 'text-center'},
            {data: 'name', name: 'name'},
            {data: 'module', name: 'module'},
            {data: 'name_db', name: 'name_db'},
            {data: 'items', name: 'items'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ],
        "columnDefs": [{
            "targets": 0,
            "searchable": false,
            "orderable": false,
            "className": "dt-body-center",
            "render": function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
        }],
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
        }
    });

    // Handle click on "Select all" control
    $('#select-all').on('click', function(){
        // Get all rows with search applied
        var rows = table.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        checkChecked();
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#dt_ajax tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        checkChecked();
        if(!this.checked){
            var el = $('#select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    $('#btn-dt_ajax').on('click', function () {
        $('#frm-dt_ajax').submit();
    });

    $('#frm-dt_ajax').on('submit', function(e){
        var form = this;
        console.log("Form submission", $(form).serialize());
        // Prevent actual form submission
        e.preventDefault();
    });

    $('#btn-dt_ajax').hide();
    function checkChecked() {
        arr = [];
        var arr = $('input[type="checkbox"]:checked').map(function () {
            return this.value;
        }).get();
        if (arr.length > 1){
            $('#btn-dt_ajax').slideDown();
        }else{
            $('#btn-dt_ajax').slideUp();
        }
    }
    /* END DATATABLE */

    function actCrud(crud_id, crud_name) {
        $("#crudNameStr").html(crud_name);
        $url = $("#crud-form-del").attr("action");
        $("#crud-form-del").attr("action", $url.replace("/0", "/" + crud_id));
        $("#delModal").modal('show');
        $.ajax({
            url: "{{ url(config('core.adminRoute') . '/get_crud_files/') }}/" + crud_id,
            type: "POST",
            beforeSend: function() {
                $("#crudDeleteFiles").html('<center><i class="fa fa-refresh fa-spin"></i></center>');
            },
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}'
            },
            success: function(data) {
                var files = data.files;
                var filesList = "<ul>";
                for ($i = 0; $i < files.length; $i++) {
                    filesList += "<li>" + files[$i] + "</li>";
                }
                filesList += "</ul>";
                $("#crudDeleteFiles").html(filesList);
            }
        });
    }

    $('input[name=icon]').iconpicker();
    $('#crud-btn-refresh').on('click', function(){
        table.DataTable()._fnAjaxUpdate();
    });

    $('#crud-form-add').on('submit', function(e){
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
                table.DataTable()._fnAjaxUpdate();
                $('#addModal').modal('hide');
            }else{
                var status = 'Gagal!!';
                var color = "#C46A69";
            }
            $.smallBox({
                title: status,
                content: "<i class='fa fa-clock-o'></i> <i>"+data.messages+"</i>",
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
