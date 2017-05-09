@extends("default::core.layouts.app")

@section("contentheader_title", "Employee View")
@section("contentheader_description", "crud view")
@section("section", "Employee View")
@section("sub_section", "View")
@section("htmlheader_title", "Employee View")

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
                            <h4 class="name">{{ $employee->$view_col }}</h4>
                            <div class="row stats">
                                <div class="col-md-6 stat"><div class="label2" data-toggle="tooltip" data-placement="top" title="Designation">{{ $employee->designation }}</div></div>
                                <div class="col-md-6 stat"><i class="fa fa-map-marker"></i> {{ $employee->city or "NA" }}</div>
                            </div>
                            <p class="desc">{{ substr($employee->about, 0, 33) }}@if(strlen($employee->about) > 33)...@endif</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dats1"><i class="fa fa-envelope-o"></i> {{ $employee->email }}</div>
                    <div class="dats1"><i class="fa fa-phone"></i> {{ $employee->mobile }}</div>
                    <div class="dats1"><i class="fa fa-clock-o"></i> Joined on {{ date("M d, Y", strtotime($employee->date_hire)) }}</div>
                </div>

                <div class="col-md-4">
                </div>

                <div class="col-md-1 actions">
                    @core_access("Employees", "edit")
                        <a href="{{ url('personel/employees/'.$employee->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
                    @endcore_access
                    
                    @core_access("Employees", "delete")
                        {{ Form::open(['route' => ['personel.employees.destroy', $employee->id], 'method' => 'delete', 'style'=>'display:inline']) }}
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
                    <a href="{{ url(config('core.adminRoute').'/employees') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <ul id="widget-tab-1" class="nav nav-tabs pull-right">

                    <li class="active">
                        <a data-toggle="tab" href="#general-info">
                            <i class="fa fa-lg fa-bars"></i>
                            <span class="hidden-mobile hidden-tablet"> General Info </span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#setting">
                            <i class="fa fa-lg fa-key"></i>
                            <span class="hidden-mobile hidden-tablet"> Account Setting </span>
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
                        <div class="tab-pane fade in active" id="general-info">

                            <div class="custom-scroll table-responsive">
                                <div class="panel infolist">
                                    <div class="panel-body">
                                        @core_display($crud, 'name')
                                        @core_display($crud, 'designation')
                                        @core_display($crud, 'gender')
                                        @core_display($crud, 'mobile')
                                        @core_display($crud, 'email')
                                        @core_display($crud, 'dept')
                                        @core_display($crud, 'city')
                                        @core_display($crud, 'address')
                                        @core_display($crud, 'about')
                                        <!-- <div class="form-group">
                                            <label class="col-md-2">
                                                Name :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->name }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Designation :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->designation }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Gender :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->gender }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Mobile :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->mobile }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Email :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->email }}
                                            </div>
                                        </div>
                                        @core_display($crud, 'dept')
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                City :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->city }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Address :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->address }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                About :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->about }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Date of Birth :
                                            </label>
                                            <div class="col-md-10 fvalue">
                                                {{ $employee->date_birth }}
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
                        <div class="tab-pane fade in" id="setting">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('success_message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success_message') }}</p>
                            @endif
                            <div class="panel infolist">
                                <div class="panel-body">
                                    <form action="{{ url(config('core.adminRoute') . '/change_password/'.$employee->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
                                        {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="password" class=" col-md-2">Password</label>
                                                <div class=" col-md-10">
                                                    <input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" autocomplete="off" required="required" data-rule-minlength="6" data-msg-minlength="Please enter at least 6 characters.">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation" class=" col-md-2">Retype password</label>
                                                <div class=" col-md-10">
                                                    <input type="password" name="password_confirmation" value="" id="password_confirmation" class="form-control" placeholder="Retype password" autocomplete="off" required="required" data-rule-equalto="#password" data-msg-equalto="Please enter the same value again.">
                                                </div>
                                            </div>
                                    </form>
                                </div>
                                <div class="widget-footer text-right">
                                    <button type="submit" class="btn btn-primary" id="password-reset-btn"><span class="fa fa-check-circle"></span> Change Password</button>
                                </div>
                            </div>
                        </div>
                        @endif
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
<script type="text/javascript">
    $('#password-reset-btn').on('click', function(){
        $('#password-reset-form').submit();
    });

    var url = window.location.href;
    var activeTab = url.substring(url.indexOf("#") + 1);

    if(!activeTab.includes("http") && activeTab.length > 1) {
        $('#widget-tab-1 a[href="#'+activeTab+'"]').tab('show');
    } else {
        $('#widget-tab-1 a[href="#general-info"]').tab('show');
    }

    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });

    $(window).on('hashchange', function(e) {
        $('#widget-tab-1 a[href="'+window.location.hash+'"]').tab('show');
    });

</script>
@endpush