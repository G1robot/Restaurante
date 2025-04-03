<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body>
    <div class="max-w-md mx-auto mt-10 bg-white p-5 rounded shadow-lg">
        <!-- LOGO Y NOMBRE DE LA TIENDA -->
        <div class="flex flex-col items-center mb-4">
            <img src="/img/logo.png" alt="Logo" class="w-16 h-16 mb-2">
            <h2 class="text-xl font-bold text-gray-800">Picantería Doña Marvin</h2>
        </div>
    
        <h2 class="text-center text-lg font-semibold mb-4">Iniciar Sesión</h2>
    
        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 rounded mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif
    
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="usuario" class="block text-gray-700 font-medium">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
    
            <div class="mb-4">
                <label for="contrasena" class="block text-gray-700 font-medium">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
    
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                Iniciar Sesión
            </button>
        </form>
    </div>
    
</body>
</html>