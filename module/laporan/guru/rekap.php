<?php
// Sanitize input to prevent SQL Injection
$idj = intval($_GET['idj']);

// Prepare and execute queries
$sqlacuan = $connection->prepare("SELECT * FROM jadwal WHERE idj = ?");
$sqlacuan->bind_param("i", $idj);
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

$tahun2 = ($dua == "Juli" || $dua == "Agustus" || $dua == "September" || $dua == "Oktober" || $dua == "November" || $dua == "Desember")
  ? $tahun1 + 1
  : $tahun1 - 1;
?>

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      <strong>
        <?php
        echo ($dua == "Juli" || $dua == "Agustus" || $dua == "September" || $dua == "Oktober" || $dua == "November" || $dua == "Desember")
          ? "Tahun Ajaran $tahun1 - $tahun2"
          : "Tahun Ajaran $tahun2 - $tahun1";
        ?>
      </strong>
      <form action="module/laporan/guru/cetak_rekap.php" method="post">
        <input type="hidden" name="idj" value="<?php echo htmlspecialchars($acuan); ?>">
        <input type="hidden" name="tgl_lengkap" value="<?php echo htmlspecialchars($tgl_lengkap); ?>">
        <input style="float:right; margin-top:-40px;" class="btn btn-success btn-lg" type="submit" name="cetak" value="Cetak">
      </form>
    </h3>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Data Absensi Kelas <?php echo "<b>$kss[nama] | $nama_mp[nama_mp]</b>"; ?>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div class="table-responsive">
          <?php
          // Fetch distinct dates of attendance
          $sqlabsen = $connection->prepare("SELECT DISTINCT tgl FROM absen WHERE idj = ?");
          $sqlabsen->bind_param("i", $idj);
          $sqlabsen->execute();
          $absen_dates = $sqlabsen->get_result();

          $jumlahtanggal = $absen_dates->num_rows;
          $jumlahkolom = $jumlahtanggal + 1;
          ?>
          <table class="table table-striped table-bordered table-hover">
            <tr>
              <td colspan="<?php echo $jumlahkolom; ?>" class="text-center info">
                <?php echo "<b>$nama_hari[hari], $rss[jam_mulai] - $rss[jam_selesai]</b>"; ?>
              </td>
            </tr>
            <tr>
              <td class="success text-center" rowspan="2"><b>Siswa</b></td>
              <td colspan="<?php echo $jumlahtanggal; ?>" class="text-center success"><b>Tanggal (TGL/BLN)</b></td>
            </tr>
            <tr>
              <?php
              while ($tglnya = $absen_dates->fetch_assoc()) {
                $pecah = explode("-", $tglnya['tgl']);
                $satu = $pecah[0];
                $dua = $pecah[1];
                $tiga = $pecah[2];
              ?>
                <td class="text-center warning"><?php echo "<b>$tiga/$dua</b>"; ?></td>
              <?php } ?>
            </tr>
            <?php
            $sqlrss = $connection->prepare("SELECT * FROM siswa WHERE idk = ?");
            $sqlrss->bind_param("i", $rss['idk']);
            $sqlrss->execute();
            $siswa_result = $sqlrss->get_result();

            while ($siswanya = $siswa_result->fetch_assoc()) {
            ?>
              <tr>
                <td class="text-center warning"><?php echo htmlspecialchars($siswanya['nama']); ?></td>
                <?php
                $sqlabsen2 = $connection->prepare("SELECT ket FROM absen WHERE ids = ? AND idj = ?");
                $sqlabsen2->bind_param("ii", $siswanya['ids'], $idj);
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
          <p>A = Tidak Masuk Tanpa Keterangan<br>
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