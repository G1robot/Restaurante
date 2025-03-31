<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use Livewire\WithPagination;

class ClienteCRUD extends Component
{
    use WithPagination;

    public $nombre, $apellidos, $ci, $cliente_id;
    public $modalOpen = false;
    public $search = '';
    public $searchQuery = '';

    protected $rules = [
        'nombre' => 'required|string|max:80',
        'apellidos' => 'required|string|max:80',
        'ci' => 'required|string|max:30|unique:clientes,ci',
    ];

    public function render()
    {
        $clientes = Cliente::where(function($query) {
            $query->where('nombre', 'ilike', "%{$this->searchQuery}%")
                ->orWhere('apellidos', 'ilike', "%{$this->searchQuery}%")
                ->orWhere('ci', 'ilike', "%{$this->searchQuery}%");
        })->paginate(10);

        return view('livewire.cliente-c-r-u-d', compact('clientes'));
    }

    public function searchClientes()
    {
        $this->searchQuery = $this->search;
    }

    public function create()
    {
        $this->resetInput();
        $this->modalOpen = true;
    }

    public function store()
    {
        $this->validate();

        Cliente::create([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'ci' => $this->ci,
        ]);

        session()->flash('message', 'Cliente agregado correctamente.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        $this->cliente_id = $cliente->id_cliente;
        $this->nombre = $cliente->nombre;
        $this->apellidos = $cliente->apellidos;
        $this->ci = $cliente->ci;
        $this->modalOpen = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|string|max:80',
            'apellidos' => 'required|string|max:80',
            'ci' => "required|string|max:30|unique:clientes,ci,{$this->cliente_id},id_cliente",
        ]);

        $cliente = Cliente::findOrFail($this->cliente_id);
        $cliente->update([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'ci' => $this->ci,
        ]);

        session()->flash('message', 'Cliente actualizado correctamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Cliente::findOrFail($id)->delete();
        session()->flash('message', 'Cliente eliminado correctamente.');
    }

    private function resetInput()
    {
        $this->nombre = '';
        $this->apellidos = '';
        $this->ci = '';
        $this->cliente_id = null;
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->modalOpen = false;
    }
}
