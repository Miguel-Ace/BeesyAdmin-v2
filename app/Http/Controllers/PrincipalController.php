<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function postWebhook(Request $request)
    {
        // // Obtiene todos los datos enviados en la solicitud POST
        $data = $request->all();
        
        SubscriptionStatus::create([
            'pv_po_id' => (int) $data['pv_po_id'],
            'po_id' => $data['po_id'],
            'status' => $data['status'] == "approved" ? 1 : 0,
            'amount' => (float) $data['amount'],
            'pv_checksum' => $data['pv_checksum'],
            'renovacion' => 0,
        ]);

        // // Convierte los datos a formato JSON para almacenarlos en el archivo de texto
        // $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        
        // // Almacena los datos en el archivo
        // Storage::disk('public')->put('archivos/texto.txt', $jsonData . "\n");
    
        // // Retorna una respuesta de confirmación
        // return response()->json(['status' => 'success', 'message' => 'se guardo bien, o eso creo']);

        return response()->json(['status' => 'Todo bien, gracias por la data.', 'data' => $data]);
    }

    public function handleWebhook(Request $request)
    {
        // Procesar el contenido JSON recibido
        $data = $request->all();
        
        // Retornar una respuesta 200 a Payvalida
        return response()->json($data, 200);
    }
}
