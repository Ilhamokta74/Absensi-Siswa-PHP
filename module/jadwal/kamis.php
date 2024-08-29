<?php
// Define an array to map module names to day IDs
$dayIdMap = [
    'senin' => 1,
    'selasa' => 2,
    'rabu' => 3,
    'kamis' => 4,
    'jumat' => 5
];

// Determine the current module and corresponding day ID
$currentModule = isset($_GET['module']) ? $_GET['module'] : 'senin';
$dayId = isset($dayIdMap[$currentModule]) ? $dayIdMap[$currentModule] : 1;
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Jadwal</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <ul class="nav nav-tabs">
                <?php foreach ($dayIdMap as $key => $day): ?>
                    <li role="presentation" class="<?= $currentModule === $key ? 'active' : '' ?>">
                        <a href="media.php?module=<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($day) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <br>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Guru</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;

                            // Prepare SQL statement
                            $stmt = $connection->prepare("
                                SELECT jadwal.idj, hari.hari, kelas.nama AS nama_kelas, guru.nama AS nama_guru, mata_pelajaran.nama_mp,
                                       jadwal.jam_selesai, jadwal.jam_mulai
                                FROM jadwal
                                JOIN hari ON jadwal.idh = hari.idh
                                JOIN kelas ON jadwal.idk = kelas.idk
                                JOIN guru ON jadwal.idg = guru.idg
                                JOIN mata_pelajaran ON jadwal.idm = mata_pelajaran.idm
                                WHERE jadwal.idh = ?
                                ORDER BY jadwal.jam_mulai
                            ");
                            $stmt->bind_param("i", $dayId);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($rs = $result->fetch_assoc()) {
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo htmlspecialchars($rs['hari']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['jam_mulai']) . " - " . htmlspecialchars($rs['jam_selesai']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['nama_kelas']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['nama_guru']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['nama_mp']); ?></td>
                                    <td class="text-center">
                                        <a href="media.php?module=input_jadwal&act=edit_jadwal&idj=<?php echo urlencode($rs['idj']); ?>">
                                            <button type="button" class="btn btn-info">Edit</button>
                                        </a>
                                        <a href="module/simpan.php?act=hapus_jadwal&idj=<?php echo urlencode($rs['idj']); ?>">
                                            <button type="button" class="btn btn-danger">Hapus</button>
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