<?php

session_start();

require_once "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}


$user_id = $_SESSION['user_id'];

$nama_sekolah = $_POST['nama_sekolah'] ?? '';
$provinsi     = $_POST['provinsi'] ?? '';
$kabupaten    = $_POST['kabupaten'] ?? '';
$kecamatan    = $_POST['kecamatan'] ?? '';
$desa         = $_POST['desa'] ?? '';
$alamat       = $_POST['alamat'] ?? '';
$jenjang      = $_POST['jenjang'] ?? '';


if (
    empty($nama_sekolah) ||
    empty($provinsi) ||
    empty($kabupaten) ||
    empty($kecamatan) ||
    empty($desa) ||
    empty($jenjang)
) {

    echo "<script>
        alert('Data sekolah belum lengkap.');
        history.back();
    </script>";

    exit;
}


/* Cek apakah profil sudah ada */

$cek = mysqli_prepare(
    $koneksi,
    "SELECT id FROM sekolah WHERE user_id = ?"
);

mysqli_stmt_bind_param(
    $cek,
    "i",
    $user_id
);

mysqli_stmt_execute($cek);

$hasil = mysqli_stmt_get_result($cek);


/* Kalau sudah ada → UPDATE */

if (mysqli_num_rows($hasil) > 0) {

    $data = mysqli_fetch_assoc($hasil);

    $id_sekolah = $data['id'];


    $stmt = mysqli_prepare(
        $koneksi,
        "UPDATE sekolah SET
        nama_sekolah = ?,
        provinsi = ?,
        kabupaten = ?,
        kecamatan = ?,
        desa = ?,
        alamat = ?,
        jenjang = ?
        WHERE id = ?"
    );


    mysqli_stmt_bind_param(
        $stmt,
        "sssssssi",
        $nama_sekolah,
        $provinsi,
        $kabupaten,
        $kecamatan,
        $desa,
        $alamat,
        $jenjang,
        $id_sekolah
    );


    mysqli_stmt_execute($stmt);

}


/* Kalau belum ada → INSERT */

else {

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO sekolah
        (
            user_id,
            nama_sekolah,
            provinsi,
            kabupaten,
            kecamatan,
            desa,
            alamat,
            jenjang
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );


    mysqli_stmt_bind_param(
        $stmt,
        "isssssss",
        $user_id,
        $nama_sekolah,
        $provinsi,
        $kabupaten,
        $kecamatan,
        $desa,
        $alamat,
        $jenjang
    );


    mysqli_stmt_execute($stmt);

}


header("Location: ../dashboard.php");

exit;