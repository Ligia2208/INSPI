<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title')</title>

		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

		<!-- DataTables JS -->
		<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" defer />
		<link href="{{ asset('assets') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets') }}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets') }}/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets') }}/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets') }}/css/themes/layout/brand/light.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets') }}/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />


		<!-- Custom -->
		<link href="{{ asset('assets') }}/css/custom.css?v.0.0.2" rel="stylesheet" type="text/css" />

		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{ config('app.logo_ico') }}" />

		@stack('styles')

		@yield('head')

		@livewireStyles

		<!-- Scripts de Bootstrap (esto debe ir antes de cerrar la etiqueta </body>) -->
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script> -->

		<meta name="csrf-token" content="{{ csrf_token() }}">

	</head>

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		@livewireScripts

		<!--begin::Main-->
		<link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}"> <!-- 2022-07-17 -->
		<script type="text/javascript"  src="{{ asset('assets/js/jquery.dataTables.min.js') }}" defer></script> <!-- 2022-07-17 -->
	   	@stack('scripts')

	   @include('layouts.header_mobile')
       @include('layouts.header')


		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop">
			<i class="fas fa-angle-double-up"></i>
		</div>

 

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var HOST_URL = "{{ config('app.url') }}";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="{{ asset('assets') }}/plugins/global/plugins.bundle.js"></script>
		<script src="{{ asset('assets') }}/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="{{ asset('assets') }}/js/scripts.bundle.js"></script>

		


		<script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
		<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

		<x-livewire-alert::scripts />

		@yield('footer')
		@stack('footer')

		@include('component.alert')
	</body>
	<!--end::Body-->
</html>
