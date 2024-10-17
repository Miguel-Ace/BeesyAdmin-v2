<?php

namespace App\Livewire;

use Livewire\Component;

class LateralComponent extends Component
{
    public function render()
    {
        return view('livewire.lateral-component');
    }

    public function redirigir($sitio){
        return redirect('/'.$sitio);
    }
}
