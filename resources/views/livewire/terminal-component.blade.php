<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Terminales</p>

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
                            <input type="text" class="h-[2rem] rounded" wire:model.live="search">
                        </td>
                        <td class="border p-1 text-white text-center">Licencia (especificar)</td>
                        <td class="border p-1 text-white text-center">Serial</td>
                        <td class="border p-1 text-white text-center">Nombre de equipo</td>
                        <td class="border p-1 text-white text-center">Último acceso</td>
                        <td class="border p-1 text-white text-center">Estado</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($terminales) > 0)
                        @foreach ($terminales as $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[6rem]">
                                    <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="text-red-800 px-1" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->licencia->cantidad}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->serial}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->nombre_equipo}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->ultimo_acceso}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->estado ? 'Si' : 'No'}}</td> 
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="6" class="p-2 font-bold">No se encontraron elementos</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $terminales->links() }}
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
                        <label for="licencia_id" class="font-semibold w-[10rem] @error('licencia_id') text-red-800 @enderror">Licencia</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('licencia_id') {{$message}} @enderror</p>
                            </div>
                            <select class="rounded-md w-full @error('licencia_id') border border-red-800 @enderror" wire:model='licencia_id'>
                                <option value="" disabled>Seleccione una licencia</option>
                                @foreach ($licencias as $licencia)
                                    <option value="{{$licencia->id}}">{{$licencia->cantidad}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="serial" class="font-semibold w-[10rem] @error('serial') text-red-800 @enderror">Serial</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('serial') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="serial" class="rounded-md w-full @error('serial') border border-red-800 @enderror" wire:model='serial'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="nombre_equipo" class="font-semibold w-[10rem] @error('nombre_equipo') text-red-800 @enderror">Nombre del equipo</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('nombre_equipo') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="nombre_equipo" class="rounded-md w-full @error('nombre_equipo') border border-red-800 @enderror" wire:model='nombre_equipo'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="ultimo_acceso" class="font-semibold w-[10rem] @error('ultimo_acceso') text-red-800 @enderror">Último acceso</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('ultimo_acceso') {{$message}} @enderror</p>
                            </div>
                            <input type="date" id="ultimo_acceso" class="rounded-md w-full @error('ultimo_acceso') border border-red-800 @enderror" wire:model='ultimo_acceso'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="estado" class="font-semibold mr-2 @error('estado') text-red-800 @enderror">Estado</label>
                        <input type="checkbox" id="estado" wire:model="estado" {{$estado ? 'checked' : ''}}>
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