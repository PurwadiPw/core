@extends("core.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('core.adminRoute') . '/organizations') }}">Organizations</a> :
@endsection
@section("contentheader_description", $organization->$view_col)
@section("section", "Organizations")
@section("section_url", url(config('core.adminRoute') . '/organizations'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Organization Edit : ".$organization->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($organization, ['route' => [config('core.adminRoute') . '.organizations.update', $organization->id ], 'method'=>'PUT', 'id' => 'organization-edit-form']) !!}
					@core_form($module)
					
					{{--
					@core_input($module, 'name')
					@core_input($module, 'email')
					@core_input($module, 'phone')
					@core_input($module, 'website')
					@core_input($module, 'assigned_to')
					@core_input($module, 'connect_since')
					@core_input($module, 'address')
					@core_input($module, 'city')
					@core_input($module, 'description')
					@core_input($module, 'profile_image')
					@core_input($module, 'profile')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('core.adminRoute') . '/organizations') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#organization-edit-form").validate({
		
	});
});
</script>
@endpush
