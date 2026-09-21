<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once "config/koneksi.php";

$user_id = $_SESSION['user_id'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM sekolah WHERE user_id = '$user_id' LIMIT 1"
);

$data = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Sekolah - EduStory</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="assets/css/style.css">

</head>


<body class="profile-page">


<nav class="navbar">

    <div class="nav-container">

        <a href="index.php" class="brand">

            <span class="brand-icon">✦</span>

            <span>EduStory</span>

        </a>

        <div class="profile-step">
            Langkah 1 dari 1
        </div>

    </div>

</nav>


<main class="profile-wrapper">


    <div class="profile-intro">

        <div class="profile-badge">
            🏫
        </div>

        <span class="section-label">
            SEBELUM MULAI
        </span>

        <h1>
            Kenalkan sekolahmu
        </h1>

        <p>
            Data ini cukup diisi satu kali.
            Setelah itu, kamu bisa langsung membuat berbagai
            cerita sekolah tanpa mengisi wilayah lagi.
        </p>

    </div>


    <div class="profile-card">


        <form
            action="proses/proses-profil.php"
            method="POST"
        >


            <div class="form-section">

                <div class="form-section-title">

                    <span>01</span>

                    <div>
                        <h2>Tentang Sekolah</h2>
                        <p>Informasi dasar sekolah</p>
                    </div>

                </div>


                <div class="form-group">

                    <label>Nama Sekolah</label>

                    <input
                        type="text"
                        name="nama_sekolah"
                        value="<?= htmlspecialchars($data['nama_sekolah'] ?? '') ?>"
                        placeholder="Contoh: TK Harapan Bangsa"
                        required
                    >

                </div>


                <div class="two-column">

                    <div class="form-group">

                        <label>Jenjang</label>

                        <select name="jenjang" required>

                            <option value="">Pilih jenjang</option>

                            <option value="PAUD"
                                <?= (($data['jenjang'] ?? '') == 'PAUD') ? 'selected' : '' ?>>
                                PAUD
                            </option>

                            <option value="TK"
                                <?= (($data['jenjang'] ?? '') == 'TK') ? 'selected' : '' ?>>
                                TK
                            </option>

                            <option value="SD"
                                <?= (($data['jenjang'] ?? '') == 'SD') ? 'selected' : '' ?>>
                                SD
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Alamat Sekolah</label>

                        <input
                            type="text"
                            name="alamat"
                            value="<?= htmlspecialchars($data['alamat'] ?? '') ?>"
                            placeholder="Nama jalan / alamat"
                            required
                        >

                    </div>

                </div>

            </div>


            <div class="form-section">

                <div class="form-section-title">

                    <span>02</span>

                    <div>
                        <h2>Lokasi Sekolah</h2>
                        <p>Digunakan untuk setiap cerita yang dibuat</p>
                    </div>

                </div>


                <div class="two-column">


                    <div class="form-group">

                        <label>Provinsi</label>

                        <select
                            name="provinsi"
                            id="provinsi"
                            required
                        >

                            <option value="">
                                Pilih provinsi
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Kabupaten / Kota</label>

                        <select
                            name="kabupaten"
                            id="kabupaten"
                            required
                            disabled
                        >

                            <option value="">
                                Pilih kabupaten / kota
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Kecamatan</label>

                        <select
                            name="kecamatan"
                            id="kecamatan"
                            required
                            disabled
                        >

                            <option value="">
                                Pilih kecamatan
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Desa / Kelurahan</label>

                        <select
                            name="desa"
                            id="desa"
                            required
                            disabled
                        >

                            <option value="">
                                Pilih desa / kelurahan
                            </option>

                        </select>

                    </div>


                </div>

            </div>


            <div class="save-info">

                <span>💡</span>

                <p>
                    Data sekolah akan digunakan otomatis
                    saat membuat artikel berikutnya.
                </p>

            </div>


            <button
                type="submit"
                class="btn-primary btn-full"
            >
                Simpan & Masuk ke Dashboard
                <span>→</span>
            </button>


        </form>

    </div>


</main>


<footer class="footer">

    <p>
        © <?php echo date('Y'); ?> EduStory
    </p>

</footer>


<script src="assets/js/wilayah.js"></script>

</body>

</html>