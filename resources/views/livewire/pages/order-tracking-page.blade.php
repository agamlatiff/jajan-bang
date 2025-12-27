<div class="min-h-screen bg-gray-50 text-gray-900 transition-colors duration-200 dark:bg-background-dark dark:text-white font-sans">
    <header class="sticky top-0 z-20 bg-white px-6 pb-4 pt-8 shadow-sm dark:bg-card-dark transition-colors">
        <div class="flex items-center justify-between">
            <a href="{{ $backUrl ?? url()->previous() }}" class="group flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="material-icons text-gray-700 transition-colors group-hover:text-primary dark:text-gray-200">arrow_back</span>
            </a>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Lacak Pesanan</h1>
            <div class="w-10"></div>
        </div>
    </header>

    <main class="relative z-10 flex-1 overflow-y-auto px-6 pb-24 pt-6 scrollbar-hide">
        <div class="mb-8 rounded-2xl bg-white p-4 shadow-lg shadow-gray-200/50 dark:bg-card-dark dark:shadow-none transition-colors">
            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400" for="invoice">
                Nomor Invoice
            </label>
            <form wire:submit="searchOrder" class="flex gap-3">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="material-icons text-lg text-gray-400">receipt</span>
                    </div>
                    <input 
                        wire:model="invoiceNumber"
                        class="w-full rounded-xl border-none bg-gray-50 py-3 pl-10 pr-4 text-sm font-medium text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white" 
                        id="invoice" 
                        placeholder="Cth: INV-2023001" 
                        type="text" 
                    />
                </div>
                <button 
                    type="submit"
                    class="rounded-xl bg-primary px-5 font-semibold text-white shadow-lg shadow-primary/30 transition-all hover:bg-red-700 active:scale-95"
                >
                    <span wire:loading.remove wire:target="searchOrder">Cari</span>
                    <span wire:loading wire:target="searchOrder" class="flex items-center">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        @if ($notFound)
            <div class="flex flex-col items-center justify-center py-10 text-center animate-fade-in">
                <div class="mb-6 flex h-32 w-32 items-center justify-center rounded-full bg-gray-100 shadow-inner dark:bg-gray-800">
                    <span class="material-icons text-5xl text-gray-400">search_off</span>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Invoice Tidak Ditemukan</h3>
                <p class="max-w-[250px] text-sm leading-relaxed text-gray-400">
                     Mohon periksa kembali nomor invoice Anda dan coba lagi.
                 </p>
            </div>
        @elseif ($transaction)
            <div class="space-y-6">
                <!-- Status Timeline -->
                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-xl shadow-gray-200/50 dark:border-gray-800 dark:bg-card-dark dark:shadow-none transition-colors">
                    <h3 class="mb-6 flex items-center gap-2 text-lg font-bold">
                        <span class="material-icons text-primary">timeline</span>
                        Status Pesanan
                    </h3>
                    
                    @php
                        $statuses = [
                            ['key' => 'pending', 'label' => 'Pesanan Diterima', 'icon' => 'receipt_long'],
                            ['key' => 'confirmed', 'label' => 'Dikonfirmasi', 'icon' => 'check_circle'],
                            ['key' => 'preparing', 'label' => 'Sedang Diproses', 'icon' => 'soup_kitchen'],
                            ['key' => 'ready', 'label' => 'Siap Disajikan', 'icon' => 'room_service'],
                            ['key' => 'delivered', 'label' => 'Pesanan Selesai', 'icon' => 'flag'],
                        ];
                        
                        $currentStatus = $transaction->order_status->value;
                        $statusOrder = array_column($statuses, 'key');
                        $currentIndex = array_search($currentStatus, $statusOrder);
                        if($currentIndex === false) $currentIndex = -1;
                    @endphp

                    <div class="relative pl-2">
                        @foreach ($statuses as $index => $status)
                            <div class="relative flex gap-4 pb-10 last:pb-0 {{ $index > $currentIndex ? 'opacity-50' : '' }}">
                                @if (!$loop->last)
                                    <div class="absolute bottom-0 left-[19px] top-10 w-0.5 {{ $index < $currentIndex ? 'bg-green-500' : 'border-l-2 border-dashed border-gray-200 dark:border-gray-700' }}"></div>
                                @endif
                                
                                <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full shadow-md transition-all
                                    {{ $index < $currentIndex ? 'bg-green-500 text-white shadow-green-200 dark:shadow-none' : '' }}
                                    {{ $index === $currentIndex ? 'bg-primary text-white shadow-primary/40 ring-4 ring-primary/10 dark:ring-primary/20' : '' }}
                                    {{ $index > $currentIndex ? 'bg-white border-2 border-gray-200 text-gray-400 dark:bg-card-dark dark:border-gray-700' : '' }}
                                ">
                                    <span class="material-icons text-[20px] {{ $index === $currentIndex ? 'animate-pulse' : '' }}">
                                        {{ $status['icon'] }}
                                    </span>
                                </div>
                                
                                <div class="pt-1">
                                    <h4 class="text-sm font-bold {{ $index === $currentIndex ? 'text-primary text-base' : 'text-gray-900 dark:text-white' }}">
                                        {{ $status['label'] }}
                                    </h4>
                                    @if ($index === $currentIndex && $status['key'] === 'processing')
                                        <div class="mt-1.5 inline-flex items-center rounded-lg border border-red-100 bg-red-50 px-2.5 py-1 dark:border-red-900/30 dark:bg-red-900/20">
                                            <span class="text-xs font-medium text-primary">Koki sedang memasak</span>
                                        </div>
                                    @endif
                                    @if ($index <= $currentIndex && isset($transaction->updated_at))
                                        <!-- Optional: Show time if available logically -->
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Detail Pesanan -->
                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-xl shadow-gray-200/50 dark:border-gray-800 dark:bg-card-dark dark:shadow-none transition-colors">
                    <h3 class="mb-4 flex items-center gap-2 text-lg font-bold">
                        <span class="material-icons text-primary">receipt_long</span>
                        Detail Pesanan
                    </h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start justify-between border-b border-gray-100 pb-4 dark:border-gray-800">
                            <span class="text-gray-400">Nama Pemesan</span>
                            <span class="font-semibold text-gray-900 text-right dark:text-white">{{ $transaction->name }}</span>
                        </div>
                        <div class="flex items-start justify-between border-b border-gray-100 pb-4 dark:border-gray-800">
                            <span class="text-gray-400">No. Handphone</span>
                            <span class="font-semibold text-gray-900 text-right dark:text-white">{{ $transaction->phone }}</span>
                        </div>
                        <div class="flex items-start justify-between border-b border-gray-100 pb-4 dark:border-gray-800">
                            <span class="text-gray-400">No. Meja</span>
                            <span class="text-lg font-bold text-primary text-right">#{{ $transaction->table_number }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Metode Bayar</span>
                            <div class="flex items-center gap-1.5 rounded bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                <span class="material-icons text-sm">qr_code</span> {{ strtoupper($transaction->payment_method) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Dipesan -->
                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-xl shadow-gray-200/50 dark:border-gray-800 dark:bg-card-dark dark:shadow-none transition-colors">
                    <h3 class="mb-4 flex items-center gap-2 text-lg font-bold">
                        <span class="material-icons text-primary">restaurant_menu</span>
                        Menu Dipesan
                    </h3>
                    <div class="space-y-4">
                        @foreach ($transaction->transactionItems as $item)
                            <div class="flex gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-xl dark:bg-gray-800">
                                    🍽️
                                </div>
                                <div class="flex-1">
                                    <div class="mb-1 flex items-start justify-between">
                                        <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 dark:text-white">
                                            {{ $item->food->name }}
                                        </h4>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ number_format($item->amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-gray-400">
                                        <span>{{ number_format($item->food->price, 0, ',', '.') }}</span>
                                        <span class="rounded bg-gray-100 px-2 py-0.5 font-mono text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                            x{{ $item->quantity }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="my-2 h-px bg-gray-100 dark:bg-gray-800"></div>
                        
                        <div class="flex items-end justify-between pt-1">
                            <span class="text-sm font-medium text-gray-400">Total Tagihan</span>
                            <span class="font-display text-2xl font-bold text-primary">
                                {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Initial State -->
            <div class="flex flex-col items-center justify-center py-10 text-center animate-fade-in">
                <div class="mb-6 flex h-32 w-32 items-center justify-center rounded-full bg-primary/5">
                    <span class="material-icons text-5xl text-primary">manage_search</span>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Lacak Pesanan Anda</h3>
                <p class="max-w-[250px] text-sm leading-relaxed text-gray-400">
                    Masukkan nomor invoice pada kolom di atas untuk melihat status pesanan terkini.
                </p>
            </div>
        @endif
    </main>
</div>
