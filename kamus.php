<?php
include 'koneksi.php';

// Ambil semua data penyakit untuk ditampilkan di kamus
$query_kamus = mysqli_query($koneksi, "SELECT * FROM penyakit ORDER BY nama_penyakit ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kamus Penyakit - SIPACAB-R</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #e5e7eb; /* Warna abu luar frame */
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
        
        <header class="p-4 bg-green-600 text-white flex items-center justify-between shadow-md z-20 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <a href="index.php" class="text-white bg-green-700 p-2 rounded-full active:scale-90 transition-transform">⬅️</a>
                <h1 class="font-bold text-lg leading-tight">Kamus Penyakit</h1>
            </div>
        </header>

        <div class="p-4 bg-white shadow-sm z-10 flex-shrink-0 relative">
            <div class="relative">
                <input type="text" placeholder="Cari penyakit..." class="w-full bg-gray-100 border border-gray-200 rounded-xl py-3 px-10 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
                <span class="absolute left-3 top-3 text-gray-400 text-lg">🔍</span>
            </div>
        </div>

        <main class="flex-grow overflow-y-auto p-4 pb-28 space-y-4">
            
            <?php while($data = mysqli_fetch_assoc($query_kamus)) : ?>
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow transition-shadow">
                <div class="h-32 bg-green-100 flex items-center justify-center">
                    <?php if($data['gambar']): ?>
                        <img src="assets/img/<?php echo $data['gambar']; ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-5xl opacity-80">🌱</span>
                    <?php endif; ?>
                </div>
                
                <div class="p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-green-800 text-lg leading-tight"><?php echo $data['nama_penyakit']; ?></h3>
                            <p class="text-[11px] italic text-gray-500 mt-1"><?php echo $data['nama_latin']; ?></p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Penyebab & Deskripsi</h4>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                <?php echo $data['deskripsi']; ?>
                            </p>
                        </div>
                        
                        <div class="bg-green-50 p-3 rounded-xl border border-green-100">
                            <h4 class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1 flex items-center gap-1">
                                <span>💡</span> Cara Penanganan
                            </h4>
                            <p class="text-[13px] text-green-900 leading-relaxed font-medium">
                                <?php echo $data['solusi']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>

        </main>

        <nav class="bg-white border-t border-gray-200 p-4 flex justify-around items-center absolute bottom-0 w-full z-20 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] pb-6 pt-4">
            <a href="index.php" class="flex flex-col items-center text-gray-400 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="diagnosis.php" class="flex flex-col items-center text-gray-400 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">🩺</span>
                <span class="text-[10px] font-bold">Diagnosis</span>
            </a>
            <a href="kamus.php" class="flex flex-col items-center text-green-600 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">📖</span>
                <span class="text-[10px] font-bold">Kamus</span>
            </a>
        </nav>

    </div>

</body>
</html>