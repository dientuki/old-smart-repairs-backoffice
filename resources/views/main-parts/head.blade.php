<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ config('app.name') }}</title>

<!-- Scripts -->
<script src="{{ load_resource('dashboard.js') }}" defer crossorigin="anonymous"></script>

<!-- Fonts -->
<link rel="preload" href="{{ load_resource('Roboto-Regular.woff2') }}" as="font" type="font/woff2" crossorigin />
<link rel="preload" href="{{ load_resource('Roboto-Regular.woff') }}" as="font" type="font/woff" crossorigin />

<!-- Styles -->
<style>{!! load_critical_css('critical.css') !!}</style>
<link href="{{ load_resource('style.css') }}" rel="preload" as="style" onload="this.rel = 'stylesheet'" />