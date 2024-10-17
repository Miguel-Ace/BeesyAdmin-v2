<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]"><a href="{{url('/clientes')}}" class="opacity-80 transition-all hover:opacity-100 hover:border-b">Clientes</a> / Usuarios de: <span class="border-b">{{$nombreCliente}}</span></p>

        <button 
        class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
        wire:click='modalCrear'
        >
            Nuevo
        </button>
    </div>

    <div class="p-2 flex flex-col items-center rounded-sm">
        <div class="w-[80vw] overflow-auto">
            <table class="w-[80rem]">
                <thead>
                    <tr>
                        <td class="border p-1">
                            <input type="text" class="h-[2rem] rounded" wire:model.live="search">
                        </td>
                        <td class="border p-1 text-white text-center">Nombre</td>
                        <td class="border p-1 text-white text-center">Correo</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($userClientes) > 0)
                        @foreach ($userClientes as $info)
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
            {{ $userClientes->links() }}
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
                        <label for="name" class="font-semibold w-[6rem] @error('name') text-red-800 @enderror">Nombre</label>
                        <input type="text" id="name" class="rounded-md w-full @error('name') border border-red-800 @enderror" wire:model='name'>
                    </div>
                    <div class="flex items-center">
                        <label for="email" class="font-semibold w-[6rem] @error('email') text-red-800 @enderror">Correo</label>
                        <input type="text" id="email" class="rounded-md w-full @error('email') border border-red-800 @enderror" wire:model='email'>
                    </div>
                </div>

                <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white">
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='{{$isModalCrear ? 'crear' : 'editar'}}'>{{$isModalCrear ? 'Crear' : 'Actualizar'}}</button>
                </div>
            </div>
        </div>
    @endif
</div>