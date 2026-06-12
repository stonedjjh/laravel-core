<?php

namespace App\Livewire;

use Livewire\Component;

class PruebaModal extends Component
{
    public bool $mostrarInfo = false;
    public bool $mostrarSuccess = false;

    protected $listeners = ['ejecutarEliminacion' => 'eliminarRegistro'];

    public function eliminarRegistro($id)
    {
        // Simulamos la operación en el backend y emitimos un Toast para confirmar que llegó el id
        $this->dispatch('toast', 
            type: 'success', 
            message: "Registro ID #{$id} eliminado con éxito desde el Backend."
        );
    }

    public function abrirInfo()
    {
        $this->mostrarInfo = true;
    }

    public function cerrarInfo()
    {
        $this->mostrarInfo = false;
    }

    public function abrirSuccess()
    {
        $this->mostrarSuccess = true;
    }

    public function cerrarSuccess()
    {
        $this->mostrarSuccess = false;
    }

    // Modifica únicamente el método render de tu PruebaModal.php para inyectar la variable de estilo en el botón:

    public function render()
    {
        $styleInfo = \DanielJimenez\Core\Helpers\CoreStyle::type('info');
        $styleSuccess = \DanielJimenez\Core\Helpers\CoreStyle::type('success');

        return <<<HTML
        <div class="flex flex-col gap-2">
            <button wire:click="abrirInfo" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-500 rounded-xl transition shadow-sm">
                Lanzar Modal Informativo
            </button>

            <button wire:click="abrirSuccess" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl transition shadow-sm">
                Lanzar Modal Éxito
            </button>

            {{-- 🌟 NUEVO BOTÓN: Dispara el servicio global de confirmación mediante JS limpio --}}
            <button type="button" 
                    onclick="window.dispatchEvent(new CustomEvent('open-confirmation', { 
                        detail: { 
                            type: 'danger', 
                            title: '¿Eliminar Usuario de Forma Permanente?', 
                            message: 'Esta acción no se puede deshacer. Se borrarán todos los accesos del perfil.', 
                            action: 'ejecutarEliminacion', 
                            id: 45 
                        } 
                    }))" 
                    class="w-full px-4 py-2.5 text-sm font-medium text-white bg-rose-600 hover:bg-rose-500 rounded-xl transition shadow-sm">
                Simular Confirmación Global (Danger)
            </button>

            <x-core::modal id="modalLivewireInfo" title="New Update Available" type="info" wire:model="mostrarInfo">
                A new version of the application is ready for download. Enhance your experience with the latest features and improvements.
                <x-slot:footer>
                    <button type="button" wire:click="cerrarInfo" class="w-full border px-4 py-2 text-center text-sm font-semibold rounded-xl {$styleInfo['button']}">
                        Install Updates Now
                    </button>
                </x-slot:footer>
            </x-core::modal>

            <x-core::modal id="modalLivewireSuccess" title="Transaction Complete" type="success" wire:model="mostrarSuccess">
                Your funds transfer was successful. Check your balance for confirmation.
                <x-slot:footer>
                    <button type="button" wire:click="cerrarSuccess" class="w-full border px-4 py-2 text-center text-sm font-semibold rounded-xl {$styleSuccess['button']}">
                        Go to My Balance
                    </button>
                </x-slot:footer>
            </x-core::modal>
        </div>
        HTML;
    }
}