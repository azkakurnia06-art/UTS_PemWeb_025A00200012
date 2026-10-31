<?php
declare(strict_types=1);

/**
 * functions.php
 * Kumpulan fungsi buatan sendiri dengan strict typing dan return type
 * Digunakan untuk pemrosesan logika katalog Twenty Three Coffee
 */

/**
 * Fungsi Keamanan HTML (Wrapper htmlspecialchars untuk pencegahan XSS)
 */
function e(string $nilai): string {
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

/**
 * Mengubah angka bulat menjadi format mata uang Rupiah
 */
function formatRupiah(int $angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * Menghitung total keseluruhan item menu
 * Menggunakan fungsi bawaan PHP: count()
 */
function hitungTotalMenu(array $dataMenu): int {
    return count($dataMenu);
}

/**
 * Menghitung total menu yang saat ini tersedia (stok ada)
 * Menggunakan fungsi bawaan PHP: count() dan array_filter()
 */
function hitungMenuTersedia(array $dataMenu): int {
    $tersedia = array_filter($dataMenu, function (array $item): bool {
        return (bool) ($item['is_tersedia'] ?? false);
    });
    return count($tersedia);
}

/**
 * Mencari menu berdasarkan kata kunci pada nama atau deskripsi
 * Menggunakan fungsi bawaan PHP: array_filter()
 */
function cariMenu(array $data, string $keyword): array {
    $keyword = trim($keyword);
    if ($keyword === '') {
        return $data;
    }

    return array_filter($data, function (array $item) use ($keyword): bool {
        $namaCocok = stripos($item['nama'], $keyword) !== false;
        $deskripsiCocok = stripos($item['deskripsi'], $keyword) !== false;
        return $namaCocok || $deskripsiCocok;
    });
}

/**
 * Menyaring menu berdasarkan kategori tertentu
 * Menggunakan fungsi bawaan PHP: array_filter()
 */
function filterKategori(array $data, string $kategori): array {
    $kategori = trim($kategori);
    if ($kategori === '' || $kategori === 'Semua') {
        return $data;
    }

    return array_filter($data, function (array $item) use ($kategori): bool {
        return strcasecmp($item['kategori'], $kategori) === 0;
    });
}

/**
 * Mengurutkan data menu berdasarkan kriteria harga atau nama
 * Menggunakan fungsi bawaan PHP: usort()
 */
function urutkanMenu(array $data, string $urutan): array {
    $hasil = $data;

    match ($urutan) {
        'harga_asc' => usort($hasil, fn (array $a, array $b): int => $a['harga'] <=> $b['harga']),
        'harga_desc' => usort($hasil, fn (array $a, array $b): int => $b['harga'] <=> $a['harga']),
        'nama_asc' => usort($hasil, fn (array $a, array $b): int => strcasecmp($a['nama'], $b['nama'])),
        'nama_desc' => usort($hasil, fn (array $a, array $b): int => strcasecmp($b['nama'], $a['nama'])),
        default => null, // Biarkan urutan default jika tidak dipilih
    };

    return $hasil;
}

/**
 * Mengambil daftar kategori unik dari data menu
 * Menggunakan fungsi bawaan PHP: array_column(), array_unique(), array_values()
 */
function ambilDaftarKategori(array $data): array {
    $semuaKategori = array_column($data, 'kategori');
    return array_values(array_unique($semuaKategori));
}

/**
 * Menghitung ringkasan statistik harga menu
 * Menggunakan fungsi bawaan PHP: count(), array_column(), array_sum(), min(), max()
 */
function hitungStatistikMenu(array $data): array {
    $totalItem = count($data);

    if ($totalItem === 0) {
        return [
            'total' => 0,
            'termurah' => 0,
            'termahal' => 0,
            'rata_rata' => 0
        ];
    }

    $daftarHarga = array_column($data, 'harga');
    $hargaTermurah = min($daftarHarga);
    $hargaTermahal = max($daftarHarga);
    $rataRata = (int) round(array_sum($daftarHarga) / $totalItem);

    return [
        'total' => $totalItem,
        'termurah' => $hargaTermurah,
        'termahal' => $hargaTermahal,
        'rata_rata' => $rataRata
    ];
}

/**
 * Mengambil menu rekomendasi / best seller
 * Menggunakan fungsi bawaan PHP: array_filter()
 */
function ambilMenuBestSeller(array $data): array {
    return array_filter($data, function (array $item): bool {
        return !empty($item['is_best_seller']);
    });
}

/**
 * Menyaring menu berdasarkan varian suhu (Hot atau Ice)
 * Menggunakan fungsi bawaan PHP: array_filter() dan in_array()
 */
function filterSuhu(array $data, string $suhu): array {
    $suhu = trim($suhu);
    if ($suhu === '' || $suhu === 'Semua') {
        return $data;
    }

    return array_filter($data, function (array $item) use ($suhu): bool {
        $opsi = $item['opsi_suhu'] ?? [];
        return is_array($opsi) && in_array($suhu, $opsi, true);
    });
}
