{!! Form::open(['route' => config('core.adminRoute').'.core_pages.store', 'class' => 'smart-form', 'id' => 'pages-add-form']) !!}
    <fieldset>
        <div class="row">
            <!-- <section class="col col-6">
                <label class="label">Template</label>
                <label class="select">
                    <select name="template">
                        <option value="0">Choose name</option>
                        <option value="1">Alexandra</option>
                        <option value="2">Alice</option>
                        <option value="3">Anastasia</option>
                        <option value="4">Avelina</option>
                    </select> <i></i> 
                </label>
            </section> -->
            <section class="col col-6">
                <label class="label">Active</label>
                <div class="inline-group">
                    <label class="radio">
                        <input type="radio" name="active" value="1">
                        <i></i>Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="active" value="0">
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
                        <input id="title" type="text" placeholder="Title ({{ $lang }})" name="{{ $locale }}[title]" value="{{ !empty($pageedit) ? $pageedit->title : old('title') }}">
                        <b class="tooltip tooltip-bottom-right">Title yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('title'))
                        <label id="name-error" class="error" for="title">{{ $errors->first('title') }}</label>
                    @endif
                </section>

                <section>
                    <label class="input"> 
                        <label>Slug</label>
                        <input id="slug" type="text" placeholder="Slug ({{ $lang }})" name="{{ $locale }}[slug]" value="{{ !empty($pageedit) ? $pageedit->slug : old('slug') }}">
                        <b class="tooltip tooltip-bottom-right">Slug yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('slug'))
                        <label id="slug-error" class="error" for="slug">{{ $errors->first('slug') }}</label>
                    @endif
                </section>
                
                <section>
                    <label class="input"> 
                        <label>Body</label>
                        <textarea class="form-control summernote" name="{{ $locale }}[body]"></textarea>
                    </label>
                </section>

                <section>
                    <label class="input"> 
                        <label>Meta Title</label>
                        <input id="meta_title" type="text" placeholder="Meta Title ({{ $lang }})" name="{{ $locale }}[meta_title]" value="{{ !empty($pageedit) ? $pageedit->meta_title : old('meta_title') }}">
                        <b class="tooltip tooltip-bottom-right">Meta Title yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('meta_title'))
                        <label id="meta_title-error" class="error" for="meta_title">{{ $errors->first('meta_title') }}</label>
                    @endif
                </section>

                <section>
                    <label>Meta Description</label>
                    <label class="textarea textarea-resizable">                                         
                        <textarea name="{{ $locale }}[meta_description]" rows="3" class="custom-scroll"></textarea> 
                    </label>
                    @if ($errors->has('meta_description'))
                        <label id="meta_description-error" class="error" for="meta_description">{{ $errors->first('meta_description') }}</label>
                    @endif
                </section>

                <section>
                    <label class="input"> 
                        <label>Og Title</label>
                        <input id="og_title" type="text" placeholder="Og Title ({{ $lang }})" name="{{ $locale }}[og_title]" value="{{ !empty($pageedit) ? $pageedit->og_title : old('og_title') }}">
                        <b class="tooltip tooltip-bottom-right">Og Title yang akan di tampilkan</b>
                    </label>
                    @if ($errors->has('og_title'))
                        <label id="og_title-error" class="error" for="og_title">{{ $errors->first('og_title') }}</label>
                    @endif
                </section>

                <section>
                    <label>Og Description</label>
                    <label class="textarea textarea-resizable">                                         
                        <textarea name="{{ $locale }}[og_description]" rows="3" class="custom-scroll"></textarea> 
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
        {!! Form::submit( 'Save', ['class'=>'btn btn-primary', 'id' => 'btn-create']) !!}
    </footer>
{!! Form::close() !!}

<script type="text/javascript">
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
</script>