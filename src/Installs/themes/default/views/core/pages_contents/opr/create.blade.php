{!! Form::open(['route' => 'content.pages_contents.store', 'class' => 'smart-form', 'id' => 'pages-add-form']) !!}
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <label class="label">Page</label>
                <label class="select">
                    <select name="page" id="page">
                        <option>-- Pilih Page --</option>
                        @foreach($pages as $page)
                        <option value="{{$page->id}}">{{$page->title}}</option>
                        @endforeach
                    </select> <i></i> 
                </label>
            </section>
            <section class="col col-6">
                <label class="label">Variable</label>
                <label class="select">
                    <select name="variable" id="variable">
                        <option>-- Pilih Variable --</option>
                    </select> <i></i> 
                </label>
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
                        <label>Content</label>
                        <textarea class="form-control summernote" name="{{ $locale }}[content]"></textarea>
                    </label>
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
    $('#page').change(function() {
        $.get("{{ url('content/pages_contents_page_ajax')}}", {
            option: $(this).val()
        }, function(data) {
            console.log(data.data);
            var variable = $('#variable');
            variable.empty();
            for (var i = 0; i < data.data.length; i++) {
                variable.append("<option value='" + data.data[i] + "'>" + data.data[i] + "</option>");
            }
        });
    });
</script>