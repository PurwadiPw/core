@extends("default::core.layouts.app")

@section("contentheader_title", "Configs")
@section("contentheader_description", "Configs")
@section("section", "Configs")
@section("sub_section", "Core")
@section("htmlheader_title", "Configs")

@section("content")

    <div id="content">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false">
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
                <h2>@hasSection('contentheader_title')@yield('contentheader_title')@endif</h2>    
                
                <!-- <ul id="widget-tab-1" class="nav nav-tabs pull-right">
                    @foreach(CoreHelper::availableLang() as $locale => $lang)
                    <li class="{{ App::getLocale() == $locale ? 'active' : ''}}">
                        <a data-toggle="tab" href="#{{ $locale }}"> 
                            <span class="hidden-mobile hidden-tablet"> {{ $lang }} </span> 
                        </a>
                    </li>
                    @endforeach
                </ul>   --> 
                
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

                    <div class="widget-body-toolbar">
                        <div class="row">
                            <div class="col-xs-6 col-sm-12 col-md-12 col-lg-12 text-left">
                                <button class="btn btn-success" id="btn-save">
                                    <i class="fa fa-plus"></i> <span class="hidden-mobile">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {!! Form::open(['route' => config('core.adminRoute').'.core_configs.store', 'class' => 'smart-form', 'id' => 'configs-add-form']) !!}
                    <ul id="myTab1" class="nav nav-tabs bordered">
                        @foreach(CoreHelper::availableLang() as $locale => $lang)
                        <li class="{{ App::getLocale() == $locale ? 'active' : ''}}">
                            <a href="#{{ $locale }}" data-toggle="tab">{{ $lang }}</a>
                        </li>
                        @endforeach
                    </ul>

                    <div id="myTabContent1" class="tab-content padding-10">
                        @foreach(CoreHelper::availableLang() as $locale => $lang)
                        <div class="tab-pane fade in {{ App::getLocale() == $locale ? 'active' : ''}}" id="{{ $locale }}">
                            <section>
                                <label class="label">Sitename</label>
                                <label class="input">
                                    <input type="text" name="{{ $locale }}[sitename]" value="{{$configs->{$locale}['sitename']}}" placeholder="Sitename ({{ strtoupper($locale) }})">
                                </label>
                            </section>

                            <section>
                                <label class="label">Sitename First Word</label>
                                <label class="input">
                                    <input type="text" name="{{ $locale }}[sitename_part1]" value="{{$configs->{$locale}['sitename_part1']}}" placeholder="Sitename First Word ({{ strtoupper($locale) }})">
                                </label>
                            </section>
                            
                            <section>
                                <label class="label">Sitename Second Word</label>
                                <label class="input">
                                    <input type="text" name="{{ $locale }}[sitename_part2]" value="{{$configs->{$locale}['sitename_part2']}}" placeholder="Sitename Second Word ({{ strtoupper($locale) }})">
                                </label>
                            </section>
                            
                            <section>
                                <label class="label">Sitename Short (2/3 Characters)</label>
                                <label class="input">
                                    <input type="text" name="{{ $locale }}[sitename_short]" value="{{$configs->{$locale}['sitename_short']}}" placeholder="Sitename Short (2/3 Characters) ({{ strtoupper($locale) }})" maxlength="3">
                                </label>
                            </section>

                            <section>
                                <label class="label">Site Description</label>
                                <label class="textarea textarea-resizable">                                         
                                    <textarea name="{{ $locale }}[site_description]" rows="3" class="custom-scroll">{{$configs->{$locale}['sitename_short']}}</textarea> 
                                </label>
                            </section>
                        </div>
                        @endforeach
                    </div>
                    {!! Form::close() !!}
                    
                </div>
                <!-- end widget content -->
                
            </div>
            <!-- end widget div -->
            
        </div>
        <!-- end widget -->
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).on('click', '#btn-save', function(e){
        e.preventDefault();
        frmSubmit('#configs-add-form');
    });
</script>
@endpush
