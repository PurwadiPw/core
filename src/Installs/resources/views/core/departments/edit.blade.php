@extends("core.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('core.adminRoute') . '/departments') }}">Departments</a> :
@endsection
@section("contentheader_description", $department->$view_col)
@section("section", "Departments")
@section("section_url", url(config('core.adminRoute') . '/departments'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Department Edit : ".$department->$view_col)

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
				{!! Form::model($department, ['route' => [config('core.adminRoute') . '.departments.update', $department->id ], 'method'=>'PUT', 'id' => 'department-edit-form']) !!}
					@core_form($crud)
					
					{{--
					@core_input($crud, 'name')
					@core_input($crud, 'tags')
					@core_input($crud, 'color')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('core.adminRoute') . '/departments') }}">Cancel</a></button>
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
	$("#department-edit-form").validate({
		
	});
});
</script>
@endpush
