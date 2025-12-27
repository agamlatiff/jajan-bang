<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Access - JajanBang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg shadow-red-500/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Dashboard Dapur</h1>
            <p class="text-gray-400 mt-1">Masukkan PIN untuk mengakses</p>
        </div>

        <!-- PIN Form -->
        <form method="POST" action="{{ route('kitchen.auth') }}" class="bg-gray-800/50 backdrop-blur-xl rounded-2xl p-6 border border-gray-700/50">
            @csrf
            
            @if($errors->has('kitchen_pin'))
                <div class="mb-4 p-3 bg-red-500/20 border border-red-500/30 rounded-lg">
                    <p class="text-red-400 text-sm text-center">{{ $errors->first('kitchen_pin') }}</p>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="kitchen_pin" class="block text-sm font-medium text-gray-300 mb-2">PIN Akses</label>
                    <input 
                        type="password" 
                        name="kitchen_pin" 
                        id="kitchen_pin"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        autofocus
                        class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600 rounded-xl text-white text-center text-2xl tracking-[0.5em] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="••••"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-all shadow-lg shadow-red-500/30"
                >
                    Masuk ke Dapur
                </button>
            </div>
        </form>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                ← Kembali ke Menu
            </a>
        </div>
    </div>
</body>
</html>
