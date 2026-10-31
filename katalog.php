<?php
declare(strict_types=1);

// katalog.php - Halaman Daftar Menu Dinamis Twenty Three Coffee
require_once 'data.php';
require_once 'functions.php';

// Parameter pencarian, filter kategori, dan pengurutan
$keyword = isset($_GET['keyword']) ? (string) $_GET['keyword'] : '';
$kategoriTerpilih = isset($_GET['kategori']) ? (string) $_GET['kategori'] : '';
$suhuTerpilih = isset($_GET['suhu']) ? (string) $_GET['suhu'] : '';
$urutan = isset($_GET['urutan']) ? (string) $_GET['urutan'] : '';

// 1. Ambil daftar kategori unik untuk dropdown
$daftarKategori = ambilDaftarKategori($menuTwentyThree);

// 2. Filter berdasarkan kategori
$hasilData = filterKategori($menuTwentyThree, $kategoriTerpilih);

// 3. Filter berdasarkan varian suhu (Hot / Ice)
$hasilData = filterSuhu($hasilData, $suhuTerpilih);

// 4. Filter berdasarkan pencarian keyword
$hasilData = cariMenu($hasilData, $keyword);

// 5. Pengurutan data (usort)
$hasilData = urutkanMenu($hasilData, $urutan);

// 5. Perhitungan statistik menggunakan fungsi array bawaan
$stats = hitungStatistikMenu($hasilData);
$totalSemuaMenu = hitungTotalMenu($menuTwentyThree);
$totalMenuTersedia = hitungMenuTersedia($hasilData);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu - Twenty Three Coffee</title>
    <link rel="icon" type="image/png" href="assets/gambar_coffee/logo_circle.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Semantik: Header & Navigasi -->
<header>
    <div class="nav-container">
        <a href="index.php" class="brand">
            <img src="assets/gambar_coffee/logo_circle.png" alt="Logo Twenty Three Coffee" class="brand-logo">
            <h1>Twenty Three Coffee</h1>
        </a>
        <nav aria-label="Navigasi Utama">
            <a href="index.php">Profil Kafe</a>
            <a href="katalog.php" class="active">Katalog Menu</a>
        </nav>
    </div>
</header>

<!-- Semantik: Konten Utama -->
<main class="container">

    <!-- Section 1: Pengantar Katalog -->
    <section class="card" style="margin-bottom: 20px;">
        <h2 style="color: var(--primary);">What’s Brewing Today? ☕</h2>
        <p style="color: var(--text-muted); margin-top: 6px; line-height: 1.6;">
            Mulai dari racikan signature coffee yang <em>rich &amp; bold</em>, kreasi creamy non-coffee yang nyegerin, sampai artisan pastry hangat yang siap nemenin obrolan santai atau sesi produktifmu. <em>Find your mood, take a sip!</em>
        </p>
    </section>

    <!-- Section 2: Ringkasan Hitung & Statistik Array PHP -->
    <section class="stats-grid" aria-label="Ringkasan Statistik Menu">
        <div class="stat-box">
            <h3 class="stat-label">Menu Ditampilkan</h3>
            <div class="stat-val"><?= $stats['total']; ?> / <?= $totalSemuaMenu; ?></div>
        </div>
        <div class="stat-box">
            <h3 class="stat-label">Menu Siap Saji</h3>
            <div class="stat-val"><?= $totalMenuTersedia; ?> Tersedia</div>
        </div>
        <div class="stat-box">
            <h3 class="stat-label">Harga Termurah</h3>
            <div class="stat-val"><?= $stats['termurah'] > 0 ? formatRupiah($stats['termurah']) : '-'; ?></div>
        </div>
        <div class="stat-box">
            <h3 class="stat-label">Rata-Rata Harga</h3>
            <div class="stat-val"><?= $stats['rata_rata'] > 0 ? formatRupiah($stats['rata_rata']) : '-'; ?></div>
        </div>
    </section>

    <!-- Section 3: Form Filter, Cari, dan Pengurutan -->
    <section class="filter-card">
        <form method="GET" action="katalog.php" class="filter-form">
            <!-- Pencarian Input -->
            <input 
                type="text" 
                name="keyword" 
                class="input-search" 
                placeholder="Lagi pengen apa? (kopi, oat milk, matcha, croissant...)" 
                value="<?= e($keyword); ?>"
            >

            <!-- Dropdown Filter Kategori -->
            <select name="kategori" class="input-select" aria-label="Filter berdasarkan Kategori">
                <option value="">Semua Kategori</option>
                <?php foreach ($daftarKategori as $kat): ?>
                    <option value="<?= e($kat); ?>" <?= ($kategoriTerpilih === $kat) ? 'selected' : ''; ?>>
                        <?= e($kat); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown Filter Varian Suhu -->
            <select name="suhu" class="input-select" aria-label="Filter berdasarkan Varian Suhu">
                <option value="">Semua Suhu</option>
                <option value="Hot" <?= ($suhuTerpilih === 'Hot') ? 'selected' : ''; ?>>☕ Panas (Hot)</option>
                <option value="Ice" <?= ($suhuTerpilih === 'Ice') ? 'selected' : ''; ?>>🧊 Dingin (Ice)</option>
            </select>

            <!-- Dropdown Pengurutan (Sorting) -->
            <select name="urutan" class="input-select" aria-label="Urutkan Menu">
                <option value="">Urutan: Standar</option>
                <option value="harga_asc" <?= ($urutan === 'harga_asc') ? 'selected' : ''; ?>>Harga Termurah &uarr;</option>
                <option value="harga_desc" <?= ($urutan === 'harga_desc') ? 'selected' : ''; ?>>Harga Termahal &darr;</option>
                <option value="nama_asc" <?= ($urutan === 'nama_asc') ? 'selected' : ''; ?>>Nama A - Z</option>
                <option value="nama_desc" <?= ($urutan === 'nama_desc') ? 'selected' : ''; ?>>Nama Z - A</option>
            </select>

            <!-- Tombol Aksi -->
            <button type="submit" class="btn btn-primary">Terapkan</button>
            <?php if ($keyword !== '' || $kategoriTerpilih !== '' || $suhuTerpilih !== '' || $urutan !== ''): ?>
                <a href="katalog.php" class="btn btn-reset">Reset</a>
            <?php endif; ?>
        </form>
    </section>

    <!-- Section 4: Render Menu Dinamis dengan foreach dan Percabangan UI -->
    <section>
        <?php if (!empty($hasilData)): ?>
            <div class="menu-grid">
                <?php foreach ($hasilData as $item): ?>
                    <?php 
                        // Percabangan UI: Cek ketersediaan dan promo
                        $isTersedia = (bool) ($item['is_tersedia'] ?? true);
                        $isPromo = (bool) ($item['is_promo'] ?? false);
                        $isBestSeller = (bool) ($item['is_best_seller'] ?? false);
                    ?>
                    <article class="menu-card <?= !$isTersedia ? 'is-sold-out' : ''; ?>">
                        <img src="<?= e($item['gambar']); ?>" alt="Foto sajian <?= e($item['nama']); ?>" class="menu-img" loading="lazy">
                        <div class="menu-card-body">
                            <!-- Percabangan Badge UI -->
                            <div class="badge-row">
                                <span class="badge badge-category"><?= e($item['kategori']); ?></span>
                                
                                <?php if ($isPromo): ?>
                                    <span class="badge badge-promo">% Promo</span>
                                <?php endif; ?>

                                <?php if ($isBestSeller): ?>
                                    <span class="badge badge-bestseller">★ Best</span>
                                <?php endif; ?>

                                <?php if (!$isTersedia): ?>
                                    <span class="badge badge-danger">Habis</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="menu-title"><?= e($item['nama']); ?></h3>

                            <!-- Varian Suhu (Hot / Ice) jika tersedia -->
                            <?php $opsiSuhu = $item['opsi_suhu'] ?? []; ?>
                            <?php if (!empty($opsiSuhu) && is_array($opsiSuhu)): ?>
                                <div class="temp-pills">
                                    <?php if (in_array('Hot', $opsiSuhu, true)): ?>
                                        <span class="temp-pill pill-hot">☕ Hot</span>
                                    <?php endif; ?>
                                    <?php if (in_array('Ice', $opsiSuhu, true)): ?>
                                        <span class="temp-pill pill-ice">🧊 Ice</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <p class="menu-desc"><?= e($item['deskripsi']); ?></p>

                            <div class="menu-footer">
                                <span class="menu-price <?= $isPromo ? 'price-promo' : ''; ?>">
                                    <?= formatRupiah($item['harga']); ?>
                                </span>
                                <span style="font-size: 0.8rem; color: #888;">
                                    <?= $isTersedia ? 'Tersedia' : 'Habis'; ?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card" style="text-align: center; padding: 40px 20px;">
                <h3 style="color: var(--primary); margin-bottom: 8px;">Oops, Belum Ketemu Nih! ☕</h3>
                <p style="color: var(--text-muted); margin-bottom: 16px;">
                    Racikan dengan kata kunci "<em><?= e($keyword); ?></em>" belum ada di bar kami. Coba cari varian lain atau reset filter yuk!
                </p>
                <a href="katalog.php" class="btn btn-primary">Lihat Semua Menu</a>
            </div>
        <?php endif; ?>
    </section>

</main>

<!-- Semantik: Footer -->
<footer>
    <p>&copy; <?= date('Y'); ?> Twenty Three Coffee &bull; Surakarta, Indonesia. &bull; Crafted by Azka.</p>
</footer>

</body>
</html>
