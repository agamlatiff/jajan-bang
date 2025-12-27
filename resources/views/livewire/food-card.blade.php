<div
    wire:click="showDetails"
    class="{{ $isGrid ? 'h-full' : '' }} relative col-span-1 flex min-w-[40%] flex-1 flex-col rounded-[2rem] bg-white p-4 pt-14 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-card-dark group cursor-pointer"
>
    <!-- Floating Image -->
    <div class="absolute -top-12 left-1/2 z-10 h-28 w-28 -translate-x-1/2">
        <div class="absolute inset-0 scale-75 transform rounded-full bg-primary/20 blur-2xl transition-transform duration-500 group-hover:scale-90"></div>
        @php
            $imageUrl = str_starts_with($data->image, 'http') ? $data->image : Storage::url($data->image);
        @endphp
        <img
            src="{{ $imageUrl }}"
            alt="{{ $data->name }}"
            loading="lazy"
            decoding="async"
            fetchpriority="low"
            class="relative h-full w-full rounded-full object-cover shadow-2xl transition-transform duration-500 group-hover:rotate-6"
            onerror="this.onerror=null; this.src='{{ asset('assets/images/placeholder-food.svg') }}'; this.classList.add('p-4');"
        />
    </div>

    <!-- Promo Badge -->
    @if ($data->is_promo)
        <div class="absolute -top-4 right-2 z-20 rounded-full bg-primary px-2.5 py-1 text-[10px] font-bold text-white shadow-md shadow-primary/30">
            {{ $data->percent }}% OFF
        </div>
    @endif

    <!-- Content -->
    <div class="text-center mt-2">
        <h3 class="mb-1 truncate font-display text-lg font-bold leading-tight text-gray-900 dark:text-white">
            {{ $data->name }}
        </h3>
        <p class="mb-4 text-xs font-medium text-gray-500 dark:text-gray-400">
            {{ $matchedCategory ? $matchedCategory->name : "Menu" }}
        </p>

        <!-- Price & Action -->
        <div class="flex items-end justify-between rounded-xl border border-gray-100 bg-gray-50 p-2 dark:border-white/5 dark:bg-white/5">
            <div class="flex flex-col text-left">
                @if ($data->is_promo)
                    <span class="text-[10px] text-gray-400 line-through decoration-red-500/50">
                        {{ number_format($data->price, 0, ",", ".") }}
                    </span>
                    <span class="text-lg font-bold text-primary">
                        {{ number_format($data->price_afterdiscount, 0, ",", ".") }}
                    </span>
                @else
                    <span class="text-lg font-bold text-primary">
                        {{ number_format($data->price, 0, ",", ".") }}
                    </span>
                @endif
            </div>
            
            <button class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/30 transition hover:bg-red-700 active:scale-95">
                <span class="material-icons text-sm">add</span>
            </button>
        </div>
    </div>
</div>
