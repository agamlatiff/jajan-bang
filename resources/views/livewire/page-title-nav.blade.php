<header class="sticky top-0 z-30 flex items-center justify-between px-6 py-4 bg-white/90 dark:bg-card-dark/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 transition-all duration-200">
    <!-- Back Button -->
    <div class="flex items-center w-10">
        @if($backUrl)
            <a href="{{ $backUrl }}" class="{{ $hasBack ? 'flex' : 'invisible' }} items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-900 dark:text-white" wire:navigate>
                <span class="material-icons">arrow_back</span>
            </a>
        @else
            <button
                class="{{ $hasBack ? 'flex' : 'invisible' }} items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-900 dark:text-white"
                x-on:click="window.history.back()"
            >
                <span class="material-icons">arrow_back</span>
            </button>
        @endif
    </div>

    <!-- Title -->
    <h1 class="font-display font-bold text-lg text-gray-900 dark:text-white capitalize truncate max-w-[60%] text-center">
        {{ $title }}
    </h1>

    <!-- Right Action (Filter) -->
    <div class="flex items-center justify-end w-10">
        <button
            class="{{ $hasFilter ? 'flex' : 'invisible' }} items-center justify-center w-10 h-10 rounded-full bg-primary text-white shadow-lg shadow-primary/30 hover:bg-red-700 transition-all active:scale-95"
            x-on:click="open = !open"
        >
            <span class="material-icons text-sm">tune</span>
        </button>
    </div>
</header>
