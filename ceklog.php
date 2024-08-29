<?php
// FILE KONEKSI
include "config/conn.php";

// Ambil data dari form
$pass = md5($_POST['password']);
$passw = $_POST['password'];
$user = $_POST['username'];

// Sanitize input untuk mencegah SQL Injection
$user = mysqli_real_escape_string($connection, $user);

// Query untuk tabel user
$sql = mysqli_query($connection, "SELECT * FROM user WHERE nama='$user' AND pass='$pass'");
$count = mysqli_num_rows($sql);
$rs = mysqli_fetch_array($sql);

if ($count > 0) {
    session_start();
    $_SESSION['idu'] = $rs['idu'];
    $_SESSION['nama'] = $rs['nama'];
    $_SESSION['level'] = $rs['level'];
    $_SESSION['idk'] = "";
    $_SESSION['ortu'] = "";
    $_SESSION['id'] = $rs['id'];

    header('location:media.php?module=home');
} else {
    $mr = md5($_POST['password']);

    // Query untuk tabel siswa
    $sqla = mysqli_query($connection, "SELECT * FROM siswa WHERE nis='$user' AND pass='$mr'");
    $counta = mysqli_num_rows($sqla);
    $rsa = mysqli_fetch_array($sqla);

    if ($counta > 0) {
        session_start();
        $_SESSION['idu'] = $rsa['nis'];
        $_SESSION['nama'] = $rsa['nama'];
        $_SESSION['level'] = "user";
        $_SESSION['ortu'] = $passw;
        $_SESSION['idk'] = $rsa['idk'];
        $_SESSION['id'] = "2";

        header('location:media.php?module=home');
    } else {
        $gr = md5($_POST['password']);

        // Query untuk tabel guru
        $sqlz = mysqli_query($connection, "SELECT * FROM guru WHERE nip='$user' AND pass='$gr'");
        $countz = mysqli_num_rows($sqlz);
        $rsz = mysqli_fetch_array($sqlz);

        if ($countz > 0) {
            session_start();
            $_SESSION['idu'] = $rsz['nip'];
            $_SESSION['nama'] = $rsz['nama'];
            $_SESSION['idk'] = $rsz['idk'];
            $_SESSION['level'] = "guru";
            $_SESSION['ortu'] = "";
            $_SESSION['id'] = "2";

            header('location:media.php?module=home');
        } else {
            echo "<script>alert('Mohon periksa kembali Username & Password Anda'); location.href='login.php';</script>";
        }
    }
}
