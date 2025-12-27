<div class="min-h-screen bg-background-light text-gray-900 transition-colors duration-200 dark:bg-background-dark dark:text-white font-sans flex flex-col">
    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white px-6 pt-12 pb-4 shadow-sm dark:bg-card-dark transition-colors">
        <div class="flex items-center justify-between">
            <a href="{{ $backUrl ?? route('home') }}" wire:navigate class="group flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="material-icons text-gray-700 transition-colors group-hover:text-primary dark:text-gray-200">arrow_back</span>
            </a>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Lacak Pesanan</h1>
            <div class="w-10"></div>
        </div>
    </header>

    <main class="relative z-10 flex-1 overflow-y-auto px-6 pb-24 pt-6 scrollbar-hide">
        <!-- Search -->
        <div class="bg-white dark:bg-card-dark rounded-2xl p-4 shadow-lg shadow-gray-200/50 dark:shadow-none mb-8">
            <label class="block text-xs font-bold text-secondary-text uppercase tracking-wider mb-2" for="invoice">
                Nomor Invoice
            </label>
            <form wire:submit="searchOrder" class="flex gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-icons text-gray-400 text-lg">receipt</span>
                    </div>
                    <input 
                        wire:model="invoiceNumber"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary placeholder-gray-400 text-sm font-medium" 
                        id="invoice" 
                        placeholder="Cth: INV-2023001" 
                        type="text" 
                    />
                </div>
                <button 
                    type="submit"
                    class="bg-primary hover:bg-red-700 text-white px-5 rounded-xl font-semibold shadow-lg shadow-primary/30 transition-all active:scale-95 flex items-center justify-center disabled:opacity-70"
                >
                    <span wire:loading.remove wire:target="searchOrder">Cari</span>
                    <span wire:loading wire:target="searchOrder">
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
                <div class="w-32 h-32 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <span class="material-icons text-gray-400 text-5xl">search_off</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Invoice Tidak Ditemukan</h3>
                <p class="text-secondary-text text-sm max-w-[250px] leading-relaxed">
                     Mohon periksa kembali nomor invoice Anda dan coba lagi.
                 </p>
            </div>
        @elseif ($transaction)
            <div class="space-y-6">
                <!-- Status Timeline -->
                <div class="bg-white dark:bg-card-dark rounded-3xl p-6 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800">
                    <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="material-icons text-primary">timeline</span>
                        Status Pesanan
                    </h3>
                    
                    @php
                        $statuses = [
                            ['key' => 'pending', 'label' => 'Pesanan Diterima', 'icon' => 'receipt_long'],
                            ['key' => 'confirmed', 'label' => 'Dikonfirmasi', 'icon' => 'check_circle'],
                            ['key' => 'processing', 'label' => 'Sedang Diproses', 'icon' => 'soup_kitchen'],
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
                            <div class="flex gap-4 relative pb-10 last:pb-0 {{ $index > $currentIndex ? 'opacity-50' : '' }}">
                                @if (!$loop->last)
                                    <div class="absolute left-[19px] top-10 bottom-0 w-0.5 {{ $index < $currentIndex ? 'bg-green-500' : 'border-l-2 border-dashed border-gray-200 dark:border-gray-700' }}"></div>
                                @endif
                                
                                <div class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center shrink-0 transition-all
                                    {{ $index < $currentIndex ? 'bg-green-500 text-white shadow-md shadow-green-200 dark:shadow-none' : '' }}
                                    {{ $index === $currentIndex ? 'bg-primary text-white shadow-lg shadow-primary/40 ring-4 ring-primary/10 dark:ring-primary/20' : '' }}
                                    {{ $index > $currentIndex ? 'bg-white dark:bg-card-dark border-2 border-gray-200 dark:border-gray-700 text-gray-400' : '' }}
                                ">
                                    <span class="material-icons text-[20px] {{ $index === $currentIndex ? 'animate-pulse' : '' }}">
                                        {{ $status['icon'] }}
                                    </span>
                                </div>
                                
                                <div class="pt-1">
                                    <h4 class="font-bold text-sm {{ $index === $currentIndex ? 'text-primary text-base' : 'text-gray-900 dark:text-white' }}">
                                        {{ $status['label'] }}
                                    </h4>
                                    @if ($index === $currentIndex && $status['key'] === 'processing')
                                        <div class="mt-1.5 inline-flex items-center px-2.5 py-1 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30">
                                            <span class="text-xs font-medium text-primary">Koki sedang memasak</span>
                                        </div>
                                    @endif
                                    @if ($index <= $currentIndex && isset($transaction->updated_at))
                                        <!-- Time display could go here if tracked per status -->
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Detail Pesanan -->
                <div class="bg-white dark:bg-card-dark rounded-3xl p-6 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-icons text-primary">receipt_long</span>
                        Detail Pesanan
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-start text-sm pb-4 border-b border-gray-100 dark:border-gray-800">
                            <span class="text-secondary-text">Nama Pemesan</span>
                            <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $transaction->name }}</span>
                        </div>
                        <div class="flex justify-between items-start text-sm pb-4 border-b border-gray-100 dark:border-gray-800">
                            <span class="text-secondary-text">No. Handphone</span>
                            <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $transaction->phone }}</span>
                        </div>
                        <div class="flex justify-between items-start text-sm pb-4 border-b border-gray-100 dark:border-gray-800">
                            <span class="text-secondary-text">No. Meja</span>
                            <span class="font-bold text-primary text-right text-lg">#{{ $transaction->table_number }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-secondary-text">Metode Bayar</span>
                            <div class="flex items-center gap-1.5 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-xs font-semibold text-gray-700 dark:text-gray-300">
                                <span class="material-icons text-sm">qr_code</span> {{ strtoupper($transaction->payment_method) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Dipesan -->
                <div class="bg-white dark:bg-card-dark rounded-3xl p-6 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-icons text-primary">restaurant_menu</span>
                        Menu Dipesan
                    </h3>
                    <div class="space-y-4">
                        @foreach ($transaction->items as $item)
                            <div class="flex gap-4">
                                <div class="w-14 h-14 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center text-xl shrink-0">
                                    🍽️
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">
                                            {{ $item->food->name }}
                                        </h4>
                                        <span class="font-bold text-gray-900 dark:text-white text-sm">
                                            {{ number_format($item->amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-secondary-text">
                                        <span>{{ number_format($item->food->price, 0, ',', '.') }}</span>
                                        <span class="bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded font-mono text-gray-600 dark:text-gray-300">
                                            x{{ $item->quantity }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="h-px bg-gray-100 dark:bg-gray-800 my-2"></div>
                        
                        <div class="flex justify-between items-end pt-1">
                            <span class="text-sm font-medium text-secondary-text">Total Tagihan</span>
                            <span class="text-2xl font-display font-bold text-primary">
                                {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Initial State -->
            <div class="flex flex-col items-center justify-center py-10 text-center animate-fade-in">
                <div class="w-32 h-32 bg-primary/5 rounded-full flex items-center justify-center mb-6">
                    <span class="material-icons text-primary text-5xl">manage_search</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Lacak Pesanan Anda</h3>
                <p class="text-secondary-text text-sm max-w-[250px] leading-relaxed">
                    Masukkan nomor invoice pada kolom di atas untuk melihat status pesanan terkini.
                </p>
            </div>
        @endif
    </main>
</div>
