<div class="container mx-auto px-8">
    <h2 class="text-center text-4xl font-bold mb-8 relative text-yellow-500">
        <span class="italic text-gray-900">NUESTROS PLATILLOS</span>
        <div class="absolute left-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
        <div class="absolute right-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
    </h2>
    <div class="flex justify-between items-center mb-6">
        <button wire:click="openModal()" class="bg-red-600 text-white font-bold px-6 py-3 rounded-md shadow-lg transition duration-300 hover:bg-red-700 text-lg">NUEVO PLATILLO</button>
        <div class="flex items-center relative w-full max-w-[350px]">
            <input type="text" wire:model.debounce.500ms="search" wire:keydown.enter="clickBuscar" placeholder="Buscar..." class="py-2 pl-10 pr-4 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f94f2c] focus:border-[#f94f2c] h-10 text-lg">
            <button wire:click="clickBuscar" class="absolute left-3 top-2/4 transform -translate-y-2/4 text-gray-500 text-lg">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($platillos->where('estado', 'activo') as $item)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="/storage/img/{{$item->foto}}" alt="Plato" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-gray-900 font-bold text-xl mb-2">{{$item->nombre}}</h3>
                    <p class="text-gray-700">{{$item->descripcion}}</p>
                    <p class="text-gray-900 font-bold text-lg mt-2">Bs {{$item->precio}}</p>
                    <div class="flex space-x-2 mt-4">
                        <button wire:click.prevent="editar({{$item->id_producto}})" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full">Editar</button>
                        <button wire:click.prevent="delete({{$item->id_producto}})" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 w-full">Deshabilitar</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-bl   ack w-full">No hay Platos disponibles</p>
        @endforelse
    </div>
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50">
            <div class="max-w-md w-full mx-4 p-6 bg-white rounded-2xl shadow-xl">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Detalles del Platillo</h2>

                <form wire:submit.prevent="enviarClick" class="space-y-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Producto</label>
                        <input id="nombre" wire:model="nombre" type="text"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input id="descripcion" wire:model="descripcion" type="text"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                        <input id="precio" wire:model="precio" type="text"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        @error('precio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input id="stock" wire:model="stock" type="number"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                        <input id="foto" wire:model="foto" type="file"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if ($foto)
                        <div class="text-center">
                            @if (is_object($foto))
                                <img src="{{ $foto->temporaryUrl() }}" alt="Preview" class="w-32 h-auto rounded-lg mx-auto">
                            @else
                                <img src="{{ asset('storage/img/' . $foto) }}" alt="Preview" class="w-32 h-auto rounded-lg mx-auto">
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between space-x-4 mt-4">
                        <button type="submit"
                            class="w-full bg-red-600 text-white font-bold py-3 rounded-md transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            Enviar
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="w-full bg-gray-300 text-gray-800 font-bold py-3 rounded-md transition hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>