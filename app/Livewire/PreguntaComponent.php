<?php

namespace App\Livewire;

use App\Models\Pregunta;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PreguntaComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $pregunta, $fecha_creacion, $intentos, $activo, $opcion_mult;
    public $search = '';

    public function render()
    {
        // dd(Pregunta::withCount('respuestas')->paginate(1));
        $preguntas = $this->search 
        ? Pregunta::withCount('respuestas')
        ->where(function ($query){
            $query->whereRaw('LOWER(pregunta) LIKE ?', ['%' . strtolower($this->search) . '%'])
                  ->orWhereRaw('DATE_FORMAT(fecha_creacion, "%Y-%m-%d") LIKE ?', ['%' . strtolower($this->search) . '%'])
                  ->orWhere('intentos','like','%'.$this->search.'%');
        })
        ->paginate(10)  // Asegúrate de usar paginate aquí
        : Pregunta::withCount('respuestas')->paginate(10);
        return view('livewire.pregunta-component', compact('preguntas'));
    }

    public function limpiarDatos(){
        $this->pregunta = '';
        $this->fecha_creacion = '';
        $this->intentos = '';
        $this->activo = '';
        $this->opcion_mult = '';
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
        $this->pregunta = $data['pregunta'];
        $this->fecha_creacion = $data['fecha_creacion'];
        $this->intentos = $data['intentos'];
        $this->activo = $data['activo'];
        $this->opcion_mult = $data['opcion_mult'];
    }

    public function crear(){
       $validated = $this->validate([ 
            'pregunta' => 'required',
            'fecha_creacion' => 'required',
            'intentos' => 'required',
            'activo' => 'boolean',
            'opcion_mult' => 'boolean',
        ],[
            'pregunta.required' => 'Campo obligatorio',
            'fecha_creacion.required' => 'Campo obligatorio',
            'intentos.required' => 'Campo obligatorio',
        ]);

        $validated['activo'] = $this->activo ? 1 : 0;
        $validated['opcion_mult'] = $this->opcion_mult ? 1 : 0;

        // Crear el nuevo elemento
        Pregunta::create($validated);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'pregunta' => 'required',
            'fecha_creacion' => 'required',
            'intentos' => 'required',
            'activo' => 'boolean',
            'opcion_mult' => 'boolean',
        ]);

        $pregunta = Pregunta::find($this->id);

        $pregunta->update($validated);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function borrar($id){
        Pregunta::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
