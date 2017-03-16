<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('core.layouts.partials.htmlheader')
@show
<body class="{{ CoreConfigs::getByKey('skin') }} {{ CoreConfigs::getByKey('layout') }} @if(CoreConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" bsurl="{{ url('') }}" adminRoute="{{ config('core.adminRoute') }}">
<div class="wrapper">

	@include('core.layouts.partials.mainheader')

	@if(CoreConfigs::getByKey('layout') != 'layout-top-nav')
		@include('core.layouts.partials.sidebar')
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(CoreConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif
		@if(!isset($no_header))
			@include('core.layouts.partials.contentheader')
		@endif
		
		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		@if(CoreConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
	</div><!-- /.content-wrapper -->

	@include('core.layouts.partials.controlsidebar')

	@include('core.layouts.partials.footer')

</div><!-- ./wrapper -->

@include('core.layouts.partials.file_manager')

@section('scripts')
	@include('core.layouts.partials.scripts')
@show

</body>
</html>
