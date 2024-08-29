<?php
// Sanitize input to prevent SQL Injection
$idj = intval($_GET['idj']);

// Fetch data from `jadwal`
$sqlacuan = $connection->prepare("SELECT * FROM jadwal WHERE idj = ?");
$sqlacuan->bind_param("i", $idj);
$sqlacuan->execute();
$rss = $sqlacuan->get_result()->fetch_assoc();

// Fetch data from `siswa`
$sqlrss = $connection->prepare("SELECT * FROM siswa WHERE nis = ?");
$sqlrss->bind_param("s", $uidi);
$sqlrss->execute();
$siswa = $sqlrss->get_result()->fetch_assoc();

// Fetch data from `mata_pelajaran`
$sqlmp = $connection->prepare("SELECT * FROM mata_pelajaran WHERE idm = ?");
$sqlmp->bind_param("i", $rss['idm']);
$sqlmp->execute();
$nama_mp = $sqlmp->get_result()->fetch_assoc();

// Fetch data from `hari`
$sqlidh = $connection->prepare("SELECT * FROM hari WHERE idh = ?");
$sqlidh->bind_param("i", $rss['idh']);
$sqlidh->execute();
$nama_hari = $sqlidh->get_result()->fetch_assoc();

// Calculate the academic year
$pecah = explode(" ", $tgl_lengkap);
$satu = $pecah[0];
$dua = $pecah[1];
$tahun1 = intval($pecah[2]);

$tahun2 = ($dua == "Juli" || $dua == "Agustus" || $dua == "September" || $dua == "Oktober" || $dua == "November" || $dua == "Desember") ? $tahun1 + 1 : $tahun1 - 1;
?>

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      <strong>
        <?php
        echo ($dua == "Juli" || $dua == "Agustus" || $dua == "September" || $dua == "Oktober" || $dua == "November" || $dua == "Desember")
          ? "Tahun Ajaran $tahun1 - $tahun2 ($nama_mp[nama_mp])"
          : "Tahun Ajaran $tahun2 - $tahun1 ($nama_mp[nama_mp])";
        ?>
      </strong>
    </h3>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Data Absensi Siswa
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div class="table-responsive">
          <?php
          // Fetch distinct dates of attendance
          $sqlabsen = $connection->prepare("SELECT DISTINCT tgl FROM absen WHERE idj = ? AND ids = ?");
          $sqlabsen->bind_param("is", $idj, $siswa['ids']);
          $sqlabsen->execute();
          $absen_dates = $sqlabsen->get_result();
          ?>
          <table class="table table-striped table-bordered table-hover">
            <tr>
              <td colspan="2" class="text-center info">
                <?php echo "<b>$nama_hari[hari], $rss[jam_mulai] - $rss[jam_selesai]</b>"; ?>
              </td>
            </tr>
            <tr>
              <td class="success text-center" rowspan="2"><b>Tanggal (TGL/BLN)</b></td>
              <td class="text-center success"><b>Siswa</b></td>
            </tr>
            <tr>
              <td class="text-center warning"><?php echo "<b>$usre | Kelas : $rs[nama]</b>"; ?></td>
            </tr>
            <?php
            while ($tglnya = $absen_dates->fetch_assoc()) {
              $pecah = explode("-", $tglnya['tgl']);
              $satu = $pecah[0];
              $dua = $pecah[1];
              $tiga = $pecah[2];
            ?>
              <tr>
                <td class="text-center warning"><?php echo "<b>$tiga/$dua</b>"; ?></td>
                <?php
                // Fetch attendance notes
                $sqlabsen2 = $connection->prepare("SELECT ket FROM absen WHERE ids = ? AND idj = ? AND tgl = ?");
                $sqlabsen2->bind_param("sis", $siswa['ids'], $idj, $tglnya['tgl']);
                $sqlabsen2->execute();
                $absen_notes = $sqlabsen2->get_result();
                while ($ketnya = $absen_notes->fetch_assoc()) {
                ?>
                  <td class="text-center"><?php echo htmlspecialchars($ketnya['ket']); ?></td>
                <?php } ?>
              </tr>
            <?php } ?>
          </table>
        </div>
        <!-- /.table-responsive -->
        <div class="well">
          <h4>Keterangan Absensi</h4>
          <p>A = Tidak Masuk Tanpa Keterangan</p>
          <p>I = Tidak Masuk Ada Surat Ijin Atau Pemberitahuan</p>
          <p>S = Tidak Masuk Ada Surat Dokter Atau Pemberitahuan</p>
          <p>M = Hadir</p>
        </div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->