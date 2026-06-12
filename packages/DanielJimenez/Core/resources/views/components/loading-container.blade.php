@props([
    'target' => 'save'
])

<div {{ $attributes->merge(['class' => 'transition-opacity']) }} 
     wire:loading.class="opacity-60 pointer-events-none" 
     wire:target="{{ $target }}">
    {{ $slot }}
</div>