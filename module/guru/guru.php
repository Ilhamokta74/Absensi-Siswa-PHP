<?php
// Assume $connection is your mysqli connection

// Fetch data from the database
$sql = "SELECT * FROM guru";
$result = $connection->query($sql);
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Guru</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Guru
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">NIP</th>
                                <th class="text-center" width="50%">Nama</th>
                                <th class="text-center">JK</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($rs = $result->fetch_assoc()) {
                                $idg = htmlspecialchars($rs['idg']);
                                $nip = htmlspecialchars($rs['nip']);
                                $nama = htmlspecialchars($rs['nama']);
                                $jk = $rs['jk'] === "L" ? "Laki - Laki" : "Perempuan";
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $nip; ?></td>
                                    <td><?php echo $nama; ?></td>
                                    <td class="text-center"><?php echo $jk; ?></td>
                                    <td class="text-center">
                                        <a href="media.php?module=detail_guru&idg=<?php echo $idg; ?>">
                                            <button type="button" class="btn btn-warning">Detail</button>
                                        </a>
                                        <a href="media.php?module=input_guru&act=edit_guru&idg=<?php echo $idg; ?>">
                                            <button type="button" class="btn btn-info">Edit</button>
                                        </a>
                                        <a href="module/simpan.php?act=hapus_guru&idg=<?php echo $idg; ?>">
                                            <button type="button" class="btn btn-danger">Hapus</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
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