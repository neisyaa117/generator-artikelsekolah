<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once "config/koneksi.php";

$user_id = $_SESSION['user_id'];

$userQuery = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE id = '$user_id' LIMIT 1"
);

$user = mysqli_fetch_assoc($userQuery);


$schoolQuery = mysqli_query(
    $koneksi,
    "SELECT * FROM sekolah WHERE user_id = '$user_id' LIMIT 1"
);

$sekolah = mysqli_fetch_assoc($schoolQuery);


if (!$sekolah) {
    header("Location: profil-sekolah.php");
    exit;
}


$namaUser = $user['nama'] ?? 'Teman';

$namaSekolah = $sekolah['nama_sekolah'] ?? 'Sekolahmu';

$jenjang = $sekolah['jenjang'] ?? '';

$desa = $sekolah['desa'] ?? '';

$kecamatan = $sekolah['kecamatan'] ?? '';
// ========================================
// GOOGLE FORM EDUSTORY
// ========================================

$googleFormUrl = "https://docs.google.com/forms/d/e/1FAIpQLSfz89hIx6uyJ6PkyFeSQffSOVclshvlR-fLUZoKObWLpWd33A/viewform";

function buatLinkForm($jenisArtikel, $sekolah, $user, $googleFormUrl)
{
    $parameter = [
        // DATA AKUN
        "entry.1360798628" => $user['nama'] ?? '',
        "entry.2057311873" => $user['email'] ?? '',

        // DATA SEKOLAH
        "entry.205352692"  => $sekolah['nama_sekolah'] ?? '',
        "entry.2048620659" => $sekolah['provinsi'] ?? '',
        "entry.1405967554" => $sekolah['kabupaten'] ?? '',
        "entry.660230675"  => $sekolah['kecamatan'] ?? '',
        "entry.1675713490" => $sekolah['desa'] ?? '',
        "entry.617590610"  => $sekolah['alamat'] ?? '',

        // JENIS ARTIKEL
        "entry.1051562574" => $jenisArtikel
    ];

    // "Anda sebagai..." memakai pilihan Lainnya
    $parameter["entry.963888535"] = "__other_option__";
    $parameter["entry.963888535.other_option_response"] = "Perwakilan Sekolah";

    // Jenjang juga memakai Lainnya
    $parameter["entry.1906327735"] = "__other_option__";
    $parameter["entry.1906327735.other_option_response"] =
        $sekolah['jenjang'] ?? '';

    return $googleFormUrl . "?" . http_build_query($parameter);
}
?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard - EduStory</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="assets/css/style.css">

</head>


<body class="dashboard-page">


<nav class="navbar dashboard-nav">

    <div class="nav-container">

        <a href="dashboard.php" class="brand">

            <span class="brand-icon">✦</span>

            <span>EduStory</span>

        </a>


        <div class="dashboard-nav-right">

            <div class="user-mini">

                <div class="user-avatar">
                    <?= strtoupper(substr($namaUser, 0, 1)) ?>
                </div>

                <div class="user-name">
                    <?= htmlspecialchars($namaUser) ?>
                </div>

            </div>


            <a
                href="logout.php"
                class="logout-link"
            >
                Keluar
            </a>

        </div>

    </div>

</nav>


<main class="dashboard-wrapper">


    <section class="welcome-area">

        <div>

            <span class="section-label">
                BERANDA SEKOLAH
            </span>

            <h1>
                Halo, <?= htmlspecialchars($namaUser) ?>! 👋
            </h1>

            <p>
                Mau menceritakan apa dari
                <strong><?= htmlspecialchars($namaSekolah) ?></strong>
                hari ini?
            </p>

        </div>


        <div class="school-mini-card">

            <div class="school-mini-icon">
                🏫
            </div>

            <div>

                <strong>
                    <?= htmlspecialchars($namaSekolah) ?>
                </strong>

                <span>
                    <?= htmlspecialchars($jenjang) ?>

                    <?php if ($kecamatan): ?>
                        · <?= htmlspecialchars($kecamatan) ?>
                    <?php endif; ?>

                </span>

            </div>

        </div>

    </section>


    <section class="story-section">


        <div class="story-heading">

            <div>

                <span class="section-label">
                    PILIH CERITA
                </span>

                <h2>
                    Mau membuat cerita apa?
                </h2>

            </div>

            <p>
                Pilih salah satu dan lanjutkan
                ke formulir cerita.
            </p>

        </div>


        <div class="story-grid">


            <!-- 01 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Profil', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    01
                </div>

                <div class="story-icon purple-bg">
                    👩‍🏫
                </div>

                <h3>
                    Profil
                </h3>

                <p>
                    Kenalkan sosok dan cerita
                    di balik sekolah.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 02 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Kegiatan', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    02
                </div>

                <div class="story-icon orange-bg">
                    🎉
                </div>

                <h3>
                    Kegiatan
                </h3>

                <p>
                    Ceritakan kegiatan seru
                    dan bermakna.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 03 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Pohon Bercerita', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    03
                </div>

                <div class="story-icon green-bg">
                    🌳
                </div>

                <h3>
                    Pohon Bercerita
                </h3>

                <p>
                    Bagikan cerita tentang
                    tempat yang berkesan.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 04 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Anak Hebat', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    04
                </div>

                <div class="story-icon yellow-bg">
                    🌟
                </div>

                <h3>
                    Anak Hebat
                </h3>

                <p>
                    Ceritakan pengalaman
                    dan kisah anak inspiratif.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 05 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Tips & Trik', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    05
                </div>

                <div class="story-icon blue-bg">
                    💡
                </div>

                <h3>
                    Tips & Trik
                </h3>

                <p>
                    Bagikan tips sederhana
                    yang bermanfaat.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 06 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Program Unggulan', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">
                <div class="story-number">
                    06
                </div>

                <div class="story-icon coral-bg">
                    🏫
                </div>

                <h3>
                    Program Unggulan
                </h3>

                <p>
                    Kenalkan program menarik
                    dari sekolah.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 07 -->

           <a href="<?= htmlspecialchars(buatLinkForm('Prestasi & Inovasi', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    07
                </div>

                <div class="story-icon purple-bg">
                    🏆
                </div>

                <h3>
                    Prestasi & Inovasi
                </h3>

                <p>
                    Bagikan prestasi dan
                    karya sekolah.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 08 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Suara Hati', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">
                <div class="story-number">
                    08
                </div>

                <div class="story-icon pink-bg">
                    💬
                </div>

                <h3>
                    Suara Hati
                </h3>

                <p>
                    Cerita dari siswa,
                    guru, orang tua, dan lainnya.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 09 -->

            <a href="<?= htmlspecialchars(buatLinkForm('Kekompakan Komunitas', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    09
                </div>

                <div class="story-icon orange-bg">
                    🤝
                </div>

                <h3>
                    Kekompakan Komunitas
                </h3>

                <p>
                    Ceritakan kerja sama
                    dan kebersamaan.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


            <!-- 10 -->

            <a href="<?= htmlspecialchars(buatLinkForm('7 Kebiasaan Anak Indonesia Hebat', $sekolah, $user, $googleFormUrl)) ?>" class="story-card">

                <div class="story-number">
                    10
                </div>

                <div class="story-icon green-bg">
                    🌱
                </div>

                <h3>
                    7 Kebiasaan Anak Indonesia Hebat
                </h3>

                <p>
                    Ceritakan kebiasaan baik
                    yang diterapkan anak.
                </p>

                <span class="story-link">
                    Buat cerita →
                </span>

            </a>


        </div>

    </section>


    <section class="dashboard-note">

        <div class="note-icon">
            💛
        </div>

        <div>

            <strong>
                Setiap cerita punya arti.
            </strong>

            <p>
                Ceritakan pengalaman sederhana dari sekolahmu.
                Siapa tahu bisa menginspirasi sekolah lain.
            </p>

        </div>

    </section>


</main>


<footer class="footer">

    <p>
        © <?php echo date('Y'); ?> EduStory
        · Cerita sekolah, jadi lebih mudah.
    </p>

</footer>


</body>

</html>