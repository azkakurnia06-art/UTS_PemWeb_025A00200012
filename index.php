<?php
declare(strict_types=1);

// index.php - Halaman Utama & Profil Twenty Three Coffee
require_once 'data.php';
require_once 'functions.php';

$totalMenu = hitungTotalMenu($menuTwentyThree);
$totalTersedia = hitungMenuTersedia($menuTwentyThree);
$bestSellers = ambilMenuBestSeller($menuTwentyThree);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Twenty Three Coffee</title>
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
            <a href="index.php" class="active">Profil Kafe</a>
            <a href="katalog.php">Katalog Menu</a>
        </nav>
    </div>
</header>

<!-- Semantik: Konten Utama -->
<main class="container">

    <!-- Section 1: Hero Banner -->
    <section class="hero-banner">
        <h2>Selamat Datang di Twenty Three Coffee</h2>
        <p>Menghadirkan racikan kopi artisanal terbaik, hidangan pastry lezat, dan suasana hangat untuk setiap cerita dan inspirasi Anda.</p>
    </section>

    <!-- Section 2: Cerita & Filosofi Kafe -->
    <section class="card" style="padding: 0; overflow: hidden;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <div style="min-height: 300px; background: url('assets/gambar_coffee/Twentyy.jpeg') center/cover no-repeat;" role="img" aria-label="Suasana penyeduhan kopi di Twenty Three Coffee">
            </div>
            <div style="padding: 32px; display: flex; flex-direction: column; justify-content: center;">
                <span class="badge badge-category" style="align-self: flex-start; margin-bottom: 12px;">Our Coffee Philosophy</span>
                <h2 style="color: var(--primary); margin-bottom: 12px; font-size: 1.6rem;">Harmoni Rasa di Setiap Seduhan</h2>
                <p style="color: var(--text-muted); margin-bottom: 16px; line-height: 1.7;">
                    Di Twenty Three, kami percaya bahwa secangkir kopi lebih dari sekadar minuman pembuka hari. Setiap biji kopi disangrai secara teliti untuk mengeluarkan profil rasa yang kaya, dipadukan dengan teknik penyeduhan presisi oleh barista kami.
                </p>
                <div style="display: flex; gap: 24px; margin-top: 8px;">
                    <div>
                        <h3 style="color: var(--secondary); font-size: 1.3rem; font-weight: 700;">100%</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Arabika Pilihan</p>
                    </div>
                    <div>
                        <h3 style="color: var(--secondary); font-size: 1.3rem; font-weight: 700;">Fresh</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Daily Baked Pastry</p>
                    </div>
                    <div>
                        <h3 style="color: var(--secondary); font-size: 1.3rem; font-weight: 700;">Cozy</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Work &amp; Chill Space</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Informasi Operasional & Ringkasan Menu -->
    <section class="card">
        <h2 style="color: var(--primary); margin-bottom: 12px;">Tentang Twenty Three Coffee</h2>
        <p style="margin-bottom: 12px;">
            <strong>Twenty Three</strong> adalah sebuah gerai coffee shop modern yang berfokus pada penyajian biji kopi arabika pilihan dari berbagai daerah di Indonesia dan dunia. Mengusung konsep industrial hangat dengan sentuhan kayu dan aroma panggangan roti segar setiap pagi, Twenty Three menjadi tempat ideal untuk bekerja, berdiskusi santai, maupun menikmati waktu sendiri.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 18px;">
            <div style="background: #fdf8f3; border: 1px solid var(--border-color); border-radius: 8px; padding: 14px;">
                <h3 style="color: var(--primary); font-size: 1rem; margin-bottom: 6px;">📍 Lokasi</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Jl. Merdeka No. 23, Pusat Kota</p>
            </div>
            <div style="background: #fdf8f3; border: 1px solid var(--border-color); border-radius: 8px; padding: 14px;">
                <h3 style="color: var(--primary); font-size: 1rem; margin-bottom: 6px;">⏰ Jam Operasional</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Senin - Minggu: 08.00 - 23.00 WIB</p>
            </div>
            <div style="background: #fdf8f3; border: 1px solid var(--border-color); border-radius: 8px; padding: 14px;">
                <h3 style="color: var(--primary); font-size: 1rem; margin-bottom: 6px;">☕ Status Menu Kafe</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">
                    <strong><?= $totalTersedia; ?></strong> dari <strong><?= $totalMenu; ?></strong> menu siap disajikan hari ini
                </p>
            </div>
        </div>
    </section>

    <!-- Section 4: Signature & Best Seller Menu -->
    <section class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
            <div>
                <h2 style="color: var(--primary);">Signature &amp; Best Seller</h2>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Pilihan terfavorit yang paling sering dinikmati pengunjung.</p>
            </div>
            <a href="katalog.php" class="btn btn-primary" style="font-size: 0.85rem; padding: 8px 16px;">Lihat Seluruh Katalog &rarr;</a>
        </div>
        
        <div class="menu-grid">
            <?php foreach ($bestSellers as $menu): ?>
                <article class="menu-card <?= empty($menu['is_tersedia']) ? 'is-sold-out' : ''; ?>">
                    <img src="<?= e($menu['gambar']); ?>" alt="Foto sajian <?= e($menu['nama']); ?>" class="menu-img" loading="lazy">
                    <div class="menu-card-body">
                        <div class="badge-row">
                            <span class="badge badge-category"><?= e($menu['kategori']); ?></span>
                            <span class="badge badge-bestseller">★ Best Seller</span>
                            <?php if (!empty($menu['is_promo'])): ?>
                                <span class="badge badge-promo">% Promo</span>
                            <?php endif; ?>
                            <?php if (empty($menu['is_tersedia'])): ?>
                                <span class="badge badge-danger">Habis</span>
                            <?php endif; ?>
                        </div>
                        <h3 class="menu-title"><?= e($menu['nama']); ?></h3>

                        <!-- Varian Suhu (Hot / Ice) jika tersedia -->
                        <?php $opsiSuhu = $menu['opsi_suhu'] ?? []; ?>
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

                        <p class="menu-desc"><?= e($menu['deskripsi']); ?></p>
                        <div class="menu-footer">
                            <span class="menu-price <?= !empty($menu['is_promo']) ? 'price-promo' : ''; ?>">
                                <?= formatRupiah($menu['harga']); ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

</main>

<!-- Semantik: Footer -->
<footer>
    <p>&copy; <?= date('Y'); ?> Twenty Three Coffee &bull; Surakarta, Indonesia. &bull; Crafted by Azka.</p>
</footer>

</body>
</html>
