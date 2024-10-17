<header class="bg-zinc-700 border-b max-w-full mx-auto py-3 px-8 flex justify-between w-full">
    <div class="flex items-center gap-2 text-[1.3rem] text-white">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        <p class="font-semibold">BeêsyAdmin</p>
    </div>

    <div class="text-[1.2rem] text-white relative" x-data="{
        clickName: false,
        cambiarEstado(){
            this.clickName = !this.clickName
        }
    }">
        <div class="flex gap-1 items-center">
            @unless(auth()->user()->hasRole('Cliente'))
            <div 
            class="mr-4 cursor-pointer w-[2rem] h-[2rem] bg-white text-slate-900 border rounded-[.4rem] flex items-center justify-center transition-all hover:bg-transparent hover:text-white hover:scale-110"
            wire:click='estadoModal(true)'>
                <p class="font-semibold">{{count($soportes)}}</p>
            </div>
            @endunless
            
            <div class="flex gap-2 items-center cursor-pointer" @click="clickName = !clickName">
                <p class="text-[.8rem]">({{auth()->user()->getRoleNames()->first()}})</p>
                <p>{{auth()->user()->name}}</p>
            </div>

            <ion-icon 
                name="caret-forward-outline" 
                class="transition-all cursor-pointer" 
                :class="{ 'rotate-[90deg]': clickName }"
                @click="clickName = !clickName">
            </ion-icon>
        </div>

        <div 
        class="absolute transition-all right-0 bg-white text-zinc-800 w-[12rem] rounded-md overflow-hidden"
        :class="{ 'translate-y-[1rem] opacity-100': clickName, 'opacity-0 invisible': !clickName}"
        >
            <p class="hover:bg-zinc-300 p-[.4rem] font-medium" @click="cambiarEstado()" wire:click='estadoModal'>Cambiar Password</p>
            <p class="hover:bg-zinc-300 p-[.4rem] font-medium" wire:click="logout" @click="cambiarEstado()">Cerrar sesión</p>
        </div>
    </div>

    @if ($isOpenModal)
    <div class="fixed top-0 left-0 w-full z-10 h-screen bg-black/30 transition-all flex justify-center items-center">
        <div class="bg-white w-[40%] flex flex-col">
            <div class="flex justify-between px-2 py-1 bg-slate-700 font-semibold text-[1.1rem] text-white">
                <p>{{$isSoporteDestiempo ? 'Soportes en destiempo' : 'Cabiar Password'}}</p>
                <button wire:click='estadoModal'>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
    
            <div class="p-3 flex flex-col gap-3 {{$isSoporteDestiempo ? 'h-[60vh] overflow-auto' : ''}}">
                @if ($isSoporteDestiempo)
                    @foreach ($soportes as $soporte)
                        <div class="border-b-[.5rem]">
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Ticket:</span> {{$soporte->id}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Prioridad:</span> {{$soporte->prioridad->nombre}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Estado:</span> {{$soporte->estado->nombre}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Colaborador:</span> {{$soporte->colaborador->name}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Empresa:</span> {{$soporte->cliente->nombre}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Contacto:</span> {{$soporte->cliente->contacto}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Problema:</span> {{$soporte->problema ?? '-'}}</p>
                            <p class="hover:bg-slate-600 hover:text-white rounded-sm"><span>Fecha prevista:</span> {{$soporte->fecha_prevista_cumplimiento}}</p>
                        </div>
                    @endforeach
                @else
                    <div class="flex items-center">
                        <label for="password_actual" class="font-semibold w-[11rem] @error('password_actual') text-red-800 @enderror">Password Actual</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('password_actual') {{$message}} @enderror</p>
                            </div>
                            <div class="relative" x-data="{
                                view: false,
                                funView(){
                                    this.view = !this.view,
                                    setTimeout(() => {
                                        this.view = false
                                    }, 1000);
                                }
                            }">
                                <input :type="view ? 'text' : 'password'" id="password_actual" class="rounded-md w-full @error('password_actual') border border-red-800 @enderror" wire:model='password_actual'>
                                <i class="fa-regular fa-eye absolute top-[.5rem] right-[.5rem] text-[1.5rem] cursor-pointer bg-white" x-show="view" @click="funView()"></i>
                                <i class="fa-regular fa-eye-slash absolute top-[.5rem] right-[.5rem] text-[1.5rem] cursor-pointer bg-white" x-show="!view" @click="funView()"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label for="password" class="font-semibold w-[11rem] @error('password') text-red-800 @enderror">Nuevo Password</label>
                        <div class="w-full">
                            <div class="flex justify-end py-1">
                                <p class="text-[.8rem] font-bold px-1 bg-red-800 text-white rounded">@error('password') {{$message}} @enderror</p>
                            </div>
                            <div class="relative" x-data="{
                                view: false,
                                funView(){
                                    this.view = !this.view,
                                    setTimeout(() => {
                                        this.view = false
                                    }, 1000);
                                }
                            }">
                                <input :type="view ? 'text' : 'password'" id="password" class="rounded-md w-full @error('password') border border-red-800 @enderror" wire:model='password'>
                                <i class="fa-regular fa-eye absolute top-[.5rem] right-[.5rem] text-[1.5rem] cursor-pointer bg-white" x-show="view" @click="funView()"></i>
                                <i class="fa-regular fa-eye-slash absolute top-[.5rem] right-[.5rem] text-[1.5rem] cursor-pointer bg-white" x-show="!view" @click="funView()"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
    
            <div class="px-2 py-1 bg-slate-700 font-semibold text-[1.2rem] text-white">
                @if (!$isSoporteDestiempo)
                    <button class="bg-white text-slate-700 rounded-sm px-2" wire:click='guardarPassword'>
                        Actualizar
                    </button>
                @endif
            </div>
        </div>
    </div>
    @endif
</header>

