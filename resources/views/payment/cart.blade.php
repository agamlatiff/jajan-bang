<div class="min-h-screen bg-white pb-32 text-gray-900 transition-colors duration-200 dark:bg-background-dark dark:text-white font-sans">
    <!-- Header -->
    <header class="sticky top-0 z-40 flex items-center justify-between border-b border-gray-100/50 bg-white/95 p-6 pt-8 backdrop-blur-md transition-colors dark:border-white/5 dark:bg-background-dark/95">
        <a href="{{ route('home') }}" class="group flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50 dark:border-gray-800 dark:bg-card-dark dark:hover:bg-gray-800">
            <span class="material-icons text-lg text-gray-700 transition-transform group-hover:scale-110 dark:text-white">arrow_back</span>
        </a>
        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Keranjang</h1>
        <div class="w-10"></div> 
    </header>

    <main class="px-6 pt-6">
        @if(count($cartItems) > 0)
            <!-- Selection Control -->
            <div class="mb-4 flex items-center justify-between px-1">
                <label class="group flex cursor-pointer items-center gap-3">
                    <input 
                        type="checkbox" 
                        wire:model.live="selectAll"
                        class="form-checkbox h-5 w-5 rounded border-gray-300 bg-transparent text-primary transition focus:ring-primary"
                    />
                    <span class="text-sm font-semibold text-gray-600 transition-colors group-hover:text-primary dark:text-gray-300">Pilih Semua</span>
                </label>
                @if(count($selectedItems) > 0)
                    <button wire:click="deleteSelected" class="text-xs font-medium text-primary hover:underline">Hapus Pilihan</button>
                @endif
            </div>

            <!-- Cart Items -->
            <div class="space-y-5">
                @foreach($cartItems as $index => $item)
                    <div wire:key="cart-item-{{ $index }}" class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white p-3 shadow-sm transition-transform hover:-translate-y-0.5 dark:border-white/5 dark:bg-card-dark">
                        <div class="pl-2">
                            <input 
                                type="checkbox" 
                                wire:model.live="cartItems.{{ $index }}.selected"
                                wire:change="updateSelectedItems"
                                class="form-checkbox h-5 w-5 rounded border-gray-300 bg-transparent text-primary focus:ring-primary"
                            />
                        </div>
                        <div class="relative h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-gray-100">
                            <img 
                                src="{{ $item['image_url'] ?? 'https://via.placeholder.com/150' }}" 
                                alt="{{ $item['name'] }}" 
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />
                        </div>
                        <div class="flex-1 min-w-0 pr-1">
                            <h3 class="truncate font-display text-lg font-bold leading-tight text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">
                                {{ isset($item['note']) ? $item['note'] : '' }}
                            </p>
                            <div class="flex items-end justify-between">
                                <p class="text-base font-bold text-primary">
                                    {{ 'Rp ' . number_format($item['price'], 0, ',', '.') }}
                                </p>
                                <div class="flex items-center gap-2 rounded-lg border border-gray-200 bg-gray-100 px-1 py-1 dark:border-white/5 dark:bg-white/5">
                                    <button 
                                        wire:click="decrement({{ $index }})"
                                        class="flex h-6 w-6 items-center justify-center rounded text-gray-500 shadow-sm transition hover:bg-white hover:text-primary dark:text-gray-300 dark:hover:bg-white/10"
                                    >
                                        <span class="material-icons text-sm">remove</span>
                                    </button>
                                    <span class="w-4 text-center text-sm font-semibold">{{ $item['quantity'] }}</span>
                                    <button 
                                        wire:click="increment({{ $index }})"
                                        class="flex h-6 w-6 items-center justify-center rounded text-gray-500 shadow-sm transition hover:bg-white hover:text-primary dark:text-gray-300 dark:hover:bg-white/10"
                                    >
                                        <span class="material-icons text-sm">add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-12 px-6 text-center animate-fade-in">
                <div class="bg-white dark:bg-card-dark rounded-full flex items-center justify-center mb-6 shadow-xl relative animate-pulse w-40 h-40">
                    <span class="material-icons text-6xl text-gray-300 dark:text-gray-600">shopping_bag</span>
                    <div class="absolute bottom-10 right-8 w-3 h-3 bg-primary rounded-full"></div>
                </div>
                <h2 class="font-display font-bold text-3xl text-gray-900 dark:text-white mb-3">Keranjang kosong</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-xs leading-relaxed">
                    Kamu belum menambahkan makanan apapun. Yuk, cari jajanan enak sekarang!
                </p>
                <a href="{{ route('home') }}" class="w-full bg-primary text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary/30 hover:bg-red-700 transition block">
                    Lihat Menu
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    @if(count($cartItems) > 0)
        <div class="fixed bottom-0 left-0 right-0 z-50 mx-auto max-w-md rounded-t-[2rem] border-t border-gray-100 bg-white p-6 shadow-[0_-8px_30px_rgba(0,0,0,0.08)] transition-colors dark:border-white/5 dark:bg-[#1E1E1E]">
            <div class="mb-5 flex items-center justify-between">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total ({{ count($cartItems) }} Items)</span>
                @php
                    $total = collect($cartItems)->sum(function($item){ return $item['price'] * $item['quantity']; });
                @endphp
                <span class="font-display text-2xl font-bold text-gray-900 dark:text-white">
                    {{ 'Rp ' . number_format($total, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex h-14 gap-3">
                @if(count($selectedItems) > 0)
                    <button 
                        wire:click="deleteSelected"
                        class="flex h-full items-center justify-center rounded-2xl border-2 border-red-100 px-6 text-sm font-bold text-primary transition hover:bg-red-50 dark:border-red-900/30 dark:hover:bg-red-900/20"
                    >
                        Hapus ({{ count($selectedItems) }})
                    </button>
                    <button 
                        wire:click="checkout"
                        wire:loading.attr="disabled"
                        class="flex flex-1 h-full items-center justify-center gap-2 rounded-2xl bg-primary text-base font-bold text-white shadow-xl shadow-primary/30 transition hover:bg-red-700 active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="checkout">Pesan Sekarang</span>
                        <span wire:loading wire:target="checkout" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                @else
                    <button disabled class="flex h-full w-full items-center justify-center rounded-2xl bg-gray-200 text-base font-bold text-gray-400 transition cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                        Pilih item untuk memesan
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
