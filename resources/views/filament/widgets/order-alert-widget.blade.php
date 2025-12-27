<x-filament-widgets::widget class="hidden">
    <div 
        wire:poll.10s="checkNewOrders"
        x-data="{ 
            playSound() {
                const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                audio.play().catch(e => console.log('Audio play failed silently', e));
            }
        }"
        @play-notification-sound.window="playSound()"
    >
        {{-- Hidden widget just for polling --}}
    </div>
</x-filament-widgets::widget>
