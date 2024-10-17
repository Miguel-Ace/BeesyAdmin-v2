<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function software(){
        return view('software');
    }

    public function clientes(){
        return view('clientes');
    }

    public function user_cliente($id){
        return view('user_clientes', compact('id'));
    }

    public function licencias(){
        return view('licencias');
    }

    public function terminales(){
        return view('terminales');
    }

    public function estados(){
        return view('estados');
    }

    public function etapas(){
        return view('etapas');
    }

    public function prioridades(){
        return view('prioridades');
    }

    public function preguntas(){
        return view('preguntas');
    }

    public function respuestas($id){
        return view('respuestas', compact('id'));
    }

    public function usuarios(){
        return view('usuarios');
    }

    public function soportes(){
        return view('soportes');
    }

    public function subscripciones($id_licencia,$name){
        return view('subscripciones', compact('id_licencia','name'));
    }

    public function handleWebhook(Request $request)
    {
        // Procesar el contenido JSON recibido
        $data = $request->all();
        
        // Retornar una respuesta 200 a Payvalida
        return response()->json($data, 200);
    }
}
