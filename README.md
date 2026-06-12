# Laravel Core Component Library

Librería de componentes arquitectónicos atómicos, reactivos y utilidades desacopladas basada en el **TALL Stack** nativo (Tailwind CSS v4, Alpine.js, Laravel 12 y Livewire 4).

Este repositorio actúa como el paquete núcleo (`core`) del ecosistema, diseñado bajo principios de Clean Architecture para garantizar un bajo acoplamiento, máxima reusabilidad y el máximo aprovechamiento de las capacidades reactivas nativas de Laravel sin dependencias externas pesadas.

---

## Filosofía de Desarrollo

Para mantener la rama principal (`main`) 100% estable y lista para producción, adoptamos un flujo de trabajo estricto basado en ramas de características (`feature branches`):

1. **Aislamiento:** Cada nuevo componente, utilidad o refactorización se desarrolla en su propia rama dedicada (ej. `feature/componente-autocomplete`).
2. **Documentación Modular:** Cada componente integrado contiene su propio archivo `README.md` local dentro de su directorio, detallando su API, propiedades, dependencias y ejemplos de uso.
3. **Integración:** Una vez el componente es completamente funcional, probado y libre de errores en su entorno aislado, se integra a la rama `main`.

---

## Estructura del Repositorio

```text
laravel-core/
├── packages/
│   └── DanielJimenez/
│       └── Core/
│           ├── resources/
│           │   └── views/
│           │       └── components/   # Componentes Blade/Livewire/Alpine
│           │           └── toast/    # Ejemplo: Directorio del componente Toast
│           │               ├── autocomplete.blade.php
│           │               └── README.md  <-- Documentación y ejemplos específicos
│           └── src/                  # Lógica de Backend y Service Providers
├── README.md                         # Documentación global del ecosistema
└── LICENSE                           # Licencia del software