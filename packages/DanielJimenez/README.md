# DanielJimenez Core Library

Librería de componentes atómicos y utilidades arquitectónicas para proyectos basados en Laravel 12 y Tailwind CSS v4.

---

## 1. Instalación del Sistema de Diseño (Tailwind v4)

Para que los componentes de la librería se rendericen con los colores y variantes correctas, es necesario registrar los tokens de diseño en la aplicación principal.

### Configuración de Estilos Básicos

Abre el archivo de estilos global de tu aplicación principal (`resources/css/app.css`) y añade las siguientes directivas para configurar las variantes oscuras y la paleta semántica del sistema:

```css
/* Registro de la variante para modo oscuro nativo en Tailwind v4 */
@custom-variant dark (&:where(.dark, .dark *));

/* Definición del tema semántico de la librería */
@theme {
    /* Tipografía base del sistema */
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';

    /* Capas de Superficie (Fondos de contenedores y vistas) */
    --color-surface: var(--color-stone-50);               /* Fondo principal claro */
    --color-surface-alt: var(--color-stone-200);           /* Fondo alternativo o bordes sutiles */
    --color-on-surface: var(--color-stone-800);            /* Texto estándar sobre superficie */
    --color-on-surface-strong: var(--color-black);         /* Texto de alto contraste (Títulos) */

    /* Identidad de Marca (Acciones principales y secundarias) */
    --color-primary: var(--color-amber-500);               /* Color de énfasis principal (Botones, enlaces) */
    --color-on-primary: var(--color-black);                /* Texto legible sobre fondo primario */
    --color-secondary: var(--color-stone-900);             /* Elementos secundarios de UI */
    --color-on-secondary: var(--color-stone-50);           /* Texto sobre elementos secundarios */

    /* Estados de Foco y Enfoque Accesible */
    --color-outline: transparent;                          /* Contorno transparente inicial */
    --color-outline-strong: var(--color-blue-600);         /* Contorno de accesibilidad para foco de teclado */

    /* Elementos de Acento (Detalles decorativos o específicos) */
    --color-accent: var(--color-neutral-800);
    --color-accent-content: var(--color-neutral-800);
    --color-accent-foreground: var(--color-white);

    /* Estados Semánticos del Sistema (Feedback al usuario) */
    --color-info: var(--color-sky-600);                    /* Mensajes informativos */
    --color-on-info: var(--color-slate-100);               /* Texto sobre fondo informativo */
    --color-success: var(--color-green-600);               /* Estados de éxito, guardado o confirmación */
    --color-on-success: var(--color-white);                /* Texto sobre fondo de éxito */
    --color-warning: var(--color-amber-500);               /* Advertencias o estados pendientes */
    --color-on-warning: var(--color-slate-900);            /* Texto sobre fondo de advertencia */
    --color-danger: var(--color-red-600);                  /* Errores críticos, alertas o destrucciones */
    --color-on-danger: var(--color-slate-100);             /* Texto sobre fondo de error */
}

/* Ajustes de tokens semánticos cuando se activa la clase .dark */
@layer theme {
    .dark {
        --color-accent: var(--color-white);
        --color-accent-content: var(--color-white);
        --color-accent-foreground: var(--color-neutral-800);

        /* Ajustes oscuros para superficies y tipografías */
        --color-surface-dark: var(--color-stone-950);
        --color-surface-dark-alt: var(--color-stone-900);
        --color-on-surface-dark: var(--color-stone-300);
        --color-on-surface-dark-strong: var(--color-white);
        --color-primary-dark: var(--color-amber-400);
        --color-on-primary-dark: var(--color-black);
        --color-secondary-dark: var(--color-stone-700);
        --color-on-secondary-dark: var(--color-white);
        --color-outline-dark: var(--color-stone-700);
        --color-outline-dark-strong: var(--color-blue-500);
    }
}
```

---

## 2. Requisitos e Instalación del Ecosistema Reactivo (Livewire & Alpine.js)

Los componentes dinámicos y asíncronos de esta librería (como el Autocomplete) dependen nativamente de Livewire en el backend y del motor de JavaScript de Alpine.js en el frontend para procesar las directivas `wire:model` y gestionar los estados reactivos.

### Requisito A: Instalar Livewire (Backend)
Ejecuta el siguiente comando en la raíz de la aplicación principal para integrar Livewire en el proyecto:

```bash
composer require livewire/livewire
```

### Requisito B: Instalar e Iniciar Alpine.js (Frontend)

1. **Instalar la Dependencia de Node:**
   Ejecuta el comando en la raíz del proyecto para agregar Alpine mediante npm:
   ```bash
   npm install alpinejs
   ```

2. **Configurar el Bundle Principal:**
   Abre el archivo de JavaScript principal de tu aplicación (`resources/js/app.js`) e inyecta las directivas de inicialización globales:
   ```javascript
    document.addEventListener('livewire:init', () => {
        window.Alpine = Livewire.Alpine;
    });
   ```

3. **Carga en la Plantilla Maestra:**
   Asegúrate de incluir las directivas de Vite junto con los estilos y scripts obligatorios de Livewire dentro del bloque `<head>` de tus layouts principales:
   ```html
   <head>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
       @livewireStyles
   </head>
   <body>
       @livewireScripts
   </body>
   ```