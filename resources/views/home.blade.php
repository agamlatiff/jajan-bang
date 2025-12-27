<div class="min-h-screen bg-white pb-24 text-gray-900 transition-colors duration-200 dark:bg-background-dark dark:text-white">
    <!-- Header -->
    <header class="sticky top-0 z-30 flex items-center justify-between bg-white/90 p-6 pt-8 backdrop-blur-md dark:bg-background-dark/90 transition-all">
        <div class="flex items-center gap-2">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">
                Jajan<span class="text-primary">Bang</span>
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 overflow-x-auto bg-linear-to-r from-primary-60 to-primary-50 px-4 py-3 text-white no-scrollbar">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Meja</span>
                <span class="font-bold text-primary">{{ $tableNumber }}</span>
            </div>
            <button class="relative rounded-full p-2 transition hover:bg-gray-100 dark:hover:bg-gray-800">
                <span class="material-icons text-gray-600 dark:text-gray-300">notifications_none</span>
                <span class="absolute right-2 top-2 h-2 w-2 rounded-full border-2 border-white bg-primary dark:border-background-dark"></span>
            </button>
        </div>
    </header>

    <main x-data="{ open: @entangle('isCustomerDataComplete') }">
        <!-- Hero & Search -->
        <div class="mb-8 px-6">
            <h2 class="mb-4 font-display text-3xl font-bold leading-tight">
                Mau Pesan Apa<br />hari ini?
            </h2>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <!-- Search Input -->
                <input
                    class="block w-full rounded-2xl border-none bg-gray-50 py-3.5 pl-12 pr-4 text-sm shadow-sm transition-all focus:ring-2 focus:ring-primary dark:bg-card-dark dark:text-white dark:placeholder-gray-400"
                    placeholder="Cari makanan, minuman..."
                    type="text"
                    wire:model.live.debounce.300ms="term"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                    <button 
                        @click="$dispatch('open-modal', 'filter-modal')"
                        class="rounded-xl bg-primary p-2 text-white shadow-lg shadow-primary/30 active:scale-95 transition-transform"
                    >
                        <span class="material-icons text-sm">tune</span>
                    </button>
                </div>
            </div>
        </div>

        <div wire:loading.remove>
            @if ($term == "")
                <!-- Today's Promo -->
                <section class="mb-8">
                    <div class="mb-4 flex items-end justify-between px-6">
                        <div>
                            <h3 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Today's promo</h3>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Don't miss out on these daily deals</p>
                        </div>
                        <a href="{{ route('product.promo') }}" wire:navigate class="flex items-center gap-0.5 text-sm font-bold text-primary transition-colors hover:text-red-700">
                            See More <span class="material-icons text-sm">chevron_right</span>
                        </a>
                    </div>
                    
                    <!-- Carousel -->
                    <div class="scrollbar-hide flex snap-x snap-mandatory gap-6 overflow-x-auto px-6 pb-12 pt-16">
                        @if (isset($promos) && count($promos) > 0)
                            @foreach ($promos as $promo)
                                <!-- Wrapper for FoodCard to enforce carousel width -->
                                <div class="min-w-[85%] snap-center sm:min-w-[320px]">
                                    <livewire:components.food-card
                                        wire:key="promo-{{ $promo->id }}"
                                        :data="$promo"
                                        :categories="$categories"
                                    />
                                </div>
                            @endforeach
                        @else
                            <div class="w-full text-center py-8 text-gray-400 italic">
                                Belum ada promo tersedia
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Special Offer Banner -->
                <section class="mb-12 px-6">
                    <div class="group relative flex min-h-[220px] w-full items-center overflow-hidden rounded-[2rem] bg-gray-900 shadow-2xl">
                        <div class="absolute inset-0">
                            <img 
                                alt="Indonesian Food Spread" 
                                class="h-full w-full object-cover opacity-80 transition-transform duration-700 ease-out group-hover:scale-105" 
                                src="{{ asset('assets/images/bg-container.png') }}"
                            />
                            <div class="absolute inset-0 bg-linear-to-r from-black via-black/70 to-transparent"></div>
                        </div>
                        <div class="relative z-10 flex h-full w-full max-w-[80%] flex-col justify-center px-8 py-8">
                            <div class="mb-3 flex items-center gap-2">
                                <div class="h-0.5 w-6 bg-primary"></div>
                                <span class="text-xs font-bold uppercase tracking-widest text-primary drop-shadow-md">Special Offer</span>
                            </div>
                            <h3 class="mb-2 font-display text-3xl font-bold leading-tight text-white drop-shadow-lg">
                                Cita Rasa <br /><span class="text-primary-400">Lokal</span>
                            </h3>
                            <p class="mb-6 max-w-[90%] text-sm font-medium leading-relaxed text-gray-200 drop-shadow-md">
                                Rasakan kelezatan rempah nusantara dalam setiap gigitan.
                            </p>
                            <div>
                                <a 
                                    href="{{ route('product.index') }}"
                                    wire:navigate
                                    class="inline-flex transform items-center gap-2 rounded-full bg-white px-6 py-3 text-xs font-bold text-gray-900 shadow-lg transition-all hover:scale-105 hover:bg-gray-200 hover:shadow-xl"
                                >
                                    Lihat Semua Menu
                                    <span class="material-icons text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Favorite Food -->
                <section class="mb-24">
                    <div class="mb-4 flex items-center justify-between px-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Favorite Food</h3>
                        <a href="{{ route('product.favorite') }}" wire:navigate class="text-sm font-medium text-primary hover:underline">See More</a>
                    </div>
                    <div class="flex flex-col gap-4 px-6">
                        @if (isset($favorites) && count($favorites) > 0)
                            @foreach ($favorites as $favorite)
                                <div 
                                    wire:click="$dispatch('open-modal', 'detail-modal-{{ $favorite->id }}')" 
                                    class="flex cursor-pointer items-center rounded-2xl bg-white p-3 shadow-sm transition hover:shadow-md dark:bg-card-dark"
                                >
                                    <div class="shrink-0 h-20 w-20 overflow-hidden rounded-xl bg-gray-100">
                                        <img 
                                            alt="{{ $favorite->name }}" 
                                            class="h-full w-full object-cover" 
                                            src="{{ str_starts_with($favorite->image, 'http') ? $favorite->image : Storage::url($favorite->image) }}"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $favorite->name }}</h4>
                                        <div class="my-1 flex items-center gap-1">
                                            <span class="material-icons text-xs text-yellow-400">star</span>
                                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">4.8</span>
                                            <span class="text-xs text-gray-400">(120+)</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-primary">
                                                {{ number_format($favorite->price, 0, ",", ".") }}
                                            </span>
                                            <button 
                                                class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 text-gray-400 transition hover:border-primary hover:bg-primary hover:text-white dark:border-gray-700"
                                            >
                                                <span class="material-icons text-sm">add</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-gray-400 italic">No favorite food yet</div>
                        @endif
                    </div>
                </section>
            @else
                <!-- Search Results Grid -->
                @if ($searchResult->isEmpty())
                     <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                        <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-50 dark:bg-white/5">
                             <span class="material-icons text-4xl text-gray-300">search_off</span>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Makanan Tidak Ditemukan</h3>
                        <p class="mb-6 max-w-xs text-sm text-gray-500 dark:text-gray-400">
                            Coba cari dengan kata kunci lain atau lihat semua menu kami
                        </p>
                        <a href="{{ route('product.index') }}" wire:navigate class="text-primary font-semibold hover:underline">
                            Lihat Semua Menu →
                        </a>
                    </div>
                @else
                    <div class="mb-8 mt-4 px-6">
                        <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">
                            Hasil pencarian: "{{ $term }}"
                        </h3>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach ($searchResult as $result)
                                <div class="min-w-0">
                                    <livewire:components.food-card
                                        wire:key="search-{{ $result->id }}"
                                        :data="$result"
                                        :categories="$categories"
                                    />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div x-show="open">
            <livewire:components.customer-modal />
        </div>
        
        <livewire:filter-modal :categories="$categories" />
    </main>
</div>
