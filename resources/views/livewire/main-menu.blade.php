<nav class="fixed bottom-0 left-0 right-0 bg-white dark:bg-card-dark border-t border-gray-100 dark:border-gray-800 px-6 py-4 z-30 flex justify-between items-center max-w-md mx-auto shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    <!-- Home -->
    <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}" wire:navigate>
        <span class="material-icons text-2xl">home</span>
        <span class="text-[10px] font-medium">Home</span>
    </a>

    <!-- Menu / All Food -->
    <a href="{{ route('product.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('product.index') || request()->routeIs('product.promo') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}" wire:navigate>
        <span class="material-icons text-2xl">restaurant_menu</span>
        <span class="text-[10px] font-medium">Menu</span>
    </a>

    <!-- Cart (Floating Center) -->
    <div class="relative -top-8">
        <a href="{{ route('payment.cart') }}" class="bg-primary text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg shadow-primary/40 transform transition hover:scale-105" wire:navigate>
            <span class="material-icons text-2xl">shopping_bag</span>
        </a>
    </div>

    <!-- Favorites -->
    <a href="{{ route('product.favorite') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('product.favorite') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}" wire:navigate>
        <span class="material-icons text-2xl">{{ request()->routeIs('product.favorite') ? 'favorite' : 'favorite_border' }}</span>
        <span class="text-[10px] font-medium">Favorites</span>
    </a>

    <!-- Orders -->
    <a href="{{ route('order.track') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('order.track') ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200' }}" wire:navigate>
        <span class="material-icons text-2xl">receipt_long</span>
        <span class="text-[10px] font-medium">Orders</span>
    </a>
</nav>
