<x-filament-panels::page>
    <div class="space-y-6">
        @if($is2FAEnabled)
            {{-- 2FA is Enabled --}}
            <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <x-heroicon-o-shield-check class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">2FA Aktif</h3>
                        <p class="text-green-600 dark:text-green-400">Akun Anda dilindungi dengan Two-Factor Authentication.</p>
                    </div>
                </div>
            </div>

            <x-filament::button color="danger" wire:click="disable2FA">
                Nonaktifkan 2FA
            </x-filament::button>
        @else
            {{-- Setup 2FA --}}
            <div class="p-6 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800">
                <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200 mb-4">Setup Two-Factor Authentication</h3>
                <p class="text-yellow-700 dark:text-yellow-300 mb-4">
                    Scan QR code di bawah dengan aplikasi authenticator (Google Authenticator, Authy, dll).
                </p>

                @if($qrCodeSvg)
                    <div class="bg-white p-4 rounded-lg inline-block mb-4">
                        {!! $qrCodeSvg !!}
                    </div>
                @endif

                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Atau masukkan kode ini secara manual:</p>
                    <code class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded text-sm font-mono">{{ $secret }}</code>
                </div>

                <div class="max-w-xs">
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            wire:model="code"
                            placeholder="Masukkan 6-digit kode"
                            maxlength="6"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="mt-4">
                    <x-filament::button wire:click="enable2FA">
                        Aktifkan 2FA
                    </x-filament::button>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
