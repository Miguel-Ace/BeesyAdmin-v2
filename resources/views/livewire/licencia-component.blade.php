<div class="flex-1 bg-slate-700">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Licencias</p>

        <div class="flex gap-4">
            <button
            class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
            wire:click=''
            >
                Verificar licencias
            </button>

            <button 
            class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
            wire:click='modalCrear'
            >
                Nuevo
            </button>
        </div>
    </div>

    <div class="p-2 flex flex-col items-center rounded-sm">
        <div class="w-[80vw] overflow-auto">
            <table class="w-[150rem]">
                <thead>
                    <tr>
                        <td class="border p-1">
                            <input type="search" class="h-[2rem] rounded" wire:model.live="search">
                        </td>
                        @if (auth()->user()->getRoleNames()->first() == 'Administrador')
                        <td class="border p-1 text-white text-center">
                            Editar plan
                        </td>
                        @endif
                        @if (auth()->user()->getRoleNames()->first() == 'Cliente')
                        <td class="border p-1 text-white text-center">
                            Subscripción de plan
                        </td>
                        @endif
                        <td class="border p-1 text-white text-center">Cancelar plan</td>
                        <td class="border p-1 text-white text-center">Cliente</td>
                        <td class="border p-1 text-white text-center">Software</td>
                        <td class="border p-1 text-white text-center">Ruta</td>
                        <td class="border p-1 text-white text-center">Cantidad</td>
                        <td class="border p-1 text-white text-center">fecha de inicio</td>
                        <td class="border p-1 text-white text-center">Fecha final</td>
                        <td class="border p-1 text-white text-center">cantidad de usuarios</td>
                        <td class="border p-1 text-white text-center">Beecommerce</td>
                        <td class="border p-1 text-white text-center">Intervalo</td>
                        <td class="border p-1 text-white text-center">Cantidad de intervalo</td>
                        <td class="border p-1 text-white text-center">Monto</td>
                        <td class="border p-1 text-white text-center">Descripcion</td>
                        <td class="border p-1 text-white text-center">Plan id</td>
                        <td class="border p-1 text-white text-center">Subscripción id</td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchDateUpdate : JSON.parse(localStorage.getItem('searchDateUpdate')) || false,
                                funsearchDateUpdate(){
                                    this.searchDateUpdate = !this.searchDateUpdate;
                                    localStorage.setItem('searchDateUpdate', JSON.stringify(this.searchDateUpdate));
                                }
                            }">
                                <div>
                                    <input type="date" class="w-full h-[2rem] rounded text-black" wire:model.live="searchDateUpdate" x-show="searchDateUpdate">
                                    <p x-show="!searchDateUpdate">Fecha de actualización</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchDateUpdate" :class="{'fa-magnifying-glass' : !searchDateUpdate, 'fa-xmark' : searchDateUpdate}"></i>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($licencias) > 0)
                        @foreach ($licencias as $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[6rem]">
                                    @role('Administrador|Programador')
                                        @if ($info->response_id)
                                        -
                                        @else
                                        <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="text-red-800 px-1" wire:click='borrar({{$info->id}})'>
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        @endif
                                    @else
                                    -
                                    @endrole
                                </td>
                                @if (auth()->user()->getRoleNames()->first() == 'Administrador')
                                <td class="border border-slate-700 p-1 font-medium text-center">
                                    @if ($info->plan_id)
                                    <button class="w-full text-slate-700 hover:bg-slate-700 hover:text-white rounded-sm" wire:click='modalEditarPlan({{$info}})'><i class="fa-solid fa-pen"></i></button>
                                    @else
                                    -
                                    @endif
                                </td>
                                @endif
                                @if (auth()->user()->getRoleNames()->first() == 'Cliente')
                                <td class="border border-slate-700 p-1 font-medium text-center">
                                    @if ($info->intervalo && !$info->plan_id)
                                    <a href="{{url('licencias/subscripciones'.'/'.$info->id.'/'.$info->cliente->nombre)}}" class="block w-full text-slate-700 hover:bg-slate-700 hover:text-white rounded-sm"><i class="fa-solid fa-check-to-slot"></i></a>
                                    @else
                                    -
                                    @endif
                                </td>
                                @endif
                                <td class="border border-slate-700 p-1 font-medium text-center">
                                    @if ($info->plan_id)
                                        <button class="w-full text-slate-700 hover:bg-slate-700 hover:text-white rounded-sm" wire:click='cancelarPlan({{$info}})'><i class="fa-solid fa-ban"></i></button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cliente->nombre}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->software->nombre}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->ruta}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cantidad}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->fechaInicio}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->fechaFinal}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->cantidad_usuario}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center">{{$info->bee_commerce ? 'Si' : 'No'}}</td> 
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->intervalo ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->countIntervalo ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->monto ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->descripcion ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->plan_id ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->subscripcion_id ?? '-'}}</td>
                                <td class="border border-slate-700 p-1 font-medium text-center bg-green-100">{{$info->updated_at ?? '-'}}</td>
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
            {{ $licencias->links() }}
        </div>
    </div>

    @if ($isOpenModal)
        <div class="fixed top-0 left-0 w-full h-screen bg-black/30 transition-all flex justify-center items-center">
            <div class="bg-white w-[40%] flex flex-col">
                <div class="flex justify-between px-2 py-1 bg-slate-700 font-semibold text-[1.1rem] text-white">
                    <p>@if ($isModalEditPlan) Editar plan @else {{$isModalCrear ? 'Nuevo regístro' : 'Editar regístro'}} @endif</p>
                    <button wire:click='modalCrear'>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-3 flex flex-col gap-2">

                    @if ($isModalEditPlan)
                        <div class="flex items-center">
                            <label for="intervalo" class="font-semibold w-[10rem] @error('intervalo') text-red-800 @enderror">Intervalo</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('intervalo') px-1 @enderror bg-red-800 text-white rounded">@error('intervalo') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('intervalo') border border-red-800 @enderror" wire:model='intervalo'>
                                    <option value="" disabled>Seleccione un intervalo</option>
                                    @foreach ($intervalos as $intervalo)
                                        <option value="{{$intervalo}}">{{$intervalo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="countIntervalo" class="font-semibold w-[10rem] @error('countIntervalo') text-red-800 @enderror">Cantidad de intervalo</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('countIntervalo') px-1 @enderror bg-red-800 text-white rounded">@error('countIntervalo') {{$message}} @enderror</p>
                                </div>
                                <input type="number" id="countIntervalo" min="1" class="rounded-md w-full @error('countIntervalo') border border-red-800 @enderror" wire:model='countIntervalo'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="monto" class="font-semibold w-[10rem] @error('monto') text-red-800 @enderror">Monto</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold @error('monto') px-1 @enderror bg-red-800 text-white rounded">@error('monto') {{$message}} @enderror</p>
                                </div>
                                <input type="number" id="monto" min="1" class="rounded-md w-full @error('monto') border border-red-800 @enderror" wire:model='monto'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="descripcion" class="font-semibold w-[10rem] @error('descripcion') text-red-800 @enderror">Descripción</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">Opcional</p>
                                    <p class="text-[.8rem] font-bold @error('descripcion') px-1 @enderror bg-red-800 text-white rounded">@error('descripcion') {{$message}} @enderror</p>
                                </div>
                                <textarea id="descripcion" class="rounded-md w-full border @error('descripcion') border-red-800 @enderror" wire:model='descripcion'></textarea>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center">
                            <label for="cliente_id" class="font-semibold w-[10rem] @error('cliente_id') text-red-800 @enderror">Cliente</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('cliente_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('cliente_id') border border-red-800 @enderror" wire:model='cliente_id'>
                                    <option value="" disabled>Seleccione un cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="software_id" class="font-semibold w-[10rem] @error('software_id') text-red-800 @enderror">Software</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('software_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('software_id') border border-red-800 @enderror" wire:model='software_id'>
                                    <option value="" disabled>Seleccione un software</option>
                                    @foreach ($software as $sistema)
                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="ruta" class="font-semibold w-[10rem] @error('ruta') text-red-800 @enderror">Ruta</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('ruta') px-1 @enderror bg-red-800 text-white rounded">@error('ruta') {{$message}} @enderror</p>
                                </div>
                                <input type="text" id="ruta" class="rounded-md w-full @error('ruta') border border-red-800 @enderror" wire:model='ruta'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="cantidad" class="font-semibold w-[10rem] @error('cantidad') text-red-800 @enderror">Cantidad</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('cantidad') {{$message}} @enderror</p>
                                </div>
                                <input type="number" id="cantidad" class="rounded-md w-full @error('cantidad') border border-red-800 @enderror" wire:model='cantidad'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="fechaInicio" class="font-semibold w-[10rem] @error('fechaInicio') text-red-800 @enderror">Fecha de inicio</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('fechaInicio') {{$message}} @enderror</p>
                                </div>
                                <input type="date" id="fechaInicio" class="rounded-md w-full @error('fechaInicio') border border-red-800 @enderror" wire:model='fechaInicio'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="fechaFinal" class="font-semibold w-[10rem] @error('fechaFinal') text-red-800 @enderror">Fecha final</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('fechaFinal') {{$message}} @enderror</p>
                                </div>
                                <input type="date" id="fechaFinal" class="rounded-md w-full @error('fechaFinal') border border-red-800 @enderror" wire:model='fechaFinal'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="cantidad_usuario" class="font-semibold w-[10rem] @error('cantidad_usuario') text-red-800 @enderror">Cantidad de usuario</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('cantidad_usuario') {{$message}} @enderror</p>
                                </div>
                                <input type="number" id="cantidad_usuario" class="rounded-md w-full @error('cantidad_usuario') border border-red-800 @enderror" wire:model='cantidad_usuario'>
                            </div>
                        </div>
                        <div class="flex gap-4 p-1 bg-slate-200">
                            <div class="flex gap-2 items-center">
                                <input type="checkbox" id="bee_commerce" wire:model="bee_commerce" {{$bee_commerce ? 'checked' : ''}}>
                                <label for="bee_commerce" class="font-semibold @error('bee_commerce') text-red-800 @enderror">Beecommerce</label>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white">
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='@if ($isModalEditPlan) editarPlan @else {{$isModalCrear ? 'crear' : 'editar'}} @endif'>
                        @if ($isModalEditPlan) Actualizar plan @else {{$isModalCrear ? 'Crear' : 'Actualizar'}} @endif
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>