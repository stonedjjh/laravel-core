# Loading Container Component

El componente `<x-core::loading-container>` es un wrapper (contenedor) arquitectónico diseñado para gestionar estados de carga (*loading states*) de forma nativa con Livewire. Controla de manera automática la opacidad visual y bloquea la interacción del usuario en el frontend durante peticiones asíncronas, previniendo duplicaciones de eventos en sistemas críticos.

---

## 1. API del Componente

### Propiedades (`@props`)
* **`target`** *(string, por defecto: `'save'`)*: Define el método o acción del componente de Livewire que se desea monitorear. El estado de carga solo se activará cuando la acción que esté viajando hacia el servidor coincida exactamente con este valor.

### Atributos Heredados (`$attributes`)
Cualquier clase CSS, identificador o directiva adicional pasada al componente se fusionará automáticamente con la capa contenedora externa.

---

## 2. Implementación Modular

Crea el archivo en el directorio de componentes de tu paquete:  
`packages/DanielJimenez/Core/resources/views/components/loading-container.blade.php`

```html
@props([
    'target' => 'save'
])

<div {{ $attributes->merge(['class' => 'transition-opacity duration-200']) }} 
     wire:loading.class="opacity-60 pointer-events-none" 
     wire:target="{{ $target }}">
    {{ $slot }}
</div>
```

## 3. Ejemplos de Uso

### Caso A: Uso por Defecto (Acción `save`)

Si no se especifica el atributo target, el contenedor asume automáticamente que debe escuchar y bloquear la UI cuando se ejecute el método `save()`.

```HTML
<x-core::loading-container>
    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="text-sm font-medium">Nombre del Perfil</label>
            <input type="text" wire:model="name" class="w-full border rounded-xl p-2">
        </div>
        
        <button type="submit" class="w-full bg-stone-900 text-white p-2 rounded-xl">
            Guardar Cambios
        </button>
    </form>
</x-core::loading-container>
```

### Caso B: Monitoreo de Acciones Específicas (Acción `procesarPago`)

Para aislar flujos y asegurar que el bloqueo ocurra únicamente con una acción financiera o destructiva pesada, se pasa el nombre del método al parámetro `target`.

```HTML
<x-core::loading-container target="procesarPago">
    <div class="p-6 bg-white rounded-2xl border border-stone-200">
        <h3 class="font-bold">Resumen de Transferencia</h3>
        <p class="text-sm text-stone-500">Monto a liquidar: $1,250.00</p>
        
        <button wire:click="procesarPago" class="mt-4 w-full bg-emerald-600 text-white py-2 rounded-xl">
            Confirmar y Pagar
        </button>
    </div>
</x-core::loading-container>
```

## 4. Ventajas de UX y Arquitectura

1. **Prevención de peticiones duplicadas:** La clase pointer-events-none desactiva todos los eventos de clic en el cliente, evitando que un usuario impaciente haga doble clic en un botón de envío antes de que el servidor retorne la respuesta.

2. **Feedback No Invasivo:** Alternar la opacidad a opacity-60 ofrece una transición visual fluida sin necesidad de inyectar spinners o loaders invasivos que alteren el flujo del diseño.

3. **Bajo Acoplamiento:** Al envolver por completo el DOM del formulario o card, no requiere alterar las clases internas de los botones ni agregar condicionales complejos de Blade por cada elemento.