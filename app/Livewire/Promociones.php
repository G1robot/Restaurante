<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PromocionModel;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Promociones extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $id = '';
    public $search = '';
    public $nombre = '';
    public $descuento = '';
    public $fecha = '';
    public $foto = '';

    public function buscar(){
        $this->render();
    }

    public function mount()
    {
        $this->deshabilitarPromocion();
    }

    public function openModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function edit($id){
        $promocion = PromocionModel::findOrFail($id);
        $this->id = $promocion->id_promocion;
        $this->nombre = $promocion->nombre;
        $this->descuento = $promocion->descuento;
        $this->fecha = $promocion->fecha;
        $this->foto = $promocion->foto;
        $this->openModal();
    }

    public function guardar(){
        $rules = [
            'nombre' => 'required|string|max:255',
            'descuento' => 'required|numeric|min:0|max:1000',
            'fecha' => 'required|date',
        ];
        if (!$this->id || ($this->foto && is_object($this->foto))) {
            $rules['foto'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }
        $this->validate($rules);
        $data = [
            'nombre' => $this->nombre,
            'descuento' => $this->descuento,
            'fecha' => $this->fecha,
            'estado' => 'activo',
        ];
        if ($this->foto && is_object($this->foto)) {
            $nameImg = 'c' . now()->format('YmdHis') . '.jpg';
            $this->foto->storeAs('img/', $nameImg, 'public');
            $data['foto'] = $nameImg;
        }
        if ($this->id) {
            $promocion = PromocionModel::findOrFail($this->id);
            $promocion->update($data);
        } else {
            PromocionModel::create($data);
        }
        $this->reset();
        $this->closeModal();
    }

    public function deshabilitar($id){
        $promocion = PromocionModel::findOrFail($id);
        $promocion->update(['estado' => 'inactivo']);
    }

    public function deshabilitarPromocion()
    {
        $hoy = Carbon::today();
        PromocionModel::where('fecha', '<', $hoy)
            ->where('estado', 'activo')
            ->update(['estado' => 'inactivo']);
    }

    public function render()
    {
        $this->deshabilitarPromocion();
        $promociones = PromocionModel::where('nombre', 'like', '%'.$this->search.'%')
            ->where('estado', 'activo')
            ->get();
        return view('livewire.promociones', compact('promociones'));
    }
}
