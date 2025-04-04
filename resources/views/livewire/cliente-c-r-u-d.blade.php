<div class="container mx-auto p-4" x-data="{ showDeleteModal: false, deleteId: null }">
    <h2 class="text-center text-4xl font-bold mb-8 relative text-yellow-500">
        <span class="italic text-gray-900">CLIENTES</span>
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1/4 border-t-2 border-gray-300"></div>
        <div class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1/4 border-t-2 border-gray-300"></div>
    </h2>
    <div class="flex justify-between items-center mb-6">
        <button wire:click="create" x-on:click="$dispatch('reset-modal')"
            class="bg-red-600 text-white font-bold px-6 py-3 rounded-md shadow-lg hover:bg-red-700 text-lg">
            NUEVO CLIENTE
        </button>
        <div class="flex items-center relative w-full max-w-[350px]">
            <input type="text" wire:model="search" wire:keydown.enter="searchClientes"
                placeholder="Buscar cliente..."
                class="py-2 pl-10 pr-4 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f94f2c] focus:border-[#f94f2c] h-10 text-lg text-black">
            <button wire:click="searchClientes"
                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    @if(session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" 
            x-show="show" class="bg-green-500 text-white p-3 mb-4 rounded-md shadow-md">
            {{ session('message') }}
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-red-600 text-white">
                    <th class="px-4 py-2 border">Nombre</th>
                    <th class="px-4 py-2 border">Apellidos</th>
                    <th class="px-4 py-2 border">CI</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                    <tr class="text-center hover:bg-gray-100">
                        <td class="px-4 py-2 border text-black">{{ $cliente->nombre }}</td>
                        <td class="px-4 py-2 border text-black">{{ $cliente->apellidos }}</td>
                        <td class="px-4 py-2 border text-black">{{ $cliente->ci }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex justify-center gap-3">
                                <button wire:click="edit({{ $cliente->id_cliente }})"
                                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    Editar
                                </button>
                                <button x-on:click="deleteId = {{ $cliente->id_cliente }}; showDeleteModal = true;"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-4 py-4 text-gray-500">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded w-1/3 border-2 border-black shadow-xl">
            <h2 class="text-xl font-bold mb-4 text-black text-center">¿Estás seguro de eliminar al Cliente?</h2>
            <p class="text-black text-center mb-4">Esta acción no se puede deshacer.</p>

            <div class="flex justify-center gap-4">
                <button x-on:click="showDeleteModal = false" 
                    class="bg-gray-500 text-white px-4 py-2 rounded shadow-md hover:bg-gray-600">
                    Cancelar
                </button>
                <button x-on:click="$wire.delete(deleteId); showDeleteModal = false;" 
                    class="bg-red-600 text-white px-4 py-2 rounded shadow-lg hover:bg-red-700">
                    Sí, eliminar
                </button>
            </div>
        </div>
    </div>
    @if($modalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50" x-data x-on:reset-modal.window="$wire.set('nombre', ''); $wire.set('apellidos', ''); $wire.set('ci', '');">
            <div class="max-w-md w-full mx-4 p-6 bg-white rounded-2xl shadow-xl">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">{{ $cliente_id ? 'Editar Cliente' : 'Agregar Cliente' }}</h2>
                <form wire:submit.prevent="{{ $cliente_id ? 'update' : 'store' }}" class="space-y-6">
                    <div class="flex flex-col space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input id="nombre" wire:model="nombre" type="text"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <input id="apellidos" wire:model="apellidos" type="text"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            @error('apellidos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="ci" class="block text-sm font-medium text-gray-700">C.I.</label>
                            <input id="ci" wire:model="ci" type="text"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            @error('ci') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-between space-x-4 mt-4">
                        <button type="submit" 
                            class="w-full bg-red-600 text-white font-bold py-3 rounded-md transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            {{ $cliente_id ? 'Actualizar' : 'Guardar' }}
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
