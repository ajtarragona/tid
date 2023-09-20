<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="base-url" content="{{ url('') }}">
	<meta name="lang" content="{{ app()->getLocale() }}">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="{{ asset('vendor/ajtarragona/css/tid.css') }}" rel="stylesheet">
	
	<title>TID | {{ config('app.name')}}</title>
</head>

<body >

    @validLoginForm

	{{-- @include('ajtarragona-tid::parts.login-form') --}}
    
    <script src="{{ asset('vendor/ajtarragona/js/tid.js')}}" language="JavaScript"></script>
	
</body>
</html>
