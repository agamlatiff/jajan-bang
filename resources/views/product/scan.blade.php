<div class="fixed inset-0 z-50 flex flex-col bg-black text-white font-sans antialiased overflow-hidden">
    <!-- Camera Feed -->
    <div id="reader" class="absolute inset-0 h-full w-full bg-gray-900"></div>

    <!-- Dark Gradient Overlay -->
    <div class="pointer-events-none absolute inset-0 z-10 bg-linear-to-b from-black/60 via-transparent to-black/60"></div>

    <!-- Header -->
    <div class="safe-area-padding absolute inset-x-0 top-0 z-20 flex items-center justify-between p-6 pt-8">
        <a href="{{ route('home') }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/20 text-white backdrop-blur-md transition active:scale-95 hover:bg-white/30">
            <span class="material-icons">arrow_back</span>
        </a>
        <h1 class="font-display text-xl font-bold tracking-wide text-white drop-shadow-md">Scan QR Code</h1>
        <button onclick="window.toggleFlash()" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/20 text-white backdrop-blur-md transition active:scale-95 hover:bg-white/30">
            <span class="material-icons">flash_on</span>
        </button>
    </div>

    <!-- Scanner Frame -->
    <div class="relative flex flex-1 flex-col items-center justify-center px-8 pb-12 z-10 pointer-events-none">
        <div class="relative h-72 w-72">
            <!-- Corners -->
            <div class="absolute left-0 top-0 h-12 w-12 rounded-tl-3xl border-l-4 border-t-4 border-primary shadow-[0_0_15px_rgba(217,30,38,0.6)]"></div>
            <div class="absolute right-0 top-0 h-12 w-12 rounded-tr-3xl border-r-4 border-t-4 border-primary shadow-[0_0_15px_rgba(217,30,38,0.6)]"></div>
            <div class="absolute bottom-0 left-0 h-12 w-12 rounded-bl-3xl border-b-4 border-l-4 border-primary shadow-[0_0_15px_rgba(217,30,38,0.6)]"></div>
            <div class="absolute bottom-0 right-0 h-12 w-12 rounded-br-3xl border-b-4 border-r-4 border-primary shadow-[0_0_15px_rgba(217,30,38,0.6)]"></div>
            
            <!-- Scanning Line -->
            <div class="absolute left-6 right-6 top-1/2 h-0.5 animate-pulse bg-primary shadow-[0_0_20px_rgba(217,30,38,1)]"></div>
            
            <!-- Icon Background -->
            <div class="absolute inset-0 flex items-center justify-center opacity-20">
                <span class="material-icons text-6xl text-white">qr_code_scanner</span>
            </div>
        </div>

        <div class="mt-10 space-y-2 text-center">
            <p class="text-lg font-bold tracking-wide text-white drop-shadow-lg">Align QR code within frame</p>
            <p class="max-w-[240px] text-sm font-medium text-gray-300 shadow-black drop-shadow-md">
                Scanning will start automatically
            </p>
        </div>
        
        <!-- Error Message Container (Hidden by default) -->
        <div id="scanner-error" class="hidden mt-4 p-3 bg-red-600/80 rounded-lg text-white text-sm max-w-xs text-center backdrop-blur-sm">
            Please allow camera access to scan QR codes.
        </div>
    </div>

    <!-- Footer Controls -->
    <div class="absolute inset-x-0 bottom-0 z-30 px-8 pb-12 pt-6 safe-area-padding">
        <div class="flex items-center justify-around rounded-3xl border border-white/10 bg-gray-900/80 p-6 shadow-2xl backdrop-blur-xl">
            <!-- Gallery Button -->
            <button onclick="document.getElementById('qr-input-file').click()" class="group flex flex-col items-center gap-2">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-gray-700 bg-gray-800 text-gray-300 shadow-lg transition-all duration-300 group-hover:border-gray-600 group-hover:bg-gray-700 group-active:scale-95">
                    <span class="material-icons text-xl">image</span>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 transition-colors group-hover:text-white">Gallery</span>
            </button>
            <input type="file" id="qr-input-file" accept="image/*" class="hidden" onchange="window.scanFromFile(this)">

            <!-- Flash Button (Big) -->
            <button onclick="window.toggleFlash()" class="group -mt-8 flex flex-col items-center gap-2">
                <div class="flex h-16 w-16 items-center justify-center rounded-full border-4 border-gray-900 bg-primary text-white shadow-[0_10px_20px_rgba(217,30,38,0.4)] transition-all duration-300 group-hover:bg-red-600 group-hover:shadow-[0_10px_25px_rgba(217,30,38,0.5)] group-active:scale-95">
                    <span class="material-icons text-2xl">flashlight_on</span>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider text-primary">Flash</span>
            </button>

            <!-- Enter Code Button -->
            <button onclick="
                const code = prompt('Enter table number (e.g. A1234):'); if(code) { 
                    fetch('/store-qr-result', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ table_number: code })
                    }).then(r=>r.json()).then(d=>{
                        if(d.status==='success') window.location.href='/';
                        else alert(d.message);
                    });
                }" class="group flex flex-col items-center gap-2">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-gray-700 bg-gray-800 text-gray-300 shadow-lg transition-all duration-300 group-hover:border-gray-600 group-hover:bg-gray-700 group-active:scale-95">
                    <span class="material-icons text-xl">keyboard</span>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 transition-colors group-hover:text-white">Enter Code</span>
            </button>
        </div>
    </div>
</div>
<script src="{{ asset('js/qr/scanner.js') }}" type="text/javascript" defer></script>
