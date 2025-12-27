<div class="relative min-h-screen bg-white shadow-2xl transition-colors duration-200 dark:bg-background-dark overflow-hidden pb-10">
    <!-- Filter Toggle State -->
    <input class="peer hidden" id="filter-toggle" type="checkbox"/>

    <!-- Header -->
    <header class="sticky top-0 z-40 flex items-center justify-between bg-white/95 p-6 pt-12 text-gray-900 transition-colors backdrop-blur-md dark:bg-background-dark/95 dark:text-white">
        <a href="{{ route('home') }}" class="group flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50 dark:border-gray-800 dark:bg-card-dark dark:hover:bg-gray-800">
            <span class="material-icons text-lg text-gray-700 transition-transform group-hover:scale-110 dark:text-white">arrow_back</span>
        </a>
        <h1 class="font-display text-2xl font-bold">Favorite</h1>
        <label for="filter-toggle" class="group relative z-50 flex h-14 w-14 cursor-pointer items-center justify-center rounded-full border-4 border-white bg-primary text-white shadow-xl shadow-primary/30 transition-all duration-300 hover:scale-110 active:scale-95 dark:border-background-dark box-content">
            <span class="material-icons text-2xl transition-transform duration-500 group-hover:rotate-90">tune</span>
            <span class="absolute right-3.5 top-3.5 h-2.5 w-2.5 rounded-full border border-primary bg-yellow-400"></span>
        </label>
    </header>

    <main class="px-6 pt-2 pb-12">
        <!-- Search Bar -->
        <div class="group relative mb-8 z-30">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <span class="material-icons text-gray-400 transition-colors group-focus-within:text-primary">search</span>
            </div>
            <input 
                wire:model.live.debounce.300ms="term"
                class="block w-full rounded-[1.25rem] border-none bg-gray-50 py-4 pl-12 pr-12 text-sm font-medium text-gray-900 shadow-sm ring-1 ring-gray-200 transition-all placeholder:text-gray-400 focus:ring-2 focus:ring-primary/50 dark:bg-card-dark dark:text-white dark:ring-white/10 outline-none" 
                placeholder="Cari makanan favoritmu..." 
                type="text"
            />
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition-colors hover:bg-gray-100 dark:hover:bg-white/10">
                    <span class="material-icons text-lg">mic</span>
                </button>
            </div>
        </div>

        <!-- Active Deals Info -->
        <div class="relative mb-8 flex items-center justify-between z-30">
            <div class="flex items-center gap-2">
                <span class="material-icons text-sm text-primary">favorite</span>
                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                    {{ count($filteredProducts) }} favorites
                </span>
            </div>
        </div>

        <!-- Grid -->
        <div class="mt-28 grid grid-cols-2 gap-x-5 gap-y-24">
            @foreach($filteredProducts as $item)
                <div wire:key="fav-item-{{ $item->id }}" class="group relative cursor-pointer rounded-[2rem] bg-white p-4 pt-14 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-card-dark">
                    <!-- Image -->
                    <div class="absolute -top-12 left-1/2 z-10 w-28 -translate-x-1/2 overflow-visible">
                         <div class="absolute inset-0 h-28 w-28 translate-y-4 scale-75 transform rounded-full bg-primary/20 blur-2xl transition-transform duration-500 group-hover:scale-90"></div>
                         <div class="relative h-28 w-28">
                            <img 
                                src="{{ $item->image }}" 
                                alt="{{ $item->name }}" 
                                class="h-full w-full rounded-full object-cover shadow-2xl transition-transform duration-500 group-hover:rotate-6"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder-food.svg') }}';"
                            />
                         </div>
                    </div>
                    
                    <!-- Badge -->
                    @if($item->percent)
                    <div class="absolute -top-4 right-2 z-20 rounded-full bg-primary px-2.5 py-1 text-[10px] font-bold text-white shadow-md shadow-primary/30">
                        {{ $item->percent }}% OFF
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="text-center mt-2">
                        <h3 class="mb-1 truncate font-display text-lg font-bold leading-tight text-gray-900 dark:text-white" title="{{ $item->name }}">{{ $item->name }}</h3>
                        <p class="mb-4 text-xs font-medium text-gray-500 dark:text-gray-400 truncate">{{ $item->description ?? 'Enak & Lezat' }}</p>
                        
                        <div class="flex items-end justify-between rounded-xl border border-gray-100 bg-gray-50 p-2 dark:border-white/5 dark:bg-white/5">
                            <div class="flex flex-col text-left">
                                @if($item->is_promo)
                                <span class="text-[10px] text-gray-400 line-through decoration-red-500/50">
                                    {{ 'Rp ' . number_format($item->price, 0, ',', '.') }}
                                </span>
                                <span class="text-lg font-bold text-primary">
                                    {{ 'Rp ' . number_format($item->price_afterdiscount, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="text-lg font-bold text-primary">
                                    {{ 'Rp ' . number_format($item->price, 0, ',', '.') }}
                                </span>
                                @endif
                            </div>
                            <button 
                                wire:click="addItemToCart({{ $item->id }})"
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/30 transition hover:bg-red-700 active:scale-95"
                            >
                                <span class="material-icons text-sm">add</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Filter Sheet Overlay -->
    <label for="filter-toggle" class="fixed inset-0 z-40 bg-black/50 opacity-0 backdrop-blur-sm transition-all duration-300 ease-out pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto"></label>

    <!-- Filter Sheet Panel -->
    <div class="fixed bottom-0 left-0 right-0 z-50 mx-auto flex h-[85vh] w-full max-w-md flex-col translate-y-full rounded-t-[2.5rem] bg-white p-6 pb-10 shadow-2xl transition-transform duration-500 cubic-bezier(0.32,0.72,0,1) peer-checked:translate-y-0 dark:bg-card-dark">
        <div class="mx-auto mb-6 h-1.5 w-12 shrink-0 rounded-full bg-gray-200 dark:bg-gray-700"></div>
        
        <div class="mb-8 flex shrink-0 items-center justify-between px-2">
            <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Filter Search</h2>
            <button 
                wire:click="$set('selectedCategory', null); $set('sort', 'popular'); $set('minPrice', 0); $set('maxPrice', 1000000)"
                type="button"
                class="text-sm font-semibold text-gray-400 transition-colors hover:text-primary"
            >
                Reset
            </button>
        </div>

        <div class="flex-1 space-y-10 overflow-y-auto px-2 pb-6 scrollbar-hide">
            <!-- Categories -->
            <div>
                <h3 class="mb-4 pl-1 text-xs font-bold uppercase tracking-wider text-gray-400">Categories</h3>
                <div class="flex flex-wrap gap-2.5">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="selectedCategory" name="category" value="" class="peer hidden" />
                        <span class="inline-block rounded-xl border border-transparent bg-gray-50 px-5 py-2.5 text-sm font-medium text-gray-600 transition-all hover:border-gray-200 peer-checked:bg-primary peer-checked:font-semibold peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-primary/30 dark:bg-white/5 dark:text-gray-300 dark:hover:border-white/10">
                            All Food
                        </span>
                    </label>
                    @foreach($categories as $category)
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="selectedCategory" name="category" value="{{ $category->id }}" class="peer hidden" />
                        <span class="inline-block rounded-xl border border-transparent bg-gray-50 px-5 py-2.5 text-sm font-medium text-gray-600 transition-all hover:border-gray-200 peer-checked:bg-primary peer-checked:font-semibold peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-primary/30 dark:bg-white/5 dark:text-gray-300 dark:hover:border-white/10">
                            {{ $category->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Sort By -->
            <div>
                <h3 class="mb-4 pl-1 text-xs font-bold uppercase tracking-wider text-gray-400">Sort By</h3>
                <div class="space-y-1">
                    <label class="group flex cursor-pointer items-center justify-between rounded-2xl p-3 transition-colors hover:bg-gray-50 dark:hover:bg-white/5 -mx-2">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-50 text-orange-500 dark:bg-orange-500/10">
                                <span class="material-icons text-xl">local_fire_department</span>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Popular</span>
                        </div>
                        <input type="radio" wire:model.live="sort" name="sort" value="popular" class="h-5 w-5 border-2 border-gray-300 bg-transparent text-primary focus:ring-primary focus:ring-offset-0" />
                    </label>
                    <label class="group flex cursor-pointer items-center justify-between rounded-2xl p-3 transition-colors hover:bg-gray-50 dark:hover:bg-white/5 -mx-2">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-500 dark:bg-blue-500/10">
                                <span class="material-icons text-xl">new_releases</span>
                            </div>
                            <span class="font-medium text-gray-600 transition-colors group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">Newest</span>
                        </div>
                        <input type="radio" wire:model.live="sort" name="sort" value="newest" class="h-5 w-5 border-2 border-gray-300 bg-transparent text-primary focus:ring-primary focus:ring-offset-0" />
                    </label>
                    <label class="group flex cursor-pointer items-center justify-between rounded-2xl p-3 transition-colors hover:bg-gray-50 dark:hover:bg-white/5 -mx-2">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-500 dark:bg-green-500/10">
                                <span class="material-icons text-xl">attach_money</span>
                            </div>
                            <span class="font-medium text-gray-600 transition-colors group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">Price: Low to High</span>
                        </div>
                        <input type="radio" wire:model.live="sort" name="sort" value="price_low" class="h-5 w-5 border-2 border-gray-300 bg-transparent text-primary focus:ring-primary focus:ring-offset-0" />
                    </label>
                </div>
            </div>

            <!-- Price Range (Simple Implementation) -->
            <div>
                <h3 class="mb-6 pl-1 text-xs font-bold uppercase tracking-wider text-gray-400">Price Range</h3>
                <div class="flex justify-between gap-4">
                    <div class="flex-1">
                        <label class="mb-1 block text-[10px] uppercase text-gray-400">Min Price</label>
                        <input type="number" wire:model.live.debounce.500ms="minPrice" class="w-full rounded-xl border border-gray-100 bg-gray-50 px-4 py-2 text-center font-bold text-gray-900 focus:border-primary focus:ring-primary dark:border-white/10 dark:bg-white/5 dark:text-white" />
                    </div>
                    <div class="flex-1">
                        <label class="mb-1 block text-[10px] uppercase text-gray-400">Max Price</label>
                        <input type="number" wire:model.live.debounce.500ms="maxPrice" class="w-full rounded-xl border border-gray-100 bg-gray-50 px-4 py-2 text-center font-bold text-gray-900 focus:border-primary focus:ring-primary dark:border-white/10 dark:bg-white/5 dark:text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Apply Button -->
        <div class="mt-auto shrink-0 border-t border-gray-100 px-2 pt-6 dark:border-white/5">
            <label for="filter-toggle" class="block w-full cursor-pointer rounded-2xl bg-primary py-4 text-center text-lg font-bold text-white shadow-xl shadow-primary/30 transition-all hover:bg-red-700 hover:shadow-2xl active:scale-[0.98]">
                Show {{ count($filteredProducts) }} results
            </label>
        </div>
    </div>
    
    <livewire:components.toast />
</div>
