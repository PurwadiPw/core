@extends("default::core.layouts.app")

@section("contentheader_title", "Pages Contents")
@section("contentheader_description", "Pages Contents Editor")
@section("section", "Pages Contents")
@section("sub_section", "Editor")
@section("htmlheader_title", "Pages Contents Editor")

@section("addButton")
    <div class="widget-toolbar" id="action-row">
        <a href="javascript:void(0);" data-act="create" class="btn btn-default">
            <i class="fa fa-plus"></i> Tambah @hasSection('section') @yield('section') @endif
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
                    <ul id="widget-tab-1" class="nav nav-tabs">
                        
                        <li class="active">
                            <a data-toggle="tab" data-act="act-list" href="#frm-list"> 
                                <i class="fa fa-lg fa-arrow-circle-o-down"></i> 
                                <span class="hidden-mobile hidden-tablet"> Pages Contents </span> 
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" data-act="act-create" href="#frm-create" style="display:none;"> 
                                <i class="fa fa-lg fa-plus"></i> 
                                <span class="hidden-mobile hidden-tablet"> Add New </span>
                                <button class="close closeTab" type="button" rel="tooltip" title=""><i class="fa fa-times-circle-o"></i></button>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" data-act="act-read" href="#frm-read" style="display:none;"> 
                                <i class="fa fa-lg fa-search"></i> 
                                <span class="hidden-mobile hidden-tablet"> View </span>
                                <button class="close closeTab" type="button" rel="tooltip" title=""><i class="fa fa-times-circle-o"></i></button>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" data-act="act-update" href="#frm-update" style="display:none;"> 
                                <i class="fa fa-lg fa-pencil"></i> 
                                <span class="hidden-mobile hidden-tablet"> Edit </span>
                                <button class="close closeTab" type="button" rel="tooltip" title=""><i class="fa fa-times-circle-o"></i></button>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" data-act="act-delete" href="#frm-delete" style="display:none;"> 
                                <i class="fa fa-lg fa-trash"></i> 
                                <span class="hidden-mobile hidden-tablet"> Delete </span>
                                <button class="close closeTab" type="button" rel="tooltip" title=""><i class="fa fa-times-circle-o"></i></button>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" data-act="act-audit" href="#frm-audit" style="display:none;"> 
                                <i class="fa fa-lg fa-list-alt"></i> 
                                <span class="hidden-mobile hidden-tablet"> Audit Trail </span>
                                <button class="close closeTab" type="button" rel="tooltip" title=""><i class="fa fa-times-circle-o"></i></button>
                            </a>
                        </li>

                    </ul>   

                    <div class="jarviswidget-ctrls" role="menu">
                        <a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" id="crud-btn-refresh" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>

                    @hasSection('addButton')
                        @yield('addButton')
                    @endif

                    @if($show_actions)
                    <div class="widget-toolbar" id="btn-act-dt_ajax" style="display: none;">
                        <div class="btn-group" id="action-row">
                            <button class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
                                Action <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" id="act-single-row" style="display: none;">
                                <li>
                                    <a href="javascript:void(0);" data-act="read"><i class="fa fa-search"></i> View</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-act="update"><i class="fa fa-pencil"></i> Edit</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-act="delete"><i class="fa fa-trash"></i> Delete</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-act="audit"><i class="fa fa-list-alt"></i> Audit Trail</a>
                                </li>
                            </ul>
                            <ul class="dropdown-menu pull-right" id="act-multi-row" style="display: none;">
                                <li>
                                    <a href="javascript:void(0);" data-act="delete"><i class="fa fa-trash"></i>  Delete Multiple</a>
                                </li>
                            </ul>
                        </div>
                    </div>
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

                        <!-- widget body text-->
                        
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="frm-list">
                                @include('default::core.pages_contents.opr.list')
                            </div>
                            <div class="tab-pane fade" id="frm-create">
                                <div id="frm-create-content"></div>
                            </div>
                            <div class="tab-pane fade" id="frm-read">
                                <div id="frm-read-content"></div>
                            </div>
                            <div class="tab-pane fade" id="frm-update">
                                <div id="frm-update-content"></div>
                            </div>
                            <div class="tab-pane fade" id="frm-delete">
                                <div id="frm-delete-content"></div>
                            </div>
                            <div class="tab-pane fade" id="frm-audit">
                                <div id="frm-audit-content"></div>
                            </div>
                        </div>
                        
                        <!-- end widget body text-->
                        
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
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ Theme::asset('default::js/plugin/summernote/summernote.min.js') }}"></script>

<script src="{{ Theme::asset('default::js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/bootstrap-add-clear/bootstrap-add-clear.min.js') }}"></script>

<script>
    /* CREATE */
    $(document).on('click', '#btn-create', function(e){
        e.preventDefault();
        frmSubmit('#pages-add-form', '#dt_ajax');
        $('.nav-tabs a[href=#frm-list]').tab('show');
        checkActiveTab();
    });

    /* UPDATE */
    $(document).on('click', '#btn-update', function(e){
        e.preventDefault();
        frmSubmit('#pages-edit-form', '#dt_ajax');
        $('.nav-tabs a[href=#frm-list]').tab('show');
        checkActiveTab();
    });

    /* DELETE */
    $(document).on('click', '#btn-delete', function(e){
        e.preventDefault();
        frmSubmit('#pages-delete-form', '#dt_ajax');
        $('.nav-tabs a[href=#frm-list]').tab('show');
        checkActiveTab();
    });

    $('.nav-tabs a[data-toggle="tab"]').on('click', function(){
        checkActiveTab($(this).attr('data-act'));
    });

    /* DATATABLE */
    dataRow = [];
    var responsiveHelper_dt_ajax = undefined;
    var breakpointDefinition = {
        tablet : 1024,
        phone : 480
    };

    var table = $('#dt_ajax').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ url(config('core.adminRoute').'/core_pages_contents_dt_ajax') }}",
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
        "t"+
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "select": "single",
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
        "columnDefs": [
            {"className": "text-center", "targets": [0,1]}
        ],
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

    $('#dt_ajax tbody').on( 'click', 'tr', function (e) {
        e.preventDefault();
        $(this).toggleClass('DTTT_selected');
        var row = $('#dt_ajax').DataTable().rows('.DTTT_selected').data().length;
        if (row > 1){
            $('#act-single-row').hide();
            $('#act-multi-row').removeAttr('style');
        }else if(row < 2){
            $('#act-single-row').removeAttr('style');
            $('#act-multi-row').hide();
            if (row == 0) {
                $('#btn-act-dt_ajax').hide();
                // dataRow = [];
            }else{
                $('#btn-act-dt_ajax').show();
            }
        }
    });

    $('#action-row a').on('click', function(e){
        var row = $('#dt_ajax').DataTable().rows('.DTTT_selected').data();
        var rowId = [];
        if (row.length > 1) {
            $.each(row, function(i, el){
                rowId.push(el[0]);
            });
            var id = rowId;
            var data = {
                '_token': "{{ csrf_token() }}",
                'id': id,
                'url': "{{ route(config('core.adminRoute').'.core_pages_contents.destroy', "+id+") }}",
                'count': row.length,
                'tbl': '#dt_ajax'
            };
            delMultiple(data);
        }else if(row.length == 0){
            var id = 0;
        }else if(row.length == 1){
            var id = row[0][0];
        }
        var act = $(this).data('act');
        var data = {
            'token': "{{ csrf_token() }}",
            'dataId': id,
            'url': "{{ url(config('core.adminRoute').'/core_pages_contents/openTab') }}",
        };
        openTab(act, id, data);
        // console.log(act+'---'+id+'---'+data);
    });

    function openTab(act, id, data) {
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name=_token]').attr('content')
            },
            url: data.url,
            type: 'POST',
            cache: false,
            data: {
                'act': act,
                'dataId': data.dataId,
                '_token': data.token
            },
            datatype: 'html',
            beforeSend: function() {
                //something before send
            },
            success: function(data) {
                if (data.success == true && data.html != false) {
                    $('#frm-'+act+'-content').html(data.html);
                    $('.nav-tabs a[href=#frm-'+act+']').show();
                    $('.nav-tabs a[href=#frm-'+act+']').tab('show');
                    checkActiveTab();
                } else {
                    console.log('Something went wrong!!');
                }
            },
            error: function(xhr, textStatus, thrownError) {
                console.log(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
    }

    function checkActiveTab(dataAct = null){
        if (dataAct == null) {
            var activeTab = $('.nav-tabs li.active').find('a').attr('data-act');
        }else{
            var activeTab = dataAct;
        }
        if (activeTab == 'act-list') {
            $('#btn-act-dt_ajax').show();
        }else{
            $('#btn-act-dt_ajax').hide();
        }
    }
    /* END DATATABLE */
</script>
@endpush
