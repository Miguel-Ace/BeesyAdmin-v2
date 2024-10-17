<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Usuarios</p>

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
                        <td class="border p-1 text-white text-center">Nombre</td>
                        <td class="border p-1 text-white text-center">Correo</td>
                        <td class="border p-1 text-white text-center">Cliente relacionado</td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                buscadorInterno : JSON.parse(localStorage.getItem('buscadorInterno')) || false,
                                funBuscInterno(){
                                    this.buscadorInterno = !this.buscadorInterno;
                                    localStorage.setItem('buscadorInterno', JSON.stringify(this.buscadorInterno));
                                }
                            }">
                                <div>
                                    <select class="w-[6rem] h-[2.2rem] rounded text-black" wire:model.live="searchIterno" x-show="buscadorInterno">
                                        <option value="">Todo</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                    {{-- <input type="text" placeholder="Interno" class="w-[5rem] text-black"> --}}
                                    <p  x-show="!buscadorInterno">Interno</p>
                                </div>
                                <i class="fa-solid fa-magnifying-glass cursor-pointer" @click="funBuscInterno"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">Rol</td>
                        <td class="border p-1 text-white text-center">Laboratorios</td>
                        <td class="border p-1 text-white text-center">Especializaciones</td>
                        <td class="border p-1 text-white text-center">Mejora</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($usuarios) > 0)
                        @foreach ($usuarios as $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[6rem]">
                                    <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="text-red-800 px-1" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->name}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->email}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cliente->nombre ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->interno ? 'Si' : 'No'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->getRoleNames()->first()}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->con_laboratorio ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->con_especializacion ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->con_mejora ?? '-'}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="8" class="p-2 font-bold">No se encontraron elementos</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $usuarios->links() }}
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
                        <label for="name" class="font-semibold w-[10rem] @error('name') text-red-800 @enderror">Nombre</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('name') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="name" class="rounded-md w-full @error('name') border border-red-800 @enderror" wire:model='name'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="email" class="font-semibold w-[10rem] @error('email') text-red-800 @enderror">Correo</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('email') {{$message}} @enderror</p>
                            </div>
                            <input type="text" id="email" class="rounded-md w-full @error('email') border border-red-800 @enderror" wire:model='email'>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="rol" class="font-semibold w-[10rem] @error('rol') text-red-800 @enderror">Asignar rol</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('rol') {{$message}} @enderror</p>
                            </div>
                            <select class="rounded-md w-full @error('rol') border border-red-800 @enderror" wire:model='rol'>
                                <option value="" disabled>Seleccione un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="cliente_id" class="font-semibold w-[10rem] @error('cliente_id') text-red-800 @enderror">Cliente</label>
                        <div class="w-full">
                            <div class="flex justify-between py-1">
                                <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                <p class="text-[.8rem] font-bold @error('cliente_id') px-1 @enderror bg-red-800 text-white rounded">@error('cliente_id') {{$message}} @enderror</p>
                            </div>
                            <select class="rounded-md w-full @error('cliente_id') border border-red-800 @enderror" wire:model='cliente_id'>
                                <option value="" disabled>Seleccione un cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
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