<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | Jajan Bang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen flex items-center justify-center font-poppins">
    <div class="text-center px-6 py-12 max-w-md">
        <!-- Illustration -->
        <div class="mb-8">
            <svg class="w-48 h-48 mx-auto text-red-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                <path d="M12 8v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="12" cy="16" r="1" fill="currentColor"/>
            </svg>
        </div>
        
        <!-- Error Code -->
        <h1 class="text-8xl font-bold text-red-500 mb-4">500</h1>
        
        <!-- Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Terjadi Kesalahan Server</h2>
        <p class="text-gray-600 mb-8">
            Maaf, terjadi kesalahan pada server kami. Tim kami sedang memperbaikinya.
        </p>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="location.reload()" 
               class="inline-flex items-center justify-center gap-2 bg-primary-50 text-white px-6 py-3 rounded-full font-semibold hover:bg-primary-60 transition-all hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Coba Lagi
            </button>
            <a href="{{ url('/menu') }}" 
               class="inline-flex items-center justify-center gap-2 border-2 border-primary-50 text-primary-50 px-6 py-3 rounded-full font-semibold hover:bg-primary-10 transition-all">
                Kembali ke Menu
            </a>
        </div>
    </div>
</body>
</html>
