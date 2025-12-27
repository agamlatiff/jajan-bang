<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-heroicon-o-bolt class="w-5 h-5 text-primary-500" />
                <span>Aksi Cepat</span>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($this->getActions() as $action)
                <a 
                    href="{{ $action['url'] }}" 
                    @if(isset($action['external']) && $action['external']) target="_blank" @endif
                    class="group flex items-center gap-4 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-{{ $action['color'] }}-500 hover:bg-{{ $action['color'] }}-50 dark:hover:bg-{{ $action['color'] }}-900/20 transition-all duration-200 hover:shadow-md"
                >
                    <div class="shrink-0 w-12 h-12 rounded-xl bg-{{ $action['color'] }}-100 dark:bg-{{ $action['color'] }}-900/30 text-{{ $action['color'] }}-600 dark:text-{{ $action['color'] }}-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                        @svg($action['icon'], 'w-6 h-6')
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white group-hover:text-{{ $action['color'] }}-600 dark:group-hover:text-{{ $action['color'] }}-400 transition-colors">
                            {{ $action['label'] }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                            {{ $action['description'] }}
                        </p>
                    </div>
                    <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-400 group-hover:text-{{ $action['color'] }}-500 group-hover:translate-x-1 transition-all" />
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
