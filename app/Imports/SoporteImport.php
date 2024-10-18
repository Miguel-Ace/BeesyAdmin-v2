<?php

namespace App\Imports;

use App\Models\Cliente;
use App\Models\OrigenAsistencia;
use App\Models\Priority;
use App\Models\Software;
use App\Models\Soporte;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoporteImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Soporte([
            'colaborador_id' => User::whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($row['colaborador']).'%'])->pluck('id')->first() ?? 19,
            'created_at' => $row['fechacreacionticke'],
            'fechaInicioAsistencia' => $row['fechainicioasistencia'] ?? null,
            'fechaFinalAsistencia' => $row['fechafinalasistencia'] ?? null,
            'cliente_id' => Cliente::whereRaw('LOWER(contacto) LIKE ?', ['%'.strtolower($row['id_cliente']).'%'])->pluck('id')->first() ?? 52,
            'software_id' => Software::whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($row['id_software']).'%'])->pluck('id')->first(),
            'problema' => $row['problema'],
            'solucion' => $row['solucion'],
            'observaciones' => $row['observaciones'],
            'prioridad_id' => Priority::whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($row['prioridad']).'%'])->pluck('id')->first(),
            'estado_id' => State::whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($row['estado']).'%'])->pluck('id')->first() ?? 1,
            'correo_cliente' => $row['correo_cliente'],
            'tipo_id' => OrigenAsistencia::whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($row['origen_asistencia']).'%'])->pluck('id')->first(),
            'fecha_prevista_cumplimiento' => $row['fecha_prevista_cumplimiento'],
            'interno' => $row['interno'] ?? 0,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
