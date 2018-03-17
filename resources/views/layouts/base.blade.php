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
<div id="@yield('app')" class="d-none">
    <b-navbar toggleable="md" type="dark" variant="info">

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand href="#">Blog</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav>
                <b-nav-item href="{{ url('/') }}">Accueil</b-nav-item>
                <b-nav-item-dropdown text="Articles">
                    <b-dropdown-item href="{{ route('posts.create') }}">Nouveau</b-dropdown-item>
                    <b-dropdown-item href="{{ route('posts.index') }}">Tous</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>

        </b-collapse>
    </b-navbar>
    <div class="container-fluid">
        @yield('content')
    </div>
</div>
<div id="main-loader" class="loader d-flex align-items-center  justify-content-center d-flex w-100 h-100 "><i class="fas fa-5x fa-spinner fa-spin"></i></div>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    window.errors = @json(collect($errors->getBag('default'))->map(function($error) {
        return $error[0];
    }));
    window.old = @json(old());
</script>
@stack('scripts')
</body>
</html>
