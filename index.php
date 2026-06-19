<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIPACAB-R - Sistem Pakar Cabai Rawit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #e5e7eb; /* Warna abu luar frame untuk tampilan desktop */
        }
        /* CSS Khusus agar terasa seperti Aplikasi Native Android */
        .app-frame {
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            scrollbar-width: none; /* Sembunyikan scrollbar di Firefox */
        }
        .app-frame::-webkit-scrollbar { 
            display: none; /* Sembunyikan scrollbar di Chrome/Safari */
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen">

    <div class="app-frame w-full max-w-md bg-gray-50 h-[100dvh] flex flex-col relative overflow-hidden shadow-2xl sm:rounded-2xl sm:h-[90vh]">
        
        <header class="p-4 bg-green-600 text-white flex items-center space-x-3 shadow-md z-20 flex-shrink-0">
            <img src="assets/img/logo.png" alt="Logo" class="w-10 h-10 rounded-full">
            <div>
                <h1 class="font-bold text-lg leading-tight">SIPACAB-R</h1>
                <p class="text-[11px] opacity-90 text-white leading-none mt-1">Sistem Pakar Cabai Rawit</p>
            </div> 
        </header>

        <main class="flex-grow overflow-y-auto p-5 pb-28 relative">
            
            <div class="bg-green-100 rounded-2xl p-6 mb-6 text-center border-2 border-green-200 shadow-sm relative overflow-hidden">
                <h2 class="text-xl font-bold text-green-800 mb-2 relative z-10">Deteksi Dini, Diagnosa Pasti, Rawit Terlindungi</h2>
                
                <a href="diagnosis.php" class="relative z-10 block w-full bg-green-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 active:bg-green-800 transition-all shadow-lg active:scale-95 text-center text-lg tracking-wide">
                    Ayo Diagnosis
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 text-yellow-600 text-xl">🔍</div>
                    <h3 class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Amati Tanaman</h3>
                    <p class="text-[10px] text-gray-500 mt-1 leading-snug">Perhatikan gejala yang muncul pada tanaman.</p>
                </div>
                <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 text-blue-600 text-xl">🩺</div>
                    <h3 class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Mulai Diagnosis</h3>
                    <p class="text-[10px] text-gray-500 mt-1 leading-snug">Periksa tanamanmu sebelum terlambat.</p>
                </div>
                <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 text-red-600 text-xl">📝</div>
                    <h3 class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Isi Kuesioner</h3>
                    <p class="text-[10px] text-gray-500 mt-1 leading-snug">Lengkapi daftar pertanyaan gejala.</p>
                </div>
                <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 text-green-600 text-xl">💊</div>
                    <h3 class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Dapat Solusi</h3>
                    <p class="text-[10px] text-gray-500 mt-1 leading-snug">Terima rekomendasi penanganan tepat.</p>
                </div>
            </div>

        </main>

        <nav class="bg-white border-t border-gray-200 p-4 flex justify-around items-center absolute bottom-0 w-full z-20 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] pb-6 pt-4">
            <a href="index.php" class="flex flex-col items-center text-green-600 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="diagnosis.php" class="flex flex-col items-center text-gray-400 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">🩺</span>
                <span class="text-[10px] font-bold">Diagnosis</span>
            </a>
            <a href="kamus.php" class="flex flex-col items-center text-gray-400 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">📖</span>
                <span class="text-[10px] font-bold">Kamus</span>
            </a>
        </nav>

    </div>

</body>
</html>