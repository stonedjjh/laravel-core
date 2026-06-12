# Ecosistema de Layout Compuesto (`<x-core::layout>`)

Conjunto de componentes integrados y encapsulados para la maquetación del viewport principal del Panel de Administración. Combina la estructura responsiva off-canvas de Penguin UI con las directivas de seguridad por roles del backend.

---

## 🚨 Requisito de Dependencia (Alpine.js)

Para que las carpetas colapsables (`<x-core::layout.accordion>`) se expandan y contraigan correctamente, **es obligatorio** tener instalado el plugin `@alpinejs/collapse` en el proyecto principal.



## 1. Estructura de Archivos

```text
layout/
├── index.blade.php      # Contenedor maestro de la aplicación (Layout principal)
├── simple.blade.php     # Ítem de menú directo con control de roles
└── accordion.blade.php  # Carpeta colapsable para submenús con control de roles
```

## 2. API y Propiedades de los Componentes

### A. Contenedor Maestro (`index.blade.php`)

Mapeado en la aplicación como `<x-core::layout>`.

### Propiedades (`@props`)

- **logoRoute** (string, por defecto: '#'): Ruta de Laravel a la que redirigirá el logotipo superior.

- **Slots Semánticos**

   - `{{ $logo }}` (opcional): Reemplaza el texto por defecto del logo (útil para inyectar imágenes o SVG corporativos).

   - `{{ $search }}` (opcional): Espacio reservado sobre el menú para la barra de búsqueda global.

   - `{{ $sidebar }}` (requerido): Contenedor de la lista de navegación donde se instancian los ítems del menú.

   - `{{ $slot }}` (requerido): Cuerpo principal donde se renderizarán las vistas y tarjetas de la aplicación.

## B. Ítem de Menú Simple (`simple.blade.php`)

Mapeado en la aplicación como `<x-core::layout.simple>`.

Propiedades (`@props`)

- **ruta (string, requerido):** Nombre de la ruta interna de Laravel.

- **textoMenu (string, por defecto: 'Menú'):** Nombre visible en la barra lateral.

- **icono (string, por defecto: 'fa-star'):** Clase de FontAwesome v6 para el glifo.

- **roles (array|string, opcional):** Roles permitidos para ver el ítem (Inclusión).

- **exceptRoles (array|string, opcional):** Roles restringidos que no verán el ítem (Exclusión).

- **noParaSupervisor (boolean, por defecto: false):** Atajo defensivo para bloquear al rol 'Supervisor'.

## C. Carpeta Acordeón (`accordion.blade.php`)

Mapeado en la aplicación como <`x-core::layout.accordion`>.

Propiedades (`@props`)

- **titulo (string, por defecto: 'Menú Acordeón'):** Texto de la carpeta colapsable.

- **icono (string, por defecto: 'fa-folder'):** Icono representativo del módulo.

- **Soporta las mismas propiedades de seguridad que el ítem simple:** roles, exceptRoles y noParaSupervisor.

### 3. Ejemplo de Implementación Completa

```HTML
<x-core::layout logoRoute="dashboard.index">
    
    <x-slot:logo>
        <span class="text-lg font-black tracking-wider text-amber-500">SYSTEM-CORE</span>
    </x-slot:logo>

    <x-slot:search>
        <input type="search" placeholder="Buscar módulo..." class="w-full border rounded-xl bg-surface px-3 py-1.5 text-sm focus:outline-none" />
    </x-slot:search>

    <x-slot:sidebar>
        <x-core::layout.simple ruta="dashboard.index" icono="fa-chart-pie" textoMenu="Dashboard" />
        
        <x-core::layout.accordion titulo="Administración" icono="fa-shield-halved" exceptRoles="Operador">
            <x-core::layout.simple ruta="usuarios.index" icono="fa-users" textoMenu="Usuarios" />
            <x-core::layout.simple ruta="config.index" icono="fa-sliders" textoMenu="Parámetros" />
        </x-core::layout.accordion>
    </x-slot:sidebar>

    <div class="p-6 bg-surface-alt rounded-2xl border">
        <h1 class="text-xl font-bold">Bienvenido al Panel de Control</h1>
    </div>

</x-core::layout>
```