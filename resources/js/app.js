import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import collapse from '@alpinejs/collapse';

// 1. Registrar el plugin en la instancia compartida antes del inicio
Alpine.plugin(collapse);

// 2. Arrancar la instancia única oficial
Livewire.start();