@props([
    'roles' => [],
    'exceptRoles' => [],
    'ruta' => '#',
    'clasesWireCurrent' => 'text-on-surface-strong bg-primary/10 dark:text-on-surface-dark-strong dark:bg-primary-dark/10 font-bold',
    'icono' => 'fa-star',
    'textoMenu' => 'Menú',
    'noParaSupervisor' => false,
])

@php
    $user = auth()->user();
    $rolesArray = is_array($roles) ? $roles : explode('|', $roles);
    $exceptRolesArray = is_array($exceptRoles) ? $exceptRoles : explode('|', $exceptRoles);

    // Lógica defensiva y unificada de visibilidad
    $mostrarMenu = (empty($rolesArray) || $user->hasAnyRole($rolesArray)) &&
                   (empty($exceptRolesArray) || !$user->hasAnyRole($exceptRolesArray)) &&
                   (!$noParaSupervisor || !$user->hasRole('Supervisor'));
@endphp

@if($mostrarMenu)
    <li class="py-0.5">
        <a href="{{ route($ruta) }}"
           wire:current="{{ $clasesWireCurrent }}"
           wire:navigate
           {{ $attributes->merge(['class' => 'flex items-center rounded-xl gap-2 px-3 py-2 text-sm font-medium text-on-surface underline-offset-2 hover:bg-primary/5 hover:text-on-surface-strong transition dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong']) }}>
            <i class="fa-solid {{ $icono }} text-base shrink-0 opacity-75"></i>
            <span>{{ $textoMenu }}</span>
        </a>
    </li>
@endif