<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <input type="text" wire:model="search" wire:keydown.enter="searchClientes" placeholder="Buscar cliente..." class="border p-2 rounded w-1/3 text-black">
        <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Cliente</button>
    </div>

    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-2 mb-2">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-blue-500 ">
                <th class="border p-2">Nombre</th>
                <th class="border p-2">Apellidos</th>
                <th class="border p-2">CI</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td class="border p-2 text-black">{{ $cliente->nombre }}</td>
                    <td class="border p-2 text-black">{{ $cliente->apellidos }}</td>
                    <td class="border p-2 text-black">{{ $cliente->ci }}</td>
                    <td class="border p-2 flex gap-2">
                        <button wire:click="edit({{ $cliente->id_cliente }})" class="bg-yellow-500 text-white px-3 py-1 rounded">Editar</button>
                        <button wire:click="delete({{ $cliente->id_cliente }})" class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('¿Eliminar este cliente?')">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $clientes->links() }}

    @if($modalOpen)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-4 rounded w-1/3">
                <h2 class="text-lg font-bold mb-4 text-black">{{ $cliente_id ? 'Editar Cliente' : 'Agregar Cliente' }}</h2>
                
                <label class="block text-black">Nombre:</label>
                <input type="text" wire:model="nombre" class="border p-2 w-full mb-2 text-black">

                <label class="block text-black">Apellidos:</label>
                <input type="text" wire:model="apellidos" class="border p-2 w-full mb-2 text-black">

                <label class="block text-black">CI:</label>
                <input type="text" wire:model="ci" class="border p-2 w-full mb-2 text-black">

                <div class="flex justify-end gap-2">
                    <button wire:click="closeModal" class="bg-gray-500 text-white px-3 py-2 rounded">Cancelar</button>
                    <button wire:click="{{ $cliente_id ? 'update' : 'store' }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        {{ $cliente_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
