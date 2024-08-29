<?php
session_start();

// Check if user is logged in
if (!empty($_SESSION['nama'])) {
  $uidi = $_SESSION['idu'];
  $usre = $_SESSION['nama'];
  $level = $_SESSION['level'];
  $klss = $_SESSION['idk'];
  $ortu = $_SESSION['ortu'];
  $idd = $_SESSION['id'];

  include "../../../config/conn.php";
  include "../../../config/fungsi.php";
  require "../../../config/html2pdf/html2pdf.class.php";

  $filename = "Laporan_Absensi_Kelas.pdf";

  // Sanitize and retrieve POST data
  $acuan = intval($_POST['idj']);
  $tgl_lengkap = $_POST['tgl_lengkap'];

  // Prepare and execute queries
  $sqlacuan = $connection->prepare("SELECT * FROM jadwal WHERE idj = ?");
  $sqlacuan->bind_param("i", $acuan);
  $sqlacuan->execute();
  $rss = $sqlacuan->get_result()->fetch_assoc();

  $sqlkss = $connection->prepare("SELECT * FROM kelas WHERE idk = ?");
  $sqlkss->bind_param("i", $rss['idk']);
  $sqlkss->execute();
  $kss = $sqlkss->get_result()->fetch_assoc();

  $sqlmp = $connection->prepare("SELECT * FROM mata_pelajaran WHERE idm = ?");
  $sqlmp->bind_param("i", $rss['idm']);
  $sqlmp->execute();
  $nama_mp = $sqlmp->get_result()->fetch_assoc();

  $sqlidh = $connection->prepare("SELECT * FROM hari WHERE idh = ?");
  $sqlidh->bind_param("i", $rss['idh']);
  $sqlidh->execute();
  $nama_hari = $sqlidh->get_result()->fetch_assoc();

  // Calculate the academic year
  $pecah = explode(" ", $tgl_lengkap);
  $satu = $pecah[0];
  $dua = $pecah[1];
  $tahun1 = intval($pecah[2]);

  if (in_array($dua, ["Juli", "Agustus", "September", "Oktober", "November", "Desember"])) {
    $tahun2 = $tahun1 + 1;
    $tahun_ajaran = "Tahun Ajaran $tahun1 - $tahun2";
  } else {
    $tahun2 = $tahun1 - 1;
    $tahun_ajaran = "Tahun Ajaran $tahun2 - $tahun1";
  }

  // Generate content for PDF
  ob_start();
  $content = "
    <h3>Laporan Data Absensi Kelas {$kss['nama']} | {$nama_mp['nama_mp']}</h3>
    <p><b>$tahun_ajaran</b><br>{$nama_hari['hari']}, {$rss['jam_mulai']} - {$rss['jam_selesai']}</p>
    <table cellpadding='0' cellspacing='0'>
        <tr>
            <td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#d0e9c6;' rowspan='2'><b>Siswa</b></td>
            <td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#d0e9c6;' colspan='" . ($jumlahtanggal = $connection->query("SELECT DISTINCT tgl FROM absen WHERE idj = $acuan")->num_rows) . "'><b>Tanggal (TGL/BLN)</b></td>
        </tr>
        <tr>";

  $sqlabsen = $connection->prepare("SELECT DISTINCT tgl FROM absen WHERE idj = ?");
  $sqlabsen->bind_param("i", $acuan);
  $sqlabsen->execute();
  $absen_dates = $sqlabsen->get_result();
  while ($tglnya = $absen_dates->fetch_assoc()) {
    $pecah = explode("-", $tglnya['tgl']);
    $satu = $pecah[0];
    $dua = $pecah[1];
    $tiga = $pecah[2];
    $content .= "<td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#faf2cc;'><b>$tiga/$dua</b></td>";
  }
  $content .= "</tr>";

  $sqlrss = $connection->prepare("SELECT * FROM siswa WHERE idk = ?");
  $sqlrss->bind_param("i", $rss['idk']);
  $sqlrss->execute();
  $siswa_result = $sqlrss->get_result();
  while ($siswanya = $siswa_result->fetch_assoc()) {
    $content .= "<tr>
            <td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#faf2cc;'>{$siswanya['nama']}</td>";

    $sqlabsen2 = $connection->prepare("SELECT ket FROM absen WHERE ids = ? AND idj = ?");
    $sqlabsen2->bind_param("ii", $siswanya['ids'], $acuan);
    $sqlabsen2->execute();
    $absen_notes = $sqlabsen2->get_result();
    while ($ketnya = $absen_notes->fetch_assoc()) {
      $content .= "<td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px;'>{$ketnya['ket']}</td>";
    }
    $content .= "</tr>";
  }
  $content .= "</table>
    <br><br>
    <b>Keterangan Absensi</b>
    <p>A = Tidak Masuk Tanpa Keterangan<br>
    I = Tidak Masuk Ada Surat Ijin Atau Pemberitahuan<br>
    S = Tidak Masuk Ada Surat Dokter Atau Pemberitahuan<br>
    M = Hadir</p>";

  // Convert HTML to PDF
  try {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr', false, 'ISO-8859-15', array(10, 10, 10, 10));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->Output($filename);
  } catch (HTML2PDF_exception $e) {
    echo $e;
  }
} else {
  echo "<center><h2>Anda Harus Login Terlebih Dahulu</h2>
    <a href='index.php'><b>Klik ini untuk Login</b></a></center>";
}
