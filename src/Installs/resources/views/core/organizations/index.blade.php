@extends("core.layouts.app")

@section("contentheader_title", "Organizations")
@section("contentheader_description", "organizations listing")
@section("section", "Organizations")
@section("sub_section", "Listing")
@section("htmlheader_title", "Organizations Listing")

@section("headerElems")
@core_access("Organizations", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Organization</button>
@endcore_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $crud->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@core_access("Organizations", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Organization</h4>
			</div>
			{!! Form::open(['action' => 'Core\OrganizationsController@store', 'id' => 'organization-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @core_form($crud)
					
					{{--
					@core_input($crud, 'name')
					@core_input($crud, 'email')
					@core_input($crud, 'phone')
					@core_input($crud, 'website')
					@core_input($crud, 'assigned_to')
					@core_input($crud, 'connect_since')
					@core_input($crud, 'address')
					@core_input($crud, 'city')
					@core_input($crud, 'description')
					@core_input($crud, 'profile_image')
					@core_input($crud, 'profile')
					--}}
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
@endcore_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('core-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('core-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('core.adminRoute') . '/organization_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#organization-add-form").validate({
		
	});
});
</script>
@endpush