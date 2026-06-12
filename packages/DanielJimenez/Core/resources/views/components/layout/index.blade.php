@props([
    'logoRoute' => '#',
])

<div x-data="{ showSidebar: false }" class="relative flex w-full flex-col md:flex-row">
    <a class="sr-only" href="#main-content">skip to the main content</a>
    
    <div x-cloak 
         x-show="showSidebar" 
         class="fixed inset-0 z-10 bg-surface-dark/10 backdrop-blur-xs md:hidden" 
         aria-hidden="true" 
         x-on:click="showSidebar = false" 
         x-transition.opacity></div>

    <nav x-cloak 
         class="fixed left-0 z-20 flex h-svh w-60 shrink-0 flex-col border-r border-outline bg-surface-alt p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative dark:border-outline-dark dark:bg-surface-dark-alt" 
         x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'" 
         aria-label="sidebar navigation">
        
        <a href="{{ $logoRoute }}" class="ml-2 w-fit text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
            @if(isset($logo))
                {{ $logo }}
            @else
                <span class="text-xl font-black tracking-wider uppercase">CORE</span>
            @endif
        </a>

        @if(isset($search))
            <div class="relative my-4 flex w-full max-w-xs flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                {{ $search }}
            </div>
        @endif

        <div class="flex flex-col gap-2 overflow-y-auto pb-6">
            <ul class="space-y-1">
                {{ $sidebar }}
            </ul>
        </div>
    </nav>

    <div id="main-content" class="h-svh w-full overflow-y-auto p-6 bg-white dark:bg-neutral-950 text-on-surface dark:text-on-surface-dark">
        {{ $slot }}
    </div>

    <button class="fixed right-4 top-4 z-20 rounded-full bg-primary p-4 md:hidden text-on-primary dark:bg-primary-dark dark:text-on-primary-dark shadow-md" 
            x-on:click="showSidebar = ! showSidebar">
        <svg x-show="showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
        </svg>
        <svg x-show="! showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
            <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z"/>
        </svg>
        <span class="sr-only">sidebar toggle</span>
    </button>
</div>