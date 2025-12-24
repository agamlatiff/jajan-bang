const CACHE_NAME = "jajanbang-v1";
const STATIC_ASSETS = [
    "/",
    "/offline.html",
    "/assets/images/logo.png",
    "/assets/icons/cart-icon.svg",
    "/assets/icons/home-icon.svg",
];

// Install event - cache static assets
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log("Caching static assets");
            return cache.addAll(STATIC_ASSETS);
        }),
    );
    self.skipWaiting();
});

// Activate event - clean old caches
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name)),
            );
        }),
    );
    self.clients.claim();
});

// Fetch event - network first, fallback to cache
self.addEventListener("fetch", (event) => {
    // Skip non-GET requests
    if (event.request.method !== "GET") return;

    // Skip API requests and Livewire
    if (
        event.request.url.includes("/livewire/") ||
        event.request.url.includes("/api/") ||
        event.request.url.includes("/payment/")
    ) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Clone and cache successful responses
                if (response.status === 200) {
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                }
                return response;
            })
            .catch(() => {
                // Return cached version or offline page
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // For navigation requests, show offline page
                    if (event.request.mode === "navigate") {
                        return caches.match("/offline.html");
                    }
                    return new Response("Offline", { status: 503 });
                });
            }),
    );
});
