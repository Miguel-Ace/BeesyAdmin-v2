<?php

namespace App\Livewire;

use App\Models\Software;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SoftwareComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $nombre = '';
    public $search = '';

    public function render()
    {
        $software = $this->search 
        ? Software::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->search) . '%'])
        ->paginate(10)  // Asegúrate de usar paginate aquí
        : Software::paginate(10);
        // $software = Software::paginate(10);
        return view('livewire.software-component', compact('software'));
    }

    public function modalCrear(){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isModalCrear = true;
        $this->resetErrorBag();

        $this->nombre = '';
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
            'nombre' => 'required|min:3',
        ],[
            'nombre.required' => 'Campo obligatorio',
            'nombre.min' => 'Mínimo de 3',
        ]);

        // Crear el nuevo elemento
        Software::create($validated);

        // Limpiar los campos del formulario
        $this->nombre = '';

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'nombre' => 'required|min:3',
        ]);

        $software = Software::find($this->id);

        $software->fill($validated);

        if ($software->isDirty()) {
            $software->update($validated);
            $this->alert('success', 'Información Actualizada');
        }else{
            $this->alert('info', 'No se realizaron cambios');
        }

        $this->isOpenModal = false;

    }

    public function borrar($id){
        Software::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
