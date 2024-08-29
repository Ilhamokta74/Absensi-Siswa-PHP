<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Mata Pelajaran</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Mata Pelajaran
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch data from the database
                            $sql = "SELECT * FROM mata_pelajaran";
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                $no = 1;
                                while ($rs = $result->fetch_assoc()) {
                            ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo htmlspecialchars($no, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rs['nama_mp'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center">
                                            <a href="./././media.php?module=input_pelajaran&act=edit_pelajaran&idm=<?php echo urlencode($rs['idm']); ?>">
                                                <button type="button" class="btn btn-info">Edit</button>
                                            </a>
                                            <a href="././module/simpan.php?act=hapus_pelajaran&idm=<?php echo urlencode($rs['idm']); ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                                <button type="button" class="btn btn-danger">Hapus</button>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No records found</td></tr>";
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