
<div class="alert alert-warning fade in">
	{{ Form::open(['route' => [config('core.adminRoute').'.core_pages.destroy', $page->id], 'method' => 'delete', 'class' => 'pull-right', 'id' => 'pages-delete-form', 'style'=>'display:inline']) }}
		<button class="btn btn-danger btn-xs" id="btn-delete" type="submit">YA</button>
	{{ Form::close() }}
	<i class="fa-fw fa fa-warning"></i>
	<strong>Hapus Data.</strong> Apakah anda yakin akan menghapus data ini?
</div>

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

