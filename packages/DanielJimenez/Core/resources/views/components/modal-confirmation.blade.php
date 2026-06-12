@props([
    'id' => 'core-global-confirmation'
])

@php
    // Cargamos el mapa completo de estilos para consumirlo dinámicamente en JS mediante @js
    $stylesMap = \DanielJimenez\Core\Helpers\CoreStyle::all();
@endphp

<div x-data="{
    isOpen: false,
    type: 'normal',
    title: '',
    message: '',
    action: '',
    targetId: null,
    styles: @js($stylesMap),

    get currentStyle() {
        return this.styles[this.type] || this.styles.normal;
    },

    init() {
        window.addEventListener('open-confirmation', (e) => {
            this.type = e.detail.type || 'normal';
            this.title = e.detail.title || '¿Confirmar acción?';
            this.message = e.detail.message || '';
            this.action = e.detail.action || '';
            this.targetId = e.detail.id || null;
            this.isOpen = true;
        });

        window.addEventListener('close-confirmation', () => {
            this.reset();
        });
    },

    confirm() {
        if (this.action) {
            // Despacha el evento nativo de Livewire hacia el componente que originó la acción
            Livewire.dispatch(this.action, { id: this.targetId });
        }
        this.reset();
    },

    reset() {
        this.isOpen = false;
        setTimeout(() => {
            this.type = 'normal';
            this.title = '';
            this.message = '';
            this.action = '';
            this.targetId = null;
        }, 200); // Espera a que termine la transición de salida
    }
}"
@open-modal-{{ $id }}.window="isOpen = true"
@close-modal-{{ $id }}.window="isOpen = false">

    <div x-cloak 
         x-show="isOpen" 
         x-transition.opacity.duration.200ms 
         x-trap.inert.noscroll="isOpen" 
         x-on:keydown.esc.window="reset()" 
         x-on:click.self="reset()" 
         class="fixed inset-0 z-[70] flex items-end justify-center bg-black/40 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" 
         role="dialog" 
         aria-modal="true" 
         :aria-labelledby="'{{ $id }}Title'">
        
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100" 
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="flex max-w-md w-full flex-col overflow-hidden rounded-xl border bg-white text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100 shadow-2xl relative"
             :class="currentStyle.border">
            
            {{-- Cabecera Dinámica con Icono Reactivo --}}
            <div class="flex items-center justify-between border-b border-zinc-200/80 p-4 dark:border-zinc-800" :class="currentStyle.container">
                <div class="flex items-center justify-center rounded-full p-1.5" :class="currentStyle.icon">
                    {{-- Icono Éxito --}}
                    <svg x-show="type === 'success'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- Icono Peligro / Error --}}
                    <svg x-show="type === 'danger' || type === 'error'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                    </svg>
                    {{-- Icono Advertencia --}}
                    <svg x-show="type === 'warning'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    {{-- Icono Informativo / Neutro --}}
                    <svg x-show="type !== 'success' && type !== 'danger' && type !== 'error' && type !== 'warning'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <button type="button" x-on:click="reset()" aria-label="close modal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            {{-- Cuerpo Centrado --}}
            <div class="px-6 pt-5 pb-4 text-center"> 
                <h3 :id="'{{ $id }}Title'" class="mb-2 text-base font-bold tracking-wide text-zinc-900 dark:text-zinc-100" x-text="title"></h3>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400 text-pretty" x-text="message"></p>
            </div>

            {{-- Pie de Acción Semántica Ajustado a Ancho Completo --}}
            <div class="p-4 pt-2 flex flex-col gap-2">
                <button type="button" 
                        x-on:click="confirm()" 
                        class="w-full border px-4 py-2 text-center text-sm font-semibold rounded-xl transition duration-200"
                        :class="currentStyle.button">
                    Confirmar
                </button>
                <button type="button" 
                        x-on:click="reset()" 
                        class="w-full border border-zinc-200 bg-white px-4 py-2 text-center text-sm font-semibold text-zinc-700 hover:bg-zinc-50 rounded-xl transition duration-200 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Cancelar
                </button>
            </div>
            
        </div>
    </div>
</div>