<table>
    <thead>
        <tr>
            <th>Ticket</th>
            <th>Prioridad</th>
            <th>Estado</th>
            <th>Asesor</th>
            <th>Empresa</th>
            <th>Usuario</th>
            <th>Origen de asistencia</th>
            <th>Detalle asistencia</th>
            <th>Fecha de creación</th>
            <th>Fecha prevista cumplimiento</th>
            <th>Estado de cumplimiento</th>
            <th>Tiempo de atraso</th>
            <th>Fecha inicial asistencia</th>
            <th>Fecha final asistencia</th>
            <th>Total de horas</th>
            <th>Solución</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($soportes as $key => $soporte)
        <tr>
            <td>{{$soporte->id}}</td>
            <td>{{$soporte->prioridad->nombre ?? '-'}}</td>
            <td>{{$soporte->estado->nombre ?? '-'}}</td>
            <td>{{$soporte->colaborador->name ?? '-'}}</td>
            <td>{{$soporte->cliente->nombre ?? '-'}}</td>
            <td>{{$soporte->cliente->contacto ?? '-'}}</td>
            <td>{{$soporte->tipo->nombre ?? '-'}}</td>
            <td>{{$soporte->problema ?? '-'}}</td>
            <td>{{$soporte->created_at ?? '-'}}</td>
            <td>{{$soporte->fecha_prevista_cumplimiento ?? '-'}}</td>
            <td>{{$tiempoRetraso[$key][0]}}</td>
            <td>{{$tiempoRetraso[$key][1]}}</td>
            <td>{{$soporte->fechaInicioAsistencia ?? '-'}}</td>
            <td>{{$soporte->fechaFinalAsistencia ?? '-'}}</td>
            <td>{{$tiempoTrabajado[$key]}}</td>
            <td>{{$soporte->solucion ?? '-'}}</td>
            <td>{{$soporte->observaciones ?? '-'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>