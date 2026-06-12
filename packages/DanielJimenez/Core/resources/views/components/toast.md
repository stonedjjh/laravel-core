# Documentación del Componente Toast Flotante (`toast`)

Este componente proporciona notificaciones flotantes no intrusivas en la esquina inferior derecha de la pantalla. Cuenta con estilos dinámicos automáticos basados en los tokens del sistema de diseño, una barra de progreso de tiempo fluida administrada por Alpine.js calculando el delta de tiempo con `Date.now()` y soporte nativo para el modo oscuro.

---

## 1. Estructura de Activación (Frontend)

El componente se expone globalmente mediante el namespace de la librería como `<x-core::toast />`. Permanece oculto en el DOM (`x-show="isVisible"`) hasta que intercepta el evento global `.window` del navegador llamado `toast`. El payload debe contener estrictamente las llaves `type`, `title` y `message`.

```html
x-on:toast.window="
    notification = $event.detail;
    startTimeout();
"
```

### Tipos de Alerta Soportados (`type`)
El componente mapea de forma automática la opacidad de los contenedores, el color de la barra inferior, el texto y los iconos utilizando los tokens semánticos definidos en tu archivo de estilos global:
* `success` (Éxito - Verde)
* `danger` / `error` (Fallas/Errores - Rojo)
* `warning` (Advertencias - Amarillo/Naranja)
* `info` (Información - Azul)

---

## 2. Casos de Uso e Implementación

### Caso A: Disparo Inmediato (Acciones Locales en la misma Pantalla)
Ideal para operaciones asíncronas por AJAX dentro del mismo componente de Livewire (por ejemplo, al eliminar una fila de la tabla o cambiar un interruptor) sin recargar ni navegar a otra URL.

Desde el componente de Livewire (Backend), se despacha el evento directamente al frente usando el nombre semántico:

```php
$this->dispatch('toast', 
    type: 'success', 
    title: '¡Operación Exitosa!', 
    message: 'El registro se procesó correctamente.'
);
```

### Caso B: Disparo con Redirección SPA (`wire:navigate`)
Ideal para los formularios de gestión (Creación / Edición) donde, tras guardar los datos con éxito, el sistema redirige al usuario de vuelta al listado plano empleando el modo SPA de Livewire.

#### 1. En el Controlador del Formulario (Backend):
Antes de redirigir, se inyecta el arreglo con los datos de la notificación dentro del `flash` de la sesión de Laravel:

```php
session()->flash('notificacion', [
    'icon'        => 'success', // Mapea directamente con el 'type' del componente
    'title'       => '¡Éxito!',
    'description' => 'Los cambios han sido guardados en el sistema.'
]);

return $this->redirectRoute('modulo.index', navigate: true);
```

#### 2. En el Layout Maestro (`layouts/app.blade.php`):
Para automatizar que el Toast se despache solo al llegar a la pantalla de destino, se coloca este interceptor global de JavaScript/Alpine.js justo arriba de la etiqueta del componente:

```html
{{-- Interceptor Global de Notificaciones Flash --}}
@if (session()->has('notificacion'))
    <div x-data="{
        init() {
            window.dispatchEvent(new CustomEvent('toast', { 
                detail: { 
                    type: '{{ session('notificacion.icon') }}', 
                    title: '{{ session('notificacion.title') }}', 
                    message: '{{ session('notificacion.description') }}' 
                } 
            }));
        }
    }"></div>
@endif

{{-- Instancia única del componente en el Layout --}}
<x-core::toast />
```

---

## 3. Parámetros del Payload

Cuando se emita el evento desde cualquier origen, el objeto `detail` debe cumplir con la siguiente interfaz:

| Propiedad | Tipo | Obligatorio | Descripción |
| :--- | :--- | :--- | :--- |
| `type` | String | Sí | Define el esquema visual: `success`, `danger`, `error`, `warning`, `info`. |
| `title` | String | No | Encabezado principal en negrita de la notificación. |
| `message` | String | No | Cuerpo del texto descriptivo con ajuste automático de línea (`text-pretty`). |

---

## 4. Comportamiento y Tiempos
* Duración: Permanece visible durante 5000ms (5 segundos) configurados en la variable interna `displayDuration`.
* Barra de Progreso: Se actualiza linealmente restando el tiempo transcurrido cada 10ms utilizando `Date.now()` para asegurar una animación de reducción fluida y sin tirones visuales.
* Cierre Manual: El usuario puede ocultar la alerta antes de que expire el tiempo haciendo clic en el botón de aspa (✕), el cual conmuta instantáneamente el estado `isVisible = false`.