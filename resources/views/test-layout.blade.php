<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Layout Compuesto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-stone-50 dark:bg-zinc-950">

    <x-core::layout logoRoute="#">
        
        <x-slot:logo>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-primary"></i>
                <span class="text-lg font-black tracking-wider text-on-surface-strong dark:text-on-surface-dark-strong">DEV-CORE</span>
            </div>
        </x-slot:logo>

        <x-slot:search>
            <div class="relative w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm opacity-50"></i>
                <input type="search" placeholder="Buscar..." class="w-full border border-outline rounded-xl bg-surface py-1.5 pl-9 text-sm focus:outline-none" />
            </div>
        </x-slot:search>

        <x-slot:sidebar>
            <x-core::layout.simple ruta="dashboard" icono="fa-chart-pie" textoMenu="Panel Principal" />
            
            <x-core::layout.accordion titulo="Operaciones" icono="fa-folder-open">
                <x-core::layout.simple ruta="dashboard" icono="fa-box" textoMenu="Productos" />
                <x-core::layout.simple ruta="dashboard" icono="fa-receipt" textoMenu="Facturas" />
            </x-core::layout.accordion>

            <x-core::layout.simple ruta="dashboard" icono="fa-gear" textoMenu="Configuración" />
        </x-slot:sidebar>

        <div class="space-y-6">
            <header class="flex items-center justify-between border-b border-outline pb-4">
                <h1 class="text-2xl font-bold tracking-tight">Área de Trabajo de Prueba</h1>
                <span class="text-xs bg-emerald-500/10 text-emerald-500 font-semibold px-2.5 py-1 rounded-full">Entorno Seguro de Test</span>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-6 bg-surface-alt border border-outline rounded-2xl">
                    <h3 class="font-bold text-sm text-on-surface-strong">Validación Alpine.js</h3>
                    <p class="text-xs opacity-70 mt-1">Haz clic en "Operaciones" en la barra lateral. Debería expandirse el submenú de forma elástica con x-collapse.</p>
                </div>
                <div class="p-6 bg-surface-alt border border-outline rounded-2xl">
                    <h3 class="font-bold text-sm text-on-surface-strong">Validación Responsiva</h3>
                    <p class="text-xs opacity-70 mt-1">Reduce el tamaño de la pantalla. El menú debe ocultarse a la izquierda y aparecer el botón flotante.</p>
                </div>
                <div class="p-6 bg-surface-alt border border-outline rounded-2xl">
                    <h3 class="font-bold text-sm text-on-surface-strong">Validación de Rutas</h3>
                    <p class="text-xs opacity-70 mt-1">Inspecciona el código de los enlaces para comprobar que generen las URLs correctas basadas en el helper route().</p>
                </div>
            </div>
        </div>

    </x-core::layout>

</body>
</html>