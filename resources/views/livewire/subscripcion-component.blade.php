<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]"><a href="{{url('/licencias')}}" class="opacity-80 transition-all hover:opacity-100 hover:border-b">Licencias</a> / Subscripción de: <span class="border-b">{{$datosCliente->contacto}}</span></p>

        <button 
        class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
        wire:click='modalCrear'
        >
            Nuevo
        </button>
    </div>

    <div class="p-2 flex flex-col items-center rounded-sm">
        <div class="w-[80vw] flex justify-center">
            <div class="w-[50%] flex flex-col border">
                <div class="flex justify-between px-2 py-1 font-semibold text-[1.1rem] text-white">
                    <p>{{$isViewTarjeta ? 'Datos de la tarjeta' : 'Datos del cliente'}}</p>
                    <p>Paso {{$isViewTarjeta ? 2 : 1}}/2</p>
                </div>

                @if ($isViewTarjeta)
                    <div class="p-3 flex flex-col gap-2 bg-white h-[60vh] overflow-auto" x-data="{
                        numTarjeta: '',
                        formatNumTarjeta() {
                            // Remover cualquier caracter no numérico
                            this.numTarjeta = this.numTarjeta.replace(/\D/g, '');

                            // Si tiene más de 19 dígitos, detener
                            if (this.numTarjeta.length > 19) {
                                this.numTarjeta = this.numTarjeta.slice(0, 19);
                            }
                        },

                        fechaVencimiento: '',
                        formatFechaVencimiento() {
                            // Remover cualquier caracter no numérico
                            this.fechaVencimiento = this.fechaVencimiento.replace(/\D/g, '');
                            
                            // Si tiene más de 2 dígitos, agregar la pleca
                            if (this.fechaVencimiento.length > 2) {
                                this.fechaVencimiento = this.fechaVencimiento.slice(0, 2) + '/' + this.fechaVencimiento.slice(2, 4);
                            }
                        },

                        cvv: '',
                        formatCVV(){
                            this.cvv = this.cvv.replace(/\D/g, '');

                            if(this.cvv.length > 4){
                                this.cvv = this.cvv.slice(0,4)
                            }
                        },

                        codPostal: '',
                        formatCodPostal(){
                            this.codPostal = this.codPostal.replace(/\D/g, '');
                            if(this.codPostal.length > 6){
                                this.codPostal = this.codPostal.slice(0,6)
                            }
                        }
                    }">
                        <div class="flex items-center">
                            <label for="numTarjeta" class="font-semibold w-[9rem] @error('numTarjeta') text-red-800 @enderror">Número de tarjeta</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('numTarjeta') px-1 @enderror bg-red-800 text-white rounded">@error('numTarjeta') {{$message}} @enderror</p>
                                </div>
                                <input 
                                type="text" 
                                id="numTarjeta" 
                                class="rounded-md w-full @error('numTarjeta') border border-red-800 @enderror" 
                                wire:model='numTarjeta' 
                                x-model="numTarjeta"
                                @input="formatNumTarjeta()"
                                placeholder="0000000000000000">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="cvv" class="font-semibold w-[9rem] @error('cvv') text-red-800 @enderror">CVV</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('cvv') px-1 @enderror bg-red-800 text-white rounded">@error('cvv') {{$message}} @enderror</p>
                                </div>
                                <input 
                                type="text" 
                                id="cvv" 
                                class="rounded-md w-full @error('cvv') border border-red-800 @enderror"
                                x-model="cvv"
                                @input="formatCVV()"
                                wire:model='cvv' placeholder="123">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="fechaVencimiento" class="font-semibold w-[9rem] @error('fechaVencimiento') text-red-800 @enderror">Fecha de vencimiento</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('fechaVencimiento') px-1 @enderror bg-red-800 text-white rounded">@error('fechaVencimiento') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="fechaVencimiento" 
                                class="rounded-md w-full @error('fechaVencimiento') border border-red-800 @enderror"
                                x-model="fechaVencimiento"
                                @input="formatFechaVencimiento()"
                                maxlength="5"
                                placeholder="MM/AA"
                                wire:model="fechaVencimiento">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="nombresTarjeta" class="font-semibold w-[9rem] @error('nombresTarjeta') text-red-800 @enderror">Nombres</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('nombresTarjeta') px-1 @enderror bg-red-800 text-white rounded">@error('nombresTarjeta') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="nombresTarjeta" class="rounded-md w-full @error('nombresTarjeta') border border-red-800 @enderror" wire:model='nombresTarjeta' placeholder="nombre nombre">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="apellidosTarjeta" class="font-semibold w-[9rem] @error('apellidosTarjeta') text-red-800 @enderror">Apellidos</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('apellidosTarjeta') px-1 @enderror bg-red-800 text-white rounded">@error('apellidosTarjeta') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="apellidosTarjeta" class="rounded-md w-full @error('apellidosTarjeta') border border-red-800 @enderror" wire:model='apellidosTarjeta' placeholder="apellido apellido">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="identificacionTarjeta" class="font-semibold w-[9rem] @error('identificacionTarjeta') text-red-800 @enderror">Identificación</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('identificacionTarjeta') px-1 @enderror bg-red-800 text-white rounded">@error('identificacionTarjeta') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="identificacionTarjeta" class="rounded-md w-full @error('identificacionTarjeta') border border-red-800 @enderror" wire:model='identificacionTarjeta' placeholder="888888888">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="telefonoTarjeta" class="font-semibold w-[9rem] @error('telefonoTarjeta') text-red-800 @enderror">Teléfono</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('telefonoTarjeta') px-1 @enderror bg-red-800 text-white rounded">@error('telefonoTarjeta') {{$message}} @enderror</p>
                                </div>
                                <input type="number" id="telefonoTarjeta" class="rounded-md w-full @error('telefonoTarjeta') border border-red-800 @enderror" wire:model='telefonoTarjeta' placeholder="00222222">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="correoTarjeta" class="font-semibold w-[9rem] @error('correoTarjeta') text-red-800 @enderror">Correo</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('correoTarjeta') px-1 @enderror bg-red-800 text-white rounded">@error('correoTarjeta') {{$message}} @enderror</p>
                                </div>
                                <input type="email" id="correoTarjeta" class="rounded-md w-full @error('correoTarjeta') border border-red-800 @enderror" wire:model='correoTarjeta' placeholder="correo@example.com">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="direccion" class="font-semibold w-[9rem] @error('direccion') text-red-800 @enderror">Dirección</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('direccion') px-1 @enderror bg-red-800 text-white rounded">@error('direccion') {{$message}} @enderror</p>
                                </div>
                                <textarea id="direccion" class="rounded-md w-full border @error('direccion') border-red-800 @enderror" wire:model='direccion'></textarea>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="direccion2" class="font-semibold w-[9rem] @error('direccion2') text-red-800 @enderror">Segunda Dirección</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('direccion2') px-1 @enderror bg-red-800 text-white rounded">@error('direccion2') {{$message}} @enderror</p>
                                </div>
                                <textarea id="direccion2" class="rounded-md w-full border @error('direccion2') border-red-800 @enderror" wire:model='direccion2'></textarea>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="direccion3" class="font-semibold w-[9rem] @error('direccion3') text-red-800 @enderror">Tercera Dirección</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('direccion3') px-1 @enderror bg-red-800 text-white rounded">@error('direccion3') {{$message}} @enderror</p>
                                </div>
                                <textarea id="direccion3" class="rounded-md w-full border @error('direccion3') border-red-800 @enderror" wire:model='direccion3'></textarea>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="provincia" class="font-semibold w-[9rem] @error('provincia') text-red-800 @enderror">Provincia</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('provincia') px-1 @enderror bg-red-800 text-white rounded">@error('provincia') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="provincia" class="rounded-md w-full @error('provincia') border border-red-800 @enderror" wire:model='provincia' placeholder="provincia">
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <label for="canton" class="font-semibold w-[9rem] @error('canton') text-red-800 @enderror">Cantón</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('canton') px-1 @enderror bg-red-800 text-white rounded">@error('canton') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="canton" class="rounded-md w-full @error('canton') border border-red-800 @enderror" wire:model='canton' placeholder="canton">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="codPostal" class="font-semibold w-[9rem] @error('codPostal') text-red-800 @enderror">Código postal</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('codPostal') px-1 @enderror bg-red-800 text-white rounded">@error('codPostal') {{$message}} @enderror</p>
                                </div>
                                <input 
                                type="text" 
                                id="codPostal" 
                                class="rounded-md w-full @error('codPostal') border border-red-800 @enderror" 
                                x-model="codPostal"
                                @input="formatCodPostal()"
                                wire:model='codPostal'>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-3 flex flex-col gap-2 bg-white">
                        <div class="flex items-center">
                            <label for="nombresCliente" class="font-semibold w-[8rem] @error('nombresCliente') text-red-800 @enderror">Nombres</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('nombresCliente') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="nombresCliente" class="rounded-md w-full @error('nombresCliente') border border-red-800 @enderror" wire:model='nombresCliente' placeholder="nombre nombre">
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="apellidosCliente" class="font-semibold w-[8rem] @error('apellidosCliente') text-red-800 @enderror">Apellidos</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('apellidosCliente') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="apellidosCliente" class="rounded-md w-full @error('apellidosCliente') border border-red-800 @enderror" wire:model='apellidosCliente' placeholder="apellido apellido">
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="identificacionCliente" class="font-semibold w-[8rem] @error('identificacionCliente') text-red-800 @enderror">Identificación</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('identificacionCliente') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="identificacionCliente" class="rounded-md w-full @error('identificacionCliente') border border-red-800 @enderror" wire:model='identificacionCliente' placeholder="888888888">
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="telefonoCliente" class="font-semibold w-[8rem] @error('telefonoCliente') text-red-800 @enderror">Teléfono</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('telefonoCliente') {{$message}} @enderror</p>
                                </div>
                                <input type="number" id="telefonoCliente" class="rounded-md w-full @error('telefonoCliente') border border-red-800 @enderror" wire:model='telefonoCliente' placeholder="00222222">
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="correoCliente" class="font-semibold w-[8rem] @error('correoCliente') text-red-800 @enderror">Correo</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('correoCliente') {{$message}} @enderror</p>
                                </div>
                                <input type="email" id="correoCliente" class="rounded-md w-full @error('correoCliente') border border-red-800 @enderror" wire:model='correoCliente' placeholder="correo@example.com">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white flex {{$isViewTarjeta ? 'justify-between' : 'justify-end'}}">
                    @if ($isViewTarjeta)
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='atras'>Atras</button>
                    @endif
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='{{$isViewTarjeta ? 'procesarPago' : 'datosTarjeta'}}'>{{$isViewTarjeta ? 'Pagar' : 'Siguiente'}}</button>
                </div>
            </div>
        </div>
    </div>

    @if ($isOpenModal)
        <div class="fixed w-full h-screen top-0 left-0 flex justify-center items-center bg-black/60">
            <div class="w-[50vw] bg-white rounded-lg p-2 flex flex-col gap-6">
                <p class="text-[1.5rem]">Política de Privacidad de Pagos</p>
                <p class="text-[1.2rem]">
                    En Bee Business Suit, nos comprometemos a proteger 
                    la privacidad de nuestros clientes. Al realizar un pago 
                    a través de nuestra plataforma, no almacenamos ni guardamos
                    la información de la tarjeta de crédito, débito u otros 
                    métodos de pago. Todos los datos sensibles son procesados 
                    de manera segura y encriptada por proveedores de servicios 
                    de pago acreditados, cumpliendo con los más altos estándares 
                    de seguridad (PCI DSS).
                </p>
                <p class="text-[1.2rem]">
                    La información que nos proporcionas se utiliza únicamente para 
                    procesar la transacción de manera segura, y no será compartida 
                    con terceros, excepto cuando sea estrictamente necesario para 
                    completar el proceso de pago.
                </p>
                <div class="flex justify-between">
                    <button class="bg-slate-700 rounded-sm text-white font-medium text-[1.3rem] px-3 hover:bg-slate-700/95" wire:click='salirModal'>Cancelar</button>
                    <button class="bg-slate-700 rounded-sm text-white font-medium text-[1.3rem] px-3 hover:bg-slate-700/95" wire:click='crearPlan'>Aceptar</button>
                </div>
            </div>
        </div>
    @endif
</div>