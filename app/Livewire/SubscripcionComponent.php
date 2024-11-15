<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Licencia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use PharIo\Manifest\License;

class SubscripcionComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $isViewTarjeta = false;
    public $nombresCliente, $apellidosCliente, $identificacionCliente, $telefonoCliente, $correoCliente;
    public $numTarjeta, $cvv, $fechaVencimiento, $nombresTarjeta, $apellidosTarjeta, $identificacionTarjeta, $telefonoTarjeta, $correoTarjeta, $direccion, $direccion2, $direccion3, $provincia, $canton, $codPostal;
    public $isOpenModal = false;
    public $licenciaId;
    public $clienteName;

    // Si necesitas ejecutar alguna lógica al momento de montar el componente

    public function obtenerCliente(){
        return Cliente::where('nombre',$this->clienteName)->first();
    }

    public function render()
    {
        $datosCliente = $this->obtenerCliente();
        return view('livewire.subscripcion-component', compact('datosCliente'));
    }

    public function mount(){
        $datosCliente = $this->obtenerCliente();
        $this->identificacionCliente = $datosCliente->cedula;
        $this->telefonoCliente = $datosCliente->telefono;
        $this->correoCliente = $datosCliente->correo;
        
        $this->identificacionTarjeta = $datosCliente->cedula;
        $this->telefonoTarjeta = $datosCliente->telefono;
        $this->correoTarjeta = $datosCliente->correo;
    }

    public function limpiarDatos(){
        $this->nombresCliente = '';
        $this->apellidosCliente = '';
        $this->identificacionCliente = '';
        $this->telefonoCliente = '';
        $this->correoCliente = '';
        $this->numTarjeta = '';
        $this->cvv = '';
        $this->fechaVencimiento = '';
        $this->nombresTarjeta = '';
        $this->apellidosTarjeta = '';
        $this->identificacionTarjeta = '';
        $this->telefonoTarjeta = '';
        $this->correoTarjeta = '';
        $this->direccion = '';
        $this->direccion2 = '';
        $this->direccion3 = '';
        $this->provincia = '';
        $this->canton = '';
        $this->codPostal = '';
    }

    public function atras(){
        $this->isViewTarjeta = false;
    }

    public function datosTarjeta(){
        $this->validate([ 
            'nombresCliente' => 'required|string|max:255',
            'apellidosCliente' => 'required|string|max:255',
            'identificacionCliente' => 'required|string|min:9|max:20', // Ajusta según el formato que uses
            'telefonoCliente' => 'required|regex:/^[0-9]{8,15}$/', // Solo números, entre 8 y 15 dígitos
            'correoCliente' => 'required|email',
        ], [
            'nombresCliente.required' => 'El nombre del cliente es obligatorio.',
            'nombresCliente.string' => 'El nombre debe ser una cadena de texto.',
            'nombresCliente.max' => 'El nombre no debe exceder 255 caracteres.',
            
            'apellidosCliente.required' => 'El apellido del cliente es obligatorio.',
            'apellidosCliente.string' => 'El apellido debe ser una cadena de texto.',
            'apellidosCliente.max' => 'El apellido no debe exceder 255 caracteres.',
            
            'identificacionCliente.required' => 'La identificación del cliente es obligatoria.',
            'identificacionCliente.string' => 'La identificación debe ser una cadena de texto.',
            'identificacionCliente.min' => 'La identificación tiene un mínimo de 9 caracteres.',
            'identificacionCliente.max' => 'La identificación no debe exceder 20 caracteres.',
            
            'telefonoCliente.required' => 'El teléfono del cliente es obligatorio.',
            'telefonoCliente.regex' => 'Solo números entre 8 y 15 dígitos.',
            
            'correoCliente.required' => 'El correo electrónico es obligatorio.',
            'correoCliente.email' => 'El formato del correo electrónico es inválido.',
        ]);

        $this->isViewTarjeta = true;
    }

    public function salirModal(){
        $this->isOpenModal = !$this->isOpenModal;
    }

    public function procesarPago(){
        $this->validate([
            'numTarjeta' => 'required|digits_between:12,20', // Entre 13 y 19 dígitos para tarjetas
            'cvv' => 'required|digits_between:3,5', // CVV con 3 o 4 dígitos
            'fechaVencimiento' => 'required|string|min:5', // Formato mm/yy y debe ser posterior a hoy
            'nombresTarjeta' => 'required|string|max:255',
            'apellidosTarjeta' => 'required|string|max:255',
            'identificacionTarjeta' => 'required|string|min:9|max:20', // Ajustar si hay un formato específico
            'telefonoTarjeta' => 'required|regex:/^[0-9]{8,15}$/', // Teléfono, solo números entre 8 y 15 dígitos
            'correoTarjeta' => 'required|email',
            'direccion' => 'required|string|max:255',
            'direccion2' => 'nullable|string|max:255', // Campo opcional
            'direccion3' => 'nullable|string|max:255', // Campo opcional
            'provincia' => 'required|string|max:100',
            'canton' => 'required|string|max:100',
            'codPostal' => 'required|string|max:10',
        ], [
            'numTarjeta.required' => 'El número de tarjeta es obligatorio.',
            'numTarjeta.digits_between' => 'El número de tarjeta debe tener entre 13 y 19 dígitos.',
            
            'cvv.required' => 'El CVV es obligatorio.',
            'cvv.digits_between' => 'El CVV debe tener entre 3 y 4 dígitos.',
            
            'fechaVencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fechaVencimiento.min' => 'Falta información.',
            
            'nombresTarjeta.required' => 'El nombre del titular es obligatorio.',
            'nombresTarjeta.string' => 'El nombre del titular debe ser una cadena de texto.',
            'nombresTarjeta.max' => 'El nombre del titular no debe exceder 255 caracteres.',
            
            'apellidosTarjeta.required' => 'El apellido del titular es obligatorio.',
            'apellidosTarjeta.string' => 'El apellido del titular debe ser una cadena de texto.',
            'apellidosTarjeta.max' => 'El apellido del titular no debe exceder 255 caracteres.',
            
            'identificacionTarjeta.required' => 'La identificación del titular es obligatoria.',
            'identificacionTarjeta.string' => 'La identificación del titular debe ser una cadena de texto.',
            'identificacionTarjeta.min' => 'La identificación debe tener un mínimo de 9 caracteres.',
            'identificacionTarjeta.max' => 'La identificación no debe exceder 20 caracteres.',
            
            'telefonoTarjeta.required' => 'El teléfono es obligatorio.',
            'telefonoTarjeta.regex' => 'El formato del teléfono es incorrecto. Debe contener solo números y tener entre 8 y 15 dígitos.',
            
            'correoTarjeta.required' => 'El correo electrónico es obligatorio.',
            'correoTarjeta.email' => 'El formato del correo electrónico es inválido.',
            
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no debe exceder 255 caracteres.',
            
            'direccion2.string' => 'La dirección 2 debe ser una cadena de texto.',
            'direccion2.max' => 'La dirección 2 no debe exceder 255 caracteres.',
            
            'direccion3.string' => 'La dirección 3 debe ser una cadena de texto.',
            'direccion3.max' => 'La dirección 3 no debe exceder 255 caracteres.',
            
            'provincia.required' => 'La provincia es obligatoria.',
            'provincia.string' => 'La provincia debe ser una cadena de texto.',
            'provincia.max' => 'La provincia no debe exceder 100 caracteres.',
            
            'canton.required' => 'El cantón es obligatorio.',
            'canton.string' => 'El cantón debe ser una cadena de texto.',
            'canton.max' => 'El cantón no debe exceder 100 caracteres.',
            
            'codPostal.required' => 'El código postal es obligatorio.',
            'codPostal.string' => 'El código postal debe ser una cadena de texto.',
            'codPostal.max' => 'El código postal no debe exceder 10 caracteres.',
        ]);

        $this->isOpenModal = !$this->isOpenModal;
    }

    function tipoTarjeta($cardNumber) {
        $cardNumber = str_replace(' ', '', $cardNumber); // Eliminar espacios si los hay
    
        if (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cardNumber)) {
            return 'VISA';
        } elseif (preg_match('/^5[1-5][0-9]{14}$/', $cardNumber)) {
            return 'MasterCard';
        } elseif (preg_match('/^3[47][0-9]{13}$/', $cardNumber)) {
            return 'Amex';
        } elseif (preg_match('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $cardNumber)) {
            return 'DISCOVER';
        } elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/', $cardNumber)) {
            return 'JCB';
        } else {
            return 'Desconocida';
        }
    }

    public function saberNavegador(){
        $userAgent = request()->header('User-Agent');
        $header_user_agent = '';

        if (preg_match('/(MSIE|Trident|Edge|Edg|OPR|Opera|Chrome|Safari|Firefox|SamsungBrowser|UCBrowser|Vivaldi)/i', $userAgent, $matches)) {
            return $header_user_agent = "{$matches[0]}";
        } else {
            return $header_user_agent = 'Desconocido';
        }
    }

    public function generarChecksum($data, $esPlan){
        $FIXED_HASH = "7109a211980e4c5b14a1986a410149a0dda7a009e9984840a8f32fe4fb01bf9667d65c12519814fb7d88b995dcd7897828b6001a4caee7b759aa93e2a0bf49cc";

        $data_string = '';

        // Concatenar los datos en una cadena
        if ($esPlan) {
            $data_string = $data['merchant'] . $data['amount'] . $data['interval'] . $data['interval_count'] . $FIXED_HASH;
        }else{
            $data_string = $data['merchant'] . $data['id'] . $FIXED_HASH;
        }

        // Calcular el hash SHA-512
        $hash_result = hash('sha512', $data_string);

        return $hash_result;
    }

    public function crearSubscripcion($data){
        $licencia = Licencia::find($this->licenciaId);

        $merchant = $data['merchant']; // o cualquier valor que corresponda
        $plan_id = $data['id']; // el valor adecuado para tu plan
        $start_date = Carbon::parse($licencia->fechaFinal)->format('d-m-Y');
        $checksum = $this->generarChecksum($data, false);

        $customer = [
            "first_name" => $this->nombresCliente,
            "last_name" => $this->apellidosCliente,
            "user_di" => $this->identificacionCliente,
            "type_di" => "CC", 
            "cellphone" => "+506{$this->telefonoCliente}",
            "email" => $this->correoCliente,
        ];

        $creditCardData = [
            "card_number" => $this->numTarjeta,
            "cvv" => intval($this->cvv),
            "expiration_date" => $this->fechaVencimiento,
            "retries" => 2,
            "franchise" => $this->tipoTarjeta($this->numTarjeta),
            "id_type" => "CC",
            "id" => $this->identificacionTarjeta,
            "holder_name" => $this->nombresTarjeta,
            "holder_last_name" => $this->apellidosTarjeta,
            "email" => $this->correoTarjeta,
            "phone" => $this->telefonoTarjeta,
            "ip" => request()->ip(),
            "header_user_agent" => $this->saberNavegador(),
            "line1" => $this->direccion,
            "line2" => $this->direccion2 ?? "CASA",
            "line3" => $this->direccion3 ?? "CASA",
            "country" => "Costa Rica", //Por el momento es estático
            "city" => $this->provincia,
            "state" => $this->canton,
            "post_code" => $this->codPostal
        ];

        // arreglo principal
        $paymentData = [
            "merchant" => $merchant,
            "plan_id" => $plan_id,
            "start_date" => $start_date,
            "checksum" => $checksum,
            "customer" => $customer,
            "credit_card_data" => $creditCardData,
        ];

        // dd($paymentData);
        
        // Hacer la solicitud POST
        $response = Http::post('https://api-test.payvalida.com/v4/subscriptions', $paymentData);
        
        // Obtener la respuesta
        if ($response->successful()) {
            $responseData = $response->json();
            if ($responseData['DATA']['status'] == "ACTIVE") {
                $licencia->update([
                    'plan_id' => $responseData['DATA']['plan']['id'],
                    'subscripcion_id' => $responseData['DATA']['id']
                ]);

                return redirect('/licencias');
            }else{
                $this->alert('error', 'No se pudo realizar el proceso');
            }
            // return $response->json(); // Devuelve los datos en formato JSON si la solicitud es exitosa
        } else {
            $this->alert('error', 'No se pudo realizar el proceso');
            // dd($response->status());
            // return $response->status(); // Devuelve el código de estado si falla
        }

        $this->alert('success', 'Información Eliminada');
    }

    public function crearPlan(){
        $datos = Licencia::find($this->licenciaId);

        $plan = [
            "merchant" => "beesysandbox",
            "interval" => $datos->intervalo,
            // "timestamp" => 1686943428,
            "interval_count" => "{$datos->countIntervalo}",
            "amount" => "{$datos->monto}",
            "description" => $datos->descripcion == '' ? "-" : $datos->descripcion,
        ];

        $plan["checksum"] = $this->generarChecksum($plan, true);

        // Hacer la solicitud POST
        $response = Http::post('https://api-test.payvalida.com/v4/subscriptions/plans', $plan);

        // Obtener la respuesta
        if ($response->successful()) {
            $responseData  = $response->json();
            // Accediendo a los valores dentro de 'DATA'
            $data = $responseData['DATA'];
            $data['merchant'] = $plan["merchant"];

            $this->crearSubscripcion($data);
        } else {
            dd($response->status());
            // return $response->status(); // Devuelve el código de estado si falla
        }
    }
}
