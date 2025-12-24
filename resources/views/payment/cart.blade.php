<div
    x-data="{ open: false }"
    class="flex min-h-screen flex-col bg-white font-poppins"
>
    <livewire:components.page-title-nav
        :title="'Keranjang'"
        wire:key="{{ str()->random(50) }}"
        :hasBack="true"
        :hasFilter="false"
    />

    <div class="container">
        <h2 class="mb-4 text-lg font-medium text-black-100">
            Baru Ditambahkan
        </h2>

        @if (isset($cartItems) && count($cartItems) > 0)
            <livewire:components.menu-item-list
                :items="$cartItems"
                wire:key="{{ str()->random(50) }}"
            />

            <div class="mt-6 flex items-center justify-between">
                <button
                    x-on:click="open = true"
                    class="flex items-center gap-2 rounded-full bg-primary-10 px-6 py-3 font-semibold text-primary-50"
                >
                    Hapus ({{ count($selectedItems) }})
                </button>
                <button
                    x-bind:disabled="! {{ count($selectedItems) }} > 0"
                    wire:click="checkout"
                    class="flex items-center gap-2 rounded-full bg-primary-50 px-6 py-3 font-semibold text-black-10 disabled:bg-primary-30"
                >
                    <span>Pesan Sekarang</span>
                    <img
                        src="{{ asset("assets/icons/arrow-right-white-icon.svg") }}"
                        alt="Cart"
                    />
                </button>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <!-- Empty Cart Illustration -->
                <svg class="w-32 h-32 text-primary-30 mb-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
                <h3 class="text-xl font-semibold text-black-80 mb-2">Keranjang Kosong</h3>
                <p class="text-center text-black-40 mb-6 max-w-xs">
                    Belum ada makanan di keranjangmu. Yuk mulai pesan makanan favoritmu!
                </p>
                
                <!-- CTA Button -->
                <a href="{{ url('/menu') }}" 
                   class="flex items-center gap-2 bg-primary-50 text-white px-6 py-3 rounded-full font-semibold hover:bg-primary-60 transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Lihat Menu
                </a>
            </div>
        @endif
    </div>

    <div x-show="open">
        <livewire:components.delete-confirm-modal />
    </div>
</div>
