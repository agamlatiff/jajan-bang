<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Jajan Bang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 to-orange-100 min-h-screen flex items-center justify-center font-poppins">
    <div class="text-center px-6 py-12 max-w-md">
        <!-- Illustration -->
        <div class="mb-8">
            <svg class="w-48 h-48 mx-auto text-primary-50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                <path d="M8 15s1.5 2 4 2 4-2 4-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" transform="rotate(180 12 15)"/>
                <circle cx="9" cy="9" r="1.5" fill="currentColor"/>
                <circle cx="15" cy="9" r="1.5" fill="currentColor"/>
            </svg>
        </div>
        
        <!-- Error Code -->
        <h1 class="text-8xl font-bold text-primary-50 mb-4">404</h1>
        
        <!-- Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-600 mb-8">
            Maaf, halaman yang kamu cari tidak ada atau sudah dipindahkan.
        </p>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/menu') }}" 
               class="inline-flex items-center justify-center gap-2 bg-primary-50 text-white px-6 py-3 rounded-full font-semibold hover:bg-primary-60 transition-all hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Menu
            </a>
            <a href="javascript:history.back()" 
               class="inline-flex items-center justify-center gap-2 border-2 border-primary-50 text-primary-50 px-6 py-3 rounded-full font-semibold hover:bg-primary-10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</body>
</html>
