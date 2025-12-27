@props(['allowClose' => true, 'showClose' => true])

<div
    x-cloak
    x-show="open"
    class="fixed inset-0 z-50 flex items-end justify-center sm:items-center"
    role="dialog"
    aria-modal="true"
    @keydown.escape.window="open = false"
>
    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @if($allowClose)
            @click="open = false"
        @endif
        class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
    ></div>

    <!-- Modal Panel -->
    <div
        x-show="open"
        x-trap.noscroll="open"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-y-full sm:translate-y-10 sm:scale-95"
        x-transition:enter-end="translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-y-0 sm:scale-100"
        x-transition:leave-end="translate-y-full sm:translate-y-10 sm:scale-95"
        class="relative w-full max-w-md transform overflow-hidden rounded-t-[2.5rem] bg-white dark:bg-card-dark p-6 pb-10 text-left shadow-2xl transition-all sm:rounded-[2rem]"
    >
        <!-- Drag Handle -->
        <div class="mx-auto mb-6 h-1.5 w-12 shrink-0 rounded-full bg-gray-200 dark:bg-gray-700"></div>

        <div class="mb-6 flex items-center justify-between">
            <h3
                class="{{ isset($title) ? 'block' : 'invisible' }} font-display text-2xl font-bold text-gray-900 dark:text-white"
            >
                {{ $title ?? "Modal" }}
            </h3>
            
            @if ($showClose)
                <button
                    @click="open = false"
                    class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-white/10 dark:hover:bg-white/20 transition-colors"
                >
                    <span class="material-icons text-gray-500 dark:text-white text-sm">close</span>
                </button>
            @endif
        </div>

        <!-- Dialog Body -->
        <div class="max-h-[75vh] overflow-y-auto scrollbar-hide">
            @yield("content")
        </div>
    </div>
</div>

