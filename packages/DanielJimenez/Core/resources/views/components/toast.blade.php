@props([
    'type' => 'success',
    'title' => '',
    'message' => ''
])

<div 
    x-data="{ 
        isVisible: false, 
        timeout: null,
        progressInterval: null,
        displayDuration: 5000,
        currentProgress: 100,
        notification: { 
            type: '{{ $type }}', 
            title: '{{ $title }}', 
            message: '{{ $message }}' 
        },

        get style() {
            const map = {
                success: { container: 'bg-success/10', bar: 'bg-success', icon: 'bg-success/15 text-success', text: 'text-success' },
                danger:  { container: 'bg-danger/10',  bar: 'bg-danger',  icon: 'bg-danger/15 text-danger',   text: 'text-danger' },
                error:   { container: 'bg-danger/10',  bar: 'bg-danger',  icon: 'bg-danger/15 text-danger',   text: 'text-danger' },
                info:    { container: 'bg-info/10',    bar: 'bg-info',    icon: 'bg-info/15 text-info',       text: 'text-info' },
                warning: { container: 'bg-warning/10', bar: 'bg-warning', icon: 'bg-warning/15 text-warning', text: 'text-warning' }
            };
            return map[this.notification.type] || map.success;
        },

        startTimeout() {
            this.isVisible = true;
            this.currentProgress = 100;
            const startTime = Date.now();
            
            clearInterval(this.progressInterval);
            clearTimeout(this.timeout);

            this.progressInterval = setInterval(() => {
                const elapsed = Date.now() - startTime;
                this.currentProgress = 100 - (elapsed / this.displayDuration * 100);
                
                if (this.currentProgress <= 0) {
                    this.currentProgress = 0;
                    clearInterval(this.progressInterval);
                }
            }, 10);

            this.timeout = setTimeout(() => {
                this.isVisible = false;
            }, this.displayDuration);
        }
    }"
    x-on:toast.window="
        notification = $event.detail;
        startTimeout();
    "
    x-cloak 
    x-show="isVisible" 
    class="fixed bottom-4 right-4 z-[100] pointer-events-auto max-w-sm rounded-radius bg-surface shadow-2xl dark:bg-surface-dark overflow-hidden border border-zinc-200 dark:border-zinc-700" 
    role="alert" 
    x-transition:enter="transition duration-300 ease-out" 
    x-transition:enter-start="translate-y-8 opacity-0" 
    x-transition:enter-end="translate-y-0 opacity-100" 
    x-transition:leave="transition duration-300 ease-in" 
    x-transition:leave-end="translate-x-24 opacity-0"
>
    <div :class="style.container" class="relative flex w-full flex-col transition-all duration-300">
        
        <div class="flex items-center gap-2.5 p-4">
            <div :class="style.icon" class="rounded-full p-0.5" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path x-show="notification.type === 'success'" fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    <path x-show="['danger', 'error'].includes(notification.type)" fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    <path x-show="notification.type === 'warning'" fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    <path x-show="notification.type === 'info'" fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                </svg>  
            </div>    

            <div class="flex flex-col gap-1">
                <h3 x-show="notification.title" :class="style.text" class="text-sm font-semibold" x-text="notification.title"></h3>
                <p x-show="notification.message" class="text-pretty text-xs opacity-90 text-on-surface dark:text-on-surface-dark" x-text="notification.message"></p>
            </div>

            <button type="button" class="ml-auto opacity-50 hover:opacity-100 text-on-surface dark:text-on-surface-dark" x-on:click="isVisible = false">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" class="size-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="h-1 w-full bg-black/5 dark:bg-white/5" role="progressbar">
            <div 
                :class="style.bar" 
                class="h-full transition-all ease-linear" 
                :style="`width: ${currentProgress}%`"
            ></div>
        </div>
    </div>
</div>