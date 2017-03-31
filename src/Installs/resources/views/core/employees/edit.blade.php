@extends("core.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('core.adminRoute') . '/employees') }}">Employees</a> :
@endsection
@section("contentheader_description", $employee->$view_col)
@section("section", "Employees")
@section("section_url", url(config('core.adminRoute') . '/employees'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Employee Edit : ".$employee->$view_col)

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
				{!! Form::model($employee, ['route' => [config('core.adminRoute') . '.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form']) !!}
					@core_form($crud)
					
					{{--
					@core_input($crud, 'name')
					@core_input($crud, 'designation')
					@core_input($crud, 'gender')
					@core_input($crud, 'mobile')
					@core_input($crud, 'mobile2')
					@core_input($crud, 'email')
					@core_input($crud, 'dept')
					@core_input($crud, 'city')
					@core_input($crud, 'address')
					@core_input($crud, 'about')
					@core_input($crud, 'date_birth')
					@core_input($crud, 'date_hire')
					@core_input($crud, 'date_left')
					@core_input($crud, 'salary_cur')
					--}}
                    <div class="form-group">
						<label for="role">Role* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							<?php $roles = App\Models\Role::all(); ?>
							@foreach($roles as $role)
								@if($role->id != 1 || Entrust::hasRole("SUPER_ADMIN"))
									@if($user->hasRole($role->name))
										<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
									@else
										<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endif
								@endif
							@endforeach
						</select>
					</div>
					<br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('core.adminRoute') . '/employees') }}">Cancel</a></button>
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
	$("#employee-edit-form").validate({
		
	});
});
</script>
@endpush
