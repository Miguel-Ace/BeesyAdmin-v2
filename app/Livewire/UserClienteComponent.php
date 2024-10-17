<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\UserCliente;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserClienteComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $name, $email;
    public $search = '';
    public $clienteId;

    // Si necesitas ejecutar alguna lógica al momento de montar el componente

    public function render()
    {
        $nombreCliente = Cliente::find($this->clienteId)->nombre; 

        $userClientes = $this->search 
        ? UserCliente::where('cliente_id',$this->clienteId)
        ->where(function ($consulta) {
            $consulta->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
                     ->OrWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($this->search) . '%']);
        })
        ->paginate(10)  // Asegúrate de usar paginate aquí
        : UserCliente::where('cliente_id',$this->clienteId)->paginate(10);
        return view('livewire.user-cliente-component', compact('userClientes','nombreCliente'));
    }

    public function limpiarDatos(){
        $this->name = '';
        $this->email = '';
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
        $this->name = $data['name'];
        $this->email = $data['email'];
    }

    public function crear(){
        $this->validate([ 
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);

        // Crear el nuevo elemento
        UserCliente::create([
            'name' => $this->name,
            'email' => $this->email,
            'cliente_id' => $this->clienteId,
        ]);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $this->validate([ 
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);

        $user_cliente = UserCliente::find($this->id);

        $user_cliente->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->isOpenModal = false;

        $this->alert('success', 'Información Actualizada');
    }

    public function borrar($id){
        UserCliente::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
