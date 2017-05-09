@extends("default::core.layouts.app")

@section("contentheader_title", "Uploads")
@section("contentheader_description", "Uploads Management")
@section("section", "Uploads")
@section("sub_section", "Management")
@section("htmlheader_title", "Uploads Management")

@section("addButton")
@core_access("Uploads", "create")
    <div class="widget-toolbar">
        <a href="javascript:void(0);" id="AddNewUploads" class="btn btn-default">
            <i class="fa fa-plus"></i> Upload New File
        </a>
    </div>
@endcore_access
@endsection

@section("content")

    <div id="content">

        <!-- @include('default::core.layouts.partials.page-title') -->
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-0" data-widget-editbutton="false">
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
                <span class="widget-icon"> <i class="fa fa-cloud"></i> </span>
                <h2>Uploader </h2>

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
                <div class="widget-body">
                    <form class="dropzone" action="{{ url('content/upload_files') }}" id="fm_dropzone_main" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <a id="closeDZ1"><i class="fa fa-times"></i></a>
                        <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>Drop files here to upload</div>
                    </form>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->


        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-0" data-widget-editbutton="false">
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
                <span class="widget-icon"> <i class="fa fa-cloud"></i> </span>
                <h2>Files </h2>

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
                    <ul class="files_container">

                    </ul>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

    <div class="modal fade" id="EditFileModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:90%;">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    <!--<button type="button" class="next"><i class="fa fa-chevron-right"></i></button>
                    <button type="button" class="prev"><i class="fa fa-chevron-left"></i></button>-->
                    <h4 class="modal-title" id="myModalLabel">File: </h4>
                </div>
                <div class="modal-body no-padding">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-8">
                                <div class="fileObject">
                                    
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                {!! Form::open(['class' => 'file-info-form smart-form']) !!}
                                    <input type="hidden" name="file_id" value="0">
                                    <div class="form-group">
                                        <label for="filename">File Name</label>
                                        <input class="form-control" placeholder="File Name" name="filename" type="text" @if(!config('core.uploads.allow_filename_change') || !Crud::hasFieldAccess("Uploads", "name", "write")) readonly @endif value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL</label>
                                        <input class="form-control" placeholder="URL" name="url" type="text" readonly value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="caption">Label</label>
                                        <input class="form-control" placeholder="Caption" name="caption" type="text" value="" @if(!Crud::hasFieldAccess("Uploads", "caption", "write")) readonly @endif>
                                    </div>
                                    @if(!config('core.uploads.private_uploads'))
                                        <div class="form-group">
                                            <label class="toggle">
                                                {{ Form::checkbox("public", "public", false, []) }}
                                                <i class="Switch Ajax Round On" data-swchon-text="ON" data-swchoff-text="OFF"></i> Is Public ?
                                            </label>
                                        </div>
                                    @endif
                                {!! Form::close() !!}
                            </div>
                        </div><!--.row-->
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success" id="downFileBtn" href="">Download</a>
                    @core_access("Uploads", "delete")
                    <button type="button" class="btn btn-danger" id="delFileBtn">Delete</button>
                    @endcore_access
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ Theme::asset('default::js/plugin/dropzone/dropzone.min.js') }}"></script>
<script type="text/javascript">
var bsurl = '{{ url('') }}';
var fm_dropzone_main = null;
var cntFiles = null;
$(function () {
    @core_access("Uploads", "create")
    Dropzone.autoDiscover = false;
    fm_dropzone_main = new Dropzone("#fm_dropzone_main", {
        maxFilesize: 2,
        acceptedFiles: "image/*,application/pdf",
        init: function() {
            this.on("complete", function(file) {
                this.removeFile(file);
            });
            this.on("success", function(file) {
                console.log("addedfile");
                console.log(file);
                loadUploadedFiles();
            });
        }
    });
    $("#fm_dropzone_main").slideUp();
    $("#AddNewUploads").on("click", function() {
        $("#fm_dropzone_main").slideDown();
    });
    $("#closeDZ1").on("click", function() {
        $("#fm_dropzone_main").slideUp();
    });
    @endcore_access
    
    $("body").on("click", "ul.files_container .fm_file_sel", function() {
        var upload = $(this).attr("upload");
        upload = JSON.parse(upload);

        $("#EditFileModal .modal-title").html("File: "+upload.name);
        $(".file-info-form input[name=file_id]").val(upload.id);
        $(".file-info-form input[name=filename]").val(upload.name);
        $(".file-info-form input[name=url]").val(bsurl+'/files/'+upload.hash+'/'+upload.name);
        $(".file-info-form input[name=caption]").val(upload.caption);
        $("#EditFileModal #downFileBtn").attr("href", bsurl+'/files/'+upload.hash+'/'+upload.name+"?download");
        

        @if(!config('core.uploads.private_uploads'))
        if(upload.public == "1") {
            $(".file-info-form input[name=public]").attr("checked", !0);
            $(".file-info-form input[name=public]").next().removeClass("On").addClass("Off");
        } else {
            $(".file-info-form input[name=public]").attr("checked", !1);
            $(".file-info-form input[name=public]").next().removeClass("Off").addClass("On");
        }
        @endif

        $("#EditFileModal .fileObject").empty();
        if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
            $("#EditFileModal .fileObject").append('<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'">');
            $("#EditFileModal .fileObject").css("padding", "15px 0px");
        } else {
            switch (upload.extension) {
                case "pdf":
                    // TODO: Object PDF
                    $("#EditFileModal .fileObject").append('<object width="100%" height="325" data="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'"></object>');
                    $("#EditFileModal .fileObject").css("padding", "0px");
                    break;
                default:
                    $("#EditFileModal .fileObject").append('<i class="fa fa-file-text-o"></i>');
                    $("#EditFileModal .fileObject").css("padding", "15px 0px");
                    break;
            }
        }
        $("#EditFileModal").modal('show');
    });
    @if(!config('core.uploads.private_uploads') && Crud::hasFieldAccess("Uploads", "public", "write"))
    $('#EditFileModal .Switch.Ajax').click(function() {
        $.ajax({
            url: "{{ url('content/uploads_update_public') }}",
            method: 'POST',
            data: $("form.file-info-form").serialize(),
            success: function( data ) {
                console.log(data);
                loadUploadedFiles();
            }
        });
        
    });
    @endif
    
    @core_field_access("Uploads", "caption", "write")
    $(".file-info-form input[name=caption]").on("blur", function() {
        // TODO: Update Caption
        $.ajax({
            url: "{{ url('content/uploads_update_caption') }}",
            method: 'POST',
            data: $("form.file-info-form").serialize(),
            success: function( data ) {
                console.log(data);
                loadUploadedFiles();
            }
        });
    });
    @endcore_field_access
    
    @if(config('core.uploads.allow_filename_change') && Crud::hasFieldAccess("Uploads", "name", "write"))
    $(".file-info-form input[name=filename]").on("blur", function() {
        // TODO: Change Filename
        $.ajax({
            url: "{{ url('content/uploads_update_filename') }}",
            method: 'POST',
            data: $("form.file-info-form").serialize(),
            success: function( data ) {
                console.log(data);
                loadUploadedFiles();
            }
        });
    });
    @endif

    @core_access("Uploads", "delete")
    $("#EditFileModal #delFileBtn").on("click", function() {
        if(confirm("Delete image "+$(".file-info-form input[name=filename]").val()+" ?")) {
            $.ajax({
                url: "{{ url('content/uploads_delete_file') }}",
                method: 'POST',
                data: $("form.file-info-form").serialize(),
                success: function( data ) {
                    console.log(data);
                    loadUploadedFiles();
                    $("#EditFileModal").modal('hide');
                }
            });
        }
    });
    @endcore_access
    
    loadUploadedFiles();
});
function loadUploadedFiles() {
    // load folder files
    $.ajax({
        dataType: 'json',
        url: "{{ url('content/uploaded_files') }}",
        success: function ( json ) {
            console.log(json);
            cntFiles = json.uploads;
            $("ul.files_container").empty();
            if(cntFiles.length) {
                for (var index = 0; index < cntFiles.length; index++) {
                    var element = cntFiles[index];
                    var li = formatFile(element);
                    $("ul.files_container").append(li);
                }
            } else {
                $("ul.files_container").html("<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>");
            }
        }
    });
}
function formatFile(upload) {
    var image = '';
    if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
        image = '<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'?s=130">';
    } else {
        switch (upload.extension) {
            case "pdf":
                image = '<i class="fa fa-file-pdf-o"></i>';
                break;
            default:
                image = '<i class="fa fa-file-text-o"></i>';
                break;
        }
    }
    return '<li><a class="fm_file_sel" data-toggle="tooltip" data-placement="top" title="'+upload.name+'" upload=\''+JSON.stringify(upload)+'\'>'+image+'</a></li>';
}
</script>
@endpush
