@extends('layouts.app')

@section('contenido')
    @unless(auth()->user()->hasRole('Cliente'))
        @livewire('dashboard-component')
    @endunless
@endsection