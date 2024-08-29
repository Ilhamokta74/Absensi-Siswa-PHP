<?php
include "../config/conn.php";

function alertAndRedirect($message, $location)
{
        echo "<script>
        window.alert('$message');
        window.location='$location';
    </script>";
}

$act = isset($_GET['act']) ? $_GET['act'] : '';

if ($act == "input_user") {
        $pw = md5($_POST['pass']);
        $stmt = $connection->prepare("INSERT INTO user (nama, pass, level, id) VALUES (?, ?, 'admin_guru', ?)");
        $stmt->bind_param('sss', $_POST['nama'], $pw, $_POST['sekolah']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=user');
}

if ($act == "edit_user") {
        if (!empty($_POST['pass'])) {
                $pw = md5($_POST['pass']);
                $stmt = $connection->prepare("UPDATE user SET nama = ?, pass = ?, id = ? WHERE idu = ?");
                $stmt->bind_param('sssi', $_POST['nama'], $pw, $_POST['sekolah'], $_POST['idu']);
        } else {
                $stmt = $connection->prepare("UPDATE user SET nama = ?, id = ? WHERE idu = ?");
                $stmt->bind_param('ssi', $_POST['nama'], $_POST['sekolah'], $_POST['idu']);
        }
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=user');
}

if ($act == "hapus_user") {
        $stmt = $connection->prepare("DELETE FROM user WHERE idu = ?");
        $stmt->bind_param('i', $_GET['idu']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Terhapus', '../media.php?module=user');
}

if ($act == "input_siswa") {
        $mr = md5($_POST["k_password"]);
        $stmt = $connection->prepare("INSERT INTO siswa (nis, nama, jk, alamat, idk, tlp, bapak, k_bapak, ibu, k_ibu, pass) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssssss', $_POST['nis'], $_POST['nama'], $_POST['jk'], $_POST['alamat'], $_POST['kelas'], $_POST['tlp'], $_POST['bapak'], $_POST['k_bapak'], $_POST['ibu'], $_POST['k_ibu'], $mr);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=siswa&kls=semua');
}

if ($act == "edit_siswa") {
        $mr = md5($_POST["k_password"]);
        $stmt = $connection->prepare("UPDATE siswa SET nis = ?, nama = ?, jk = ?, alamat = ?, idk = ?, tlp = ?, bapak = ?, k_bapak = ?, ibu = ?, k_ibu = ?, pass = ? WHERE ids = ?");
        $stmt->bind_param('sssssssssssi', $_POST['nis'], $_POST['nama'], $_POST['jk'], $_POST['alamat'], $_POST['kelas'], $_POST['tlp'], $_POST['bapak'], $_POST['k_bapak'], $_POST['ibu'], $_POST['k_ibu'], $mr, $_POST['id']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=siswa&kls=semua');
}

if ($act == "siswa_det") {
        if (!empty($_POST['pass'])) {
                $pw = md5($_POST['pass']);
                $stmt = $connection->prepare("UPDATE siswa SET pass = ? WHERE ids = ?");
                $stmt->bind_param('si', $pw, $_POST['id']);
                $stmt->execute();
                $stmt->close();
                alertAndRedirect('Data Tersimpan', '../media.php?module=siswa_det');
        } else {
                alertAndRedirect('Isi Password', '../media.php?module=siswa_det');
        }
}

if ($act == "hapus") {
        $stmt = $connection->prepare("DELETE FROM siswa WHERE ids = ?");
        $stmt->bind_param('i', $_GET['ids']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Terhapus', '../media.php?module=siswa&kls=semua');
}

if ($act == "input_absen") {
        $tgl = $_GET['tanggal'];
        $kelas = $_GET['kelas'];
        $idj = $_GET['idj'];

        $sql = $connection->prepare("SELECT ids FROM siswa WHERE idk = ?");
        $sql->bind_param('i', $kelas);
        $sql->execute();
        $result = $sql->get_result();

        while ($rs = $result->fetch_assoc()) {
                $ra = $rs['ids'];
                $stmt = $connection->prepare("SELECT * FROM absen WHERE ids = ? AND tgl = ? AND idj = ?");
                $stmt->bind_param('isi', $ra, $tgl, $idj);
                $stmt->execute();
                $absenResult = $stmt->get_result();
                $conk = $absenResult->num_rows;

                if ($conk == 0) {
                        $stmt = $connection->prepare("INSERT INTO absen (ids, idj, tgl, ket) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('iiss', $ra, $idj, $tgl, $_POST[$ra]);
                } else {
                        $stmt = $connection->prepare("UPDATE absen SET ket = ? WHERE ids = ? AND tgl = ? AND idj = ?");
                        $stmt->bind_param('siii', $_POST[$ra], $ra, $tgl, $idj);
                }
                $stmt->execute();
                $stmt->close();
        }
        alertAndRedirect('Data Tersimpan', '../media.php?module=jadwal_mengajar');
}

if ($act == "input_sekolah") {
        $stmt = $connection->prepare("INSERT INTO sekolah (kode, nama, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $_POST['kode'], $_POST['nama'], $_POST['alamat']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=sekolah');
}

if ($act == "edit_sekolah") {
        $stmt = $connection->prepare("UPDATE sekolah SET kode = ?, nama = ?, alamat = ? WHERE id = ?");
        $stmt->bind_param('sssi', $_POST['kode'], $_POST['nama'], $_POST['alamat'], $_POST['id']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=sekolah');
}

if ($act == "hapus_sekolah") {
        $stmt = $connection->prepare("DELETE FROM sekolah WHERE id = ?");
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=sekolah');
}

if ($act == "input_kelas") {
        $stmt = $connection->prepare("INSERT INTO kelas (id, nama) VALUES (?, ?)");
        $stmt->bind_param('ss', $_POST['id'], $_POST['nama']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=kelas');
}

if ($act == "edit_kelas") {
        $stmt = $connection->prepare("UPDATE kelas SET id = ?, nama = ? WHERE idk = ?");
        $stmt->bind_param('sss', $_POST['id'], $_POST['nama'], $_POST['idk']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=kelas');
}

if ($act == "hapus_kelas") {
        $stmt = $connection->prepare("DELETE FROM kelas WHERE idk = ?");
        $stmt->bind_param('i', $_GET['idk']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=kelas');
}

if ($act == "input_pelajaran") {
        $stmt = $connection->prepare("INSERT INTO mata_pelajaran (nama_mp) VALUES (?)");
        $stmt->bind_param('s', $_POST['nama_mp']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=mata_pelajaran');
}

if ($act == "edit_pelajaran") {
        $stmt = $connection->prepare("UPDATE mata_pelajaran SET nama_mp = ? WHERE idm = ?");
        $stmt->bind_param('si', $_POST['nama_mp'], $_POST['idm']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=mata_pelajaran');
}

if ($act == "hapus_pelajaran") {
        $stmt = $connection->prepare("DELETE FROM mata_pelajaran WHERE idm = ?");
        $stmt->bind_param('i', $_GET['idm']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=mata_pelajaran');
}

if ($act == "input_jadwal") {
        $stmt = $connection->prepare("INSERT INTO jadwal (idh, idg, idk, idm, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('iiisis', $_POST['hari'], $_POST['guru'], $_POST['kelas'], $_POST['pelajaran'], $_POST['jam_mulai'], $_POST['jam_selesai']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=senin');
}

if ($act == "edit_jadwal") {
        $stmt = $connection->prepare("UPDATE jadwal SET idh = ?, idg = ?, idk = ?, idm = ?, jam_mulai = ?, jam_selesai = ? WHERE idj = ?");
        $stmt->bind_param('iiisisi', $_POST['hari'], $_POST['guru'], $_POST['kelas'], $_POST['pelajaran'], $_POST['jam_mulai'], $_POST['jam_selesai'], $_POST['idj']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=senin');
}

if ($act == "hapus_jadwal") {
        $stmt = $connection->prepare("DELETE FROM jadwal WHERE idj = ?");
        $stmt->bind_param('i', $_GET['idj']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=senin');
}

if ($act == "input_guru") {
        $mrg = md5($_POST['k_password']);
        $stmt = $connection->prepare("INSERT INTO guru (nip, nama, jk, alamat, idk, pass) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $_POST['nip'], $_POST['nama'], $_POST['jk'], $_POST['alamat'], $_POST['kelas'], $mrg);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=guru&kls=semua');
}

if ($act == "edit_guru") {
        $mrg = md5($_POST['k_password']);
        $stmt = $connection->prepare("UPDATE guru SET nip = ?, nama = ?, jk = ?, alamat = ?, pass = ?, idk = ? WHERE idg = ?");
        $stmt->bind_param('ssssssi', $_POST['nip'], $_POST['nama'], $_POST['jk'], $_POST['alamat'], $mrg, $_POST['kelas'], $_POST['idg']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=guru&kls=semua');
}

if ($act == "hapus_guru") {
        $stmt = $connection->prepare("DELETE FROM guru WHERE idg = ?");
        $stmt->bind_param('i', $_GET['idg']);
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Guru Sudah Terhapus', '../media.php?module=guru&kls=semua');
}

if ($act == "guru_det") {
        if (!empty($_POST['pass'])) {
                $pw = md5($_POST['pass']);
                $stmt = $connection->prepare("UPDATE guru SET nama = ?, jk = ?, alamat = ?, pass = ? WHERE idg = ?");
                $stmt->bind_param('ssssi', $_POST['nama'], $_POST['jk'], $_POST['alamat'], $pw, $_POST['idg']);
        } else {
                $stmt = $connection->prepare("UPDATE guru SET nama = ?, jk = ?, alamat = ? WHERE idg = ?");
                $stmt->bind_param('sssi', $_POST['nama'], $_POST['jk'], $_POST['alamat'], $_POST['idg']);
        }
        $stmt->execute();
        $stmt->close();
        alertAndRedirect('Data Tersimpan', '../media.php?module=guru_det');
}

$connection->close();
