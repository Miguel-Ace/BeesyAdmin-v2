<?php

namespace App\Livewire;

use App\Livewire\Actions\Logout;
use App\Models\Soporte;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class NavComponent extends Component
{
    use LivewireAlert;

    public $isOpenModal = false;
    public $isSoporteDestiempo;
    public $password_actual, $password;

    public function render()
    {
        $fechaHoy = Carbon::now();
        $soportes = auth()->user()->getRoleNames()->first() != 'Cliente'
        ? Soporte::where('estado_id', '!=', 3)
                   ->whereDate('fecha_prevista_cumplimiento', '<', $fechaHoy)
                   ->get()
        : [];

        return view('livewire.nav-component', compact('soportes'));
    }

    public function logout(Logout $logout)
    {
        $logout();
        $this->redirect('/login');
    }

    public function limpiarDatos(){
        $this->password_actual = '';
        $this->password = '';
    }

    public function estadoModal($estado = false){
        $this->isOpenModal = !$this->isOpenModal;
        $this->isSoporteDestiempo = $estado;
        $this->limpiarDatos();
    }

    public function guardarPassword(){
        $validated = $this->validate([ 
            'password_actual' => 'required|min:8',
            'password' => 'required|min:8',
        ],[
            'password_actual.required' => 'Campo obligatorio',
            'password_actual.min' => 'Mínimo de 8 caracteres',
            'password.required' => 'Campo obligatorio',
            'password.min' => 'Mínimo de 8 caracteres',
        ]);

        $usuario = User::find(auth()->user()->id);

        if (Hash::check($validated['password_actual'], $usuario->password)) {
            $usuario->update([
                'password' => Hash::make($validated['password'])
            ]);
            $this->estadoModal();
            $this->alert('success', 'Información Actualizada');
            return;
        }

        $this->alert('error', 'No coincide la contraseña');
    }
}
