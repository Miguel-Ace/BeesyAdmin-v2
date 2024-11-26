<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Licencia;
use App\Models\Software;
use App\Models\SubscriptionStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LicenciaComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $isModalEditPlan = false;
    public $id = '';
    public $cliente_id, $software_id, $ruta, $cantidad, $fechaInicio, $fechaFinal, $cantidad_usuario, $bee_commerce;
    public $intervalo, $countIntervalo, $monto, $descripcion;
    public $search = '';
    public $searchDateUpdate = '';
    
    public function render(){
        $clientes = Cliente::orderBy('nombre')->get();
        $software = Software::orderBy('nombre')->get();
        $intervalos = ['day','week','month'];
        
        $licencias = Licencia::with(['cliente','software'])
        ->when(auth()->user()->getRoleNames()->first() == 'Cliente', function($query){
            $query->where('cliente_id', auth()->user()->cliente->id);
        })
        ->when($this->search != null, function($query){
            $query->where(function ($q) {
                // Búsqueda en clientes
                $q->whereHas('cliente', function ($consulta) {
                    $consulta->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
                // Búsqueda en software
                $q->orWhereHas('software', function ($consulta) {
                    $consulta->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
                // Otras condiciones de búsqueda
                $q->orWhereRaw('LOWER(ruta) LIKE ?', ['%' . strtolower($this->search) . '%'])
                        ->orWhereRaw('DATE_FORMAT(fechaInicio, "%Y-%m-%d") LIKE ?', ['%' . $this->search . '%'])
                        ->orWhereRaw('DATE_FORMAT(fechaFinal, "%Y-%m-%d") LIKE ?', ['%' . $this->search . '%'])
                        ->orWhere('cantidad', 'like', '%' . $this->search . '%')
                        ->orWhere('cantidad_usuario', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->searchDateUpdate != null, function($query){
            $query->whereRaw('DATE_FORMAT(updated_at, "%Y-%m-%d") LIKE ?', ['%' . $this->searchDateUpdate . '%']);
        })
        ->paginate(10);
        return view('livewire.licencia-component', compact('licencias','clientes','software','intervalos'));
    }

    public function limpiarDatos(){
        $this->cliente_id = '';
        $this->software_id = '';
        $this->ruta = '';
        $this->cantidad = '';
        $this->fechaInicio = '';
        $this->fechaFinal = '';
        $this->cantidad_usuario = '';
        $this->bee_commerce = '';
    }

    public function modalCrear(){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isModalEditPlan = false;
        $this->isModalCrear = true;
        $this->resetErrorBag();
        $this->limpiarDatos();
    }

    public function modalEditar($data){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isModalCrear = false;
        $this->resetErrorBag();
        
        $this->id = $data['id'];
        $this->cliente_id = $data['cliente_id'];
        $this->software_id = $data['software_id'];
        $this->ruta = $data['ruta'];
        $this->cantidad = $data['cantidad'];
        $this->fechaInicio = $data['fechaInicio'];
        $this->fechaFinal = $data['fechaFinal'];
        $this->cantidad_usuario = $data['cantidad_usuario'];
        $this->bee_commerce = $data['bee_commerce'];
    }

    public function modalEditarPlan($data){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isModalEditPlan = true;
        $this->resetErrorBag();

        $this->id = $data['id'];
        $this->intervalo = $data['intervalo'] ?? '';
        $this->countIntervalo = $data['countIntervalo'] ?? '';
        $this->monto = $data['monto'] ?? '';
        $this->descripcion = $data['descripcion'];
    }

    public function crear(){
       $validated = $this->validate([ 
            'cliente_id' => 'required',
            'software_id' => 'required',
            'ruta' => 'nullable|min:3',
            'cantidad' => 'required',
            'fechaInicio' => 'required',
            'fechaFinal' => 'required',
            'cantidad_usuario' => 'required',
            'bee_commerce' => 'boolean',
        ]);

        $validated['bee_commerce'] = $this->bee_commerce ? 1 : 0;

        // Crear el nuevo elemento
        Licencia::create($validated);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'cliente_id' => 'required',
            'software_id' => 'required',
            'ruta' => 'nullable',
            'cantidad' => 'required',
            'fechaInicio' => 'required',
            'fechaFinal' => 'required',
            'cantidad_usuario' => 'required',
            'bee_commerce' => 'boolean',
        ]);

        $licencia = Licencia::find($this->id);

        $licencia->update($validated);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function editarPlan(){
        $validated = $this->validate([ 
            'intervalo' => 'required',
            'countIntervalo' => 'required|integer|min:1',
            'monto' => 'required|integer|min:1',
            'descripcion' => 'nullable',
        ],[
            'intervalo.required' => 'Campo obligatorio',
            'countIntervalo.required' => 'Campo obligatorio',
            'countIntervalo.min' => 'Mínimo de 1',
            'monto.required' => 'Campo obligatorio',
            'monto.min' => 'Mínimo de 1',
        ]);

        $licencia = Licencia::find($this->id);

        $licencia->update($validated);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function borrar($id){
        Licencia::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }

    public function generarChecksum($data){
        $FIXED_HASH = "7109a211980e4c5b14a1986a410149a0dda7a009e9984840a8f32fe4fb01bf9667d65c12519814fb7d88b995dcd7897828b6001a4caee7b759aa93e2a0bf49cc";

        // Concatenar los datos en una cadena
        $data_string = $data['merchant'] . $data['id'] . $FIXED_HASH;

        // Calcular el hash SHA-512
        $hash_result = hash('sha512', $data_string);

        return $hash_result;
    }
    
    public function cancelarPlan($info){
        $data = [
            "merchant" => "beesysandbox",
            "id" => $info['subscripcion_id'],
        ];
        $data["checksum"] = $this->generarChecksum($data);

        // dd($data);
        
        // Hacer la solicitud POST
        $response = Http::delete('https://api-test.payvalida.com/v4/subscriptions', $data);

        // Obtener la respuesta
        if ($response->successful()) {
            Licencia::find($info['id'])->update([
                'plan_id' => null,
                'subscripcion_id' => null
            ]);

            $this->alert('success', 'Subscripción cancelada');
            // dd($response->json());
            // return $response->json(); // Devuelve los datos en formato JSON si la solicitud es exitosa
        } else {
            dd($response->status());
            $this->alert('error', 'No se pudo cancelar');
            // return $response->status(); // Devuelve el código de estado si falla
        }

        // $plan = Licencia::find($info->id);
        // $plan->update(['response_id' => null]);
    }

    public function verificarLicencias(){
        $licencias = Licencia::whereNotNull('plan_id')->get();

        foreach ($licencias as $licencia) {
            $estadoSuscripcion = SubscriptionStatus::where('po_id',$licencia->subscripcion_id)->where('renovacion',0)->first();

            function updateRenovacion($estadoSuscripcion){
                $estadoSuscripcion->update([
                    'renovacion' => 1
                ]);
            }


            if ($estadoSuscripcion != null ) {
                if ($estadoSuscripcion['status']) {
                    $fechaInicio = Carbon::createFromFormat('Y-m-d', $licencia->fechaInicio);
                    $fechaFinal = Carbon::createFromFormat('Y-m-d', $licencia->fechaFinal);
        
                    $licencia->update([
                        'fechaInicio' => $fechaInicio->add((int)$licencia->countIntervalo, $licencia->intervalo),
                        'fechaFinal' => $fechaFinal->add((int)$licencia->countIntervalo, $licencia->intervalo),
                    ]);
                    updateRenovacion($estadoSuscripcion);
                }else{
                    $licencia->update([
                        'plan_id' => null,
                        'subscripcion_id' => null,
                    ]);
                    updateRenovacion($estadoSuscripcion);
                }
            }
        }

        $this->alert('success', 'Renovación completada');
    }
}
