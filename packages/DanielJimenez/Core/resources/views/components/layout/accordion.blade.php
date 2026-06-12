@props([
    'titulo' => 'Menú Acordeón',
    'icono' => 'fa-folder',
    'roles' => [],
    'exceptRoles' => [],
    'noParaSupervisor' => false,
])

@php
    $user = auth()->user();
    $rolesArray = is_array($roles) ? $roles : explode('|', $roles);
    $exceptRolesArray = is_array($exceptRoles) ? $exceptRoles : explode('|', $exceptRoles);

    // Lógica defensiva de visibilidad unificada
    $mostrarAcordeon = (empty($rolesArray) || $user->hasAnyRole($rolesArray)) &&
                       (empty($exceptRolesArray) || !$user->hasAnyRole($exceptRolesArray)) &&
                       (!$noParaSupervisor || !$user->hasRole('Supervisor'));
@endphp

@if($mostrarAcordeon)
    <li x-data="{ isExpanded: false }" class="flex flex-col py-0.5">
        <button type="button" 
                x-on:click="isExpanded = ! isExpanded" 
                x-bind:aria-expanded="isExpanded ? 'true' : 'false'" 
                class="flex items-center justify-between rounded-xl gap-2 px-3 py-2 text-sm font-medium transition select-none group"
                x-bind:class="isExpanded ? 'text-on-surface-strong bg-primary/5 dark:text-on-surface-dark-strong dark:bg-primary-dark/5' : 'text-on-surface hover:bg-primary/5 hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong dark:hover:bg-primary-dark/5'">
            
            <div class="flex items-center gap-2">
                <i class="fa-solid {{ $icono }} text-base shrink-0 opacity-75"></i>
                <span>{{ $titulo }}</span>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                 class="size-4 transition-transform duration-200 shrink-0 opacity-60 group-hover:opacity-100" 
                 x-bind:class="isExpanded ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
            </svg>
        </button>

        <ul x-cloak 
            x-collapse 
            x-show="isExpanded" 
            class="pl-4 mt-0.5 space-y-0.5 border-l border-stone-200 dark:border-zinc-800 ml-5">
            {{ $slot }}
        </ul>
    </li>
@endif