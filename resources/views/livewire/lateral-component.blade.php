<div class="relative flex gap-3 flex-col items-center transition-all h-[90vh] overflow-y-auto" 
    x-data="{
        contraer: JSON.parse(localStorage.getItem('contraer')) || false,
        toggle() {
            this.contraer = !this.contraer;
            localStorage.setItem('contraer', JSON.stringify(this.contraer));
        },
        moduloSelect: JSON.parse(sessionStorage.getItem('name_modulo')) || '',
        seleccionado(modulo) {
            this.moduloSelect = modulo;
            sessionStorage.setItem('name_modulo', JSON.stringify(this.moduloSelect));
        }
    }"
    :class="{ 'w-[5%]': contraer, 'w-[13%]': !contraer}"
>

    <x-loading-screen />

    <button class="sticky top-0 w-full text-center text-[2rem] bg-slate-300 flex items-center justify-center p-2" @click="toggle">
        <ion-icon name="chevron-back-circle-outline" 
        class="transition-all "
        :class="{ 'rotate-[180deg]': contraer}"
        ></ion-icon>
    </button>

    <div class="flex-1 w-full">
        {{-- ===== --}}
        @role('Administrador|Soporte')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'dashboard', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('dashboard')"
        @click="seleccionado('dashboard')"
        >
            <i class="fa-solid fa-chart-simple"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Dashboard</p>
        </div>
        @endrole
        
        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'usuarios', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('usuarios')"
        @click="seleccionado('usuarios')"
        >
            <i class="fa-solid fa-users"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Usuarios</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'software', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('software')"
        @click="seleccionado('software')"
        >
            <i class="fa-brands fa-windows"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Software</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador|Cliente')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'clientes', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('clientes')"
        @click="seleccionado('clientes')"
        >
            <i class="fa-solid fa-users"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Clientes</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador|Cliente')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'licencias', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('licencias')"
        @click="seleccionado('licencias')"
        >
            <i class="fa-solid fa-list"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Licencias</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'terminales', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('terminales')"
        @click="seleccionado('terminales')"
        >
            <i class="fa-solid fa-computer"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Terminales</p>
        </div>
        @endrole

        {{-- ===== --}}
        {{-- <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'expedientes', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('expedientes')"
        @click="seleccionado('expedientes')"
        >
            <i class="fa-solid fa-folder-open"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Expedientes</p>
        </div> --}}
        {{-- ===== --}}
        @role('Administrador|Soporte')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'soportes', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('soportes')"
        @click="seleccionado('soportes')"
        >
            <i class="fa-regular fa-handshake"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Soportes</p>
        </div>
        @endrole

        {{-- ===== --}}
        {{-- <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'proyectos', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2': !contraer}"
        wire:click="redirigir('proyectos')"
        @click="seleccionado('proyectos')"
        >
            <i class="fa-solid fa-diagram-project"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Proyectos</p>
        </div> --}}
        {{-- ===== --}}
        {{-- <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'plantillas', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2': !contraer}"
        wire:click="redirigir('plantillas')"
        @click="seleccionado('plantillas')"
        >
            <i class="fa-solid fa-copy"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Plantillas</p>
        </div> --}}
        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'preguntas', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2': !contraer}"
        wire:click="redirigir('preguntas')"
        @click="seleccionado('preguntas')"
        >
            <i class="fa-solid fa-question"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Preguntas</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'prioridades', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2': !contraer}"
        wire:click="redirigir('prioridades')"
        @click="seleccionado('prioridades')"
        >
            <i class="fa-solid fa-person-running"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Prioridades</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'etapas', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2': !contraer}"
        wire:click="redirigir('etapas')"
        @click="seleccionado('etapas')"
        >
            <i class="fa-solid fa-layer-group"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Etapas</p>
        </div>
        @endrole

        {{-- ===== --}}
        @role('Administrador')
        <div 
        class="transition-all duration-[.2s] cursor-pointer py-3 hover:bg-zinc-600 hover:text-white"
        :class="{ 'bg-zinc-600 text-white': moduloSelect == 'estados', 'text-[1.3rem] text-center': contraer, 'flex items-center px-5 gap-2 text-[1rem]': !contraer}"
        wire:click="redirigir('estados')"
        @click="seleccionado('estados')"
        >
            <i class="fa-solid fa-clock-rotate-left"></i>
            <p 
            class="font-medium" 
            :class="{ 'hidden': contraer}"
            >Estados</p>
        </div>
        @endrole
    </div>
</div>
