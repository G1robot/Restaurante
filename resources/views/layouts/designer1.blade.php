<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Picantería Doña Marvin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @livewireStyles 
</head>
<body class="bg-gray-100 font-sans antialiased">
    <header class="bg-cover bg-center py-[45px] text-white relative" style="background-image: url('/img/fondo.jpg');">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="flex items-center justify-between px-6 relative z-10">
            <div class="w-32">
                <img src="/img/logo.png" alt="Logo de la picanteería" class="rounded-lg shadow-xl transform transition-all hover:scale-110 hover:rotate-6">
            </div>
            <div class="text-4xl sm:text-5xl font-extrabold text-center text-yellow-400 drop-shadow-2xl">
                <a class="text-white hover:text-red-600 transition-all ease-in-out duration-300 transform hover:scale-105" href="{{ route('home') }}">PICANTERÍA DOÑA MARVIN</a>
            </div>
            <div class="w-32">
                <img src="/img/logo.png" alt="Logo de la picanteería" class="rounded-lg shadow-xl transform transition-all hover:scale-110 hover:rotate-6">
            </div>
        </div>
    </header>
    <nav class="bg-red-700 shadow-xl rounded-b-xl">
        <div class="container mx-auto px-6 py-5">
            <div class="flex justify-center items-center">
                <ul class="flex space-x-12 text-white font-semibold text-lg">
                    @if (!Auth::guard('web')->check())
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
                    @endif

                    @auth('web')
                        <p class="text-black font-bold">Bienvenido, {{ Auth::guard('web')->user()->nombre }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Cerrar sesión</button>
                        </form>
                    @endauth
                    <li>
                        <a class="hover:text-yellow-300 hover:scale-105 transform transition-all ease-in-out duration-300" href="{{ route('usuarios.index') }}">
                            <i class="fas fa-utensils mr-2"></i>Menu
                        </a>
                    </li>
                    <li>
                        <a class="hover:text-yellow-300 hover:scale-105 transform transition-all ease-in-out duration-300" href="{{ route('usuarios.index') }}">
                            <i class="fas fa-users mr-2"></i>Usuarios
                        </a>
                    </li>
                    <li>
                        <a class="hover:text-yellow-300 hover:scale-105 transform transition-all ease-in-out duration-300" href="{{ route('promociones.index') }}">
                            <i class="fas fa-gift mr-2"></i>Promociones
                        </a>
                    </li>
                    <li>
                        <a class="hover:text-yellow-300 hover:scale-105 transform transition-all ease-in-out duration-300" href="{{ route('cliente.index') }}">
                            <i class="fas fa-users-cog mr-2"></i>Clientes
                        </a>
                    </li>
                    <li>
                        <a class="hover:text-yellow-300 hover:scale-105 transform transition-all ease-in-out duration-300" href="{{ route('ventas.index') }}">
                            <i class="fas fa-chart-line mr-2"></i>Ventas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="flex flex-grow justify-center items-center py-16 bg-gray-200">
        <div class="container mx-auto px-6">
            @yield('content')
        </div>
    </section>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
