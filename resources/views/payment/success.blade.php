<x-layouts.app>
    <div class="grid h-screen place-content-center bg-white font-poppins px-6">
        <div class="text-center">
            <img
                src="{{ asset("assets/icons/checkmark-icon.svg") }}"
                alt="Sukses"
                class="w-32 h-32 mx-auto mb-6"
            />
            
            <h1 class="text-2xl font-bold text-black-80 mb-2">
                Transaksi Berhasil! 🎉
            </h1>
            
            @if(session('invoice_number'))
                <div class="bg-gray-100 rounded-xl px-6 py-4 my-4">
                    <p class="text-sm text-gray-500 mb-1">Nomor Invoice</p>
                    <p class="text-lg font-bold text-primary-50">{{ session('invoice_number') }}</p>
                </div>
            @endif
            
            <p class="text-sm text-black-50 mb-6">
                Terima kasih telah memesan. Pesananmu sedang diproses!
            </p>
            
            <div class="space-y-3">
                @if(session('invoice_number'))
                    <a href="{{ route('order.track', session('invoice_number')) }}"
                       class="flex w-full items-center justify-center gap-2 rounded-full bg-primary-50 px-6 py-3 font-semibold text-white hover:bg-primary-60 transition-all">
                        📍 Lacak Pesanan
                    </a>
                @endif
                
                <a href="/"
                   wire:navigate
                   class="flex w-full items-center justify-center gap-2 rounded-full border-2 border-primary-50 px-6 py-3 font-semibold text-primary-50 hover:bg-primary-10 transition-all">
                    Kembali ke Menu
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>

