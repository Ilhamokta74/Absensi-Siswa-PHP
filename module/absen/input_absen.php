<?php
$idj = $_GET['idj'];

// Prepare and execute queries to fetch data
$stmt = $connection->prepare("SELECT * FROM jadwal WHERE idj = ?");
$stmt->bind_param('i', $idj);
$stmt->execute();
$arrayj = $stmt->get_result()->fetch_assoc();

$stmt = $connection->prepare("SELECT * FROM mata_pelajaran WHERE idm = ?");
$stmt->bind_param('i', $arrayj['idm']);
$stmt->execute();
$arraymp = $stmt->get_result()->fetch_assoc();

$stmt = $connection->prepare("SELECT * FROM kelas WHERE idk = ?");
$stmt->bind_param('i', $arrayj['idk']);
$stmt->execute();
$rsj = $stmt->get_result()->fetch_assoc();

?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Input Data Absensi</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php
                echo "Data Siswa<br>";
                echo "Kelas {$rsj['nama']} | {$arraymp['nama_mp']}";
                ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" role="form" action="././module/simpan.php?act=input_absen&idj=<?php echo $idj ?>&tanggal=<?php echo date('Y-m-d') ?>&kelas=<?php echo $arrayj['idk'] ?>">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th class="text-center">NIS</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tg = date('Y-m-d');
                                $stmt = $connection->prepare("SELECT * FROM siswa WHERE idk = ?");
                                $stmt->bind_param('i', $arrayj['idk']);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($rs = $result->fetch_assoc()) {
                                    $stmt = $connection->prepare("SELECT * FROM absen WHERE ids = ? AND tgl = ? AND idj = ?");
                                    $stmt->bind_param('iss', $rs['ids'], $tg, $idj);
                                    $stmt->execute();
                                    $rsa = $stmt->get_result()->fetch_assoc();
                                    $conk = $stmt->get_result()->num_rows;

                                ?>
                                    <tr class="odd gradeX">
                                        <td><label style="font-weight:normal;"><?php echo htmlspecialchars($rs['nis']); ?></label></td>
                                        <td><label style="font-weight:normal;"><?php echo htmlspecialchars($rs['nama']); ?></label></td>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <?php
                                                $statuses = ['A' => 'Tidak Masuk Tanpa Keterangan', 'I' => 'Tidak Masuk Ada Surat Ijin Atau Pemberitahuan', 'S' => 'Tidak Masuk Ada Surat Dokter Atau Pemberitahuan', 'M' => 'Hadir', 'N' => 'Belum di Absen'];
                                                foreach ($statuses as $key => $value) {
                                                    $checked = ($rsa['ket'] == $key) ? 'checked' : '';
                                                    echo "<label class='radio-inline'>
                                                        <input type='radio' name='{$rs['ids']}' value='$key' $checked>$key
                                                    </label>";
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Simpan Data Absen</button>
                    </form>
                </div>
                <!-- /.table-responsive -->
                <br>
                <div class="well">
                    <h4>Keterangan Absensi</h4>
                    <?php
                    foreach ($statuses as $key => $value) {
                        echo "<p>$key = $value</p>";
                    }
                    ?>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<?php
// Close connection
$connection->close();
?>