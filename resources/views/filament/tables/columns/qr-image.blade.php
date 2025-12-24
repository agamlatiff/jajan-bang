@php
    $imagePath = $getRecord()->image;
    $fullPath = storage_path('app/public/' . $imagePath);
    $svgContent = '';
    
    if (file_exists($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'svg') {
        $svgContent = file_get_contents($fullPath);
    }
@endphp

<div class="flex items-center justify-center">
    @if($svgContent)
        <div class="w-16 h-16 bg-white rounded p-1 shadow-sm flex items-center justify-center overflow-hidden">
            <div class="max-w-full max-h-full flex items-center justify-center [&>svg]:max-w-full [&>svg]:max-h-full [&>svg]:w-auto [&>svg]:h-auto">
                {!! $svgContent !!}
            </div>
        </div>
    @else
        <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center text-gray-400">
            <x-heroicon-o-photo class="w-8 h-8" />
        </div>
    @endif
</div>
