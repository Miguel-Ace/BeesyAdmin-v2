<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RespuestaComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $num_respuesta, $cliente_id, $pais, $usuario, $fecha_hora, $intento, $notas;
    public $search = '';
    public $preguntaId;

    public function render()
    {
        $paises = ['Nicaragua','Costa Rica'];
        $pregunta = Pregunta::find($this->preguntaId)->pregunta; 
        $clientes = Cliente::all();

        $respuestas = $this->search 
        ? Respuesta::with(['cliente'])
        ->where('pregunta_id',$this->preguntaId)
        ->where(function ($query){
            $query->whereHas('cliente', function($consulta){
                $consulta->whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($this->search).'%']);
            });

            $query->orWhereRaw('LOWER(cedula_cliente) LIKE ?', ['%' . strtolower($this->search) . '%'])
                  ->orWhereRaw('DATE_FORMAT(fecha_hora, "%Y-%m-%d") LIKE ?', ['%' . strtolower($this->search) . '%'])
                  ->orWhereRaw('LOWER(notas) LIKE ?', ['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('LOWER(pais) LIKE ?', ['%'.strtolower($this->search).'%'])
                  ->orWhere('num_respuesta','like', '%'.$this->search.'%')
                  ->orWhere('intento','like', '%'.$this->search.'%');
        })
        ->paginate(10)  // Asegúrate de usar paginate aquí
        : Respuesta::where('pregunta_id',$this->preguntaId)->paginate(10);
        return view('livewire.respuesta-component', compact('respuestas','pregunta','clientes','paises'));
    }

    public function limpiarDatos(){
        $this->num_respuesta = '';
        $this->cliente_id = '';
        $this->pais = '';
        $this->usuario = '';
        $this->fecha_hora = '';
        $this->intento = '';
        $this->notas = '';
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
        $this->num_respuesta = $data['num_respuesta'];
        $this->cliente_id = $data['cliente_id'];
        $this->pais = $data['pais'];
        $this->usuario = $data['usuario'];
        $this->fecha_hora = $data['fecha_hora'];
        $this->intento = $data['intento'];
        $this->notas = $data['notas'];
    }

    public function crear(){
       $validated = $this->validate([ 
            'num_respuesta' => 'required',
            'cliente_id' => 'required',
            'pais' => 'required',
            'usuario' => 'nullable',
            'fecha_hora' => 'required',
            'intento' => 'required',
            'notas' => 'nullable',
        ]);

        $validated['pregunta_id'] = $this->preguntaId;
        $validated['cedula_cliente'] = Cliente::find($validated['cliente_id'])->cedula_cliente;

        // Crear el nuevo elemento
        Respuesta::create($validated);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'num_respuesta' => 'required',
            'cliente_id' => 'required',
            'pais' => 'required',
            'usuario' => 'nullable',
            'fecha_hora' => 'required',
            'intento' => 'required',
            'notas' => 'nullable',
        ]);

        $respuesta = Respuesta::find($this->id);

        if ($respuesta->cliente_id != $validated['cliente_id']) {
            $validated['cedula_cliente'] = Cliente::find($validated['cliente_id'])->cedula_cliente;
        }

        // Actualizar el modelo con los valores validados
        $respuesta->fill($validated);

        if ($respuesta->isDirty()) {
            $respuesta->update($validated);
            $this->alert('success', 'Información Actualizada');
        } else {
            $this->alert('info', 'No se realizaron cambios');
        }

        $this->isOpenModal = false;
    }

    public function borrar($id){
        Respuesta::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
