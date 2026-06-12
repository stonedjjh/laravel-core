<?php

namespace App\Livewire;

use Livewire\Component;

class PruebaModal extends Component
{
    public bool $mostrarInfo = false;
    public bool $mostrarSuccess = false;
    public string $nombre = '';
    public string $correo = '';

    protected $listeners = ['ejecutarEliminacion' => 'eliminarRegistro'];

    public function eliminarRegistro($id)
    {
        // 🌟 SIMULACIÓN DE LATENCIA: Forzamos 2 segundos de espera en el servidor
        sleep(2);

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

    public function guardarUsuario()
    {
        sleep(2); // Simulamos procesamiento pesado en el servidor

        // Limpiamos inputs y mandamos feedback
        $this->reset(['nombre', 'correo']);
        $this->dispatch('toast', type: 'success', message: "Usuario registrado con éxito.");
    }

    // Modifica únicamente el método render de tu PruebaModal.php para inyectar la variable de estilo en el botón:

    public function render()
    {
        $styleInfo = \DanielJimenez\Core\Helpers\CoreStyle::type('info');
        $styleSuccess = \DanielJimenez\Core\Helpers\CoreStyle::type('success');

        return <<<HTML
        <div class="flex flex-col gap-6">
            {{-- SECCIÓN anterior de los botones de Modales --}}
            <div class="flex flex-col gap-2">
                <button wire:click="abrirInfo" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-500 rounded-xl transition shadow-sm">
                    Lanzar Modal Informativo
                </button>

                <button wire:click="abrirSuccess" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl transition shadow-sm">
                    Lanzar Modal Éxito
                </button>

                <button type="button" 
                        onclick="window.dispatchEvent(new CustomEvent('open-confirmation', { 
                            detail: { 
                                type: 'danger', 
                                title: '¿Eliminar Usuario?', 
                                message: 'Esta acción no se puede deshacer.', 
                                action: 'ejecutarEliminacion', 
                                id: 45 
                            } 
                        }))" 
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-rose-600 hover:bg-rose-500 rounded-xl transition shadow-sm">
                    Simular Confirmación Global (Danger)
                </button>
            </div>

            <hr class="border-zinc-200 dark:border-zinc-800" />

            {{-- 🌟 FORMULARIO DE PRUEBA DE INFRAESTRUCTURA --}}
            <div class="p-5 bg-zinc-50 dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800">
                <h4 class="text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3 tracking-wide uppercase text-xs">
                    Muestra del Loading Container
                </h4>
                
                <x-core::loading-container target="guardarUsuario">
                    <form wire:submit="guardarUsuario" class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-zinc-500 mb-1">Nombre Completo</label>
                            <input type="text" wire:model="nombre" required class="w-full text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-2.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-zinc-500" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-zinc-500 mb-1">Correo Electrónico</label>
                            <input type="email" wire:model="correo" required class="w-full text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-2.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-zinc-500" />
                        </div>

                        <button type="submit" class="w-full mt-2 px-4 py-2 text-sm font-semibold text-white bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200 rounded-xl transition">
                            Guardar Registro
                        </button>
                    </form>
                </x-core::loading-container>
            </div>

            <x-core::modal id="modalLivewireInfo" title="New Update Available" type="info" wire:model="mostrarInfo">
                A new version of the application is ready for download.
                <x-slot:footer>
                    <button type="button" wire:click="cerrarInfo" class="w-full border px-4 py-2 text-center text-sm font-semibold rounded-xl {$styleInfo['button']}">
                        Install Updates Now
                    </button>
                </x-slot:footer>
            </x-core::modal>

            <x-core::modal id="modalLivewireSuccess" title="Transaction Complete" type="success" wire:model="mostrarSuccess">
                Your funds transfer was successful.
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