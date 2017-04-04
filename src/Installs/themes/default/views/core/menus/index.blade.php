@extends("default::core.layouts.app")

@section("contentheader_title", "Menus")
@section("contentheader_description", "Menus Editor")
@section("section", "Menus")
@section("sub_section", "Editor")
@section("htmlheader_title", "Menus Editor")

@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{ Theme::asset('js/plugin/iconpicker/fontawesome-iconpicker.min.css') }}">
<style type="text/css">
    .m-bottom20{
        margin-bottom: 20px;
    }
</style>
@endpush

@section("content")

    <div id="content">

        @include('default::core.layouts.partials.page-title')

        <div class="row m-bottom20">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <select class="form-control" id="menu_type">
                    <option value="0">-- Menu Type --</option>
                    <option value="all">All Menu Type</option>
                    @foreach($menuType as $menuTipe)
                        <?php  
                        if ($menuTipe[0]['type'] == $type) {
                            $sltType = 'selected="selected"';
                        }else{
                            $sltType = '';
                        }
                        ?>
                        <option value="{{ $menuTipe[0]['type'] }}" {{ $sltType }}>{{ ucfirst($menuTipe[0]['type']) }}</option>
                    @endforeach
                </select>
            </article>
        </div>

        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-list-ul"></i> </span>
                        <h2>Menu Item  </h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <fieldset>
                                <div class="dd" id="nestable2">
                                    {!! $menuItems !!}
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </article>


            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-list-ul"></i> </span>
                        <h2>Tambah Menu Item</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            @if(!empty($menuedit))
                            {!! Form::open(['route' => [config('core.adminRoute').'.core_menus.update', $menuedit->id], 'method'=>'PUT', 'class' => 'smart-form', 'novalidate' => 'novalidate', 'role' => 'form']) !!}
                            @else
                            {!! Form::open(['action' => '\Pw\Core\Controllers\MenuController@store', 'method'=>'POST', 'class' => 'smart-form', 'novalidate' => 'novalidte', 'role' => 'form']) !!}
                            @endif
                                {{ csrf_field() }}

                                <fieldset>
                                    <section>
                                        <label class="label">Type menu</label>
                                        <label class="select">
                                            <select name="type" id="type">
                                                <option value="0">-- Menu Type --</option>
                                                <option value="module">Module</option>
                                                <option value="crud">Crud</option>
                                                <option value="front">Front</option>
                                            </select>
                                        </label>
                                    </section>

                                    <section id="parent">
                                        <label class="label">Parent menu</label>
                                        <label class="select">
                                            <select name="parent">
                                                <option value="0">/</option>
                                                @foreach($menus as $menu)
                                                    <?php  
                                                    $slInduk = !empty($menuedit) ? $menuedit->parent : '';
                                                    if ($slInduk == $menu->id) {
                                                        $sltInduk = 'selected="selected"';
                                                    }else{
                                                        $sltInduk = '';
                                                    }
                                                    ?>
                                                    <option value="{{ $menu->id }}" {{ $sltInduk }}>{{ $menu->name }}</option>
                                                @endforeach
                                            </select> 
                                            <i></i> 
                                        </label>
                                        @if ($errors->has('parent'))
                                            <label id="parent-error" class="error" for="parent">{{ $errors->first('parent') }}</label>
                                        @endif
                                    </section>
                                    
                                    <section>
                                        <label class="input"> 
                                            <label>Icon Menu</label>
                                            <input id="icon" type="text" placeholder="Icon menu" name="icon" value="{{ !empty($menuedit) ? $menuedit->icon : old('icon') }}">
                                            <b class="tooltip tooltip-bottom-right">Contoh: fa-home</b>
                                        </label>
                                        @if ($errors->has('icon'))
                                            <label id="username-error" class="error" for="username">{{ $errors->first('icon') }}</label>
                                        @endif
                                    </section>

                                    <section>
                                        <label class="label">Status</label>
                                        <div class="inline-group">
                                            <?php  
                                            $chkAktip = !empty($menuedit) ? $menuedit->active : '';
                                            if ($chkAktip == 1) {
                                                $chAktip1 = 'checked="checked"';
                                                $chAktip2 = '';
                                            }else if($chkAktip == 0){
                                                $chAktip1 = '';
                                                $chAktip2 = 'checked="checked"';
                                            }else{
                                                $chAktip1 = 'checked="checked"';
                                                $chAktip2 = '';
                                            }
                                            ?>
                                            <label class="radio">
                                                <input type="radio" {{ $chAktip1 }} name="status" value="1">
                                                <i></i>Aktif
                                            </label>
                                            <label class="radio">
                                                <input type="radio" {{ $chAktip2 }} name="status" value="0">
                                                <i></i>Tidak Aktif
                                            </label>
                                            @if ($errors->has('status'))
                                                <label id="status-error" class="error" for="status">{{ $errors->first('status') }}</label>
                                            @endif
                                        </div>
                                    </section>

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
                                                <label class="input"> 
                                                    <label>Nama Menu</label>
                                                    <input id="name" type="text" placeholder="Menu nama ({{ $lang }})" name="{{ $locale }}[name]" value="{{ !empty($menuedit) ? $menuedit->name : old('name') }}">
                                                    <b class="tooltip tooltip-bottom-right">Nama Menu yang akan di tampilkan</b>
                                                </label>
                                                @if ($errors->has('name'))
                                                    <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                                @endif
                                            </section>
                                            
                                            <section>
                                                <label class="input"> 
                                                    <label>Link halaman</label>
                                                    <input id="url" type="text" placeholder="Link halaman ({{ $lang }})" name="{{ $locale }}[url]" value="{{ !empty($menuedit) ? $menuedit->url : old('url') }}">
                                                    <b class="tooltip tooltip-bottom-right">Contoh: tentang/visi-misi</b>
                                                </label>
                                                @if ($errors->has('url'))
                                                    <label id="url-error" class="error" for="url">{{ $errors->first('url') }}</label>
                                                @endif
                                            </section>
                                        </div>
                                        @endforeach
                                    </div>

                                </fieldset>
                                <footer>
                                    <button class="btn btn-primary" type="submit">
                                        Simpan
                                    </button>
                                </footer>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ Theme::asset('default::js/plugin/iconpicker/fontawesome-iconpicker.min.js') }}"></script>
<script src="{{ Theme::asset('default::js/plugin/jquery-nestable/jquery.nestable.min.js') }}"></script>
<script type="text/javascript">
    $('input[name=icon]').iconpicker();
    $('#menu_type').on('change', function() {
        var type = $(this).val();
        if (type == 'all') {
            window.location.href = "{{ route(config('core.adminRoute').'.core_menus.index') }}";
        }else{
            window.location.href = "{{ route(config('core.adminRoute').'.core_menus.index') }}/?type="+type;
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.dd').nestable();
    $('.dd').on('change', function() {
        var data = $('.dd').nestable('serialize');
        $.ajax({
            type: 'POST',
            url: "{{ url(config('core.adminRoute') . '/core_menus/update_hierarchy') }}",
            data: {
                'jsonData': data,
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                console.log('berhasil');
            },
            error:function (xhr, ajaxOptions, thrownError){
                console.log('gagal');
            }
        });
    });
</script>
@endpush
