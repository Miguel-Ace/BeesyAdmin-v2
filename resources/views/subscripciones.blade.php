@extends('layouts.app')

@section('contenido')
    @livewire('subscripcion-component', [
        'licenciaId' => $id_licencia,
        'clienteName' => $name
        ])
@endsection