<div class="min-h-screen bg-background-light dark:bg-background-dark font-sans flex flex-col" wire:poll.5s>
    <!-- Header -->
    <header class="flex items-center justify-between px-6 pt-12 pb-4 sticky top-0 z-40 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-800/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl shadow-lg shadow-primary/30">
                JB
            </div>
            <div>
                <h1 class="font-display font-bold text-xl text-gray-900 dark:text-white">Dapur</h1>
                <p class="text-xs text-secondary-text font-medium">JajanBang Kitchen</p>
            </div>
        </div>
        <button wire:click="$refresh" class="w-10 h-10 rounded-full bg-white dark:bg-card-dark border border-gray-200 dark:border-gray-800 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group active:rotate-180 duration-500">
            <span class="material-icons text-gray-600 dark:text-gray-300">refresh</span>
        </button>
    </header>

    <main class="px-6 mt-4 space-y-6 flex-1 pb-24 relative z-10">
        <!-- Summary Cards -->
        <section class="grid grid-cols-3 gap-3">
            <div class="bg-white dark:bg-card-dark p-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col items-center justify-center text-center">
                <span class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $this->counts['active'] }}</span>
                <span class="text-[10px] uppercase font-bold text-secondary-text tracking-wide">Aktif</span>
            </div>
            <div class="bg-white dark:bg-card-dark p-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col items-center justify-center text-center">
                <span class="text-2xl font-bold text-orange-500 mb-1">{{ $this->counts['pending'] }}</span>
                <span class="text-[10px] uppercase font-bold text-secondary-text tracking-wide">Pending</span>
            </div>
            <div class="bg-white dark:bg-card-dark p-3 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col items-center justify-center text-center">
                <span class="text-2xl font-bold text-green-500 mb-1">{{ $this->counts['ready'] }}</span>
                <span class="text-[10px] uppercase font-bold text-secondary-text tracking-wide">Ready</span>
            </div>
        </section>

        <!-- Filter Tabs -->
        <section class="overflow-x-auto scrollbar-hide -mx-6 px-6">
            <div class="flex gap-2 w-max">
                <button wire:click="$set('filter', 'active')" class="px-4 py-2 rounded-xl font-semibold text-sm shadow-md transition-all {{ $filter === 'active' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-card-dark text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    All
                </button>
                <button wire:click="$set('filter', 'pending')" class="px-4 py-2 rounded-xl font-medium text-sm whitespace-nowrap border transition-all {{ $filter === 'pending' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 border-transparent shadow-md' : 'bg-white dark:bg-card-dark text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Pending <span class="ml-1 bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded-full text-[10px]">{{ $this->counts['pending'] }}</span>
                </button>
                <button wire:click="$set('filter', 'confirmed')" class="px-4 py-2 rounded-xl font-medium text-sm whitespace-nowrap border transition-all {{ $filter === 'confirmed' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 border-transparent shadow-md' : 'bg-white dark:bg-card-dark text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Confirmed <span class="ml-1 bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded-full text-[10px]">{{ $this->counts['confirmed'] }}</span>
                </button>
                <button wire:click="$set('filter', 'preparing')" class="px-4 py-2 rounded-xl font-medium text-sm whitespace-nowrap border transition-all {{ $filter === 'preparing' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 border-transparent shadow-md' : 'bg-white dark:bg-card-dark text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Preparing <span class="ml-1 bg-purple-100 text-purple-600 px-1.5 py-0.5 rounded-full text-[10px]">{{ $this->counts['preparing'] }}</span>
                </button>
                 <button wire:click="$set('filter', 'ready')" class="px-4 py-2 rounded-xl font-medium text-sm whitespace-nowrap border transition-all {{ $filter === 'ready' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 border-transparent shadow-md' : 'bg-white dark:bg-card-dark text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Ready <span class="ml-1 bg-green-100 text-green-600 px-1.5 py-0.5 rounded-full text-[10px]">{{ $this->counts['ready'] }}</span>
                </button>
            </div>
        </section>

        <!-- Orders List -->
        <section class="space-y-4">
            @forelse ($orders as $order)
                @php
                    $statusColor = match($order->order_status->value) {
                        'pending' => 'orange',
                        'confirmed' => 'blue',
                        'preparing' => 'purple',
                        'ready' => 'green',
                        'delivered' => 'gray',
                        'cancelled' => 'red',
                        default => 'gray'
                    };
                    $minutesAgo = $order->created_at->diffInMinutes(now());
                @endphp
                
                <div class="bg-white dark:bg-card-dark rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-800 relative overflow-hidden group transition-all hover:shadow-md" wire:key="order-{{ $order->id }}">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-{{ $statusColor }}-500"></div>
                    
                    <div class="flex justify-between items-start mb-4 pl-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-{{ $statusColor }}-50 dark:bg-{{ $statusColor }}-900/20 text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400 flex items-center justify-center font-bold text-sm border border-{{ $statusColor }}-100 dark:border-{{ $statusColor }}-900/30">
                                {{ $order->table_number }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-base">{{ $order->customer_name }}</h3>
                                <p class="text-xs text-secondary-text">#{{ $order->invoice_number }} • {{ $minutesAgo }}m ago</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 text-{{ $statusColor }}-700 dark:text-{{ $statusColor }}-300 text-xs font-bold uppercase tracking-wide">
                            {{ $order->order_status->label() }}
                        </span>
                    </div>

                    <div class="space-y-3 pl-3 border-t border-dashed border-gray-100 dark:border-gray-800 pt-3 mb-4">
                        @foreach ($order->items as $item)
                        <div class="flex justify-between items-start">
                            <div class="flex gap-3">
                                <span class="font-bold text-gray-500 dark:text-gray-400 text-sm py-0.5">{{ $item->quantity }}x</span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->food->name }}</p>
                                    @if($item->notes)
                                        <p class="text-xs text-secondary-text mt-0.5 italic">{{ $item->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="pl-3 flex gap-2">
                        @switch($order->order_status->value)
                            @case('pending')
                                <button wire:click="confirmOrder({{ $order->id }})" class="flex-1 py-2.5 rounded-xl bg-primary text-white font-semibold text-sm shadow-lg shadow-primary/20 hover:bg-red-700 active:scale-95 transition-all">
                                    Konfirmasi
                                </button>
                                <button wire:click="cancelOrder({{ $order->id }})" class="w-10 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <span class="material-icons text-sm">close</span>
                                </button>
                                @break
                            @case('confirmed')
                                <button wire:click="startPreparing({{ $order->id }})" class="flex-1 py-2.5 rounded-xl bg-blue-500 text-white font-semibold text-sm shadow-lg shadow-blue-500/20 hover:bg-blue-600 active:scale-95 transition-all">
                                    Mulai Masak
                                </button>
                                @break
                            @case('preparing')
                                <button wire:click="markReady({{ $order->id }})" class="flex-1 py-2.5 rounded-xl bg-purple-500 text-white font-semibold text-sm shadow-lg shadow-purple-500/20 hover:bg-purple-600 active:scale-95 transition-all">
                                    Siap Disajikan
                                </button>
                                @break
                             @case('ready')
                                <button wire:click="markDelivered({{ $order->id }})" class="flex-1 py-2.5 rounded-xl bg-green-500 text-white font-semibold text-sm shadow-lg shadow-green-500/20 hover:bg-green-600 active:scale-95 transition-all">
                                    Antar ke Meja
                                </button>
                                @break
                        @endswitch
                    </div>
                </div>
            @empty
                <div class="py-12 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <span class="material-icons text-4xl text-gray-400">restaurant</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Tidak ada pesanan aktif</h3>
                    <p class="text-sm text-secondary-text max-w-xs">Saat ini tidak ada pesanan dengan status '{{ ucfirst($filter) }}'.</p>
                </div>
            @endforelse
        </section>
    </main>
    
    <!-- Background Decor -->
    <div class="fixed top-20 -right-12 w-64 h-64 opacity-[0.03] dark:opacity-[0.05] pointer-events-none z-0">
        <img alt="Decor" class="w-full h-full object-contain -rotate-12" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBz0KBRRFfQ8CYSyo_amM-FPJ0RGrqTfs8n7jsqr1ujm7WDb3P5WEX6M1unHkX503391Pi9rbs9kAfF8is-n5rwv0703Vynil5UeqGnZsdaabbbfWaVotC77Rcl5VrvQslFP1gqNH-oeF_yU3ayrHVYaO84qQC120irZ0GgfpbBF2kHbGNNbwV7pjKvI5U3SNgvws_W45Zdwtc_YFhEMn24gN0g3eF0j022li1HiV2Bw6UT0XEF7Goju2vcT1guHRMCTZB3ScCA"/>
    </div>
</div>
