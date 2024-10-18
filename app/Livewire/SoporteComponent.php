<?php

namespace App\Livewire;

use App\Exports\SoporteExport;
use App\Imports\SoporteImport;
use App\Mail\EditSoporte;
use App\Mail\NuevoSoporteBeesy;
use App\Mail\NuevoSoporteCliente;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\OrigenAsistencia;
use App\Models\Priority;
use App\Models\Software;
use App\Models\Soporte;
use App\Models\State;
use App\Models\User;
use App\Models\UserCliente;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\map;

class SoporteComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $colaborador_id, $fecha_prevista_cumplimiento, $cliente_id, $software_id, $problema, $observaciones, $prioridad_id, $tipo_id, $user_cliente_id, $imagen, $interno;
    public $fechaInicioAsistencia, $fechaFinalAsistencia, $solucion, $estado_id;
    public $search = '';
    public $searchEstado = '';
    public $searchEmpresa = '';
    public $searchColaborador = '';
    public $searchCliente = '';
    public $searchPrioridad = '';
    public $searchProblema = '';
    public $searchSoftware = '';
    public $searchTipo = '';
    public $fileExcel = '';
    
    // Pendiente
    public function eviarEmail($info, $nuevo = true){
        $coleccion = [
            'ticket' => $info->id,
            'empresa' => $info->cliente->nombre,
            'contacto' => $info->cliente->contacto,
            'colaborador' => $info->colaborador->name,
            'creacion_ticket' => $info->created_at,
            'problema' => $info->problema ?? '-',
            'prioridad' => $info->prioridad->nombre,
            'estado' => $info->estado->nombre,
            'observaciones' => $info->observaciones ?? '-',
        ];

        $colaboradores = User::where('interno',1)->whereNot('name', 'Administrado')->orderBy('name')->pluck('email');
        // $colaboradores = User::where('id',1)->pluck('email');

        if ($nuevo) {
            // Enviar a todo soporte
            $datosParaBeesy = new NuevoSoporteBeesy($coleccion);
            Mail::to($colaboradores)->send($datosParaBeesy);
            
            // Enviar al cliente
            if (!$info->interno) {
                $datosParaCliente = new NuevoSoporteCliente($coleccion);
                // $info->cliente->correo
                Mail::to('acevedo51198@gmail.com')->send($datosParaCliente);
            }
        }else{
            $datosGeneral = new EditSoporte($coleccion);
            if ($info->estado_id == 3) {
                $colaboradores = $colaboradores->merge(['acevedo51198@gmail.com'])->unique();
                Mail::to($colaboradores)->send($datosGeneral);
            }else{
                Mail::to($colaboradores)->send($datosGeneral);
            }
        }
    }

    public function obtenerHorasTrabajadas($arr): array{
        $tiempos = [];
        foreach ($arr as $valor) {
            $fechaInicio = Carbon::parse($valor['fechaInicioAsistencia']);
            $fechaFinal = Carbon::parse($valor['fechaFinalAsistencia']);
            
            if ($fechaInicio && $fechaFinal) {
                $diferencia = $fechaInicio->diff($fechaFinal);
    
                // Obtener días, horas y minutos
                $tiempos[] = "{$diferencia->m} meses {$diferencia->d} días, {$diferencia->h} horas, {$diferencia->i} minutos";
            } else {
                $tiempos[] = "Faltan fechas"; // Mensaje alternativo si las fechas no son válidas
            }
        }
        return $tiempos;
    }

    public function obtenerHorasAtrasadas($arr): array{
        $tiempos = [];
        $fechaInicio = Carbon::now();
        foreach ($arr as $valor) {
            $fechaPrevista = Carbon::parse($valor['fecha_prevista_cumplimiento']);
            $fechaFinalAsistencia = Carbon::parse($valor['fechaFinalAsistencia']);

            if ($valor->estado_id != 3) {
                if ($fechaPrevista > $fechaInicio) {
                    $tiempos[] = ['En tiempo',""];
                }else{
                    $diferencia = $fechaInicio->diff($fechaPrevista);
                    $tiempos[] = ['Destiempo',"{$diferencia->y} años, {$diferencia->m} meses, {$diferencia->d} días, {$diferencia->h} horas, {$diferencia->i} minutos"];
                }
            }elseif ($valor->estado_id == 3) {
                if ($fechaFinalAsistencia > $fechaPrevista) {
                    $diferencia = $fechaPrevista->diff($fechaFinalAsistencia);
                    $tiempos[] = ['Realizado en destiempo',"{$diferencia->y} años, {$diferencia->m} meses, {$diferencia->d} días, {$diferencia->h} horas, {$diferencia->i} minutos"];
                }else{
                    $tiempos[] = ['Realizado en tiempo',""];
                }
            }
        }
        return $tiempos;
    }

    public function render(){
        $colaboradores = User::where('interno',1)->whereNotIn('name', ['Administrado', 'Alejandra Romero'])->orderBy('name')->get();
        $clientes = Cliente::orderBy('nombre')->get();
        $userClientes = UserCliente::orderBy('name')->get();
        // $userClientes = Cliente::find(1)->user_clientes;
        $softwares = Software::orderBy('nombre')->get();
        $prioridades = Priority::all();
        $tipos = OrigenAsistencia::orderBy('nombre')->get();
        $estados = State::whereNot('id',1)->get();

        $soportes = Soporte::with(['colaborador','cliente','software','prioridad','estado','tipo','user_cliente'])
        ->when($this->search, function($query){
            $query->where(function($q){
                $q->where('id','like','%'.$this->search.'%')
                  ->orWhereRaw('LOWER(problema) LIKE ?',['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('LOWER(solucion) LIKE ?',['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('LOWER(observaciones) LIKE ?',['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereRaw('DATE_FORMAT(fechaInicioAsistencia, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereRaw('DATE_FORMAT(fechaFinalAsistencia, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereRaw('DATE_FORMAT(fecha_prevista_cumplimiento, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereHas('colaborador', function($consulta){
                    $consulta->whereRaw('LOWER(name) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('estado', function($consulta){
                    $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('cliente', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%'])
                               ->orWhereRaw('LOWER(contacto) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('software', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('prioridad', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('tipo', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('user_cliente', function($consulta){
                      $consulta->whereRaw('LOWER(name) LIKE ?',['%'.strtolower($this->search).'%']);
                  });
            });
        })
        ->when($this->searchEstado != null, function($query){
            $query->whereHas('estado', function($consulta){
                $consulta->where('id','like','%'.$this->searchEstado.'%');
            });
        })
        ->when($this->searchEmpresa != null, function($query){
            $query->whereHas('cliente', function($consulta){
                $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.$this->searchEmpresa.'%']);
            });
        })
        ->when($this->searchCliente != null, function($query){
            $query->whereHas('cliente', function($consulta){
                $consulta->whereRaw('LOWER(contacto) LIKE ?',['%'.$this->searchCliente.'%']);
            });
        })
        ->when($this->searchColaborador != null, function($query){
            $query->whereHas('colaborador', function($consulta){
                $consulta->whereRaw('LOWER(name) LIKE ?',['%'.$this->searchColaborador.'%']);
            });
        })
        ->when($this->searchPrioridad != null, function($query){
            $query->whereHas('prioridad', function($consulta){
                $consulta->where('id','like','%'.$this->searchPrioridad.'%');
            });
        })
        ->when($this->searchProblema != null, function($query){
            $query->where(function($consulta){
                $consulta->orWhereRaw('LOWER(problema) LIKE ?',['%'.strtolower($this->searchProblema).'%']);
            });
        })
        ->when($this->searchSoftware != null, function($query){
            $query->whereHas('software', function($consulta){
                $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.$this->searchSoftware.'%']);
            });
        })
        ->when($this->searchTipo != null, function($query){
            $query->whereHas('Tipo', function($consulta){
                $consulta->where('id','like','%'.$this->searchTipo.'%');
            });
        })
        ->orderBy('id','desc')
        ->paginate(10);

        $tiempos = $this->obtenerHorasTrabajadas($soportes);
        return view('livewire.soporte-component', compact('soportes','tiempos','colaboradores','clientes','userClientes','softwares','prioridades','tipos','estados'));
    }

    public function limpiarDatos(){
        $this->colaborador_id = '';
        $this->fechaInicioAsistencia = '';
        $this->fechaFinalAsistencia = '';
        $this->fecha_prevista_cumplimiento = '';
        $this->cliente_id = '';
        $this->software_id = '';
        $this->problema = '';
        $this->solucion = '';
        $this->observaciones = '';
        $this->prioridad_id = '';
        $this->estado_id = '';
        $this->tipo_id = '';
        $this->user_cliente_id = '';
        $this->interno = '';
        $this->imagen = '';
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
        $this->colaborador_id = $data['colaborador_id'] ?? '';
        $this->fechaInicioAsistencia = $data['fechaInicioAsistencia'] ?? '';
        $this->fechaFinalAsistencia = $data['fechaFinalAsistencia'] ?? '';
        $this->problema = $data['problema'] ?? '';
        $this->solucion = $data['solucion'] ?? '';
        $this->observaciones = $data['observaciones'] ?? '';
        $this->prioridad_id = $data['prioridad_id'] ?? '';
        $this->estado_id = $data['estado_id'] ?? '';
        $this->tipo_id = $data['tipo_id'] ?? '';
        $this->interno = $data['interno'] ?? 0;
        
        // $this->fecha_prevista_cumplimiento = $data['fecha_prevista_cumplimiento'] ?? '';
        // $this->cliente_id = $data['cliente_id'] ?? '';
        // $this->software_id = $data['software_id'] ?? '';
        // $this->user_cliente_id = $data['user_cliente_id'] ?? '';
        // $this->interno = $data['interno'] ?? false; // o '' si prefieres
        // $this->imagen = $data['imagen'] ?? '';    
    }

    public function crear(){
        $validated = $this->validate([
            'colaborador_id' => 'required|exists:users,id',
            'user_cliente_id' => 'nullable|exists:user_clientes,id',
            'cliente_id' => 'required|exists:clientes,id',
            'software_id' => 'required|exists:software,id',
            'prioridad_id' => 'required|exists:priorities,id',
            'tipo_id' => 'nullable|exists:origen_asistencias,id',
            'fecha_prevista_cumplimiento' => 'required|date',
            'imagen' => 'nullable|string|max:255',
            'problema' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'interno' => 'nullable|boolean',

            // 'fechaInicioAsistencia' => 'nullable|date',
            // 'fechaFinalAsistencia' => 'nullable|date|after_or_equal:fechaInicioAsistencia',
            // 'solucion' => 'nullable|string|max:255',
            // 'archivo' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Limitar a ciertos tipos de archivo
            // 'expediente_id' => 'nullable|exists:expedientes,id',
        ]);
        
        // El correo del cliente o empresa
        $validated['correo_cliente'] = Cliente::find($validated['cliente_id'])->correo;
        // El estado es 1 == asignado
        $validated['estado_id'] = 1;
        // Si no hay tipo usuario del cliente lo pasamos a null
        $validated['user_cliente_id'] = $validated['user_cliente_id'] == '' ? null : $validated['user_cliente_id'];
        // Si no hay tipo entonces lo pasamos a null
        $validated['tipo_id'] = $validated['tipo_id'] == '' ? null : $validated['tipo_id'];
        // Determinar si es interno o no
        $validated['interno'] = $validated['interno'] ? 1 : 0;

        // Crear el nuevo elemento
        $soporte = Soporte::create($validated);

        $this->eviarEmail($soporte);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([
            'colaborador_id' => 'required|exists:users,id',
            'prioridad_id' => 'required|exists:priorities,id',
            'tipo_id' => 'nullable|exists:origen_asistencias,id',
            'estado_id' => 'required|exists:states,id',
            'fechaInicioAsistencia' => 'required|date',
            'fechaFinalAsistencia' => 'nullable|date|after_or_equal:fechaInicioAsistencia',
            'solucion' => 'nullable|string|max:255',
            'problema' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'interno' => 'nullable|boolean',

            // 'correo_cliente' => 'required|email|max:255',
            // 'archivo' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Limitar a ciertos tipos de archivo
            // 'expediente_id' => 'nullable|exists:expedientes,id',
        ], [
            'fechaInicioAsistencia.required' => 'Campo obligatorio',
            'fechaFinalAsistencia.after_or_equal' => 'Debe ser mayor a fecha inicio'
        ]);

        // Si no hay tipo entonces lo pasamos a null
        $validated['tipo_id'] = $validated['tipo_id'] == '' ? null : $validated['tipo_id'];

        // Si no hay fecha final entonces lo pasamos a null
        $validated['fechaFinalAsistencia'] = $validated['fechaFinalAsistencia'] == '' ? null : $validated['fechaFinalAsistencia'];

        // Ayuda a cambiar estado
        $validated['estado_id'] = $validated['estado_id'] == 1 ? 2 : $validated['estado_id'];

        // Indicar si el usuario es interno o no
        $validated['interno'] = $validated['interno'] ? 1 : 0;

        $soporte = Soporte::find($this->id);

        $soporte->fill($validated);

        if ($soporte->isDirty()) {
            $soporte->update($validated);
            $this->eviarEmail($soporte, false);
            $this->alert('success', 'Información Actualizada');
        }else{
            $this->alert('info', 'No se realizaron cambios');
        }

        $this->isOpenModal = false;
    }

    public function borrar($id){
        Soporte::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }

    public function exportExcel(){
        $soportes = Soporte::with(['colaborador','cliente','software','prioridad','estado','tipo','user_cliente'])
        ->when($this->search, function($query){
            $query->where(function($q){
                $q->where('id','like','%'.$this->search.'%')
                  ->orWhereRaw('LOWER(problema) LIKE ?',['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('LOWER(solucion) LIKE ?',['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('LOWER(observaciones) LIKE ?',['%'.strtolower($this->search).'%'])
                  ->orWhereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereRaw('DATE_FORMAT(fechaInicioAsistencia, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereRaw('DATE_FORMAT(fechaFinalAsistencia, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereRaw('DATE_FORMAT(fecha_prevista_cumplimiento, "%Y-%m-%d") LIKE ?', ['%'.$this->search.'%'])
                  ->orWhereHas('colaborador', function($consulta){
                    $consulta->whereRaw('LOWER(name) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('estado', function($consulta){
                    $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('cliente', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%'])
                               ->orWhereRaw('LOWER(contacto) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('software', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('prioridad', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('tipo', function($consulta){
                      $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.strtolower($this->search).'%']);
                  })
                  ->orWhereHas('user_cliente', function($consulta){
                      $consulta->whereRaw('LOWER(name) LIKE ?',['%'.strtolower($this->search).'%']);
                  });
            });
        })
        ->when($this->searchEstado != null, function($query){
            $query->whereHas('estado', function($consulta){
                $consulta->where('id','like','%'.$this->searchEstado.'%');
            });
        })
        ->when($this->searchEmpresa != null, function($query){
            $query->whereHas('cliente', function($consulta){
                $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.$this->searchEmpresa.'%']);
            });
        })
        ->when($this->searchCliente != null, function($query){
            $query->whereHas('cliente', function($consulta){
                $consulta->whereRaw('LOWER(contacto) LIKE ?',['%'.$this->searchCliente.'%']);
            });
        })
        ->when($this->searchColaborador != null, function($query){
            $query->whereHas('colaborador', function($consulta){
                $consulta->whereRaw('LOWER(name) LIKE ?',['%'.$this->searchColaborador.'%']);
            });
        })
        ->when($this->searchPrioridad != null, function($query){
            $query->whereHas('prioridad', function($consulta){
                $consulta->where('id','like','%'.$this->searchPrioridad.'%');
            });
        })
        ->when($this->searchProblema != null, function($query){
            $query->where(function($consulta){
                $consulta->orWhereRaw('LOWER(problema) LIKE ?',['%'.strtolower($this->searchProblema).'%']);
            });
        })
        ->when($this->searchSoftware != null, function($query){
            $query->whereHas('software', function($consulta){
                $consulta->whereRaw('LOWER(nombre) LIKE ?',['%'.$this->searchSoftware.'%']);
            });
        })
        ->when($this->searchTipo != null, function($query){
            $query->whereHas('Tipo', function($consulta){
                $consulta->where('id','like','%'.$this->searchTipo.'%');
            });
        })
        ->orderBy('id','desc')
        ->get();

        $tiempoTrabajado = $this->obtenerHorasTrabajadas($soportes);
        $tiempoRetraso = $this->obtenerHorasAtrasadas($soportes);

        return Excel::download(new SoporteExport($soportes, $tiempoTrabajado, $tiempoRetraso), 'Soporte.xlsx');
    }

    public function importar(){
        $this->validate([
            'fileExcel' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new SoporteImport, $this->fileExcel);
    }
}
