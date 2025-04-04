<div class="container mx-auto px-8">
    <h2 class="text-center text-4xl font-bold mb-8 relative text-yellow-500">
        <span class="italic text-gray-900">VENTAS</span>
        <div class="absolute left-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
        <div class="absolute right-0 top-1/2 transform -translate-y-2/4 w-1/4 border-t-2 border-gray-300"></div>
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-md col-span-1">
            <h2 class="text-xl font-semibold mb-4">Datos del Cliente</h2>
            <input wire:model="ciCliente" wire:keydown.enter="buscarCliente" type="text"
                placeholder="Ingrese CI del Cliente..."
                class="w-full p-2 border rounded-md mb-4 text-sm">

            <button wire:click="buscarCliente"
                class="bg-red-600 text-white w-full py-2 rounded-md hover:bg-red-700 transition duration-300">
                Buscar Cliente
            </button>

            @error('clienteId')
                <span class="text-red-600 text-sm mt-2 block">{{$message}}</span>
            @enderror

            <!-- Datos del Cliente (se muestran si existe un cliente) -->
            @if($clienteId)
                <div class="mt-4 space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" class="w-full p-2 border rounded-md bg-gray-100" value="{{ $nombre }}" disabled>

                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <input type="text" class="w-full p-2 border rounded-md bg-gray-100" value="{{ $apellidos }}" disabled>
                </div>
            @endif
        </div>

        <!-- Sección de Platos -->
        <div class="col-span-3 space-y-6">
            
            <!-- Buscador de platos -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Buscar Platos</h2>
                <div class="flex items-center space-x-4">
                    <input 
                        type="search" wire:model="searchPlato" wire:keydown.enter="clickBuscar()"
                        placeholder="Buscar Platos" 
                        class="w-full max-w-md px-4 py-2 text-sm border border-gray-300 rounded-md bg-gray-100 focus:ring-orange-500">
                    <button wire:click="clickBuscar()" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300">
                        Buscar
                    </button>
                </div>
            </div>

            <!-- Lista de Platos -->
            <div class="bg-white grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 rounded-lg shadow-md">
                @forelse ($platos->where('stock', '>', 0) as $item)
                    <div class="flex items-center space-x-4 p-4 border border-gray-300 rounded-lg">
                        <div class="shrink-0">
                            <img class="w-16 h-16 rounded-lg" src="/storage/img/{{$item->foto}}" alt="Plato">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-black truncate">{{$item->nombre}}</p>
                            <p class="text-sm text-gray-500 truncate">{{$item->descripcion}}</p>
                            <p class="text-sm text-gray-500 truncate">Disponible: {{$item->stock}}</p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900">
                            Bs. {{$item->precio}}
                        </div>
                        <div>
                            <button wire:click="addPlato({{$item->id_producto}})" class="bg-green-600 w-10 h-10 rounded-full text-white">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No hay Platos disponibles</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sección Carrito -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white p-4 rounded-lg shadow-md col-span-2">
            <h2 class="text-xl font-semibold mb-4 text-center">Carrito de Compras</h2>
            @error('carrito') <span class="text-red-500">{{ $message }}</span> @enderror
            @forelse ($carrito as $item)
                <div class="flex justify-between items-center border-b pb-4">
                    <img src="/storage/img/{{$item['plato']['foto']}}" alt="" class="w-16 h-16 rounded-lg">
                    <p class="flex-1 text-center">{{$item['plato']['nombre']}}</p>
                    <p class="flex-1 text-center">Bs. {{$item['precio']}}</p>
                    <input disabled type="number" step="1" value="{{$item['cantidad']}}" class="w-20 text-center border rounded-md bg-gray-100">
                    <div class="flex space-x-2">
                        <button wire:click="addPlato({{$item['plato']['id_producto']}})" class="bg-green-600 w-10 h-10 rounded-full text-white">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button wire:click="removePlato({{$item['plato']['id_producto']}})" class="bg-red-600 w-10 h-10 rounded-full text-white">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No hay platillos en el carrito.</p>
            @endforelse
        </div>

        <!-- Sección de Pago -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Total: Bs. {{$total}}</h2>

            <!-- Selección del tipo de pago -->
            <label class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
            <select wire:model="id_pago" class="w-full p-2 border rounded-md mb-4 text-sm">
                <option value="">Selecciona método de pago</option>
                @foreach ($tiposPago as $pago)
                    <option value="{{ $pago->id_pago }}">{{ $pago->nombre }}</option>
                @endforeach
            </select>
            @error('id_pago')
                <span class="text-red-600 text-sm">{{$message}}</span>
            @enderror

            <input type="hidden" wire:model="tipoPagoId">

            <button wire:click="guardar()" class="bg-blue-600 text-white w-full py-2 rounded-md hover:bg-blue-700 transition duration-300">Pagar</button>
        </div>
    </div>
    @if($showModal)
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-4xl w-full border border-gray-300">
        <!-- Encabezado -->
        <div class="flex items-center justify-between mb-6">
            <img src="/img/logo.png" alt="Logo" class="w-24 h-24">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800">Picantería Doña Marvin</h2>
                <p class="text-sm text-gray-600">Venta al por menor</p>
                <p class="text-sm text-gray-600">NIT: 74846531</p>
            </div>
        </div>

        <!-- Detalles de la Venta -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="text-left text-gray-800">
                <p class="font-medium">Venta N°: <span class="font-normal">{{ $idVenta }}</span></p>
                <p class="font-medium">Fecha: <span class="font-normal">{{ now()->format('d/m/Y') }}</span></p>
            </div>
            <div class="text-left text-gray-800">
                <p class="font-medium">Cliente: <span class="font-normal">{{ $nombre }} {{ $apellidos }}</span></p>
                <p class="font-medium">CI: <span class="font-normal">{{ $ciCliente }}</span></p>
            </div>
        </div>

        <!-- Tabla de productos -->
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Detalles de la Venta</h3>
        <div class="overflow-x-auto mb-6">
            <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">Producto</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Cantidad</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Precio</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($carrito as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['plato']['nombre'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $item['cantidad'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Bs. {{ $item['precio'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Bs. {{ $item['precio'] * $item['cantidad'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500">No hay productos en el carrito</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Totales -->
        <div class="text-right text-gray-800 mb-6">
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
        </div>

        <!-- Método de pago -->
        <div class="flex justify-between text-lg font-medium mb-6">
            <p>Método de Pago:</p>
            <p>{{ $tipoPago }}</p>
        </div>

        <!-- Pie de factura -->
        <div class="text-center text-sm text-gray-600 mt-4">
            <p>Gracias por su compra. ¡Vuelva pronto!</p>
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-between hidden-print">
            <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button wire:click="closeModal" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                Cerrar
            </button>
        </div>
    </div>
</div>
@endif

</div>
