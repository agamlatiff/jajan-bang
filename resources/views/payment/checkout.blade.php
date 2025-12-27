<div x-data="{ open: {{ empty($name) ? 'true' : 'false' }} }" class="min-h-screen bg-white pb-32 text-gray-900 transition-colors duration-200 dark:bg-background-dark dark:text-white font-sans">
    <!-- Header -->
    <header class="sticky top-0 z-40 flex items-center justify-between border-b border-gray-100/50 bg-white/95 px-6 pt-8 pb-4 backdrop-blur-md transition-colors dark:border-white/5 dark:bg-background-dark/95">
        <a href="{{ route('payment.cart') }}" class="group flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white shadow-sm transition hover:bg-gray-50 dark:border-gray-800 dark:bg-card-dark dark:hover:bg-gray-800">
            <span class="material-icons text-lg text-gray-700 transition-transform group-hover:scale-110 dark:text-white">arrow_back</span>
        </a>
        <h1 class="font-display text-lg font-bold text-gray-900 dark:text-white">Pemesanan</h1>
        <div class="w-10"></div>
    </header>

    <main class="mt-2 space-y-6 px-6">
        <!-- Info Pemesan -->
        <section>
            <h2 class="mb-3 px-1 text-base font-bold text-gray-900 dark:text-white">Info Pemesan</h2>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-card-dark">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border border-orange-100 bg-orange-50 text-lg font-bold text-orange-600 dark:border-orange-900/30 dark:bg-orange-900/20 dark:text-orange-400">
                        {{ $tableNumber }}
                    </div>
                    <div>
                        <p class="mb-0.5 text-[10px] font-bold uppercase tracking-wider text-gray-400">No. Meja</p>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $name ?? 'Belum Diisi' }}</h3>
                    </div>
                </div>
                <button 
                    @click="open = true"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-50 text-gray-500 transition-colors hover:bg-primary hover:text-white dark:bg-gray-800 dark:text-gray-300"
                >
                    <span class="material-icons text-sm">edit</span>
                </button>
            </div>
        </section>

        <!-- Pesanan Anda -->
        <section>
            <h2 class="mb-3 px-1 text-base font-bold text-gray-900 dark:text-white">Pesanan Anda</h2>
            <div class="space-y-3">
                @foreach($cartItems as $item)
                    <div class="flex gap-4 rounded-2xl border border-gray-100 bg-white p-3 shadow-sm dark:border-gray-800 dark:bg-card-dark">
                        <div class="relative h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-gray-200">
                            <img 
                                src="{{ $item['image_url'] ?? 'https://via.placeholder.com/150' }}" 
                                alt="{{ $item['name'] }}" 
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />
                        </div>
                        <div class="flex flex-1 flex-col justify-between py-1">
                            <div>
                                <h3 class="leading-tight text-sm font-bold text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                                <p class="mt-1 line-clamp-1 text-xs text-gray-400">
                                    {{ isset($item['note']) ? $item['note'] : '' }}
                                </p>
                            </div>
                            <div class="flex items-end justify-between">
                                <span class="font-bold text-primary">
                                    {{ 'Rp ' . number_format($item['price'], 0, ',', '.') }}
                                </span>
                                <span class="rounded-md bg-gray-100 px-2 py-0.5 text-sm font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                    x{{ $item['quantity'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Rincian Pembayaran -->
        <section class="pb-6">
            <h2 class="mb-3 px-1 text-base font-bold text-gray-900 dark:text-white">Rincian Pembayaran</h2>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-card-dark/50">
                <div class="mb-3 flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>
                <div class="mb-4 flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">PPN 11%</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ 'Rp ' . number_format($tax, 0, ',', '.') }}
                    </span>
                </div>
                <div class="my-4 border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total Bayar</span>
                    <span class="text-xl font-bold text-primary">
                        {{ 'Rp ' . number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Action -->
    <div class="fixed bottom-0 left-0 right-0 z-50 mx-auto max-w-md border-t border-gray-100 bg-white/90 p-6 pt-4 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] backdrop-blur-lg transition-colors dark:border-gray-800 dark:bg-card-dark/90 dark:shadow-none">
        
        @if (! $hasUnpaidTransaction)
            <form action="{{ route('payment', ['token' => $paymentToken]) }}" method="POST">
                @csrf
                <button 
                    type="submit" 
                    name="action" 
                    value="pay"
                    @if (empty($name) || empty($phone)) disabled @endif
                    class="group flex h-14 w-full items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/30 transition-all hover:bg-red-700 active:scale-95 disabled:cursor-not-allowed disabled:bg-gray-400 disabled:shadow-none"
                >
                    <span class="mr-2 text-base font-bold">Bayar Sekarang</span>
                    <span class="material-icons text-sm text-white/80 transition-transform group-hover:translate-x-1">arrow_forward</span>
                </button>
            </form>
        @else
            <form action="{{ route('payment', ['token' => $paymentToken]) }}" method="POST">
                @csrf
                <button 
                    type="submit" 
                    name="action" 
                    value="continue"
                    @if (empty($name) || empty($phone)) disabled @endif
                    class="group flex h-14 w-full items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/30 transition-all hover:bg-red-700 active:scale-95 disabled:cursor-not-allowed disabled:bg-gray-400 disabled:shadow-none"
                >
                    <span class="mr-2 text-base font-bold">Lanjut Bayar</span>
                    <span class="material-icons text-sm text-white/80 transition-transform group-hover:translate-x-1">arrow_forward</span>
                </button>
            </form>
        @endif
    </div>

    <!-- Customer Modal -->
    <div x-show="open">
        <livewire:components.customer-modal />
    </div>

    <livewire:components.toast />
</div>
