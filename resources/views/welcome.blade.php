<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Sistema Core</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-stone-50 flex flex-col items-center justify-center min-h-screen p-6 dark:bg-stone-950">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-stone-200/80 space-y-4 dark:bg-stone-900 dark:border-stone-800">
        <div>
            <h1 class="text-xl font-bold text-stone-900 dark:text-white">Panel de Control Core</h1>
            <p class="text-xs text-stone-500 dark:text-stone-400 mt-1">Simulación y disparo de alertas globales.</p>
        </div>

        <div class="pt-2 flex flex-col gap-2">
            <button 
                onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: '¡Operación ejecutada con éxito!' } }))"
                class="w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 rounded-xl transition-all shadow-sm"
            >
                Lanzar Toast de Éxito
            </button>

            <button 
                onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: 'Hubo un fallo en la conexión con el servidor.' } }))"
                class="w-full px-4 py-2.5 text-sm font-medium text-white bg-rose-600 hover:bg-rose-500 active:bg-rose-700 rounded-xl transition-all shadow-sm"
            >
                Lanzar Toast de Error
            </button>

            <div class="pt-2 border-t border-stone-100 dark:border-stone-800">
                {{-- Inyección limpia del componente reactivo --}}
                <livewire:prueba-modal />
            </div>        
        </div>

        <x-core::toast />
    </div>

    <x-core::modal-confirmation />

    @livewireScriptConfig
</body>
</html>