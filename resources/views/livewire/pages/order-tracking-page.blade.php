<div class="min-h-screen bg-gray-50 font-poppins">
    <livewire:components.page-title-nav 
        :title="'Lacak Pesanan'" 
        wire:key="{{ str()->random(50) }}" 
        :hasBack="true"
        :hasFilter="false"
        :backUrl="route('home')" />

    <div class="container py-6">
        <!-- Search Form -->
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
            <h2 class="text-lg font-semibold text-black-80 mb-4">Cari Pesanan</h2>
            <form wire:submit="searchOrder" class="flex gap-3">
                <input 
                    type="text" 
                    wire:model="invoiceNumber"
                    placeholder="Masukkan nomor invoice..."
                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-50 focus:border-transparent"
                />
                <button 
                    type="submit"
                    class="px-6 py-3 bg-primary-50 text-white rounded-xl font-semibold hover:bg-primary-60 transition-all"
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
            <!-- Not Found State -->
            <div class="bg-white rounded-2xl p-8 shadow-sm text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Pesanan Tidak Ditemukan</h3>
                <p class="text-gray-500">Pastikan nomor invoice yang kamu masukkan sudah benar</p>
            </div>
        @elseif ($transaction)
            <!-- Order Details -->
            <div class="space-y-4">
                <!-- Status Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Invoice</p>
                            <p class="font-semibold text-black-80">{{ $transaction->invoice_number }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $transaction->order_status?->color() ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $transaction->order_status?->label() ?? 'Unknown' }}
                        </span>
                    </div>

                    <!-- Status Timeline -->
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        
                        @php
                            $statuses = [
                                ['key' => 'pending', 'label' => 'Pesanan Diterima', 'desc' => 'Pesanan kamu telah diterima'],
                                ['key' => 'confirmed', 'label' => 'Dikonfirmasi', 'desc' => 'Pesanan dikonfirmasi oleh dapur'],
                                ['key' => 'preparing', 'label' => 'Sedang Diproses', 'desc' => 'Makanan sedang dimasak'],
                                ['key' => 'ready', 'label' => 'Siap Diambil', 'desc' => 'Pesanan siap untuk diantar'],
                                ['key' => 'delivered', 'label' => 'Selesai', 'desc' => 'Pesanan sudah diantar ke meja'],
                            ];
                            $currentStatus = $transaction->order_status?->value ?? 'pending';
                            $statusOrder = array_column($statuses, 'key');
                            $currentIndex = array_search($currentStatus, $statusOrder);
                        @endphp

                        @foreach ($statuses as $index => $status)
                            <div class="relative flex items-start pl-10 pb-6 last:pb-0">
                                <div class="absolute left-2 w-4 h-4 rounded-full border-2 
                                    {{ $index <= $currentIndex ? 'bg-primary-50 border-primary-50' : 'bg-white border-gray-300' }}">
                                </div>
                                <div>
                                    <p class="font-semibold {{ $index <= $currentIndex ? 'text-black-80' : 'text-gray-400' }}">
                                        {{ $status['label'] }}
                                    </p>
                                    <p class="text-sm {{ $index <= $currentIndex ? 'text-gray-600' : 'text-gray-400' }}">
                                        {{ $status['desc'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Info -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="font-semibold text-black-80 mb-4">Detail Pesanan</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-medium">{{ $transaction->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Telepon</span>
                            <span class="font-medium">{{ $transaction->customer_phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Meja</span>
                            <span class="font-medium">{{ $transaction->table_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pembayaran</span>
                            <span class="font-medium uppercase">{{ $transaction->payment_method }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between text-lg">
                            <span class="font-semibold text-black-80">Total</span>
                            <span class="font-bold text-primary-50">{{ $transaction->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="font-semibold text-black-80 mb-4">Item Pesanan</h3>
                    
                    <div class="space-y-3">
                        @foreach ($transaction->items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-10 rounded-lg flex items-center justify-center text-primary-50 font-semibold">
                                    {{ $item->quantity }}x
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-black-80">{{ $item->food_name ?? 'Item' }}</p>
                                    <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-black-80">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Initial State -->
            <div class="bg-white rounded-2xl p-8 shadow-sm text-center">
                <svg class="w-20 h-20 text-primary-30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Lacak Status Pesananmu</h3>
                <p class="text-gray-500">Masukkan nomor invoice untuk melihat status pesanan</p>
            </div>
        @endif
    </div>
</div>
