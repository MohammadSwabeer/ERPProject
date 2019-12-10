<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	@include('admin.mainpage._header')
	<body class="skin-blue fixed-layout lock-nav">
		@include('admin.mainpage._navbar')
		<div id="main-wrapper">
			@include('admin.mainpage._leftnav')
			<div class="page-wrapper">
				<div class="container-fluid">
					@yield('admincontents')
				</div>
			</div>
			@include('admin.mainpage._pagefooter')
		</div>
	</body>
</html>