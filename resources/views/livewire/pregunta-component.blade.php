<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Preguntas</p>

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
                        <td class="border p-1 text-white text-center">Pregunta</td>
                        <td class="border p-1 text-white text-center">Cantidad de respuestas</td>
                        <td class="border p-1 text-white text-center">Fecha de creacion</td>
                        <td class="border p-1 text-white text-center">Intentos</td>
                        <td class="border p-1 text-white text-center">Activo</td>
                        <td class="border p-1 text-white text-center">Opción multiple</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($preguntas) > 0)
                        @foreach ($preguntas as $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[6rem]">
                                    <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="text-red-800 px-1 mr-2" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <a href="{{url('preguntas/respuestas'.'/'.$info->id)}}" class="text-red-800 px-1">
                                        <i class="fa-solid fa-r"></i>
                                        {{-- <i class="fa-solid fa-registered"></i> --}}
                                    </a>
                                    {{-- <button class="text-red-800 px-1" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-exclamation"></i>
                                    </button> --}}
                                </td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->pregunta}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->respuestas_count}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->fecha_creacion}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->intentos}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->activo ? 'Si' : 'No'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->opcion_mult ? 'Si' : 'No'}}</td>
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
            {{ $preguntas->links() }}
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
                        <label for="pregunta" class="font-semibold w-[10rem] @error('pregunta') text-red-800 @enderror">Pregunta</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('pregunta') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="pregunta" class="rounded-md w-full @error('pregunta') border border-red-800 @enderror" wire:model='pregunta'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="fecha_creacion" class="font-semibold w-[10rem] @error('fecha_creacion') text-red-800 @enderror">Fecha de creación</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('fecha_creacion') {{$message}} @enderror</p>
                            </div>
                            <input type="date" id="fecha_creacion" class="rounded-md w-full @error('fecha_creacion') border border-red-800 @enderror" wire:model='fecha_creacion'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="intentos" class="font-semibold w-[10rem] @error('intentos') text-red-800 @enderror">Intentos</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('intentos') {{$message}} @enderror</p>
                            </div>
                            <input type="number" id="intentos" class="rounded-md w-full @error('intentos') border border-red-800 @enderror" wire:model='intentos'>
                        </div>
                    </div>
                    <div class="flex gap-4 p-1 bg-slate-200">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="activo" wire:model="activo" {{$activo ? 'checked' : ''}}>
                            <label for="activo" class="font-semibold @error('activo') text-red-800 @enderror">Activo</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="opcion_mult" wire:model="opcion_mult" {{$opcion_mult ? 'checked' : ''}}>
                            <label for="opcion_mult" class="font-semibold @error('opcion_mult') text-red-800 @enderror">Opción multiple</label>
                        </div>
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