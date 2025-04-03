<div class="bg-gray-200 p-4">
    <div class="grid grid-cols-4 gap-4">
        <!-- Panel Cliente -->
        <div class="bg-white p-4 rounded-lg shadow-md col-span-1">
            <h2 class="text-lg font-semibold mb-2">Datos del Cliente</h2>
            <input wire:model="ciCliente" wire:keydown.enter="buscarCliente" type="text"
                placeholder="Ingrese CI del Cliente..."
                class="w-full p-2 border rounded mb-2">
            
            <button wire:click="buscarCliente"
                class="bg-orange-500 text-white w-full py-2 rounded">
                Buscar Cliente
            </button>
            @error('clienteId')
                    <span class="error text-red-600">{{$message}}</span>
                @enderror

            <!-- Datos del Cliente (se muestran si existe un cliente) -->
            @if($clienteId)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" class="w-full p-2 border rounded" value="{{ $nombre }}" disabled>

                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <input type="text" class="w-full p-2 border rounded" value="{{ $apellidos }}" disabled>

                </div>
            @endif
            
        </div>

        <!-- Sección de Platos -->
        <div class="col-span-3 space-y-4">
            
            <!-- Buscador de platos -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Buscar Platos</h2>
                <div class="flex items-center space-x-2">
                    <input 
                        type="search" wire:model="searchPlato" wire:keydown.enter="clickBuscar()"placeholder="Buscar Platos" 
                        class="w-full max-w-md px-4 py-2 text-sm text-[#000000] border border-[#37383a] rounded-lg bg-[#d1d4da] focus:ring-[#c70606] focus:border-[#c70606]"/>
                    <button wire:click="clickBuscar()" class="bg-[hsl(25,95%,53%)] rounded-lg px-4 py-2 text-white">Buscar</button>
                </div>
               
            </div>
            <!-- Lista de Platos -->
            <div class=" bg-white grid grid-cols-2 gap-4 rounded-lg shadow-md">
                @forelse ($platos->where('stock', '>', 0) as $item)
                    <div class="flex items-center space-x-4 p-4 border border-gray-400 rounded-lg">
                        <div class="shrink-0">
                            <img class="w-16 h-16 rounded-lg" src="/storage/img/{{$item->foto}}" alt="Plato">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-black truncate dark:text-black">
                                {{$item->nombre}}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{$item->descripcion}}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Disponible: {{$item->stock}}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            Bs. {{$item->precio}}
                        </div>
                        <div>
                            <button wire:click="addPlato({{$item->id_producto}})" class="bg-green-600 w-10 h-10 rounded text-white">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p>No hay Platos</p>
                @endforelse
            </div>
            
        </div>
    </div>
    
    <!-- Sección Carrito -->
    <div class="grid grid-cols-3 gap-4 mt-4">
        <div class="bg-white p-4 rounded-lg shadow-md col-span-2">
            <h2 class="text-lg font-semibold mb-2 text-center">Carrito de Compras</h2>
            @error('carrito') <span class="text-red-500">{{ $message }}</span> @enderror
            @forelse ($carrito as $item)
                <div class="flex justify-between items-center border-b pb-2">
                    <img src="/storage/img/{{$item['plato']['foto']}}" alt="" class=" rounded-lg w-16 h-16 ">
                    <p class="flex-1 text-center">{{$item['plato']['nombre']}}</p>
                    <p class="flex-1 text-center"> {{$item['precio']}}</p>
                    <input disabled type="number" step="1" value="{{$item['cantidad']}}" class="border-black bg-[#bdbdbd] w-20 rounded text-center">
                    <div class="flex space-x-1">
                        <button wire:click="addPlato({{$item['plato']['id_producto']}})" class="bg-green-600 w-10 rounded text-white">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button wire:click="removePlato({{$item['plato']['id_producto']}})" class="bg-red-600 w-10 rounded text-white">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center">No hay platillos en el carrito.</p>
            @endforelse
        </div>
        
        <!-- Sección de Pago -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-2">Total: Bs. {{$total}}</h2>

            <!-- Selección del tipo de pago -->
            <label class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
            <select wire:model="id_pago" class="w-full p-2 border rounded mb-2">
                <option value="">Selecciona método de pago</option>
                @foreach ($tiposPago as $pago)
                    <option value="{{ $pago->id_pago }}">{{ $pago->nombre }}</option>
                @endforeach
            </select>
            @error('id_pago')
                    <span class="error text-red-600">{{$message}}</span>
            @enderror

            <input type="hidden" wire:model="tipoPagoId">

            <button wire:click="guardar()" class="bg-blue-500 text-white w-full py-2 rounded">Pagar</button>
        </div>


    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full border border-gray-300">
        
            <div class="flex items-center justify-between border-b pb-4">
                <img src="/img/logo.png" alt="Logo" class="w-16 h-16">
                <div class="text-right">
                    <h2 class="text-xl font-bold text-gray-800">Picantería Doña Marvin</h2>
                </div>
            </div>
    
            <div class="mt-4 flex justify-between text-gray-800">
                <div class="text-left">
                    <p class="font-medium">NIT: 74846531</p>
                    <p class="font-medium">Venta N°: {{ $idVenta }}</p>
                    <p class="font-medium">Fecha: {{ now()->format('d/m/Y') }}</p>
                </div>
                <div class="text-left">
                    <p class="font-medium">Cliente: <span class="font-normal">{{ $nombre }} {{ $apellidos }}</span></p>
                    <p class="font-medium">CI: <span class="font-normal">{{ $ciCliente }}</span></p>
                </div>
            </div>
    
            <h3 class="text-lg font-semibold mt-6 border-b pb-2">Detalles de la Venta</h3>
            <div class="overflow-x-auto mt-2">
                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-2 py-1 text-left">Producto</th>
                            <th class="border border-gray-300 px-2 py-1 text-center">Cantidad</th>
                            <th class="border border-gray-300 px-2 py-1 text-right">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carrito as $item)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">{{ $item['plato']['nombre'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center">{{ $item['cantidad'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-right">Bs. {{ $item['precio'] }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
    
            <div class="mt-4 text-gray-800">
                <div class="flex justify-between text-lg font-semibold">
                    <p>Total:</p>
                    <p>Bs. {{ $total }}</p>
                </div>
                <div class="flex justify-between text-lg font-semibold">
                    <p>Descuento:</p>
                    <p>Bs. {{ $des }}</p>
                </div>
                <div class="flex justify-between text-lg font-semibold">
                    <p>Total a Pagar:</p>
                    <p>Bs. {{ $totalPagar }}</p>
                </div>
                <div class="flex justify-between">
                    <p class="font-medium">Método de Pago:</p>
                    <p>{{ $tipoPago }}</p>
                </div>
            </div>
    
            <style>
                @media print {
                    .hidden-print {
                        display: none !important;
                    }
                }
            </style>
    
            <div class="mt-6 flex justify-between hidden-print">
                <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-700">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <button wire:click="closeModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700">
                    Cerrar
                </button>
            </div>
    
        </div>
    </div>
    
    
    
    @endif

</div>