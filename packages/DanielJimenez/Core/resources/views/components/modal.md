# Componentes de Modales (Ecosistema Reactivo)

Este módulo provee dos componentes modales de bajo acoplamiento para el TALL Stack: un contenedor base estructural controlado por el backend y un servicio asíncrono global de confirmación.

---

## 1. Modal Estructural Base (`modal.blade.php`)

Un contenedor atómico reactivo mediante Alpine.js enganchado al backend de Livewire por medio de enlaces bidireccionales de datos (`wire:model`).

### API del Componente

#### Propiedades (`@props`)
* **`id`** *(string, requerido)*: Identificador único del componente en el DOM para la gestión de eventos de Alpine.js.
* **`title`** *(string, opcional)*: Texto que se renderizará en la cabecera del modal.
* **`type`** *(string, por defecto: `'normal'`)*: Variante semántica (`success`, `danger`, `error`, `info`, `warning`, `normal`) que inyecta bordes y estilos dinámicos mapeados mediante el helper `CoreStyle`.

#### Slots
* **`{{ $slot }}`**: Contenido principal del cuerpo del modal.
* **`{{ $footer }}`**: Espacio reservado en la parte inferior para los botones de acción.

### Ejemplos de Implementación Base

#### Caso A: Modal Informativo Simple

```html
<x-core::modal id="modalActualizacion" title="Nueva Versión" type="info" wire:model="mostrarModal">
    Una nueva versión de la librería está lista con optimizaciones para Tailwind v4.
    
    <x-slot:footer>
        <button type="button" wire:click="$set('mostrarModal', false)" class="w-full text-sm font-semibold rounded-xl py-2 border">
            Entendido
        </button>
    </x-slot:footer>
</x-core::modal>
```

## 2. Servicio Global de Confirmación (modal-confirmation.blade.php)

Componente desacoplado de instancia única. No requiere duplicarse por cada registro de una tabla; se configura dinámicamente en el cliente mediante eventos de JavaScript y despacha de vuelta al backend de Livewire de forma asíncrona.

### Formato del Payload del Evento (`open-confirmation`)

Para invocar el modal de confirmación global desde cualquier parte de la aplicación, se despacha un CustomEvent con la siguiente estructura:

```JavaScript
window.dispatchEvent(new CustomEvent('open-confirmation', { 
    detail: { 
        type: 'danger',                              // Variante semántica visual
        title: '¿Confirmar eliminación?',            // Título superior
        message: 'Esta acción no se puede deshacer.', // Mensaje del cuerpo
        action: 'ejecutarEliminacion',               // Listener de Livewire a disparar
        id: 45                                       // ID del registro a procesar
    } 
}));
```

### Intercepción en el Componente Livewire

El componente que origina la petición debe declarar el método oyente para procesar la respuesta asíncrona:

```PHP
protected $listeners = ['ejecutarEliminacion' => 'eliminarRegistro'];

public function eliminarRegistro($id)
{
    // Lógica crítica del sistema
    $this->dispatch('toast', type: 'success', message: "Registro #{$id} eliminado.");
}
```