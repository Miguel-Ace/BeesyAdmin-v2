<?php

namespace App\Livewire;

use App\Models\Licencia;
use App\Models\Terminal;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TerminalComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $licencia_id, $serial, $nombre_equipo, $ultimo_acceso, $estado;
    public $search = '';

    public function render()
    {
        $licencias = Licencia::all();

        $terminales = $this->search 
        ? Terminal::with(['licencia'])
        ->where(function ($query) {
            // Búsqueda en licencias
            $query->whereHas('licencia', function ($consulta) {
                $consulta->whereRaw('LOWER(cantidad) LIKE ?', ['%' . strtolower($this->search) . '%']);
            });
            // Otras condiciones de búsqueda
            $query->orWhereRaw('LOWER(serial) LIKE ?', ['%' . strtolower($this->search) . '%'])
                  ->orWhereRaw('LOWER(nombre_equipo) LIKE ?', ['%' . $this->search . '%'])
                  ->orWhereRaw('DATE_FORMAT(ultimo_acceso, "%Y-%m-%d") LIKE ?', ['%' . $this->search . '%']);
        })
        ->paginate(10)  // Asegúrate de usar paginate aquí
        : Terminal::paginate(10);
        return view('livewire.terminal-component', compact('terminales','licencias'));
    }

    public function limpiarDatos(){
        $this->licencia_id = '';
        $this->serial = '';
        $this->nombre_equipo = '';
        $this->ultimo_acceso = '';
        $this->estado = '';
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
        $this->licencia_id = $data['licencia_id'];
        $this->serial = $data['serial'];
        $this->nombre_equipo = $data['nombre_equipo'];
        $this->ultimo_acceso = $data['ultimo_acceso'];
        $this->estado = $data['estado'];
    }

    public function crear(){
       $validated = $this->validate([ 
            'licencia_id' => 'required',
            'serial' => 'required',
            'nombre_equipo' => 'required',
            'ultimo_acceso' => 'required',
            'estado' => 'boolean',
        ],[
            'licencia_id.required' => 'Campo obligatorio',
            'serial.required' => 'Campo obligatorio',
            'nombre_equipo.required' => 'Campo obligatorio',
            'ultimo_acceso.required' => 'Campo obligatorio',
        ]);

        $validated['estado'] = $this->estado ? 1 : 0;

        // Crear el nuevo elemento
        Terminal::create($validated);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'licencia_id' => 'required',
            'serial' => 'required',
            'nombre_equipo' => 'required',
            'ultimo_acceso' => 'required',
            'estado' => 'boolean',
        ]);

        $terminal = Terminal::find($this->id);

        $terminal->update($validated);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function borrar($id){
        Terminal::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
