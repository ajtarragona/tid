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
	
    
<div class="login-container">
    <div class="login-form">
            <section class="login-title">
                <h4 >Vàlid</h4>
                <div class="aoc-logo"><img src="{{asset('vendor/ajtarragona/img/tid/logo-aoc.svg')}}"/></div>
            </section>
            <p>
                <strong>Identificació mitjançant la plataforma Vàlid del Consorci Administració Oberta de Catalunya</strong>
            </p>
            <p>
                Permet la identificació mitjançant qualsevol dels mètodes compatibles amb la plataforma (alguns mètodes requereixen un registre previ)
            </p>
            <ul class="validation-types">
                
                <li >
                    <img src="{{asset('vendor/ajtarragona/img/tid/icon-dni.svg')}}"/>
                    <span class="label">DNI electrònic</span>
                </li>
                <li >
                    <img src="{{asset('vendor/ajtarragona/img/tid/icon-cert.svg')}}"/>

                    <span class="label">Certificat digital</span>
                </li>
                <li >
                    <img src="{{asset('vendor/ajtarragona/img/tid/icon-idcat.svg')}}"/>
                    <span class="label">idCAT Mòbil</span>
                </li>
            </ul>

            <section class="validate-btn-container">
                
                <a class="validate-btn" tabindex="0" aria-disabled="false" href="{{tid()->makeValidUrl()}}">
                    <span class="">
                        <span >Vàlid</span>
                        <span ><img src="{{asset('vendor/ajtarragona/img/tid/icon-arrow.svg')}}"/></span>
                    </span>
                </a>
            </section>
        
    </div>
</div>

<script src="{{ asset('vendor/ajtarragona/js/tid.js')}}" language="JavaScript"></script>
	
</body>
</html>
