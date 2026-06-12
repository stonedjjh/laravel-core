import './bootstrap';

// Escuchamos el evento nativo de Livewire antes de que levante su Alpine interno
document.addEventListener('livewire:init', () => {
    // Compartimos la misma instancia global para evitar duplicados
    window.Alpine = Livewire.Alpine;
});