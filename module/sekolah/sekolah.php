<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Sekolah</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Nama Sekolah</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM sekolah";
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                while ($rs = $result->fetch_assoc()) {
                            ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo htmlspecialchars($rs['kode'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rs['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rs['alamat'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center">
                                            <a href="./././media.php?module=input_sekolah&act=edit_sekolah&id=<?php echo urlencode($rs['id']); ?>">
                                                <button type="button" class="btn btn-info">Edit</button>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
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

<?php
$connection->close();
?>