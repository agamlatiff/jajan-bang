<div class="min-h-screen bg-gray-100 font-poppins" wire:poll.5s>
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold text-primary-50">🍳 Dapur</h1>
                <span class="text-sm text-gray-500">
                    {{ now()->format('d M Y, H:i') }}
                </span>
            </div>
            
            <!-- Filter Tabs -->
            <div class="flex gap-2">
                <button wire:click="$set('filter', 'active')"
                    class="px-4 py-2 rounded-lg font-medium transition-all
                    {{ $filter === 'active' ? 'bg-primary-50 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Aktif
                </button>
                <button wire:click="$set('filter', 'today')"
                    class="px-4 py-2 rounded-lg font-medium transition-all
                    {{ $filter === 'today' ? 'bg-primary-50 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Hari Ini
                </button>
                <button wire:click="$set('filter', 'all')"
                    class="px-4 py-2 rounded-lg font-medium transition-all
                    {{ $filter === 'all' ? 'bg-primary-50 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </button>
            </div>
        </div>
    </header>

    <!-- Order Cards Grid -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @if ($orders->isEmpty())
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-500">Tidak Ada Pesanan</h3>
                <p class="text-gray-400">Pesanan baru akan muncul di sini</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden border-l-4 
                        {{ match($order->order_status?->value) {
                            'pending' => 'border-yellow-400',
                            'confirmed' => 'border-blue-400',
                            'preparing' => 'border-orange-400',
                            'ready' => 'border-green-400',
                            'delivered' => 'border-gray-400',
                            'cancelled' => 'border-red-400',
                            default => 'border-gray-300'
                        } }}"
                        wire:key="order-{{ $order->id }}">
                        
                        <!-- Order Header -->
                        <div class="p-4 border-b bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-lg font-bold text-black-80">Meja {{ $order->table_number }}</span>
                                    <p class="text-sm text-gray-500">#{{ $order->invoice_number }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->order_status?->color() ?? 'bg-gray-100' }}">
                                    {{ $order->order_status?->label() ?? 'Pending' }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                <span>👤 {{ $order->customer_name }}</span>
                                <span>📞 {{ $order->customer_phone }}</span>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-4 max-h-48 overflow-y-auto">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between py-2 border-b last:border-0">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 bg-primary-10 text-primary-50 rounded text-sm font-bold flex items-center justify-center">
                                            {{ $item->quantity }}
                                        </span>
                                        <span class="font-medium">{{ $item->food_name ?? 'Item' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Actions -->
                        <div class="p-4 bg-gray-50 border-t">
                            <div class="flex gap-2">
                                @switch($order->order_status?->value)
                                    @case('pending')
                                        <button wire:click="confirmOrder({{ $order->id }})"
                                            class="flex-1 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-all">
                                            ✓ Konfirmasi
                                        </button>
                                        <button wire:click="cancelOrder({{ $order->id }})"
                                            class="px-4 py-2 bg-red-100 text-red-600 rounded-lg font-semibold hover:bg-red-200 transition-all">
                                            ✕
                                        </button>
                                        @break
                                    @case('confirmed')
                                        <button wire:click="startPreparing({{ $order->id }})"
                                            class="flex-1 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-all">
                                            🍳 Mulai Masak
                                        </button>
                                        @break
                                    @case('preparing')
                                        <button wire:click="markReady({{ $order->id }})"
                                            class="flex-1 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-all">
                                            🔔 Siap Diantar
                                        </button>
                                        @break
                                    @case('ready')
                                        <button wire:click="markDelivered({{ $order->id }})"
                                            class="flex-1 py-2 bg-gray-700 text-white rounded-lg font-semibold hover:bg-gray-800 transition-all">
                                            ✓ Selesai
                                        </button>
                                        @break
                                    @default
                                        <span class="flex-1 py-2 text-center text-gray-500">
                                            {{ $order->order_status?->label() ?? '-' }}
                                        </span>
                                @endswitch
                            </div>
                            
                            <!-- Time Info -->
                            <p class="text-center text-xs text-gray-400 mt-2">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Stats Footer -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white border-t py-3 px-4">
        <div class="max-w-7xl mx-auto flex justify-around text-center">
            <div>
                <p class="text-2xl font-bold text-yellow-500">{{ $orders->where('order_status.value', 'pending')->count() }}</p>
                <p class="text-xs text-gray-500">Menunggu</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-orange-500">{{ $orders->where('order_status.value', 'preparing')->count() }}</p>
                <p class="text-xs text-gray-500">Diproses</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-500">{{ $orders->where('order_status.value', 'ready')->count() }}</p>
                <p class="text-xs text-gray-500">Siap</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-500">{{ $orders->where('order_status.value', 'delivered')->count() }}</p>
                <p class="text-xs text-gray-500">Selesai</p>
            </div>
        </div>
    </footer>
</div>
