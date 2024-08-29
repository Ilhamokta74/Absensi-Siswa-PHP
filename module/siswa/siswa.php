<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Siswa</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php
                $klas = isset($_GET['kls']) ? $_GET['kls'] : '';
                if ($klas == "semua") {
                    echo "Data Semua Siswa";
                } else {
                    $stmt = $connection->prepare("SELECT nama FROM kelas WHERE idk = ?");
                    $stmt->bind_param('i', $klas);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    echo "Data Siswa Kelas " . htmlspecialchars($row['nama']);
                    $stmt->close();
                }
                ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">NIS</th>
                                <th class="text-center" width="30%">Nama</th>
                                <th class="text-center">JK</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">No Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $connection->prepare($klas == "semua" ? "SELECT * FROM siswa" : "SELECT * FROM siswa WHERE idk = ?");
                            if ($klas != "semua") {
                                $stmt->bind_param('i', $klas);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($rs = $result->fetch_assoc()) {
                                // Fetch class and school information
                                $stmtClass = $connection->prepare("SELECT * FROM kelas WHERE idk = ?");
                                $stmtClass->bind_param('i', $rs['idk']);
                                $stmtClass->execute();
                                $classResult = $stmtClass->get_result();
                                $class = $classResult->fetch_assoc();

                                $stmtSchool = $connection->prepare("SELECT * FROM sekolah WHERE id = ?");
                                $stmtSchool->bind_param('i', $class['id']);
                                $stmtSchool->execute();
                                $schoolResult = $stmtSchool->get_result();
                                $school = $schoolResult->fetch_assoc();

                                // Display student data
                                if ($_SESSION['level'] == "admin_guru" && $school['id'] == $_SESSION['id']) {
                                    echo '<tr class="odd gradeX">';
                                    echo '<td>' . htmlspecialchars($rs['nis']) . '</td>';
                                    echo '<td>' . htmlspecialchars($rs['nama']) . '</td>';
                                    echo '<td class="text-center">' . ($rs['jk'] == "L" ? "Laki - Laki" : "Perempuan") . '</td>';
                                    echo '<td>' . htmlspecialchars($rs['idk']) . '</td>';
                                    echo '<td>' . htmlspecialchars($rs['tlp']) . '</td>';
                                    echo '<td class="text-center">';
                                    echo '<a href="./media.php?module=input_siswa&act=edit&ids=' . urlencode($rs['ids']) . '"><button type="button" class="btn btn-info">Edit</button></a> ';
                                    echo '<a href="./module/simpan.php?act=hapus&ids=' . urlencode($rs['ids']) . '"><button type="button" class="btn btn-danger">Hapus</button></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                } else {
                                    echo '<tr class="odd gradeX">';
                                    echo '<td>' . htmlspecialchars($rs['nis']) . '</td>';
                                    echo '<td>' . htmlspecialchars($rs['nama']) . '</td>';
                                    echo '<td class="text-center">' . ($rs['jk'] == "L" ? "Laki - Laki" : "Perempuan") . '</td>';
                                    echo '<td>' . htmlspecialchars($class['nama']) . '</td>';
                                    echo '<td>' . htmlspecialchars($rs['tlp']) . '</td>';
                                    echo '<td class="text-center">';
                                    echo '<a href="./media.php?module=detail_siswa&act=details&ids=' . urlencode($rs['ids']) . '"><button type="button" class="btn btn-warning">Details</button></a> ';
                                    echo '<a href="./media.php?module=input_siswa&act=edit&ids=' . urlencode($rs['ids']) . '"><button type="button" class="btn btn-info">Edit</button></a> ';
                                    echo '<a href="./module/simpan.php?act=hapus&ids=' . urlencode($rs['ids']) . '"><button type="button" class="btn btn-danger">Hapus</button></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                // Close statements
                                $stmtClass->close();
                                $stmtSchool->close();
                            }

                            // Close main statement
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