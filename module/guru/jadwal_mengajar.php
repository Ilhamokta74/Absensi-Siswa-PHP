<?php
// Assuming you have a mysqli connection stored in $connection
// Replace with your actual connection variable
$uidi = $connection->real_escape_string($uidi);

// Fetch the teacher's data
$stmt = $connection->prepare("SELECT * FROM guru WHERE nip = ?");
$stmt->bind_param("s", $uidi);
$stmt->execute();
$result = $stmt->get_result();
$rs = $result->fetch_assoc();
$stmt->close();
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Jadwal Mengajar</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Prepare SQL statement
                            $stmt = $connection->prepare("
                                SELECT jadwal.idj, hari.hari, kelas.nama AS nama_kelas, guru.idg AS id_guru, mata_pelajaran.nama_mp,
                                       jadwal.jam_selesai, jadwal.jam_mulai
                                FROM jadwal
                                JOIN hari ON jadwal.idh = hari.idh
                                JOIN kelas ON jadwal.idk = kelas.idk
                                JOIN guru ON jadwal.idg = guru.idg
                                JOIN mata_pelajaran ON jadwal.idm = mata_pelajaran.idm
                                WHERE guru.idg = ?
                                ORDER BY jadwal.idh ASC
                            ");
                            $stmt->bind_param("i", $rs['idg']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo htmlspecialchars($no); ?></td>
                                    <td><?php echo htmlspecialchars($row['hari']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jam_mulai']) . " - " . htmlspecialchars($row['jam_selesai']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_mp']); ?></td>
                                    <td class="text-center">
                                        <a href="media.php?module=absen&idj=<?php echo urlencode($row['idj']); ?>">
                                            <button type="button" class="btn btn-info">Mulai Absen</button>
                                        </a>
                                        <a href="media.php?module=rekap_g&idj=<?php echo urlencode($row['idj']); ?>">
                                            <button type="button" class="btn btn-warning">Rekap Absen</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->