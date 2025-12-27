<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="#f97316" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <meta name="apple-mobile-web-app-title" content="Jajan Bang" />
        <meta name="description" content="Aplikasi pemesanan makanan dengan QR Code - Jajan Bang" />
        
        <!-- PWA Manifest -->
        <link rel="manifest" href="/manifest.json" />
        <link rel="apple-touch-icon" href="/assets/icons/icon-192.png" />
        
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

        <script
            src="https://unpkg.com/html5-qrcode"
            type="text/javascript"
            defer
        ></script>

        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&flay=swap"
            rel="stylesheet"
        />

        @vite(["resources/css/app.css", "resources/js/app.js"])

        <title>{{ $title ?? "Jajan Bang" }}</title>
    </head>
    <body class="{{ $class ?? "" }} mx-auto max-w-md min-h-screen bg-background-light text-black-100 font-sans antialiased selection:bg-primary selection:text-white">
        {{ $slot }}
        
        <!-- Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then(reg => console.log('SW registered'))
                        .catch(err => console.log('SW registration failed'));
                });
            }
        </script>
    </body>
</html>

