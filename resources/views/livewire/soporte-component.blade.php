<div class="flex-1 bg-slate-700 overflow-auto">
    <x-loading-screen />
    
    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Soportes</p>

        <div class="flex gap-5">
            <button 
            class="bg-green-700 rounded-sm font-medium text-[1.3rem] px-3 hover:bg-green-700/95"
            wire:click='exportExcel'
            >
                Exportar
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
        <div class="w-[85vw]  overflow-auto">
            <table class="w-[200rem]">
                <thead>
                    <tr>
                        <td class="border p-1">
                            <input type="search" class="w-full h-[2rem] rounded" wire:model.live="search">
                        </td>
                        <td class="border p-1 text-white text-center">#</td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchEmpresa : JSON.parse(localStorage.getItem('searchEmpresa')) || false,
                                funsearchEmpresa(){
                                    this.searchEmpresa = !this.searchEmpresa;
                                    localStorage.setItem('searchEmpresa', JSON.stringify(this.searchEmpresa));
                                }
                            }">
                                <div>
                                    <input type="search" class="w-full h-[2rem] rounded text-black" wire:model.live="searchEmpresa" x-show="searchEmpresa" placeholder="Empresa">
                                    <p x-show="!searchEmpresa">Empresa</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchEmpresa" :class="{'fa-magnifying-glass' : !searchEmpresa, 'fa-xmark' : searchEmpresa}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchColaborador : JSON.parse(localStorage.getItem('searchColaborador')) || false,
                                funsearchColaborador(){
                                    this.searchColaborador = !this.searchColaborador;
                                    localStorage.setItem('searchColaborador', JSON.stringify(this.searchColaborador));
                                }
                            }">
                                <div>
                                    <input type="search" class="w-full h-[2rem] rounded text-black" wire:model.live="searchColaborador" x-show="searchColaborador" placeholder="Colaborador">
                                    <p x-show="!searchColaborador">Colaborador</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchColaborador"  :class="{'fa-magnifying-glass' : !searchColaborador, 'fa-xmark' : searchColaborador}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchProblema : JSON.parse(localStorage.getItem('searchProblema')) || false,
                                funsearchProblema(){
                                    this.searchProblema = !this.searchProblema;
                                    localStorage.setItem('searchProblema', JSON.stringify(this.searchProblema));
                                }
                            }">
                                <div>
                                    <input type="search" class="w-full h-[2rem] rounded text-black" wire:model.live="searchProblema" x-show="searchProblema" placeholder="Problema">
                                    <p x-show="!searchProblema">Problema</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchProblema"   :class="{'fa-magnifying-glass' : !searchProblema, 'fa-xmark' : searchProblema}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">Fecha creación del ticket</td>
                        <td class="border p-1 text-white text-center">Fecha prevista cumplimiento</td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchCliente : JSON.parse(localStorage.getItem('searchCliente')) || false,
                                funsearchCliente(){
                                    this.searchCliente = !this.searchCliente;
                                    localStorage.setItem('searchCliente', JSON.stringify(this.searchCliente));
                                }
                            }">
                                <div>
                                    <input type="search" class="w-full h-[2rem] rounded text-black" wire:model.live="searchCliente" x-show="searchCliente" placeholder="Cliente">
                                    <p x-show="!searchCliente">Cliente</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchCliente"   :class="{'fa-magnifying-glass' : !searchCliente, 'fa-xmark' : searchColaborador}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">Usuario del cliente</td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchSoftware : JSON.parse(localStorage.getItem('searchSoftware')) || false,
                                funsearchSoftware(){
                                    this.searchSoftware = !this.searchSoftware;
                                    localStorage.setItem('searchSoftware', JSON.stringify(this.searchSoftware));
                                }
                            }">
                                <div>
                                    <input type="search" class="w-full h-[2rem] rounded text-black" wire:model.live="searchSoftware" x-show="searchSoftware" placeholder="Software">
                                    <p x-show="!searchSoftware">Software</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchSoftware"   :class="{'fa-magnifying-glass' : !searchSoftware, 'fa-xmark' : searchSoftware}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchPrioridad : JSON.parse(localStorage.getItem('searchPrioridad')) || false,
                                funsearchPrioridad(){
                                    this.searchPrioridad = !this.searchPrioridad;
                                    localStorage.setItem('searchPrioridad', JSON.stringify(this.searchPrioridad));
                                }
                            }">
                                <div>
                                    <select class="w-[6rem] h-[2.2rem] rounded text-black" wire:model.live="searchPrioridad" x-show="searchPrioridad">
                                        <option value="">Todo</option>
                                        <option value="1">Leve</option>
                                        <option value="2">Moderado</option>
                                        <option value="3">Alta</option>
                                    </select>
                                    <p x-show="!searchPrioridad">Prioridad</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchPrioridad"   :class="{'fa-magnifying-glass' : !searchPrioridad, 'fa-xmark' : searchColaborador}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchEstado : JSON.parse(localStorage.getItem('searchEstado')) || false,
                                funsearchEstado(){
                                    this.searchEstado = !this.searchEstado;
                                    localStorage.setItem('searchEstado', JSON.stringify(this.searchEstado));
                                }
                            }">
                                <div>
                                    <select class="w-[6rem] h-[2.2rem] rounded text-black" wire:model.live="searchEstado" x-show="searchEstado">
                                        <option value="">Todo</option>
                                        <option value="1">Asignado</option>
                                        <option value="2">En proceso</option>
                                        <option value="3">Completado</option>
                                    </select>
                                    <p  x-show="!searchEstado">Estado</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchEstado"   :class="{'fa-magnifying-glass' : !searchEstado, 'fa-xmark' : searchEstado}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">Fecha inicial de la sistencia</td>
                        <td class="border p-1 text-white text-center">Fecha final de la sistencia</td>
                        <td class="border p-1 text-white text-center">Horas trabajadas</td>
                        <td class="border p-1 text-white text-center">
                            <div 
                            class="flex gap-2 justify-center items-center" 
                            x-data="{
                                searchTipo : JSON.parse(localStorage.getItem('searchTipo')) || false,
                                funsearchTipo(){
                                    this.searchTipo = !this.searchTipo;
                                    localStorage.setItem('searchTipo', JSON.stringify(this.searchTipo));
                                }
                            }">
                                <div>
                                    <select class="w-[6rem] h-[2.2rem] rounded text-black" wire:model.live="searchTipo" x-show="searchTipo">
                                        <option value="">Todo</option>
                                        <option value="1">Laboratorio</option>
                                        <option value="2">Asistencia</option>
                                        <option value="3">Garantia</option>
                                        <option value="4">Instalación</option>
                                        <option value="5">Configuración</option>
                                        <option value="6">Mejora</option>
                                        <option value="7">Especialización</option>
                                        <option value="8">Importancia</option>
                                        <option value="9">Servidor</option>
                                        <option value="10">Reunión</option>
                                    </select>
                                    <p  x-show="!searchTipo">Origen de sistencia</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchTipo"   :class="{'fa-magnifying-glass' : !searchTipo, 'fa-xmark' : searchTipo}"></i>
                            </div>
                        </td>
                        <td class="border p-1 text-white text-center">Solución</td>
                        <td class="border p-1 text-white text-center">Observaciones</td>
                        {{-- <td class="border p-1 text-white text-center">Imagen</td> --}}
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($soportes) > 0)
                        @foreach ($soportes as $key => $info)
                            <tr class="hover:bg-slate-200">
                                <td class="border border-slate-700 p-1 font-medium text-center w-[13rem]">
                                    <button class="text-blue-800 px-1 mr-2" wire:click='modalEditar({{$info}})'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="text-red-800 px-1" wire:click='borrar({{$info->id}})'>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->id}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium {{$info->cliente_id ? 'text-nowrap' : 'text-center'}} overflow-hidden hover:overflow-auto max-w-[10rem]">{{$info->cliente->nombre ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->colaborador->name}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-nowrap overflow-hidden hover:overflow-auto max-w-[10rem]">{{$info->problema ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->created_at ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->fecha_prevista_cumplimiento ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->cliente->contacto ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium {{$info->user_cliente_id ? 'text-nowrap' : 'text-center'}} overflow-hidden hover:overflow-auto max-w-[10rem]">{{$info->user_cliente->name ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-nowrap overflow-hidden hover:overflow-auto max-w-[10rem]">{{$info->software->nombre ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem] {{ $info->prioridad_id == 1 ? 'text-blue-700' : ($info->prioridad_id == 2 ? 'text-yellow-800' : 'text-red-600') }}">{{$info->prioridad->nombre}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem] {{ $info->estado_id == 1 ? 'text-blue-700' : ($info->estado_id == 2 ? 'text-yellow-800' : 'text-green-700') }}">{{$info->estado->nombre}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->fechaInicioAsistencia ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->fechaFinalAsistencia ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-nowrap overflow-hidden hover:overflow-auto max-w-[10rem]">{{$tiempos[$key]}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->tipo->nombre ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium {{$info->solucion ? 'text-nowrap' : 'text-center'}} overflow-hidden hover:overflow-auto max-w-[10rem]">{{$info->solucion ?? '-'}}</td>
                                <td class="border border-slate-700 py-1 px-2 font-medium {{$info->observaciones ? 'text-nowrap' : 'text-center'}} overflow-hidden hover:overflow-auto max-w-[10rem]">{{$info->observaciones ?? '-'}}</td>
                                {{-- <td class="border border-slate-700 py-1 px-2 font-medium text-center truncate max-w-[10rem]">{{$info->imagen ?? '-'}}</td> --}}
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="19" class="p-2 font-bold">No se encontraron elementos</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $soportes->links() }}
        </div>
    </div>

    @if ($isOpenModal)
        <div class="fixed top-0 left-0 w-full h-screen bg-black/30 transition-all flex justify-center items-center">
            <div class="bg-white w-[40%] flex flex-col h-[70vh]">
                <div class="flex justify-between px-2 py-1 bg-slate-700 font-semibold text-[1.1rem] text-white">
                    <p>{{$isModalCrear ? 'Nuevo' : 'Editar'}} regístro</p>
                    <button wire:click='modalCrear'>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-3 flex flex-col gap-2  overflow-auto">
                    
                    <div class="flex items-center">
                        <label for="colaborador_id" class="font-semibold w-[10rem] @error('colaborador_id') text-red-800 @enderror">Colaborador</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('colaborador_id') {{$message}} @enderror</p>
                            </div>
                            <select class="rounded-md w-full @error('colaborador_id') border border-red-800 @enderror" wire:model='colaborador_id'>
                                <option value="" disabled>Seleccione un colaborador</option>
                                @foreach ($colaboradores as $colaborador)
                                    <option value="{{$colaborador->id}}">{{$colaborador->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if ($isModalCrear)
                        <div class="flex items-center">
                            <label for="cliente_id" class="font-semibold w-[10rem] @error('cliente_id') text-red-800 @enderror">Empresa</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('cliente_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('cliente_id') border border-red-800 @enderror" wire:model.live='cliente_id'>
                                    <option value="" disabled>Seleccione la empresa</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="user_cliente_id" class="font-semibold w-[10rem] @error('user_cliente_id') text-red-800 @enderror">Usuario del cliente</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('user_cliente_id') px-1 @enderror bg-red-800 text-white rounded">@error('user_cliente_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('user_cliente_id') border border-red-800 @enderror" wire:model='user_cliente_id'>
                                    <option value="" disabled>Seleccione un usuario del cliente</option>
                                    @foreach ($userClientes as $userCliente)
                                        <option value="{{$userCliente->id}}">{{$userCliente->name}}</option>
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
                                    @foreach ($softwares as $software)
                                        <option value="{{$software->id}}">{{$software->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                    @endif

                    @if ($isModalCrear || !$isModalCrear)
                        <div class="flex items-center">
                            <label for="prioridad_id" class="font-semibold w-[10rem] @error('prioridad_id') text-red-800 @enderror">Prioridad</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('prioridad_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('prioridad_id') border border-red-800 @enderror" wire:model='prioridad_id'>
                                    <option value="" disabled>Seleccione una prioridad</option>
                                    @foreach ($prioridades as $prioridad)
                                        <option value="{{$prioridad->id}}">{{$prioridad->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="tipo_id" class="font-semibold w-[10rem] @error('tipo_id') text-red-800 @enderror">Tipo asistencia</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('tipo_id') px-1 @enderror bg-red-800 text-white rounded">@error('tipo_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('ruta') border border-red-800 @enderror" wire:model='tipo_id'>
                                    <option value="" disabled>Seleccione tipo de asistencia</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($isModalCrear)
                        <div class="flex items-center">
                            <label for="fecha_prevista_cumplimiento" class="font-semibold w-[10rem] @error('fecha_prevista_cumplimiento') text-red-800 @enderror">Fecha prevista cumplimiento</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('fecha_prevista_cumplimiento') {{$message}} @enderror</p>
                                </div>
                                <input type="datetime-local" id="fecha_prevista_cumplimiento" class="rounded-md w-full @error('fecha_prevista_cumplimiento') border border-red-800 @enderror" wire:model='fecha_prevista_cumplimiento'>
                            </div>
                        </div>
                        {{-- <div class="flex items-center">
                            <label for="imagen" class="font-semibold w-[10rem] @error('imagen') text-red-800 @enderror">Imagen ó documento</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('imagen') px-1 @enderror bg-red-800 text-white rounded">@error('imagen') {{$message}} @enderror</p>
                                </div>
                                <input type="file" id="imagen" class="rounded-md w-full border  @error('imagen') border-red-800 @enderror" wire:model='imagen'>
                            </div>
                        </div> --}}
                    @endif

                    @if (!$isModalCrear)
                        <div class="flex items-center">
                            <label for="estado_id" class="font-semibold w-[10rem] @error('estado_id') text-red-800 @enderror">Estado</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('estado_id') {{$message}} @enderror</p>
                                </div>
                                <select class="rounded-md w-full @error('estado_id') border border-red-800 @enderror" wire:model='estado_id'>
                                    <option value="" disabled>Seleccione un estado</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="fechaInicioAsistencia" class="font-semibold w-[10rem] @error('fechaInicioAsistencia') text-red-800 @enderror">Fecha inicio de asistencia</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('fechaInicioAsistencia') {{$message}} @enderror</p>
                                </div>
                                <input type="datetime-local" id="fechaInicioAsistencia" class="rounded-md w-full @error('fechaInicioAsistencia') border border-red-800 @enderror" wire:model='fechaInicioAsistencia'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="fechaFinalAsistencia" class="font-semibold w-[10rem] @error('fechaFinalAsistencia') text-red-800 @enderror">Fecha final de asistencia</label>
                            <div class="w-full">
                                <div class="flex justify-end py-1">
                                    <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('fechaFinalAsistencia') {{$message}} @enderror</p>
                                </div>
                                <input type="datetime-local" id="fechaFinalAsistencia" class="rounded-md w-full @error('fechaFinalAsistencia') border border-red-800 @enderror" wire:model='fechaFinalAsistencia'>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="solucion" class="font-semibold w-[10rem] @error('solucion') text-red-800 @enderror">Solución</label>
                            <div class="w-full">
                                <div class="flex justify-between py-1">
                                    <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                    <p class="text-[.8rem] font-bold @error('solucion') px-1 @enderror bg-red-800 text-white rounded">@error('solucion') {{$message}} @enderror</p>
                                </div>
                                <textarea id="solucion" class="rounded-md w-full border @error('solucion') border-red-800 @enderror" wire:model='solucion'></textarea>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center">
                        <label for="problema" class="font-semibold w-[10rem] @error('problema') text-red-800 @enderror">Problema</label>
                        <div class="w-full">
                            <div class="flex justify-between py-1">
                                <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                <p class="text-[.8rem] font-bold @error('problema') px-1 @enderror bg-red-800 text-white rounded">@error('problema') {{$message}} @enderror</p>
                            </div>
                            <textarea id="problema" class="rounded-md w-full border @error('problema') border-red-800 @enderror" wire:model='problema'></textarea>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label for="observaciones" class="font-semibold w-[10rem] @error('observaciones') text-red-800 @enderror">Observaciones</label>
                        <div class="w-full">
                            <div class="flex justify-between py-1">
                                <p class="text-[.7rem] font-bold px-1 bg-amber-900 text-white rounded">opcional</p>
                                <p class="text-[.8rem] font-bold @error('observaciones') px-1 @enderror bg-red-800 text-white rounded">@error('observaciones') {{$message}} @enderror</p>
                            </div>
                            <textarea id="observaciones" class="rounded-md w-full border @error('observaciones') border-red-800 @enderror" wire:model='observaciones'></textarea>
                        </div>
                    </div>
                </div>

                <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white flex justify-between">
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='{{$isModalCrear ? 'crear' : 'editar'}}'>{{$isModalCrear ? 'Crear' : 'Actualizar'}}</button>
                    
                    <div class="flex gap-4 p-1">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="interno" wire:model="interno" {{$interno ? 'checked' : ''}}>
                            <label for="interno" class="font-semibold">Interno</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>