<?php

namespace App\Livewire;

use App\Models\Etapa;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EtapaComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $nombre;
    public $search = '';

    public function render()
    {
        $etapas = $this->search 
        ? Etapa::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->search) . '%'])
        ->paginate(10)  // Asegúrate de usar paginate aquí
        : Etapa::paginate(10);
        return view('livewire.etapa-component', compact('etapas'));
    }

    public function limpiarDatos(){
        $this->nombre = '';
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
    }

    public function crear(){
       $validated = $this->validate([ 
            'nombre' => 'required',
        ],[
            'nombre.required' => 'Campo obligatorio',
        ]);

        // Crear el nuevo elemento
        Etapa::create($validated);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'nombre' => 'required',
        ]);

        $etapa = Etapa::find($this->id);

        $etapa->update($validated);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function borrar($id){
        Etapa::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}