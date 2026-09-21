<?php

session_start();

require_once "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM sekolah WHERE user_id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$sekolah = mysqli_fetch_assoc($result);

if (!$sekolah) {
    header("Location: ../profil-sekolah.php");
    exit;
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

<title>Profil Sekolah - EduStory</title>

<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@400;600;700;800;900&display=swap"
    rel="stylesheet"
>


<style>

* {
    box-sizing: border-box;
}


body {
    margin: 0;

    font-family: 'Nunito', sans-serif;

    background:
        radial-gradient(
            circle at 10% 10%,
            #fff3b8 0,
            transparent 20%
        ),
        radial-gradient(
            circle at 90% 20%,
            #ffd9e8 0,
            transparent 22%
        ),
        radial-gradient(
            circle at 80% 90%,
            #d9f7ed 0,
            transparent 20%
        ),
        #fffdf8;

    color: #41394f;
}


/* =========================
   NAVBAR
========================= */

.navbar {

    height: 72px;

    padding: 0 6%;

    background: rgba(255,255,255,.92);

    backdrop-filter: blur(10px);

    border-bottom:
        1px solid #f0e8df;

    display: flex;

    align-items: center;

    justify-content: space-between;

    position: sticky;

    top: 0;

    z-index: 10;
}


.logo {

    display: flex;

    align-items: center;

    gap: 10px;

    text-decoration: none;

    color: #41394f;

    font-family: 'Baloo 2', sans-serif;

    font-size: 23px;

    font-weight: 800;
}


.logo-icon {

    width: 40px;

    height: 40px;

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #8b70e8,
            #ff9c83
        );

    display: flex;

    align-items: center;

    justify-content: center;

    color: white;

    font-size: 21px;

    transform: rotate(-4deg);
}


.back {

    text-decoration: none;

    color: #756c7e;

    font-size: 14px;

    font-weight: 700;

    padding: 9px 14px;

    border-radius: 12px;

    background: #f7f3ff;
}


.back:hover {
    background: #eee7ff;
}


/* =========================
   MAIN
========================= */

.main {

    max-width: 900px;

    margin: auto;

    padding: 45px 20px 70px;
}


/* =========================
   HERO
========================= */

.hero {

    text-align: center;

    margin-bottom: 35px;
}


.hero-icon {

    width: 80px;

    height: 80px;

    margin: auto;

    border-radius: 26px;

    background: #fff0a8;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    transform: rotate(-3deg);

    box-shadow:
        0 12px 25px rgba(222,180,50,.15);
}


.hero h1 {

    font-family: 'Baloo 2', sans-serif;

    font-size: 34px;

    margin: 17px 0 4px;

    color: #3d3549;
}


.hero p {

    margin: 0 auto;

    max-width: 580px;

    color: #817889;

    line-height: 1.7;

    font-size: 14px;
}


/* =========================
   SCHOOL BADGE
========================= */

.school-badge {

    margin: 25px auto 0;

    width: fit-content;

    padding: 9px 16px;

    border-radius: 30px;

    background: white;

    border: 1px solid #eee5dc;

    box-shadow:
        0 7px 20px rgba(80,60,30,.05);

    font-size: 13px;

    font-weight: 800;

    color: #6b5e72;
}


/* =========================
   PROGRESS
========================= */

.progress-wrap {

    margin-bottom: 20px;
}


.progress-top {

    display: flex;

    justify-content: space-between;

    align-items: center;

    font-size: 12px;

    color: #938a99;

    margin-bottom: 8px;
}


.progress {

    height: 8px;

    background: #eee9e3;

    border-radius: 20px;

    overflow: hidden;
}


.progress-bar {

    height: 100%;

    width: 25%;

    border-radius: 20px;

    background:
        linear-gradient(
            90deg,
            #8b70e8,
            #ff9c83
        );
}


/* =========================
   FORM CARD
========================= */

.form-card {

    background: white;

    border-radius: 28px;

    padding: 35px;

    border:
        1px solid #eee7df;

    box-shadow:
        0 18px 50px rgba(80,60,40,.07);
}


/* =========================
   SECTION
========================= */

.form-section {

    margin-bottom: 34px;
}


.section-heading {

    display: flex;

    align-items: center;

    gap: 13px;

    margin-bottom: 22px;
}


.section-number {

    width: 39px;

    height: 39px;

    flex-shrink: 0;

    border-radius: 13px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eee8ff;

    color: #765dd0;

    font-family: 'Baloo 2', sans-serif;

    font-weight: 800;

    font-size: 18px;
}


.section-heading h2 {

    margin: 0;

    font-family: 'Baloo 2', sans-serif;

    font-size: 21px;

    color: #41394f;
}


.section-heading p {

    margin: 2px 0 0;

    color: #9a919e;

    font-size: 12px;
}


/* =========================
   FORM
========================= */

.form-group {

    margin-bottom: 21px;
}


.form-group label {

    display: block;

    font-weight: 800;

    font-size: 14px;

    color: #51485c;

    margin-bottom: 8px;
}


.required {
    color: #ff7d75;
}


.optional {

    color: #aaa2ad;

    font-weight: 600;

    font-size: 11px;

    margin-left: 4px;
}


input,
select,
textarea {

    width: 100%;

    border:
        1.5px solid #e9e2da;

    background: #fffdfa;

    border-radius: 14px;

    padding: 13px 15px;

    font-family: 'Nunito', sans-serif;

    font-size: 14px;

    color: #4a4252;

    outline: none;

    transition: .2s;
}


input:focus,
select:focus,
textarea:focus {

    border-color: #9a83e8;

    background: white;

    box-shadow:
        0 0 0 4px rgba(139,112,232,.09);
}


textarea {

    min-height: 115px;

    resize: vertical;
}


.help {

    margin-top: 6px;

    color: #a49aa6;

    font-size: 11px;

    line-height: 1.5;
}


/* =========================
   OPTION CARDS
========================= */

.option-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 12px;
}


.option {

    position: relative;
}


.option input {

    position: absolute;

    opacity: 0;
}


.option label {

    display: block;

    padding: 15px;

    border:
        1.5px solid #e9e2da;

    border-radius: 15px;

    cursor: pointer;

    text-align: center;

    background: #fffdfa;

    transition: .2s;

    font-weight: 700;
}


.option label:hover {

    transform: translateY(-2px);

    border-color: #b9a9ed;
}


.option input:checked + label {

    background: #f1edff;

    border-color: #8b70e8;

    color: #6750c2;

    box-shadow:
        0 5px 15px rgba(139,112,232,.12);
}


/* =========================
   BUTTON
========================= */

.submit-area {

    border-top:
        1px solid #f0ebe5;

    padding-top: 25px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}


.submit-info {

    color: #958c99;

    font-size: 12px;

    line-height: 1.5;
}


.submit-button {

    border: none;

    cursor: pointer;

    padding: 14px 25px;

    border-radius: 15px;

    color: white;

    font-family: 'Nunito', sans-serif;

    font-size: 14px;

    font-weight: 900;

    background:
        linear-gradient(
            135deg,
            #8067dc,
            #ff927b
        );

    box-shadow:
        0 10px 25px rgba(128,103,220,.22);

    transition: .2s;
}


.submit-button:hover {

    transform: translateY(-2px);

    box-shadow:
        0 14px 30px rgba(128,103,220,.28);
}


/* =========================
   MOBILE
========================= */

@media (max-width: 650px) {

    .navbar {
        padding: 0 15px;
    }


    .logo {
        font-size: 20px;
    }


    .main {
        padding:
            30px 14px 50px;
    }


    .hero h1 {
        font-size: 28px;
    }


    .hero-icon {
        width: 68px;
        height: 68px;
        font-size: 34px;
    }


    .form-card {
        padding: 22px 18px;

        border-radius: 21px;
    }


    .option-grid {
        grid-template-columns: 1fr;
    }


    .submit-area {

        flex-direction: column;

        align-items: stretch;
    }


    .submit-button {
        width: 100%;
    }

}

</style>

</head>


<body>


<nav class="navbar">

    <a
        href="../dashboard.php"
        class="logo"
    >

        <span class="logo-icon">
            ✦
        </span>

        EduStory

    </a>


    <a
        href="../dashboard.php"
        class="back"
    >
        ← Kembali
    </a>

</nav>



<main class="main">


    <section class="hero">

        <div class="hero-icon">
            👤
        </div>


        <h1>
            Yuk Ceritakan Sosok Hebat! ✨
        </h1>


        <p>
            Ceritakan guru, siswa, kepala sekolah,
            atau orang-orang hebat di sekolahmu.
            Nanti EduStory akan membantu merangkainya
            menjadi artikel yang menarik.
        </p>


        <div class="school-badge">

            🏫
            <?= htmlspecialchars($sekolah['nama_sekolah']) ?>

        </div>

    </section>



    <div class="progress-wrap">

        <div class="progress-top">

            <span>
                Langkah 1 dari 4
            </span>

            <span>
                Yuk, sedikit lagi! 🌟
            </span>

        </div>


        <div class="progress">

            <div class="progress-bar"></div>

        </div>

    </div>



    <form
        class="form-card"
        action="#"
        method="POST"
    >


        <!-- SECTION 1 -->

        <div class="form-section">

            <div class="section-heading">

                <div class="section-number">
                    1
                </div>

                <div>

                    <h2>
                        Siapa yang mau diceritakan?
                    </h2>

                    <p>
                        Pilih orang yang menjadi tokoh dalam cerita.
                    </p>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Tokoh yang ingin diceritakan
                    <span class="required">*</span>
                </label>


                <div class="option-grid">


                    <div class="option">

                        <input
                            type="radio"
                            name="tokoh"
                            id="guru"
                            value="Guru"
                        >

                        <label for="guru">
                            👩‍🏫 Guru
                        </label>

                    </div>


                    <div class="option">

                        <input
                            type="radio"
                            name="tokoh"
                            id="siswa"
                            value="Siswa"
                        >

                        <label for="siswa">
                            🧒 Siswa
                        </label>

                    </div>


                    <div class="option">

                        <input
                            type="radio"
                            name="tokoh"
                            id="kepala"
                            value="Kepala Sekolah"
                        >

                        <label for="kepala">
                            👨‍💼 Kepala Sekolah
                        </label>

                    </div>


                    <div class="option">

                        <input
                            type="radio"
                            name="tokoh"
                            id="orangtua"
                            value="Orang Tua"
                        >

                        <label for="orangtua">
                            👨‍👩‍👧 Orang Tua
                        </label>

                    </div>


                    <div class="option">

                        <input
                            type="radio"
                            name="tokoh"
                            id="alumni"
                            value="Alumni"
                        >

                        <label for="alumni">
                            🎓 Alumni
                        </label>

                    </div>


                    <div class="option">

                        <input
                            type="radio"
                            name="tokoh"
                            id="lainnya"
                            value="Lainnya"
                        >

                        <label for="lainnya">
                            🌟 Lainnya
                        </label>

                    </div>

                </div>

            </div>

        </div>



        <!-- SECTION 2 -->

        <div class="form-section">

            <div class="section-heading">

                <div class="section-number">
                    2
                </div>

                <div>

                    <h2>
                        Kenalan dengan tokohnya
                    </h2>

                    <p>
                        Informasi dasar tentang tokoh.
                    </p>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Nama tokoh
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="nama_tokoh"
                    placeholder="Contoh: Ibu Siti"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Jabatan atau peran di sekolah
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="jabatan"
                    placeholder="Contoh: Guru Kelas 5"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Sejak kapan berada di sekolah ini?
                </label>

                <input
                    type="text"
                    name="sejak"
                    placeholder="Contoh: Tahun 2020"
                >

            </div>

        </div>



        <!-- SECTION 3 -->

        <div class="form-section">

            <div class="section-heading">

                <div class="section-number">
                    3
                </div>

                <div>

                    <h2>
                        Ceritakan tentang tokohnya 💬
                    </h2>

                    <p>
                        Tidak perlu formal, ceritakan saja dengan bahasa sehari-hari.
                    </p>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Latar belakang tokoh
                    <span class="required">*</span>
                </label>

                <textarea
                    name="latar_belakang"
                    placeholder="Ceritakan sedikit tentang tokoh ini..."
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Apa yang membuat tokoh ini istimewa?
                    <span class="required">*</span>
                </label>

                <textarea
                    name="keistimewaan"
                    placeholder="Misalnya: selalu membantu siswa, kreatif dalam mengajar, ramah..."
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Kontribusi atau hal paling berkesan
                    <span class="required">*</span>
                </label>

                <textarea
                    name="kontribusi"
                    placeholder="Ceritakan hal yang pernah dilakukan dan paling berkesan..."
                    required
                ></textarea>

            </div>

        </div>



        <!-- SECTION 4 -->

        <div class="form-section">

            <div class="section-heading">

                <div class="section-number">
                    4
                </div>

                <div>

                    <h2>
                        Cerita penutup 🌈
                    </h2>

                    <p>
                        Tambahkan pencapaian, pengalaman, atau pesan.
                    </p>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Prestasi atau pencapaian
                    <span class="optional">
                        (boleh dikosongkan)
                    </span>
                </label>

                <textarea
                    name="prestasi"
                    placeholder="Misalnya: pernah mendapat penghargaan..."
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Pengalaman menarik
                    <span class="optional">
                        (boleh dikosongkan)
                    </span>
                </label>

                <textarea
                    name="pengalaman"
                    placeholder="Ada cerita lucu, mengharukan, atau berkesan?"
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Pesan untuk pembaca
                </label>

                <textarea
                    name="pesan"
                    placeholder="Apa pesan yang ingin disampaikan?"
                ></textarea>

            </div>

        </div>



        <div class="submit-area">

            <div class="submit-info">

                ✨ Setelah dikirim, data akan diproses
                untuk membuat artikel.

            </div>


            <button
                type="submit"
                class="submit-button"
            >

                ✨ Buat Artikel

            </button>

        </div>


    </form>

</main>


</body>

</html>