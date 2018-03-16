<!doctype html>
<html lang="{{ app()->getLocale() }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="h-100">
<div id="app" class="d-none">
    <b-navbar toggleable="md" type="dark" variant="info">

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand href="#">Blog</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav>
                <b-nav-item href="{{ url('/') }}">Accueil</b-nav-item>
                <b-nav-item href="{{ route('posts.create') }}">Articles</b-nav-item>
            </b-navbar-nav>

        </b-collapse>
    </b-navbar>
    <div class="container-fluid">
        @yield('content')
    </div>
</div>
<div id="main-loader" class="loader d-flex align-items-center  justify-content-center d-flex w-100 h-100 "><i class="fas fa-5x fa-spinner fa-spin"></i></div>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
