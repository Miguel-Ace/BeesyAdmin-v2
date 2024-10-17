@extends('layouts.app')

@section('contenido')
    @livewire('user-cliente-component', ['clienteId' => $id])
@endsection