<div class="relative min-h-screen bg-white pb-28 shadow-2xl transition-colors duration-200 dark:bg-background-dark overflow-hidden">
    <!-- Header -->
    <header class="sticky top-0 z-40 flex items-center justify-between bg-white/95 px-6 pt-12 pb-4 backdrop-blur-md transition-colors dark:bg-background-dark/95">
        <button 
            @click="history.back()" 
            class="group flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50 dark:border-gray-800 dark:bg-card-dark dark:hover:bg-gray-800"
        >
            <span class="material-icons text-lg text-gray-700 transition-transform group-hover:-translate-x-0.5 dark:text-white">arrow_back</span>
        </button>
        <h1 class="font-sans text-lg font-bold text-gray-900 dark:text-white">Food Detail</h1>
        <button class="flex h-10 w-10 items-center justify-center rounded-full transition hover:bg-gray-50 dark:hover:bg-gray-800">
            <span class="material-icons text-gray-700 dark:text-white">favorite_border</span>
        </button>
    </header>

    <!-- Main Content -->
    <div class="px-6 mt-2 relative z-10 w-full max-w-md mx-auto">
        <!-- Image Section -->
        <div class="group relative aspect-4/3 w-full overflow-hidden rounded-[2rem] shadow-2xl">
            <div class="absolute inset-0 z-10 bg-linear-to-t from-black/40 via-transparent to-transparent"></div>
            <img 
                src="{{ str_starts_with($food->image, 'http') ? $food->image : Storage::url($food->image) }}" 
                alt="{{ $food->name }}" 
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder-food.svg') }}';"
            />
        </div>
    </div>

    <div class="mt-8 px-6 w-full max-w-md mx-auto">
        <div class="flex flex-col gap-1">
            <!-- Tags -->
            <div class="mb-4 flex items-center gap-3">
                @if($food->total_sold > 0)
                <div class="flex items-center gap-1 rounded-full border border-orange-200 bg-orange-100 px-3 py-1 dark:border-orange-500/30 dark:bg-orange-500/20">
                    <span class="material-icons text-[14px] text-orange-600 dark:text-orange-400">local_fire_department</span>
                    <span class="text-xs font-bold text-orange-700 dark:text-orange-300">{{ $food->total_sold }}+ Terjual</span>
                </div>
                @endif
                
                @if($food->percent)
                <div class="flex items-center gap-1 rounded-full bg-primary px-3 py-1 shadow-lg shadow-primary/30">
                    <span class="material-icons text-[14px] text-white">percent</span>
                    <span class="text-xs font-bold text-white">{{ $food->percent }}% OFF</span>
                </div>
                @endif
            </div>

            <!-- Title & Subtitle -->
            <h2 class="font-display text-3xl font-bold leading-tight text-gray-900 dark:text-white">
                {{ $food->name }}
            </h2>
            <p class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ $matchedCategory ? $matchedCategory->name : 'Menu' }} • Lezat
            </p>

            <!-- Price -->
            <div class="mt-6 flex items-end gap-3 border-b border-gray-200 pb-6 dark:border-gray-800">
                <div class="flex flex-col">
                    @if($food->is_promo)
                        <span class="text-sm font-medium text-gray-400 line-through decoration-red-500/50">
                            {{ 'Rp ' . number_format($food->price, 0, ',', '.') }}
                        </span>
                        <span class="text-3xl font-bold text-primary">
                            {{ 'Rp ' . number_format($food->price_afterdiscount, 0, ',', '.') }}
                        </span>
                    @else
                        <span class="text-3xl font-bold text-primary">
                            {{ 'Rp ' . number_format($food->price, 0, ',', '.') }}
                        </span>
                    @endif
                </div>
                <span class="mb-2 text-xs font-medium text-gray-400">/ porsi</span>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <h3 class="mb-2 font-bold text-gray-900 dark:text-white">Description</h3>
                <div class="text-sm leading-relaxed text-gray-600 dark:text-gray-400 prose dark:prose-invert">
                    {!! $food->description !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Footer -->
    <div class="fixed bottom-0 left-0 right-0 z-50 mx-auto max-w-md border-t border-gray-100 bg-white p-6 pt-4 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] dark:border-gray-800 dark:bg-card-dark dark:shadow-none">
        <div class="flex items-center gap-4">
            <button 
                wire:click="addToCart"
                wire:loading.attr="disabled"
                class="flex h-12 flex-1 items-center justify-center gap-2 rounded-xl border border-gray-200 transition-all hover:bg-gray-50 active:scale-95 disabled:opacity-70 dark:border-gray-700 dark:hover:bg-white/5"
            >
                <span wire:loading.remove wire:target="addToCart" class="flex items-center gap-2">
                    <span class="material-icons text-sm text-primary">shopping_bag</span>
                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Tambah</span>
                </span>
                <span wire:loading wire:target="addToCart">
                   <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>

            <button 
                wire:click="orderNow"
                wire:loading.attr="disabled"
                class="flex h-12 flex-1 items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/30 transition-all hover:bg-red-700 active:scale-95 disabled:opacity-70"
            >
                <span wire:loading.remove wire:target="orderNow" class="text-sm font-bold">Pesan Sekarang</span>
                <span wire:loading wire:target="orderNow">
                   <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>

    <!-- Background Decor -->
    <div class="pointer-events-none fixed -left-12 top-20 z-0 h-64 w-64 opacity-[0.03] dark:opacity-[0.05]">
        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBz0KBRRFfQ8CYSyo_amM-FPJ0RGrqTfs8n7jsqr1ujm7WDb3P5WEX6M1unHkX503391Pi9rbs9kAfF8is-n5rwv0703Vynil5UeqGnZsdaabbbfWaVotC77Rcl5VrvQslFP1gqNH-oeF_yU3ayrHVYaO84qQC120irZ0GgfpbBF2kHbGNNbwV7pjKvI5U3SNgvws_W45Zdwtc_YFhEMn24gN0g3eF0j022li1HiV2Bw6UT0XEF7Goju2vcT1guHRMCTZB3ScCA" alt="Decor" class="h-full w-full rotate-45 object-contain" />
    </div>

    <livewire:components.toast />
</div>