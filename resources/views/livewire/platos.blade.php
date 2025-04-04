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
                <div class="flex justify-between items-center">
                    <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Detalles del Platillo</h2>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>    
                <div class="mt-4">
                    <form class="space-y-4">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_nombre" class="block text-sm font-medium text-gray-700">Producto</label>
                            <input wire:model="nombre"  type="text" name="floating_nombre" id="floating_nombre" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition" placeholder=" " required />
                            @error('nombre')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_descripcion" class="block text-sm font-medium text-gray-700">Descripcion</label>
                            <input wire:model="descripcion" type="text" name="floating_descripcion" id="floating_descripcion" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition" placeholder=" " required />
                            @error('descripcion')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_precio" class="block text-sm font-medium text-gray-700">Precio</label>
                            <input wire:model="precio" type="text" name="floating_precio" id="floating_precio" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition" placeholder=" " required />
                            @error('precio')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_stock" class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input wire:model="stock" type="number" name="floating_stock" id="floating_stock" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition" placeholder=" " required />
                            @error('stock')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="floating_repeat_foto" class="block text-sm font-medium text-gray-700">Foto</label>
                            <input wire:model="foto" type="file" name="repeat_foto" id="floating_repeat_foto" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none 
                            focus:ring-2 focus:ring-orange-500 transition" placeholder=" " required />
                            @error('foto')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($foto && is_object($foto))
                            Foto Preview:
                            <img src="{{ $foto->temporaryUrl() }}" class="w-32 h-auto rounded-lg mx-auto">
                        @else 
                            @if ($foto)
                                Foto Preview:
                                <img src="{{ asset('storage/img/' . $foto) }}" alt="Preview" class="w-32 h-auto rounded-lg mx-auto">                                                
                            @endif
                        @endif
                    </form>
                </div>
                <div class="flex justify-between space-x-4 mt-4">
                    <button wire:click="enviarClick()" type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-md transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500">Enviar</button>
                    <button wire:click="closeModal" class="w-full bg-gray-300 text-gray-800 font-bold py-3 rounded-md transition hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">Cerrar</button>
                </div>
            </div>
        </div>
    @endif
</div>