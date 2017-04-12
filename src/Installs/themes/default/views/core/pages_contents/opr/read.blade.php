<div class="panel infolist">
    <div class="panel-body">
        <div class="form-group">
            <label class="col-md-2">
                Variable :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->variable }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                Title :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->title }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                Content :
            </label>
            <div class="col-md-10 fvalue">
            	{!! $page->content !!}
            </div>
        </div>
    </div>
</div>
