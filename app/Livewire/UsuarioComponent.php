<?php

namespace App\Livewire;

use App\Mail\NuevoUsuario;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Permission\Models\Role;

class UsuarioComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isOpenModal = false;
    public $isModalCrear = false;
    public $id = '';
    public $name, $email, $interno, $cliente_id, $rol;
    public $search = '';
    public $searchIterno = '';

    public function render()
    {
        $roles = Role::all();
        $clientes = Cliente::all();

        $usuarios = User::with(['cliente'])
        ->where('name', '!=', 'Administrado')
        ->when($this->searchIterno !== null, function ($query) {
            $query->where('interno', 'like', '%' . $this->searchIterno . '%');
        })
        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
                ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($this->search) . '%'])
                ->orWhereHas('cliente', function ($consulta) {
                    $consulta->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
            });
        })
        ->paginate(10);
        return view('livewire.usuario-component', compact('usuarios','clientes','roles'));
    }

    public function limpiarDatos(){
        $this->name = '';
        $this->email = '';
        $this->cliente_id = '';
        $this->rol = '';
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
        $this->rol = User::find($this->id)->roles->first()->id ?? '';
        $this->cliente_id = $data['cliente_id'] ?? '';
    }

    public function crear(){
        $validated = $this->validate([ 
            'name' => 'required|min:3',
            'email' => 'required|email',
            // 'interno' => 'required',
            'cliente_id' => 'nullable',
            'rol' => 'required',
        ],[
            'name.required' => 'Campo obligatorio',
            'name.min' => 'Mínimo de 3',
            'email.required' => 'Campo obligatorio',
            'email.email' => 'No es un email valido',
            'rol.required' => 'Campo obligatorio',
        ]);
        
        // Si no hay cliente entonces que sea null
        if ($validated['cliente_id'] === '') {
            $validated['cliente_id'] = null;
        }
        
        // Indicar si el usuario es interno o no
        $validated['interno'] = $validated['rol'] != 2 ? 1 : 0;

        // Crear contraseña hasheada
        $validated['password'] = Hash::make(12345678);

        // Crear el nuevo elemento
        $user = User::create($validated);

        // Asignar el rol al usuario según el valor validado
        $user->assignRole(Role::find($validated['rol'])->name);

        // Limpiar los campos del formulario
        $this->limpiarDatos();

        // Cerrar el modal
        $this->isOpenModal = false;

        // Información que lleva el mensaje
        $datosParaCorreo = new NuevoUsuario($validated);
        // Enviar correo al usuario
        Mail::to($validated['email'])->send($datosParaCorreo);

        $this->alert('success', 'Información Guardada');

        // La lista se actualizará automáticamente en el render()
    }

    public function editar(){
        $validated = $this->validate([ 
            'name' => 'required|min:3',
            'email' => 'required|email',
            // 'interno' => 'required',
            'cliente_id' => 'nullable',
            'rol' => 'required',
        ]);

        // Si no hay cliente entonces que sea null
        if ($validated['cliente_id'] === '') {
            $validated['cliente_id'] = null;
        }

        // Indicar si el usuario es interno o no
        $validated['interno'] = $validated['rol'] != 2 ? 1 : 0;

        $usuario = User::find($this->id);

        // Comprobar si hay un cambio de rol
        $cambioDeRol = $usuario->getRoleNames()->first() !== Role::find($validated['rol'])->name;

        $usuario->fill($validated);

        if ($usuario->isDirty() || $cambioDeRol) {
            $usuario->update($validated);
            $usuario->syncRoles([Role::find($validated['rol'])->name]);
            $this->alert('success', 'Información Actualizada');
        }else{
            $this->alert('info', 'No se realizaron cambios');
        }

        $this->isOpenModal = false;
    }

    public function borrar($id){
        User::find($id)->syncRoles([]);
        User::destroy($id);
        $this->alert('success', 'Información Eliminada');
    }
}
