<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]"><a href="{{url('/preguntas')}}" class="opacity-80 transition-all hover:opacity-100 hover:border-b">Preguntas</a> / Respuestas de: <span class="border-b">{{$pregunta}}</span></p>

        <button 
        class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
        wire:click='modalCrear'
        >
            Nuevo
        </button>
    </div>

    <div class="p-2 flex flex-col items-center rounded-sm">
        <div class="w-[80vw] overflow-auto">
            <table class="w-[100vw]">
                <thead>
                    <tr>
                        <td class="border p-1">
                            <input type="text" class="h-[2rem] rounded" wire:model.live="search">
                        </td>
                        <td class="border p-1 text-white text-center">Número de respuesta</td>
                        <td class="border p-1 text-white text-center">Cliente</td>
                        <td class="border p-1 text-white text-center">Cédula del cliente</td>
                        <td class="border p-1 text-white text-center">País</td>
                        <td class="border p-1 text-white text-center">Usuario</td>
                        <td class="border p-1 text-white text-center">Fecha</td>
                        <td class="border p-1 text-white text-center">Intentos</td>
                        <td class="border p-1 text-white text-center">Notas</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($respuestas) > 0)
                        @foreach ($respuestas as $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[6rem]">
                                    <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="text-red-800 px-1 mr-2" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->num_respuesta}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cliente->nombre}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cedula_cliente}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->pais}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->usuario}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->fecha_hora}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->intento}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->notas}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="9" class="p-2 font-bold">No se encontraron elementos</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $respuestas->links() }}
        </div>
    </div>

    @if ($isOpenModal)
        <div class="fixed top-0 left-0 w-full h-screen bg-black/30 transition-all flex justify-center items-center">
            <div class="bg-white w-[40%] flex flex-col">
                <div class="flex justify-between px-2 py-1 bg-slate-700 font-semibold text-[1.1rem] text-white">
                    <p>{{$isModalCrear ? 'Nuevo' : 'Editar'}} regístro</p>
                    <button wire:click='modalCrear'>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-3 flex flex-col gap-2">
                    <div class="flex items-center">
                        <label for="num_respuesta" class="font-semibold w-[10rem] @error('num_respuesta') text-red-800 @enderror">Número de respuesta</label>
                        <input type="number" id="num_respuesta" class="rounded-md w-full @error('num_respuesta') border border-red-800 @enderror" wire:model='num_respuesta'>
                    </div>
                    <div class="flex items-center">
                        <label for="cliente_id" class="font-semibold w-[10rem] @error('cliente_id') text-red-800 @enderror">Cliente</label>
                        <select class="rounded-md w-full @error('cliente_id') border border-red-800 @enderror" wire:model='cliente_id'>
                            <option value="" disabled>Seleccione un software</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label for="pais" class="font-semibold w-[10rem] @error('pais') text-red-800 @enderror">País</label>
                        <select class="rounded-md w-full @error('pais') border border-red-800 @enderror" wire:model='pais'>
                            <option value="" disabled>Seleccione un país</option>
                            @foreach ($paises as $paise)
                                <option value="{{$paise}}">{{$paise}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label for="usuario" class="font-semibold w-[10rem] @error('usuario') text-red-800 @enderror">Usuario</label>
                        <input type="text" id="usuario" class="rounded-md w-full @error('usuario') border border-red-800 @enderror" wire:model='usuario'>
                    </div>
                    <div class="flex items-center">
                        <label for="fecha_hora" class="font-semibold w-[10rem] @error('fecha_hora') text-red-800 @enderror">Fecha</label>
                        <input type="datetime-local" id="fecha_hora" class="rounded-md w-full @error('fecha_hora') border border-red-800 @enderror" wire:model='fecha_hora'>
                    </div>
                    <div class="flex items-center">
                        <label for="intento" class="font-semibold w-[10rem] @error('intento') text-red-800 @enderror">Intento</label>
                        <input type="number" id="intento" class="rounded-md w-full @error('intento') border border-red-800 @enderror" wire:model='intento'>
                    </div>
                    <div class="flex items-center">
                        <label for="notas" class="font-semibold w-[10rem] @error('notas') text-red-800 @enderror">Nota</label>
                        <input type="text" id="notas" class="rounded-md w-full @error('notas') border border-red-800 @enderror" wire:model='notas'>
                    </div>
                </div>

                <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white">
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='{{$isModalCrear ? 'crear' : 'editar'}}'>
                        {{$isModalCrear ? 'Crear' : 'Actualizar'}}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>