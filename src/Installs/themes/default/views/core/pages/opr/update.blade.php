{!! Form::model($pageedit, ['route' => [config('core.adminRoute').'.core_pages.update', $pageedit->id ], 'method'=>'PUT', 'id' => 'pages-edit-form', 'class' => 'smart-form', 'novalidate' => 'novalidate']) !!}
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <label class="label">Menu</label>
                <label class="select">
                    <select name="menu">
                        <option>-- Select Menu --</option>
                        @foreach($menus as $menu)
                        <?php  
                        $slInduk = !empty($pageedit) ? $pageedit->core_menus_id : '';
                        if ($slInduk == $menu->id) {
                            $sltInduk = 'selected="selected"';
                        }else{
                            $sltInduk = '';
                        }
                        ?>
                        <option value="{{ $menu->id }}" {{ $sltInduk }}>{{ $menu->name }}</option>
                        @endforeach
                    </select> <i></i> 
                </label>
            </section>
            <section class="col col-6">
                <label class="label">Active</label>
                <?php  
                $chkAktip = !empty($pageedit) ? $pageedit->active : '';
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
                <div class="inline-group">
                    <label class="radio">
                        <input type="radio" name="active" {{ $chAktip1 }} value="1">
                        <i></i>Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="active" {{ $chAktip2 }} value="0">
                        <i></i>No
                    </label>
                </div>
            </section>
        </div>

        <ul id="PageTab" class="nav nav-tabs bordered">
            @foreach(CoreHelper::availableLang() as $locale => $lang)
            <li class="{{ App::getLocale() == $locale ? 'active' : ''}}">
                <a href="#{{ $locale }}" data-toggle="tab">{{ $lang }}</a>
            </li>
            @endforeach
        </ul>

        <div id="PageTabContent" class="tab-content padding-10">
            @foreach(CoreHelper::availableLang() as $locale => $lang)
            <div class="tab-pane fade in {{ App::getLocale() == $locale ? 'active' : ''}}" id="{{ $locale }}">
                <section>
                    <label class="input"> 
                        <label>Title</label>
                        <input id="title" type="text" placeholder="Title ({{ $lang }})" name="{{ $locale }}[title]" value="{{ !empty($pageedit) ? $pageedit->translate($locale)->title : old('title') }}">
                        <b class="tooltip tooltip-bottom-right">Title yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('title'))
                        <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                    @endif
                </section>

                <section>
                    <label class="input"> 
                        <label>Slug</label>
                        <input id="slug" type="text" placeholder="Slug ({{ $lang }})" name="{{ $locale }}[slug]" value="{{ !empty($pageedit) ? $pageedit->translate($locale)->slug : old('slug') }}">
                        <b class="tooltip tooltip-bottom-right">Slug yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('slug'))
                        <label id="slug-error" class="error" for="slug">{{ $errors->first('slug') }}</label>
                    @endif
                </section>
                
                <section>
                    <label class="input"> 
                        <label>Body</label>
<textarea id="code_update_{{ $locale }}" class="form-control">
{{ !empty($pageedit) ? $pageedit->translate($locale)->body : old('body') }}
</textarea>
<input type="hidden" id="code_val_update_{{ $locale }}" name="{{ $locale }}[body]" value="{{ !empty($pageedit) ? $pageedit->translate($locale)->body : old('body') }}">
                    </label>
                </section>

                <section>
                    <label class="input"> 
                        <label>Meta Title</label>
                        <input id="meta_title" type="text" placeholder="Meta Title ({{ $lang }})" name="{{ $locale }}[meta_title]" value="{{ !empty($pageedit) ? $pageedit->translate($locale)->meta_title : old('meta_title') }}">
                        <b class="tooltip tooltip-bottom-right">Meta Title yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('meta_title'))
                        <label id="meta_title-error" class="error" for="meta_title">{{ $errors->first('meta_title') }}</label>
                    @endif
                </section>

                <section>
                    <label>Meta Description</label>
                    <label class="textarea textarea-resizable">                                         
                        <textarea name="{{ $locale }}[meta_description]" rows="3" class="custom-scroll">{{ !empty($pageedit) ? $pageedit->translate($locale)->meta_description : old('meta_description') }}</textarea> 
                    </label>
                    @if ($errors->has('meta_description'))
                        <label id="meta_description-error" class="error" for="meta_description">{{ $errors->first('meta_description') }}</label>
                    @endif
                </section>

                <section>
                    <label class="input"> 
                        <label>Og Title</label>
                        <input id="og_title" type="text" placeholder="Og Title ({{ $lang }})" name="{{ $locale }}[og_title]" value="{{ !empty($pageedit) ? $pageedit->translate($locale)->og_title : old('og_title') }}">
                        <b class="tooltip tooltip-bottom-right">Og Title yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('og_title'))
                        <label id="og_title-error" class="error" for="og_title">{{ $errors->first('og_title') }}</label>
                    @endif
                </section>

                <section>
                    <label>Og Description</label>
                    <label class="textarea textarea-resizable">                                         
                        <textarea name="{{ $locale }}[og_description]" rows="3" class="custom-scroll">{{ !empty($pageedit) ? $pageedit->translate($locale)->og_description : old('og_description') }}</textarea> 
                    </label>
                    @if ($errors->has('og_description'))
                        <label id="og_description-error" class="error" for="og_description">{{ $errors->first('og_description') }}</label>
                    @endif
                </section>
            </div>
            @endforeach
        </div>
    </fieldset>

    <footer>
        {!! Form::submit( 'Update', ['class'=>'btn btn-primary', 'id' => 'btn-update']) !!}
    </footer>
{!! Form::close() !!}


<script type="text/javascript">
    /*CODEMIRROR*/
    var mixedMode = {
        name: "htmlmixed",
        scriptTypes: [{
            matches: /\/x-handlebars-template|\/x-mustache/i,
            mode: null
        }, {
            matches: /(text|application)\/(x-)?vb(a|script)/i,
            mode: "vbscript"
        }]
    };

    var editor = [];
    @foreach(CoreHelper::availableLang() as $locale => $lang)
        editor['{{$locale}}'] = CodeMirror.fromTextArea(document.getElementById("code_update_{{ $locale }}"), {
            mode: mixedMode,
            selectionPointer: true,
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            theme: 'monokai',
            indentUnit: 4,
            indentWithTabs: true,
            autoRefresh: true,
        });
        editor['{{$locale}}'].on('blur', function(){
            var value = editor['{{$locale}}'].getValue();
            $('#code_val_update_{{ $locale }}').val(value);
        });
    @endforeach
    /*END CODEMIRROR*/
</script>