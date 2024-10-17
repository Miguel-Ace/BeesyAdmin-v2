@extends('layouts.app')

@section('contenido')
    @livewire('respuesta-component', ['preguntaId' => $id])
@endsection