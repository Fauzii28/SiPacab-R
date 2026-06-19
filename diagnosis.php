<?php
include 'koneksi.php';

// Ambil semua data gejala dan kelompokkan berdasarkan kategori
$query_gejala = mysqli_query($koneksi, "SELECT * FROM gejala ORDER BY id_gejala ASC");

$gejala_buah = [];
$gejala_daun = [];
$gejala_batang = [];

while($row = mysqli_fetch_assoc($query_gejala)) {
    // Pastikan penulisan kategori di database sama persis (huruf besar/kecil)
    if (strtolower($row['kategori_bagian']) == 'buah') {
        $gejala_buah[] = $row;
    } elseif (strtolower($row['kategori_bagian']) == 'daun') {
        $gejala_daun[] = $row;
    } else {
        $gejala_batang[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mulai Diagnosis - SIPACAB-R</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #e5e7eb; 
        }
        /* CSS Khusus agar terasa seperti Aplikasi Native Android */
        .app-frame { 
            -webkit-tap-highlight-color: transparent; 
            user-select: none; 
            scrollbar-width: none; 
        }
        .app-frame::-webkit-scrollbar { 
            display: none; 
        }
        .sticky-tabs { 
            position: sticky; 
            top: 0; 
            z-index: 10; 
            background-color: #f9fafb; 
            padding-top: 10px; 
            padding-bottom: 10px; 
            margin-top: -10px;
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen">

    <div class="app-frame w-full max-w-md bg-gray-50 h-[100dvh] flex flex-col relative overflow-hidden shadow-2xl sm:rounded-2xl sm:h-[90vh]">
        
        <header class="p-4 bg-green-600 text-white flex items-center space-x-3 shadow-md z-20 flex-shrink-0">
            <a href="index.php" class="text-white bg-green-700 p-2 rounded-full active:scale-90 transition-transform">⬅️</a>
            <div>
                <h1 class="font-bold text-lg leading-tight">SIPACAB-R</h1>
                <p class="text-xs opacity-90 leading-none">Kuesioner Diagnosis</p>
            </div>
        </header>

        <main class="flex-grow overflow-y-auto p-4 pb-28 relative">
            
            <div class="bg-blue-50 border border-blue-200 p-3 rounded-xl mb-4">
                <p class="text-xs text-blue-800 leading-relaxed text-center">
                    <strong>Petunjuk:</strong> Ceklis tingkat keyakinan pada gejala yang Anda temukan. Biarkan opsi <b>"Tidak"</b> jika gejala tidak terjadi.
                </p>
            </div>

            <div class="flex space-x-2 mb-4 bg-gray-200 p-1 rounded-xl sticky-tabs shadow-sm">
                <button type="button" onclick="switchTab('buah')" id="btn-buah" class="flex-1 py-2 bg-white text-green-600 shadow-sm rounded-lg text-xs font-bold transition-all active:scale-95">Gejala Buah</button>
                <button type="button" onclick="switchTab('daun')" id="btn-daun" class="flex-1 py-2 text-gray-500 rounded-lg text-xs font-bold transition-all active:scale-95">Gejala Daun</button>
                <button type="button" onclick="switchTab('batang')" id="btn-batang" class="flex-1 py-2 text-gray-500 rounded-lg text-xs font-bold transition-all active:scale-95">Gejala Batang</button>
            </div>

            <form action="hasil.php" method="POST" id="form-diagnosis">
                
                <div id="tab-buah" class="tab-content block">
                    <h2 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">📋 Fase 1: Observasi Buah</h2>
                    <?php foreach($gejala_buah as $row) : ?>
                        <?php renderPertanyaan($row); ?>
                    <?php endforeach; ?>
                    <button type="button" onclick="switchTab('daun')" class="w-full bg-gray-200 text-gray-700 font-bold py-4 rounded-xl hover:bg-gray-300 mt-4 text-sm shadow-sm active:scale-95 transition-transform">Lanjut ke Fase Daun ➔</button>
                </div>

                <div id="tab-daun" class="tab-content hidden">
                    <h2 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">📋 Fase 2: Observasi Daun</h2>
                    <?php foreach($gejala_daun as $row) : ?>
                        <?php renderPertanyaan($row); ?>
                    <?php endforeach; ?>
                    <button type="button" onclick="switchTab('batang')" class="w-full bg-gray-200 text-gray-700 font-bold py-4 rounded-xl hover:bg-gray-300 mt-4 text-sm shadow-sm active:scale-95 transition-transform">Lanjut ke Fase Batang ➔</button>
                </div>

                <div id="tab-batang" class="tab-content hidden">
                    <h2 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">📋 Fase 3: Observasi Batang & Umum</h2>
                    <?php foreach($gejala_batang as $row) : ?>
                        <?php renderPertanyaan($row); ?>
                    <?php endforeach; ?>
                    
                    <div class="mt-8 mb-4">
                        <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-green-700 active:scale-95 transition-all text-lg">
                            🔍 Proses Hasil Diagnosis
                        </button>
                    </div>
                </div>

            </form>
        </main>

        <nav class="bg-white border-t border-gray-200 p-4 flex justify-around items-center absolute bottom-0 w-full z-20 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] pb-6 pt-4">
            <a href="index.php" class="flex flex-col items-center text-gray-400 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="diagnosis.php" class="flex flex-col items-center text-green-600 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">🩺</span>
                <span class="text-[10px] font-bold">Diagnosis</span>
            </a>
            <a href="kamus.php" class="flex flex-col items-center text-gray-400 transform transition-transform active:scale-90">
                <span class="text-2xl mb-1">📖</span>
                <span class="text-[10px] font-bold">Kamus</span>
            </a>
        </nav>

    </div>

    <script>
        function switchTab(tabId) {
            // Sembunyikan semua konten tab
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('block');
                el.classList.add('hidden');
            });
            // Tampilkan tab yang dipilih
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.add('block');

            // Reset warna semua tombol
            let buttons = ['btn-buah', 'btn-daun', 'btn-batang'];
            buttons.forEach(btn => {
                let element = document.getElementById(btn);
                element.classList.remove('bg-white', 'text-green-600', 'shadow-sm');
                element.classList.add('text-gray-500');
            });

            // Warnai tombol yang aktif
            let activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-gray-500');
            activeBtn.classList.add('bg-white', 'text-green-600', 'shadow-sm');
            
            // Scroll ke atas (di dalam tag main) saat pindah tab agar rapi
            document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>
</html>

<?php
// Fungsi HTML dirender ulang dengan UI Mobile, nilai VALUE SAMA PERSIS.
function renderPertanyaan($row) {
?>
    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4 shadow-sm">
        <p class="font-semibold text-gray-800 mb-3 text-sm leading-snug">
            "Apakah <?php echo $row['nama_gejala']; ?>?"
        </p>
        <div class="space-y-1">
            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-green-50 active:bg-green-100 transition border border-transparent cursor-pointer text-sm">
                <input type="radio" name="gejala[<?php echo $row['id_gejala']; ?>]" value="1.0" class="w-5 h-5 text-green-600 accent-green-600">
                <span>Sangat Yakin (Pasti Terjadi)</span>
            </label>
            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-green-50 active:bg-green-100 transition border border-transparent cursor-pointer text-sm">
                <input type="radio" name="gejala[<?php echo $row['id_gejala']; ?>]" value="0.8" class="w-5 h-5 text-green-600 accent-green-600">
                <span>Yakin</span>
            </label>
            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-green-50 active:bg-green-100 transition border border-transparent cursor-pointer text-sm">
                <input type="radio" name="gejala[<?php echo $row['id_gejala']; ?>]" value="0.6" class="w-5 h-5 text-green-600 accent-green-600">
                <span>Cukup Yakin</span>
            </label>
            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-green-50 active:bg-green-100 transition border border-transparent cursor-pointer text-sm">
                <input type="radio" name="gejala[<?php echo $row['id_gejala']; ?>]" value="0.4" class="w-5 h-5 text-green-600 accent-green-600">
                <span>Kurang Yakin</span>
            </label>
            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-green-50 active:bg-green-100 transition border border-transparent cursor-pointer text-sm">
                <input type="radio" name="gejala[<?php echo $row['id_gejala']; ?>]" value="0" class="w-5 h-5 text-green-600 accent-green-600">
                <span>Tidak (Sama Sekali Tidak Terjadi)</span>
            </label>
        </div>
    </div>
<?php
}
?>