<div class="panel infolist">
    <div class="panel-body">
        <!-- <div class="form-group">
            <label class="col-md-2">
                Tempate :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->template }}
            </div>
        </div> -->
        <div class="form-group">
            <label class="col-md-2">
                Active :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->active == 1 ? 'Yes' : 'No'}}
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
                Slug :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->slug }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                Meta Title :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->meta_title }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                Meta Description :
            </label>
            <div class="col-md-10 fvalue">
            	{{ $page->meta_description }}
            </div>
        </div>
        <!-- <div class="form-group">
            <label class="col-md-2">
                Body :
            </label>
            <div class="col-md-10 fvalue">
            	{!! $page->body !!}
            </div>
        </div> -->
    </div>
</div>
