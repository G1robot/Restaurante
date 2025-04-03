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

    protected $rules = [
        'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:80',
        'apellidos' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:80',
        'ci' => 'required|regex:/^\d{6,}[a-zA-Z0-9]*$/|max:30|unique:Cliente,ci',
    ];
    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
        'nombre.max' => 'El nombre no puede exceder los 80 caracteres.',
    
        'apellidos.required' => 'Los apellidos son obligatorios.',
        'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
        'apellidos.max' => 'Los apellidos no pueden exceder los 80 caracteres.',
    
        'ci.required' => 'El CI es obligatorio.',
        'ci.regex' => 'El CI debe tener al menos 6 dígitos y puede contener letras o números.',
        'ci.max' => 'El CI no puede exceder los 30 caracteres.',
        'ci.unique' => 'El CI ya está registrado.',
    ];
    

    public function render()
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('apellidos', 'like', '%' . $this->search . '%')
            ->orWhere('ci', 'like', '%' . $this->search . '%')
            ->paginate(10);

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
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:80',
            'apellidos' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:80',
            'ci' => "required|regex:/^\d{6,}[a-zA-Z0-9]*$/|max:30|unique:Cliente,ci,{$this->cliente_id},id_cliente",
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
        $this->resetValidation(); 
        $this->modalOpen = false;
    }

}
