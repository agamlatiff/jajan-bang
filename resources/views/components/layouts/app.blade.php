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

        <script
            src="https://unpkg.com/html5-qrcode"
            type="text/javascript"
        ></script>

        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet"
        />

        @vite(["resources/css/app.css", "resources/js/app.js"])

        <title>{{ $title ?? "Jajan Bang" }}</title>
    </head>
    <body class="{{ $class ?? "" }} mx-auto max-w-md bg-[#f5f5f9]">
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

