<?php

namespace App\Console\Commands;

use App\Mail\SoporteDestiempoBeesy;
use App\Models\Soporte;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SoporteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:soportesdestiempo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tickets en destiempo';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $fechaHoy = Carbon::now();
        $soportes = Soporte::where('estado_id', '!=', 3)
                   ->whereDate('fecha_prevista_cumplimiento', '<', $fechaHoy)
                   ->get();

        $colaboradores = User::where('interno',1)->whereNot('name', 'Administrado')->orderBy('name')->pluck('email');
        // $colaboradores = User::where('id',1)->pluck('email');

        // Enviar a todo soporte
        $datosParaBeesy = new SoporteDestiempoBeesy($soportes);
        Mail::to($colaboradores)->send($datosParaBeesy);
    }
}
