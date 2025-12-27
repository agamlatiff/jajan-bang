<x-layouts.app>
    <div class="relative min-h-screen bg-white shadow-2xl transition-colors duration-200 dark:bg-background-dark overflow-hidden flex flex-col">
        <!-- Decor -->
        <div class="fixed top-20 -left-12 w-64 h-64 opacity-[0.03] dark:opacity-[0.05] pointer-events-none z-0">
            <img alt="Decor" class="w-full h-full object-contain rotate-45" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBz0KBRRFfQ8CYSyo_amM-FPJ0RGrqTfs8n7jsqr1ujm7WDb3P5WEX6M1unHkX503391Pi9rbs9kAfF8is-n5rwv0703Vynil5UeqGnZsdaabbbfWaVotC77Rcl5VrvQslFP1gqNH-oeF_yU3ayrHVYaO84qQC120irZ0GgfpbBF2kHbGNNbwV7pjKvI5U3SNgvws_W45Zdwtc_YFhEMn24gN0g3eF0j022li1HiV2Bw6UT0XEF7Goju2vcT1guHRMCTZB3ScCA"/>
        </div>

        <main class="flex-1 flex flex-col items-center justify-center px-6 relative z-10 w-full py-10">
            <div class="mb-8 relative">
                <div class="w-24 h-24 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center animate-pulse">
                    <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center shadow-lg shadow-red-500/30">
                        <span class="material-icons text-white text-4xl">priority_high</span>
                    </div>
                </div>
                <div class="absolute top-0 -right-2 w-3 h-3 bg-red-400 rounded-full opacity-60"></div>
                <div class="absolute bottom-2 -left-2 w-2 h-2 bg-orange-400 rounded-full opacity-60"></div>
                <div class="absolute -top-2 left-4 w-2 h-2 bg-yellow-400 rounded-full opacity-60"></div>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 text-center">Pembayaran Gagal</h1>
            <p class="text-secondary-text text-center mb-10 max-w-[280px] leading-relaxed">
                Mohon maaf, transaksi Anda gagal diproses. Silakan periksa saldo atau coba metode lain.
            </p>

            @if($transaction)
            <div class="w-full bg-white dark:bg-card-dark rounded-3xl p-6 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-linear-to-r from-transparent via-primary to-transparent opacity-50"></div>
                <div class="text-center mb-6 pt-2">
                    <p class="text-xs font-bold text-secondary-text uppercase tracking-widest mb-1">Total Tagihan</p>
                    <h2 class="text-3xl font-display font-bold text-gray-900 dark:text-white">{{ $transaction->formatted_total }}</h2>
                </div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="h-px bg-gray-100 dark:bg-gray-800 flex-1"></div>
                    <span class="text-[10px] text-gray-400 font-medium px-2 uppercase">Detail Transaksi</span>
                    <div class="h-px bg-gray-100 dark:bg-gray-800 flex-1"></div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 dark:text-gray-400">ID Pesanan</span>
                        <span class="font-semibold text-gray-900 dark:text-white font-mono">#{{ $transaction->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Tanggal</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $transaction->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Waktu</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $transaction->created_at->format('h:i A') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Metode Bayar</span>
                         <div class="flex items-center gap-2">
                            <span class="material-icons text-base text-gray-400">credit_card</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $transaction->payment_method ?? 'Unknown' }}</span>
                        </div>
                    </div>
                     <div class="flex justify-between items-center text-sm bg-red-50 dark:bg-red-900/10 p-2 rounded-lg mt-2">
                        <span class="text-red-600 dark:text-red-400 font-medium">Status</span>
                        <span class="font-bold text-red-600 dark:text-red-400 uppercase text-xs">Gagal</span>
                    </div>
                </div>
                <!-- Card Punch Holes -->
                <div class="absolute -bottom-3 left-0 w-full flex justify-between px-2">
                    @for($i = 0; $i < 9; $i++)
                        <div class="w-4 h-4 rounded-full bg-background-light dark:bg-background-dark"></div>
                    @endfor
                </div>
            </div>
            @endif
        </main>

        <div class="p-6 pb-24 bg-white dark:bg-background-dark relative z-20">
            <div class="flex flex-col gap-3">
                <a href="{{ route('payment.checkout') }}" wire:navigate class="w-full h-14 rounded-xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/30 hover:bg-red-700 active:scale-95 transition-all group">
                    <span class="material-icons mr-2 text-white/90">refresh</span>
                    <span class="text-base font-bold">Coba Lagi</span>
                </a>
                <a href="{{ route('home') }}" wire:navigate class="w-full h-14 rounded-xl bg-white dark:bg-card-dark border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all">
                    <span class="text-base font-bold">Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
