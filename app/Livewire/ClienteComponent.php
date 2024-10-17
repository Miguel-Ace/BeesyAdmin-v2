<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ClienteComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $nombre, $correo, $telefono, $pais, $contacto, $cedula;
    public $search = '';


    public function render(){
        $paises = ['Nicaragua','Costa Rica'];
        $clientes = Cliente::
        when(auth()->user()->getRoleNames()->first() == 'Cliente', function($query){
            $query->where('id', auth()->user()->cliente->id);
        })
        ->when($this->search != '', function($query){
            $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orWhereRaw('LOWER(contacto) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orWhereRaw('LOWER(cedula) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orWhereRaw('LOWER(correo) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orWhereRaw('LOWER(pais) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orWhere('telefono', 'like', '%' . $this->search . '%');
        })
        ->paginate(10);
        return view('livewire.cliente-component', compact('clientes','paises'));
    }

    public function limpiarDatos(){
        $this->nombre = '';
        $this->correo = '';
        $this->telefono = '';
        $this->pais = '';
        $this->contacto = '';
        $this->cedula = '';
    }

    public function modalCrear(){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isModalCrear = true;
        $this->limpiarDatos();
        $this->resetErrorBag();
    }

    public function modalEditar($data){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isModalCrear = false;
        $this->resetErrorBag();
        
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
        $this->correo = $data['correo'];
        $this->telefono = $data['telefono'];
        $this->pais = $data['pais'];
        $this->contacto = $data['contacto'];
        $this->cedula = $data['cedula'];
    }

    public function crear(){
        $validated = $this->validate([ 
            'nombre' => 'required|min:3',
            'correo' => 'required|email',
            'telefono' => 'required|min:8',
            'pais' => 'required',
            'contacto' => 'required|min:3',
            'cedula' => 'required|min:7',
        ],[
            'nombre.required' => 'Campo obligatorio',
            'nombre.min' => 'Mínimo de 3',
            'correo.required' => 'Campo obligatorio',
            'correo.email' => 'Email no valido',
            'telefono.required' => 'Campo obligatorio',
            'telefono.min' => 'Mínimo de 8',
            'pais.required' => 'Campo obligatorio',
            'contacto.required' => 'Campo obligatorio',
            'contacto.min' => 'Mínimo de 3',
            'cedula.required' => 'Campo obligatorio',
            'cedula.min' => 'Mínimo de 7',
        ]);

        // Crear el nuevo elemento
        Cliente::create($validated);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $this->validate([ 
            'nombre' => 'required|min:3',
            'correo' => 'required|email',
            'telefono' => 'required|min:8',
            'pais' => 'required',
            'contacto' => 'required|min:3',
            'cedula' => 'required|min:7',
        ]);

        $cliente = Cliente::find($this->id);

        $cliente->update([
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'pais' => $this->pais,
            'contacto' => $this->contacto,
            'cedula' => $this->cedula,
        ]);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function borrar($id){
        Cliente::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
