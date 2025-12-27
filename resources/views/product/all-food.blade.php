<div class="min-h-screen bg-white pb-12 text-gray-900 transition-colors duration-200 dark:bg-background-dark dark:text-white">
    <!-- Header -->
    <header class="sticky top-0 z-40 flex items-center justify-between bg-white/95 p-6 pt-8 backdrop-blur-md dark:bg-background-dark/95 transition-all">
        <a href="{{ route('home') }}" wire:navigate class="group flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50 dark:border-gray-800 dark:bg-card-dark dark:hover:bg-gray-800">
            <span class="material-icons text-lg text-gray-700 transition-transform group-hover:scale-110 dark:text-white">arrow_back</span>
        </a>
        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">All Foods</h1>
        <button 
            @click="$dispatch('open-modal', 'filter-modal')"
            class="group relative z-50 box-content flex h-14 w-14 cursor-pointer items-center justify-center rounded-full border-4 border-white bg-primary text-white shadow-xl shadow-primary/30 transition-all duration-300 active:scale-95 hover:scale-110 dark:border-background-dark"
        >
            <span class="material-icons text-2xl transition-transform duration-500 group-hover:rotate-90">tune</span>
            @if(count($selectedCategories) > 0)
                <span class="absolute right-3.5 top-3.5 h-2.5 w-2.5 rounded-full border border-primary bg-yellow-400"></span>
            @endif
        </button>
    </header>

    <main class="px-6 pb-12 pt-2">
        <!-- Search -->
        <div class="group relative mb-8 z-30">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <span class="material-icons text-gray-400 transition-colors group-focus-within:text-primary">search</span>
            </div>
            <input 
                wire:model.live.debounce.300ms="term"
                class="block w-full rounded-[1.25rem] border-none bg-white py-4 pl-12 pr-12 text-sm font-medium text-gray-900 shadow-md ring-1 ring-gray-200 transition-all placeholder-gray-400 focus:ring-2 focus:ring-primary/50 dark:bg-card-dark dark:text-white dark:ring-white/10 dark:placeholder-gray-400 outline-none" 
                placeholder="Find your favorite food..." 
                type="text"
            />
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition-colors hover:bg-gray-100 dark:hover:bg-white/10">
                    <span class="material-icons text-lg">mic</span>
                </button>
            </div>
        </div>

        <!-- Info/Stats -->
        <div class="relative z-30 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-icons text-sm text-primary">local_offer</span>
                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                    {{ isset($filteredProducts) ? $filteredProducts->count() : 0 }} items found
                </span>
            </div>
        </div>

        <!-- Grid -->
        <div class="mt-28 grid grid-cols-2 gap-x-5 gap-y-24 sm:grid-cols-3 sm:gap-y-28">
            @if (isset($filteredProducts) && count($filteredProducts) > 0)
                @foreach ($filteredProducts as $food)
                    <div class="min-w-0">
                        <livewire:components.food-card
                            wire:key="all-{{ $food->id }}"
                            :data="$food"
                            :categories="$categories"
                        />
                    </div>
                @endforeach
            @else
                <div class="col-span-2 flex flex-col items-center justify-center py-12 text-center sm:col-span-3">
                    <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-50 dark:bg-white/5">
                         <span class="material-icons text-4xl text-gray-300">search_off</span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">No food available</p>
                </div>
            @endif
        </div>
    </main>

    <livewire:components.filter-modal
        :selectedCategories="$selectedCategories"
        :categories="$categories"
        wire:key="filter-modal"
    />
</div>
