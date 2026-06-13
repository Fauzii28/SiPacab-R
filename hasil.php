<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gejala'])) {
    $gejala_terpilih = $_POST['gejala']; // Ambil array [id_gejala => cf_user]
    $hasil_diagnosis = [];

    // 1. Ambil data semua penyakit
    $query_penyakit = mysqli_query($koneksi, "SELECT * FROM penyakit");

    while ($p = mysqli_fetch_assoc($query_penyakit)) {
        $id_p = $p['id_penyakit'];
        $cf_he = 0;
        $cf_old = 0;
        $list_cf_gejala = [];

        // 2. Cari gejala yang berhubungan dengan penyakit ini di basis_pengetahuan
        $query_bp = mysqli_query($koneksi, "SELECT * FROM basis_pengetahuan WHERE id_penyakit = '$id_p'");
        
        while ($bp = mysqli_fetch_assoc($query_bp)) {
            $id_g = $bp['id_gejala'];
            
            
            if (isset($gejala_terpilih[$id_g]) && $gejala_terpilih[$id_g] > 0) {
                $cf_user = $gejala_terpilih[$id_g];
                $cf_pakar = $bp['cf_pakar'];
                
                
                $cf_gejala = $cf_user * $cf_pakar;
                
               
                $list_cf_gejala[] = $cf_gejala;
            }
        }

        
        if (!empty($list_cf_gejala)) {
            $cf_old = $list_cf_gejala[0];
            for ($i = 1; $i < count($list_cf_gejala); $i++) {
                
                $cf_old = $cf_old + ($list_cf_gejala[$i] * (1 - $cf_old));
            }
            
            $hasil_diagnosis[] = [
                'nama' => $p['nama_penyakit'],
                'latin' => $p['nama_latin'],
                'persentase' => round($cf_old * 100, 2),
                'deskripsi' => $p['deskripsi'],
                'solusi' => $p['solusi']
            ];
        }
    }

    // Urutkan hasil dari persentase tertinggi
    usort($hasil_diagnosis, function($a, $b) {
        return $b['persentase'] <=> $a['persentase'];
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosis - SIPACAB-R</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50">
    <div class="max-w-md mx-auto bg-white min-h-screen shadow-xl flex flex-col">
        
        <header class="p-4 bg-green-600 text-white flex items-center space-x-3 shadow-md">
            <a href="diagnosis.php" class="text-white">⬅️</a>
            <h1 class="font-bold text-lg">Hasil Diagnosis</h1>
        </header>

        <main class="p-6">
            <?php if (!empty($hasil_diagnosis)) : ?>
                <div class="text-center mb-8">
                    <p class="text-gray-500 text-sm">Berdasarkan gejala yang dipilih, tanaman Anda didiagnosa:</p>
                    <h2 class="text-3xl font-bold text-red-600 mt-2"><?php echo $hasil_diagnosis[0]['nama']; ?></h2>
                    <p class="italic text-gray-400 text-sm">(<?php echo $hasil_diagnosis[0]['latin']; ?>)</p>
                    
                    <div class="mt-4 bg-green-100 rounded-full h-4 overflow-hidden border border-green-200">
                        <div class="bg-green-600 h-full" style="width: <?php echo $hasil_diagnosis[0]['persentase']; ?>%"></div>
                    </div>
                    <p class="font-bold text-green-700 mt-2">Tingkat Keyakinan: <?php echo $hasil_diagnosis[0]['persentase']; ?>%</p>
                </div>

                <div class="space-y-6">
                    <div class="bg-white border-l-4 border-blue-500 p-4 shadow-sm rounded-r-xl bg-blue-50">
                        <h3 class="font-bold text-blue-800 mb-1">📋 Deskripsi</h3>
                        <p class="text-sm text-gray-700"><?php echo $hasil_diagnosis[0]['deskripsi']; ?></p>
                    </div>

                    <div class="bg-white border-l-4 border-green-500 p-4 shadow-sm rounded-r-xl bg-green-50">
                        <h3 class="font-bold text-green-800 mb-1">💡 Solusi Penanganan</h3>
                        <p class="text-sm text-gray-700"><?php echo $hasil_diagnosis[0]['solusi']; ?></p>
                    </div>
                </div>

                <div class="mt-10 flex gap-2">
                    <a href="diagnosis.php" class="flex-1 text-center border-2 border-green-600 text-green-600 font-bold py-3 rounded-xl hover:bg-green-50 transition">Ulangi</a>
                    <button onclick="window.print()" class="flex-1 bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-green-700 transition">Cetak Hasil</button>
                </div>

            <?php else : ?>
                <div class="text-center py-20">
                    <p class="text-gray-400">Maaf, sistem tidak menemukan kecocokan penyakit. Pastikan gejala yang dipilih sesuai.</p>
                    <a href="diagnosis.php" class="mt-4 inline-block text-green-600 font-bold underline">Kembali</a>
                </div>
            <?php endif; ?>
        </main>

    </div>
</body>
</html>