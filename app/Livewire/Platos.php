<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PlatoModel;
//use Jantinnerezo\LivewireAlert\LivewireAlert;

class Platos extends Component
{
    use WithFileUploads;
    //use LivewireAlert;
    public $search='';
    public $showModal=false;


    public $nombre='';
    public $precio='';
    public $stock='';
    public $estado='';
    public $descripcion='';
    public $foto;
    public $plato_id='';

    public function rules(){
        $rules = [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:1', 
        ];
        if (($this->plato_id && is_object($this->foto)) ){
            $rules['foto']=['image','max:10024'];
        }
        else if($this->plato_id=='')
            $rules['foto']=['image','max:10024'];
        return $rules;
    }

    public function render()
    {
        $platillos = PlatoModel::where('nombre', 'like', '%' . $this->search . '%')->get();
        return view('livewire.platos',compact('platillos'));
    }
    public function clickBuscar(){

    }
    public function openModal(){
        $this->showModal=true;
    }
    public function closeModal(){
        $this->showModal=false;
        $this->limpiarDatos();
    }
    public function limpiarDatos(){
        $this->nombre='';
        $this->precio='';
        $this->stock='';
        $this->estado='';
        $this->descripcion='';
        $this->foto=null;
        $this->plato_id='';
    }

    public function enviarClick()
    {
        $this->validate();
        if ($this->plato_id) {
            $plato = PlatoModel::find($this->plato_id);
            $plato->nombre = $this->nombre;
            $plato->precio = $this->precio;
            $plato->stock = intval($this->stock);
            $plato->descripcion = $this->descripcion;
            if ($this->foto && is_object($this->foto)) {
                $filename = time() . '_' . $this->foto->getClientOriginalName();
                $this->foto->storeAs('img', $filename, 'public');
                $plato->foto = $filename;
            }
            $plato->save();
            $this->plato_id='';
        } else {
            $filename = time() . '_' . $this->foto->getClientOriginalName();
            $this->foto->storeAs('img', $filename, 'public');

            PlatoModel::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'stock' => $this->stock,
                'estado' => 'activo',
                'foto' => $filename,
            ]);
        }
        $this->limpiarDatos();
        $this->closeModal();
    }
    public function editar($id){
        
        $plato = PlatoModel::find($id);
        $this->nombre = $plato->nombre;
        $this->descripcion = $plato->descripcion;
        $this->precio = $plato->precio;
        $this->stock = $plato->stock;
        if (!$this->foto) {
            $this->foto = $plato->foto;
        }
        
        $this->plato_id = $id;
        $this->openModal();
    }

    public function delete($id){
        $plato = PlatoModel::find($id);
        if ($plato) {
            $plato->estado = 'inactivo';
            $plato->save();
        }
    }

}
