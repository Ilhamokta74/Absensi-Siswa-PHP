<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Kelas</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Kelas
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">Kode Sekolah</th>
                                <th class="text-center">Nama Sekolah</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Use prepared statements to prevent SQL injection
                            $stmt = $connection->prepare("SELECT * FROM kelas");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($rs = $result->fetch_assoc()) {
                                // Fetch related school data
                                $stmt_school = $connection->prepare("SELECT * FROM sekolah WHERE id = ?");
                                $stmt_school->bind_param("i", $rs['id']);
                                $stmt_school->execute();
                                $rsa = $stmt_school->get_result()->fetch_assoc();

                                // Check user level and display actions accordingly
                                $is_admin_guru = $_SESSION['level'] === "admin_guru";
                                if ($is_admin_guru && $rsa['id'] === $_SESSION['id']) {
                            ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo htmlspecialchars($rsa['kode']); ?></td>
                                        <td><?php echo htmlspecialchars($rsa['nama']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($rs['nama']); ?></td>
                                        <td class="text-center">
                                            <a href="./media.php?module=input_kelas&act=edit_kelas&idk=<?php echo urlencode($rs['idk']); ?>" class="btn btn-info">Edit</a>
                                            <a href="./module/simpan.php?act=hapus_kelas&idk=<?php echo urlencode($rs['idk']); ?>" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo htmlspecialchars($rsa['kode']); ?></td>
                                        <td><?php echo htmlspecialchars($rsa['nama']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($rs['nama']); ?></td>
                                        <td class="text-center">
                                            <a href="./media.php?module=input_kelas&act=edit_kelas&idk=<?php echo urlencode($rs['idk']); ?>" class="btn btn-info">Edit</a>
                                            <a href="./module/simpan.php?act=hapus_kelas&idk=<?php echo urlencode($rs['idk']); ?>" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
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