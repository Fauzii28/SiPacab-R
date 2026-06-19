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
                'solusi' => $p['solusi'],
                'gambar' => $p['gambar']
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosis - SIPACAB-R</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        @media print {
            @page { 
                size: A4;
                margin: 1.5cm; /* Diperkecil agar muat 1 halaman */
            }
            body { 
                background-color: white !important; 
                color: black !important;
                font-family: 'Times New Roman', Times, serif !important; 
                font-size: 11pt !important; /* Standar font surat agar tidak kebesaran */
            }
            .print-clean {
                background: transparent !important; border: none !important; box-shadow: none !important; padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 print:bg-white text-gray-800 print:text-black">
    
    <div class="max-w-md mx-auto bg-white min-h-screen shadow-xl print:shadow-none print:max-w-full print:mx-0 flex flex-col">
        
        <header class="p-4 bg-green-600 text-white flex items-center space-x-3 shadow-md print:hidden">
            <a href="diagnosis.php" class="text-white">⬅️</a>
            <h1 class="font-bold text-lg ">Hasil Diagnosis</h1>
        </header>

        <div class="hidden print:block text-center mb-4 text-black">
            <h1 class="text-2xl font-bold uppercase tracking-wider">SIPACAB-R</h1>
            <h2 class="text-lg font-bold uppercase tracking-wide">Sistem Pakar Diagnosa Penyakit Cabai</h2>
            <p class="text-xs italic">Jl. KH. Abdul Halim No. 103, Universitas Majalengka, Kabupaten Majalengka, Jawa Barat</p>
            <div class="border-b-2 border-black mt-2 mb-0.5"></div>
            <div class="border-b border-black mb-4"></div>
            
            <h3 class="text-base font-bold uppercase underline">Surat Keterangan Hasil Diagnosa</h3>
            <p class="text-xs mt-0.5">Nomor: <?php echo date('Y/m'); ?>/SPC-R/<?php echo rand(100, 999); ?></p>
        </div>

        <main class="p-6 print:px-0 print:py-0">
            <?php if (!empty($hasil_diagnosis)) : ?>
                
                <div class="hidden print:block mb-4 text-sm">
                    <table class="w-full text-left">
                        <tr>
                            <td class="w-1/4 font-semibold py-0.5">Tanggal Diagnosa</td>
                            <td class="w-4 py-0.5">:</td>
                            <td class="py-0.5"><?php echo date('d F Y / H:i:s'); ?> WIB</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-0.5">Metode Analisis</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">Certainty Factor</td>
                        </tr>
                    </table>
                </div>

                <div class="text-center mb-6 print:text-left print:mb-4">
                    <p class="text-gray-500 text-sm print:text-black print:font-semibold print:mb-2">Kesimpulan Hasil Diagnosa:</p>
                    
                    <div class="flex flex-col items-center print:flex-row print:items-center print:gap-4">
                        <div class="my-4 print:my-0 w-48 h-48 rounded-2xl overflow-hidden shadow-md border-4 border-white bg-gray-100 print:rounded-none print:shadow-none print:border-black print:border print:w-28 print:h-28">
                            <img src="assets/img/<?php echo $hasil_diagnosis[0]['gambar']; ?>" alt="Foto Penyakit" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="w-full print:w-auto text-center print:text-left">
                            <h2 class="text-3xl font-bold text-red-600 print:text-black print:text-xl uppercase"><?php echo $hasil_diagnosis[0]['nama']; ?></h2>
                            <p class="italic text-gray-400 text-sm print:text-black">(<?php echo $hasil_diagnosis[0]['latin']; ?>)</p>
                            
                            <div class="mt-4 bg-green-100 rounded-full h-4 overflow-hidden border border-green-200 print:hidden">
                                <div class="bg-green-600 h-full" style="width: <?php echo $hasil_diagnosis[0]['persentase']; ?>%"></div>
                            </div>
                            <p class="font-bold text-green-700 mt-2 print:text-black print:text-sm">Keyakinan Sistem: <?php echo $hasil_diagnosis[0]['persentase']; ?>%</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 print:space-y-3 print:border-t print:border-black print:pt-3">
                    <div class="bg-white border-l-4 border-blue-500 p-4 shadow-sm rounded-r-xl bg-blue-50 print:clean">
                        <h3 class="font-bold text-blue-800 mb-1 print:text-black print:text-sm print:font-bold">📋 Deskripsi Penyakit:</h3>
                        <p class="text-sm text-gray-700 print:text-black text-justify leading-snug">
                            <?php echo $hasil_diagnosis[0]['deskripsi']; ?>
                        </p>
                    </div>

                    <div class="bg-white border-l-4 border-green-500 p-4 shadow-sm rounded-r-xl bg-green-50 print:clean print:border-t print:border-dashed print:border-gray-400 print:pt-2">
                        <h3 class="font-bold text-green-800 mb-1 print:text-black print:text-sm print:font-bold">💡 Solusi Penanganan:</h3>
                        <p class="text-sm text-gray-700 print:text-black text-justify leading-snug">
                            <?php echo $hasil_diagnosis[0]['solusi']; ?>
                        </p>
                    </div>
                </div>

                <div class="hidden print:flex justify-end mt-8">
                    <div class="text-center w-56 text-sm">
                        <p class="mb-16">Majalengka, <?php echo date('d M Y'); ?><br>Mengetahui,</p>
                        <p class="font-bold underline">Tim SIPACAB-R</p>
                    </div>
                </div>

                <div class="mt-8 flex gap-2 print:hidden">
                    <a href="diagnosis.php" class="flex-1 text-center border-2 border-green-600 text-green-600 font-bold py-3 rounded-xl hover:bg-green-50 transition">Ulangi</a>
                    <button onclick="window.print()" class="flex-1 bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-green-700 transition">Cetak Hasil</button>
                </div>

            <?php else : ?>
                <div class="text-center py-20 print:hidden">
                    <p class="text-gray-400">Maaf, sistem tidak menemukan kecocokan penyakit. Pastikan gejala yang dipilih sesuai.</p>
                    <a href="diagnosis.php" class="mt-4 inline-block text-green-600 font-bold underline">Kembali</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>