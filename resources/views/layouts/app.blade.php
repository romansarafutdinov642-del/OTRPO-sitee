<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Актёры всех времён')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<header>
    <nav class="navbar shadow-sm rounded-3 my-2 mx-auto" style="max-width: 1800px;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/TheShining.webp') }}" alt="logo" width="40" height="30" class="d-inline-block align-text-top me-2">
                <span class="fw-bold">Актёры всех времён</span>
            </a>
            <a href="{{ route('cards.create') }}" class="btn px-3 py-1 rounded-3">
                <i class="fa-solid fa-plus me-1"></i> Добавить
            </a>
        </div>
    </nav>
</header>

<div class="container my-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<footer>
    <div class="footer-content">
        <div class="info">
            <p>prod. Letita Matvey</p>
        </div>
        <div class="social-link">
            <a href="https://max.ru/" target="_blank">
                <img src="{{ asset('images/logo_max.jpg') }}" alt="logo max">
            </a>
            <a href="https://dzen.ru/" target="_blank">
                <img src="{{ asset('images/logo_dzen.png') }}" alt="logo dzen">
            </a>
            <a href="https://claude.com/" target="_blank">
                <img src="{{ asset('images/logo_claude.jfif') }}" alt="logo claude">
            </a>
        </div>
    </div>
</footer>

<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
