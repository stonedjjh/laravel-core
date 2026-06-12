@props([
    'modal',   // El ID del modal que queremos abrir
    'type' => 'normal' // El estilo semántico del botón: success, danger, info, normal...
])

@php
    // Consumimos directamente nuestro CoreStyle Helper para pintar el botón
    $style = \DanielJimenez\Core\Helpers\CoreStyle::type($type) ?? \DanielJimenez\Core\Helpers\CoreStyle::type('normal');
@endphp

<button 
    type="button"
    onclick="window.dispatchEvent(new CustomEvent('open-modal-{{ $modal }}'))"
    {{ $attributes->merge(['class' => "w-full px-4 py-2.5 text-sm font-medium text-white rounded-xl transition-all shadow-sm active:scale-95 " . $style['button']]) }}
>
    {{ $slot }}
</button>