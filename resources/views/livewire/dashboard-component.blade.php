<div 
class="flex-1 bg-slate-700 flex flex-col" 
x-data="{
    modalGrafico: JSON.parse(localStorage.getItem('modal_grafico')) || false,
    cambiarModal() {
        this.modalGrafico = !this.modalGrafico;
        localStorage.setItem('modal_grafico', JSON.stringify(this.modalGrafico));
    }
}">

    <x-loading-screen />

    <div class="text-white p-2 flex justify-between">
        <p class="text-[1.5rem]">Dashboard</p>

        <button 
        class="bg-white rounded-sm text-slate-700 font-medium text-[1.3rem] px-3 hover:bg-white/95"
        @click="cambiarModal"
        >
        <span x-show="!modalGrafico">Tabla</span>
        <span x-show="modalGrafico">Gráficos</span>
        </button>
    </div>

    <div class="flex-1">
        <div class="flex flex-wrap justify-between gap-1 p-2 box-border">
            {{-- ====== --}}
            <div class="w-[100%] sm:w-[49%] md:flex-1 flex items-center justify-between bg-white p-1 rounded-sm shadow-sm shadow-white">
                <div class="flex items-center gap-2">
                    <div class="border border-slate-800 p-1 rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <p class="text-[1.2rem] font-medium">Licencias</p>
                </div>
                <p class="font-semibold">{{$countLicencias}}</p>
            </div>
            {{-- ====== --}}
            <div class="w-[100%] sm:w-[49%] md:flex-1 flex items-center justify-between bg-white p-1 rounded-sm shadow-sm shadow-white">
                <div class="flex items-center gap-2">
                    <div class="border border-slate-800 p-1 rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <p class="text-[1.2rem] font-medium">Clientes</p>
                </div>
                <p class="font-semibold">{{$countClientes}}</p>
            </div>
            {{-- ====== --}}
            <div class="w-[100%] sm:w-[49%] md:flex-1 flex items-center justify-between bg-white p-1 rounded-sm shadow-sm shadow-white">
                <div class="flex items-center gap-2">
                    <div class="border border-slate-800 p-1 rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fa-regular fa-handshake"></i>
                    </div>
                    <p class="text-[1.2rem] font-medium">Soportes</p>
                </div>
                <p class="font-semibold">{{$countSoportes}}</p>
            </div>
            {{-- ====== --}}
            <div class="w-[100%] sm:w-[49%] md:flex-1 flex items-center justify-between bg-white p-1 rounded-sm shadow-sm shadow-white">
                <div class="flex items-center gap-2">
                    <div class="border border-slate-800 p-1 rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fa-solid fa-diagram-project"></i>
                    </div>
                    <p class="text-[1.2rem] font-medium">Proyectos</p>
                </div>
                <p class="font-semibold">{{$countProyectos}}</p>
            </div>
        </div>

        <div 
        class="h-[70vh] p-2 flex justify-center"
        x-show="!modalGrafico"
        >
            <canvas id="myChart" class="bg-white rounded-sm"></canvas>
        </div>

        <div 
        class="p-2 flex flex-col items-center rounded-sm"
        x-show="modalGrafico"
        >
            <table class="w-full md:w-[90%]">
                <thead>
                    <tr class="text-center text-white">
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
                                <i class="fa-solid cursor-pointer" @click="funsearchEmpresa"   :class="{'fa-magnifying-glass' : !searchEmpresa, 'fa-xmark' : searchEmpresa}"></i>
                            </div>
                        </td>
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
                                <i class="fa-solid cursor-pointer" @click="funsearchCliente" :class="{'fa-magnifying-glass' : !searchCliente, 'fa-xmark' : searchCliente}"></i>
                            </div>
                        </td>
                        <td class="border p-1">Cantidad de soportes (General)</td>
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
                                <div :class="{'w-full' : searchColaborador}">
                                    <select name="" id="" class="w-full h-[2rem] p-0 px-2 rounded text-black" wire:model.live="searchColaborador" x-show="searchColaborador">
                                        <option value="" disabled selected>Seleccione Colaborador</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <p x-show="!searchColaborador">Cantidad de soportes (Colaborador)</p>
                                </div>
                                <i class="fa-solid cursor-pointer" @click="funsearchColaborador" :class="{'fa-magnifying-glass' : !searchColaborador, 'fa-xmark' : searchColaborador}"></i>
                            </div>
                        </td>
                        {{-- <td class="border p-1">Cantidad de soportes (Colaborador)</td> --}}
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($clientes as $info)
                        <tr>
                            <td class="border border-slate-700 p-1 font-medium text-center">{{$info->nombre}}</td>
                            <td class="border border-slate-700 p-1 font-medium text-center">{{$info->contacto}}</td>
                            <td class="border border-slate-700 p-1 font-medium text-center">{{$info->soportes_count}}</td>
                            <td class="border border-slate-700 p-1 font-medium text-center">{{$info->soportesAtendidosPorColaborador}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');
  
    setTimeout(() => {
        new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $nombreCLientes?>,
            datasets: [{
                type: 'bar',
                label: 'Barra',
                data: <?= $soportesObtuvoCLientes?>
            }, {
                type: 'line',
                label: 'Linea',
                data: <?= $soportesObtuvoCLientes?>,
            }, {
                type: 'polarArea',
                label: 'Area',
                data: <?= $soportesObtuvoCLientes?>,
            }, {
                type: 'radar',
                label: 'Radar',
                data: <?= $soportesObtuvoCLientes?>,
            }, {
                type: 'pie',
                label: 'Pastel',
                data: <?= $soportesObtuvoCLientes?>,
            }],
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
        });
    }, 300);
  </script>