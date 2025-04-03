<div class="container mx-auto px-8">
    <!-- Título de la sección -->
    <h2 class="text-center text-4xl font-bold mb-8 relative text-yellow-500">
        <span class="italic text-gray-900">USUARIOS</span>
        <div class="absolute left-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
        <div class="absolute right-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
    </h2>
    <div class="flex justify-between items-center mb-6">
        <button wire:click="openModal()" class="bg-red-600 text-white font-bold px-6 py-3 rounded-md shadow-lg transition duration-300 hover:bg-red-700 text-lg">NUEVA USUARIO</button>
        <div class="flex items-center relative w-full max-w-[350px]">
            <input type="text" wire:model.debounce.500ms="search" wire:keydown.enter="buscar" placeholder="Buscar..." class="py-2 pl-10 pr-4 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f94f2c] focus:border-[#f94f2c] h-10 text-lg">
            <button wire:click="buscar" class="absolute left-3 top-2/4 transform -translate-y-2/4 text-gray-500 text-lg">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-red-600 text-white">
                    <th class="px-4 py-2 border">Nombre</th>
                    <th class="px-4 py-2 border">Apellidos</th>
                    <th class="px-4 py-2 border">C.I.</th>
                    <th class="px-4 py-2 border">Nombre de Usuario</th>
                    <th class="px-4 py-2 border">Rol</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $item)
                    <tr class="text-center">
                        <td class="px-4 py-2 border">{{ $item->nombre }}</td>
                        <td class="px-4 py-2 border">{{ $item->apellidos }}</td>
                        <td class="px-4 py-2 border">{{ $item->ci }}</td>
                        <td class="px-4 py-2 border">{{ $item->usuario }}</td>
                        <td class="px-4 py-2 border">{{ $item->rol }}</td>
                        <td class="px-4 py-2 border">
                            <button wire:click.prevent="edit({{$item->id_usuario}})" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">Editar</button>
                            <button wire:click.prevent="deshabilitar({{$item->id_usuario}})" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-600">No hay promociones disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50">
            <div class="max-w-3xl w-full mx-4 p-6 bg-white rounded-2xl shadow-xl">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Detalles</h2>
                <form wire:submit.prevent="guardar" class="grid grid-cols-2 gap-x-6 gap-y-4">
                    <div class="flex flex-col space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input id="nombre" wire:model="nombre" type="text" 
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                focus:ring-2 focus:ring-orange-500 transition">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <input id="apellidos" wire:model="apellidos" type="text"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                focus:ring-2 focus:ring-orange-500 transition">
                            @error('apellidos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="ci" class="block text-sm font-medium text-gray-700">C.I.</label>
                            <input id="ci" wire:model="ci" type="text"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                focus:ring-2 focus:ring-orange-500 transition">
                            @error('ci') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="rol" class="block text-sm font-medium text-gray-700">Rol del Usuario</label>
                            <select id="rol" wire:model="rol"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                    focus:ring-2 focus:ring-orange-500 transition">
                                <option value="">Seleccione un rol</option>
                                <option value="personal">Personal</option>
                                <option value="administrador">Administrador</option>
                            </select>
                            @error('rol') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <div>
                            <label for="usuario" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                            <input id="usuario" wire:model="usuario" type="text"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                focus:ring-2 focus:ring-orange-500 transition">
                            @error('usuario') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="contrasena" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input id="contrasena" wire:model="contrasena" type="password"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                focus:ring-2 focus:ring-orange-500 transition">
                            @error('contrasena') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="contrasena1" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                            <input id="contrasena1" wire:model="contrasena1" type="password"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                                focus:ring-2 focus:ring-orange-500 transition">
                            @error('contrasena1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-span-2 flex justify-between space-x-4 mt-4">
                        <button type="submit"
                            class="w-full bg-red-600 text-white font-bold py-3 rounded-md transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            Guardar
                        </button>
                        <button type="button" wire:click="closeModal()"
                            class="w-full bg-gray-300 text-gray-800 font-bold py-3 rounded-md transition hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
