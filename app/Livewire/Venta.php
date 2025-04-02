<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\PlatoModel;
use App\Models\PromocionModel;
use App\Models\Cliente;
use App\Models\PagoModel;

class Venta extends Component
{
    public $platos=[];
    public $searchPlato='';
    public $carrito= [];
    public $total=0;
    public $searchCliente='';
    public $clientes= [];

    public $ciCliente;
    public $clienteId;
    public $nombre;
    public $apellidos;

    public $tipoPago = "Efectivo";
    public $id_pago;
    public $tiposPago;

    public function render()
    {
        $this->tiposPago = PagoModel::all(); 
        $this->id_pago = PagoModel::where('nombre', 'Efectivo')->value('id_pago');
        $this->platos = PlatoModel::where('nombre', 'like', '%' . $this->searchPlato . '%')->get();
        return view('livewire.venta');
    }
    public function guardar(){
        $this->validate([
            'clienteId'=>'required',
            'carrito'=>'required',
            'id_pago'=>'required',
        ]);
        $venta = new VentaModel();
        $venta->fecha=now();
        $venta->total = $this->total;
        $venta->id_usuario=1;
        $venta->id_cliente = $this->clienteId;
        $venta->id_pago = $this->id_pago;
        $venta->estado = 'pagado';
        $venta->id_restaurante = 1;
        $venta->save();

        foreach ($this->carrito as $item) {
            $detalle = new DetalleVentaModel();
            $detalle->id_venta = $venta->id_venta;
            $detalle->id_plato = $item['id_producto'];
            $detalle->cantidad = $item['cantidad'];
            $detalle->save();
            $plato = PlatoModel::find($item['id_producto']);
            $plato->stock -= $item['cantidad'];
            $plato->save();
        }   
        $this->reset(['carrito', 'total', 'ciCliente', 'clienteId', 'nombre', 'apellidos']);
    }
    public function buscarCliente()
    {
        $cliente = Cliente::where('ci', $this->ciCliente)->first();

        if ($cliente) {
            $this->clienteId = $cliente->id_cliente;
            $this->nombre = $cliente->nombre;
            $this->apellidos = $cliente->apellidos;
        } else {
            $this->reset(['clienteId', 'nombre', 'apellidos']);
            $this->alert('error', 'Cliente no encontrado.');
        }
    }
    public function clickBuscar(){

    }
    function calcularTotal(){
        $total = 0;
        foreach ($this->carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }

    public function addPlato($idPlato){
        $plato = PlatoModel::find($idPlato)->toArray();
        if ($plato) {
            $exists = false;
            foreach ($this->carrito as &$item) {
                if ($item['id_producto'] == $idPlato) {
                    if($item['cantidad']+1 > $plato['stock'])
                    {
                        return;
                    } 
                    $item['cantidad'] += 1;
                    
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $this->carrito[] = [
                    'precio' => $plato['precio'],
                    'cantidad' => 1,
                    'id_producto' => $plato['id_producto'],
                    'plato' => $plato
                ];
            }
            $this->total = $this->calcularTotal();
        }
    }
    public function removePlato($idPlato)
    {
        foreach ($this->carrito as $key => &$item) {
            if ($item['id_producto'] == $idPlato) {
                if ($item['cantidad'] > 1) {
                    $item['cantidad'] -= 1;
                } else {
                    unset($this->carrito[$key]);
                }
                break;
            }
        }
        $this->total = $this->calcularTotal();
    }

}