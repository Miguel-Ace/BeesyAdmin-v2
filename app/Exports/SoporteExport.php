<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SoporteExport implements FromView
{
    public $soportes;
    public $tiempoTrabajado;
    public $tiempoRetraso;

    public function __construct($soportes, $tiempoTrabajado, $tiempoRetraso){
        $this->soportes = $soportes;
        $this->tiempoTrabajado = $tiempoTrabajado;
        $this->tiempoRetraso = $tiempoRetraso;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $soportes = $this->soportes;
        $tiempoTrabajado = $this->tiempoTrabajado;
        $tiempoRetraso = $this->tiempoRetraso;
        return view('exportSoporte', compact('soportes','tiempoTrabajado','tiempoRetraso'));
    }
}
