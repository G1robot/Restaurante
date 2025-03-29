<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @livewireStyles

    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- <x-livewire-alert::scripts /> --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    <style>
        body {
            background: linear-gradient(135deg, #ffffff, #ffffff);
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #e29f0f !important;
            padding: 1rem;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #f8f9fa !important;
        }

        .navbar-nav .nav-link {
            color: #f8f9fa !important;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #fbd46d !important;
        }

        .dropdown-item {
            color: #f8f9fa;
            transition: 0.3s;
        }

        .dropdown-item:hover {
            background-color: #fbd46d;
            color: black;
        }

        .title {
            font-family: 'Lobster', cursive;
            font-size: 2.5rem;
            color: #d62828;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <header class="bg-[#ffbb2a] font-bold">
        <div class="flex items-center justify-between">
            <!-- Logo a la izquierda -->
            <div class="flex-none w-20">
                <img width="250" src="/img/logo.png" class="logo">
            </div>
    
            <!-- Título centrado -->
            <div class="title">
                <a class="Pizz" href="{{route('home')}}">PICANTERIA DON MARVIN</a>
            </div>
    
            <!-- Logo a la derecha -->
            <div class="flex-none w-20">
                <img width="250" src="/img/logo.png" class="logo">
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Usuario </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Promociones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ventas</a>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
        </div>
    </nav>

    <section>
        @yield('content')
        
    </section>
</body>
</html>