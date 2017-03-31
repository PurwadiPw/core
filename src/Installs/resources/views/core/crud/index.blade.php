@extends("core.layouts.app")

<?php
use Pw\Core\Models\Crud;
?>

@section("contentheader_title", "Crud")
@section("contentheader_description", "cruds listing")
@section("section", "Crud")
@section("sub_section", "Listing")
@section("htmlheader_title", "Crud Listing")

@section("headerElems")
<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Crud</button>
@endsection

@section("main-content")

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="dt_cruds" class="table table-bordered">
		<thead>
		<tr class="success">
			<th>ID</th>
			<th>Name</th>
			<th>Table</th>
			<th>Items</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			
			@foreach ($cruds as $crud)
				<tr>
					<td>{{ $crud->id }}</td>
					<td><a href="{{ url(config('core.adminRoute') . '/crud/'.$crud->id) }}">{{ $crud->name }}</a></td>
					<td>{{ $crud->name_db }}</td>
					<td>{{ Crud::itemCount($crud->name) }}</td>
					<td>
						<a href="{{ url(config('core.adminRoute') . '/crud/'.$crud->id)}}#fields" class="btn btn-primary btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
						<a href="{{ url(config('core.adminRoute') . '/crud/'.$crud->id)}}#access" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-key"></i></a>
						<a href="{{ url(config('core.adminRoute') . '/crud/'.$crud->id)}}#sort" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-sort"></i></a>
						<a crud_name="{{ $crud->name }}" crud_id="{{ $crud->id }}" class="btn btn-danger btn-xs delete_crud" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Crud</h4>
			</div>
			{!! Form::open(['route' => config('core.adminRoute') . '.crud.store', 'id' => 'crud-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					<div class="form-group">
						<label for="name">Crud Name :</label>
						{{ Form::text("name", null, ['class'=>'form-control', 'placeholder'=>'Crud Name', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'required' => 'required']) }}
					</div>
					<div class="form-group">
						<label for="icon">Icon</label>
						<div class="input-group">
							<input class="form-control" placeholder="FontAwesome Icon" name="icon" type="text" value="fa-cube"  data-rule-minlength="1" required>
							<span class="input-group-addon"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- crud deletion confirmation  -->
<div class="modal" id="crud_delete_confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title">Crud Delete</h4>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete crud <b id="crudNameStr" class="text-danger"></b> ?</p>
				<p>Following files will be deleted:</p>
				<div id="crudDeleteFiles"></div>
				<p class="text-danger">Note: Migration file will not be deleted but modified.</p>
			</div>
			<div class="modal-footer">
				{{ Form::open(['route' => [config('core.adminRoute') . '.crud.destroy', 0], 'id' => 'crud_del_form', 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-danger btn-delete pull-left" type="submit">Yes</button>
				{{ Form::close() }}
				<a data-dismiss="modal" class="btn btn-default pull-right" >No</a>				
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('core-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('core-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('core-assets/plugins/iconpicker/fontawesome-iconpicker.js') }}"></script>
<script>
$(function () {
	$('.delete_crud').on("click", function () {
    	var crud_id = $(this).attr('crud_id');
		var crud_name = $(this).attr('crud_name');
		$("#crudNameStr").html(crud_name);
		$url = $("#crud_del_form").attr("action");
		$("#crud_del_form").attr("action", $url.replace("/0", "/"+crud_id));
		$("#crud_delete_confirm").modal('show');
		$.ajax({
			url: "{{ url(config('core.adminRoute') . '/get_crud_files/') }}/" + crud_id,
			type:"POST",
			beforeSend: function() {
				$("#crudDeleteFiles").html('<center><i class="fa fa-refresh fa-spin"></i></center>');
			},
			headers: {
		    	'X-CSRF-Token': '{{ csrf_token() }}'
    		},
			success: function(data) {
				var files = data.files;
				var filesList = "<ul>";
				for ($i = 0; $i < files.length; $i++) { 
					filesList += "<li>" + files[$i] + "</li>";
				}
				filesList += "</ul>";
				$("#crudDeleteFiles").html(filesList);
			}
		});
	});
	
	$('input[name=icon]').iconpicker();
	$("#dt_cruds").DataTable({
		
	});
	$("#crud-add-form").validate({
		
	});
});
</script>
@endpush
