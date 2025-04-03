<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Picantería Doña Marvin - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden flex max-w-4xl w-full">
        <div class="flex-1 bg-cover bg-center" style="background-image: url('/img/imagen.jpeg')"></div>
        <div class="flex-1 flex justify-center items-center p-8">
            <div class="w-full max-w-md">
                <div class="flex flex-col items-center mb-6">
                    <img src="/img/logo.png" alt="Logo Picantería Doña Marvin" class="w-20 h-20 mb-4">
                    <h2 class="text-3xl font-extrabold text-brown-800">Picantería Doña Marvin</h2>
                </div>
                <h2 class="text-center text-xl font-semibold text-brown-700 mb-4">Iniciar Sesión</h2>
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-2 rounded mb-4 text-center">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="usuario" class="block text-brown-700 font-medium">Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="w-full border-2 border-brown-600 rounded-lg px-4 py-2 mt-2 focus:outline-none focus:ring-2 focus:ring-orange-400 transition duration-200" required>
                    </div>

                    <div class="mb-6">
                        <label for="contrasena" class="block text-brown-700 font-medium">Contraseña</label>
                        <input type="password" name="contrasena" id="contrasena" class="w-full border-2 border-brown-600 rounded-lg px-4 py-2 mt-2 focus:outline-none focus:ring-2 focus:ring-orange-400 transition duration-200" required>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition duration-300 ease-in-out">
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
