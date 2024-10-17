<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Licencia;
use App\Models\Proyecto;
use App\Models\Soporte;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardComponent extends Component
{
    use WithPagination;
    public $searchEmpresa;
    public $searchCliente;
    public $searchColaborador = '';

    public function sacarDatosParaGrafico(){
        // Obtén los clientes con la cantidad de soportes en una sola consulta
        $clientes = Cliente::withCount('soportes')->get();
        $nombreCLientes = $clientes->pluck('nombre');
        $soportesObtuvoCLientes = $clientes->pluck('soportes_count');

        return [
            $nombreCLientes,
            $soportesObtuvoCLientes
        ];
    }

    public function render(){
        $users = User::where('interno',1)->whereNotIn('id', [2,8,19,20])->get();

        // Los datos que sirven como leyenda
        $countLicencias = Licencia::count() != 0 ? Licencia::orderBy('id', 'desc')->first()->id : 0;
        $countClientes = Cliente::count() != 0 ? Cliente::orderBy('id', 'desc')->first()->id : 0;
        $countSoportes = Soporte::count() != 0 ? Soporte::orderBy('id', 'desc')->first()->id : 0;
        $countProyectos = Proyecto::count() != 0 ? Proyecto::orderBy('id', 'desc')->first()->id : 0;

        // Los datos que se mostrarán en el gráfico
        $datos = $this->sacarDatosParaGrafico();

        // Obtenemos los clientes paginados y actualizamos el array de info
        $clientes = Cliente::
        when($this->searchEmpresa != '', function($query){
            $query->whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($this->searchEmpresa).'%']);
        })
        ->when($this->searchCliente != '', function($query){
            $query->whereRaw('LOWER(contacto) LIKE ?', ['%'.strtolower($this->searchCliente).'%']);
        })
        ->withCount(['soportes as soportesAtendidosPorColaborador' => function ($query) {
            $query->where('colaborador_id', $this->searchColaborador);
        }])
        ->withCount('soportes')
        ->paginate(10);
        
        return view('livewire.dashboard-component', [
            'countLicencias' => $countLicencias,
            'countClientes' => $countClientes,
            'countSoportes' => $countSoportes,
            'countProyectos' => $countProyectos,
            'nombreCLientes' => json_encode($datos[0]),
            'soportesObtuvoCLientes' => json_encode($datos[1]),
            'clientes' => $clientes,
            'users' => $users,
        ]);
    }
}
