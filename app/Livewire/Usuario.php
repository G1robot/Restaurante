<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UsuarioModel;

class Usuario extends Component
{
    public $showModal = false;
    public $id = '';
    public $nombre = '';
    public $apellidos = '';
    public $ci = '';
    public $usuario = '';
    public $contrasena = '';
    public $contrasena1 = '';
    public $rol = '';
    public $search = '';

    public function buscar(){
        $this->render();
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
        $usuario = UsuarioModel::findOrFail($id);
        $this->id = $usuario->id_usuario;
        $this->nombre = $usuario->nombre;
        $this->apellidos = $usuario->apellidos;
        $this->ci = $usuario->ci;
        $this->usuario = $usuario->usuario;
        $this->contrasena = $usuario->contrasena;
        $this->contrasena1 = $usuario->contrasena;
        $this->rol = $usuario->rol;
        $this->openModal();
    }

    public function guardar(){
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'ci' => 'required|string|max:20',
            'usuario' => 'required|string|max:255',
            'contrasena' => 'required|string|min:6',
            'contrasena1' => 'required|string|same:contrasena',
            'rol' => 'required|in:administrador,personal',
        ];
        $this->validate($rules);
        $data = [
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'ci' => $this->ci,
            'usuario' => $this->usuario,
            'contrasena' => $this->contrasena,
            'rol' => $this->rol,
        ];
        if($this->id){
            $usuario = UsuarioModel::findOrFail($this->id);
            $usuario->update($data);
        }else{
            UsuarioModel::create($data);
        }
        $this->reset();
        $this->closeModal();
    }

    public function delete($id){
        $usuario = UsuarioModel::findOrFail($id);
        $usuario->delete();
    }

    public function render()
    {
        $usuarios = UsuarioModel::where('nombre', 'like', '%'.$this->search.'%')
            ->get();
        return view('livewire.usuario', compact('usuarios'));
    }
}
