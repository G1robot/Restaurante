<div class="container mx-auto p-4" x-data="{ showDeleteModal: false, deleteId: null }">
    <!-- Barra de búsqueda y botón de agregar -->
    <div class="flex justify-between items-center mb-6">
        <input type="text" wire:model="search" wire:keydown.enter="searchClientes" 
            placeholder="Buscar cliente..." class="border border-gray-300 p-2 rounded w-1/3 text-black shadow-md focus:outline-none focus:ring-2 focus:ring-red-500">
        <button wire:click="create" x-on:click="$dispatch('reset-modal')"
            class="bg-red-600 text-white px-6 py-2 rounded shadow-lg hover:bg-red-700 flex items-center gap-2 text-lg font-semibold">
            <i class="fas fa-user-plus"></i>
            Agregar Cliente
        </button>
    </div>

    <!-- Mensaje de éxito con desaparición automática -->
    @if(session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" 
            x-show="show" class="bg-green-500 text-white p-2 mb-2 rounded shadow-md">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tabla de clientes -->
    <table class="w-full border border-black shadow-lg">
        <thead>
            <tr class="bg-black text-white">
                <th class="border border-black p-2">Nombre</th>
                <th class="border border-black p-2">Apellidos</th>
                <th class="border border-black p-2">CI</th>
                <th class="border border-black p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr class="bg-white hover:bg-gray-200">
                    <td class="border border-black p-2 text-black">{{ $cliente->nombre }}</td>
                    <td class="border border-black p-2 text-black">{{ $cliente->apellidos }}</td>
                    <td class="border border-black p-2 text-black">{{ $cliente->ci }}</td>
                    <td class="border border-black p-2">
                        <div class="flex gap-2 justify-center">
                            <button wire:click="edit({{ $cliente->id_cliente }})" 
                                class="bg-orange-500 text-white px-3 py-1 rounded shadow-md hover:bg-orange-700">
                                <i class="fas fa-pencil"></i>
                            </button>
                            <button x-on:click="deleteId = {{ $cliente->id_cliente }}; showDeleteModal = true;" 
                                class="bg-red-600 text-white px-3 py-1 rounded shadow-lg hover:bg-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $clientes->links() }}

    <!-- Modal de Confirmación de Eliminación -->
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


    <!-- Modal de agregar/editar cliente -->
    @if($modalOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" x-data x-on:reset-modal.window="$wire.set('nombre', ''); $wire.set('apellidos', ''); $wire.set('ci', '');">
            <div class="bg-white p-6 rounded-lg w-96 shadow-xl">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">{{ $cliente_id ? 'Editar Cliente' : 'Agregar Cliente' }}</h2>
                
                <label class="block text-gray-700 mb-1">Nombre:</label>
                <input type="text" wire:model="nombre" class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('nombre')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <label class="block text-gray-700 mt-3 mb-1">Apellidos:</label>
                <input type="text" wire:model="apellidos" class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('apellidos')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <label class="block text-gray-700 mt-3 mb-1">CI:</label>
                <input type="text" wire:model="ci" class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('ci')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <div class="flex justify-end gap-3 mt-4">
                    <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded shadow-md hover:bg-gray-600">Cancelar</button>
                    <button wire:click="{{ $cliente_id ? 'update' : 'store' }}" 
                        class="bg-red-600 text-white px-5 py-2 rounded shadow-md hover:bg-red-700">
                        {{ $cliente_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
