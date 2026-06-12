<?php

namespace DanielJimenez\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Aquí registraremos servicios en el contenedor si es necesario más adelante
    }

    public function boot(): void
    {
        // Registra el namespace para las vistas de la librería bajo el prefijo 'core'
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'core');
    }
}