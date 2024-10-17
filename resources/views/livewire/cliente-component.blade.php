<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Clientes</p>

        <button 
        class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
        wire:click='modalCrear'
        >
            Nuevo
        </button>
    </div>

    <div class="p-2 flex flex-col items-center rounded-sm">
        <div class="w-[80vw] overflow-auto">
            <table class="w-[100rem]">
                <thead>
                    <tr>
                        <td class="border p-1">
                            <input type="text" class="h-[2rem] rounded" wire:model.live="search" @role('Cliente') disabled @endrole>
                        </td>
                        <td class="border p-1 text-white text-center">Nombre</td>
                        <td class="border p-1 text-white text-center">Contacto</td>
                        <td class="border p-1 text-white text-center">Cédula</td>
                        <td class="border p-1 text-white text-center">Correo</td>
                        <td class="border p-1 text-white text-center">Teléfono</td>
                        <td class="border p-1 text-white text-center">País</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($clientes) > 0)
                        @foreach ($clientes as $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[6rem]">
                                    <a href="{{url('/clientes/user_cliente/'.$info->id)}}" class="text-orange-800 px-1 mr-2">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </a>
                                    <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    @unless(auth()->user()->hasRole('Cliente'))
                                    <button class="text-red-800 px-1" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    @endunless
                                </td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->nombre}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->contacto}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cedula}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->correo}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->telefono}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->pais}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="7" class="p-2 font-bold">No se encontraron elementos</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $clientes->links() }}
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
                        <label for="nombre" class="font-semibold w-[6rem] @error('nombre') text-red-800 @enderror">Nombre</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('nombre') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="nombre" class="rounded-md w-full @error('nombre') border border-red-800 @enderror" wire:model='nombre'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="contacto" class="font-semibold w-[6rem] @error('contacto') text-red-800 @enderror">Contacto</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('contacto') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="contacto" class="rounded-md w-full @error('contacto') border border-red-800 @enderror" wire:model='contacto'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="cedula" class="font-semibold w-[6rem] @error('cedula') text-red-800 @enderror">Cédula</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('cedula') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="cedula" class="rounded-md w-full @error('cedula') border border-red-800 @enderror" wire:model='cedula'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="correo" class="font-semibold w-[6rem] @error('correo') text-red-800 @enderror">Correo</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('correo') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="correo" class="rounded-md w-full @error('correo') border border-red-800 @enderror" wire:model='correo'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="telefono" class="font-semibold w-[6rem] @error('telefono') text-red-800 @enderror">Teléfono</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('telefono') {{$message}} @enderror</p>
                            </div>
                            <input type="number" id="telefono" class="rounded-md w-full @error('telefono') border border-red-800 @enderror" wire:model='telefono'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="pais" class="font-semibold w-[6rem] @error('pais') text-red-800 @enderror">País</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('pais') {{$message}} @enderror</p>
                            </div>
                            <select class="rounded-md w-full @error('pais') border border-red-800 @enderror" wire:model='pais'>
                                <option value="" disabled>Seleccione un país</option>
                                @foreach ($paises as $paise)
                                    <option value="{{$paise}}">{{$paise}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white">
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='{{$isModalCrear ? 'crear' : 'editar'}}'>{{$isModalCrear ? 'Crear' : 'Actualizar'}}</button>
                </div>
            </div>
        </div>
    @endif
</div>