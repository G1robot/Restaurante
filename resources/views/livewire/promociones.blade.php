<div class="container mx-auto px-8">
    <h2 class="text-center text-3xl font-bold mb-8 relative">
        <span class="italic text-gray-900">PROMOCIONES</span>
        <div class="absolute left-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
        <div class="absolute right-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
    </h2>

    <div class="flex justify-between items-center mb-6">
        <button wire:click="openModal()" class="bg-[#f94f2c] text-white font-bold px-6 py-2 rounded-md shadow-lg transition duration-300 hover:bg-[#d83d21]">NUEVA PROMOCIÓN</button>
        
        <div class="flex items-center relative w-full max-w-[350px]">
            <input type="text" wire:model.debounce.500ms="search" wire:keydown.enter="buscar" placeholder="Buscar..." class="py-2 pl-10 pr-4 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f94f2c] focus:border-[#f94f2c] h-10">
            <button wire:click="buscar" class="absolute left-3 top-2/4 transform -translate-y-2/4 text-gray-500">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-[#f94f2c] text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Descuento</th>
                    <th class="px-4 py-3 text-left">Fecha Límite</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promociones as $item)
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="px-4 py-3 flex items-center space-x-3">
                            <img src="/storage/img/{{$item->foto}}" class="w-12 h-12 object-cover rounded-md shadow-sm">
                            <span>{{ $item->nombre }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-700 font-medium">{{$item->descuento}}%</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->fecha }}</td>
                        <td class="px-4 py-3 flex justify-center space-x-2">
                            <button wire:click.prevent="edit({{$item->id_promocion}})" class="bg-green-500 text-white w-24 px-3 py-1 rounded hover:bg-green-600 flex items-center justify-center space-x-1">
                                <span>Editar</span>
                            </button>
                            <button wire:click.prevent="deshabilitar({{$item->id_promocion}})" class="bg-blue-500 text-white w-24 px-3 py-1 rounded hover:bg-blue-600 flex items-center justify-center space-x-1">
                                <span>Deshabilitar</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-600">No hay promociones disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50">
            <div class="max-w-md w-full mx-4 p-6 bg-white rounded-2xl shadow-xl">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Detalles</h2>
                <form wire:submit.prevent="guardar" class="space-y-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input id="nombre" wire:model="nombre" type="text" 
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition">
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento</label>
                        <input id="descuento" wire:model="descuento" type="number"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition">
                        @error('descuento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha Límite</label>
                        <input id="fecha" wire:model="fecha" type="date"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition">
                        @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Imagen</label>
                        <input id="foto" wire:model="foto" type="file"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition">
                        @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if ($foto)
                        <div class="text-center">
                            @if (is_object($foto))
                                <img src="{{ $foto->temporaryUrl() }}" alt="Preview" class="w-32 h-auto rounded-lg mx-auto">
                            @else
                                <img src="/storage/img/{{ $item->foto }}" alt="Preview" class="w-32 h-auto rounded-lg mx-auto">
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between space-x-4 mt-4">
                        <button type="submit"
                            class="w-full bg-[#f94f2c] text-white font-bold py-3 rounded-md transition hover:bg-[#d83d21] focus:outline-none focus:ring-2 focus:ring-orange-500">
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
