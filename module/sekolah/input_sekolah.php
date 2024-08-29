<?php
if ($_GET['act'] == "edit_sekolah") {
    // Sanitize the id parameter
    $id = $connection->real_escape_string($_GET['id']);

    // Query to fetch the school data
    $sql = "SELECT * FROM sekolah WHERE id='$id'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Data Sekolah</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Edit Data Sekolah
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <form method="post" role="form" action="././module/simpan.php?act=edit_sekolah">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>" />

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Kode Sekolah</label>
                                        <input class="form-control" placeholder="Kode" name="kode" value="<?php echo htmlspecialchars($rs['kode'], ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Sekolah</label>
                                        <input class="form-control" placeholder="Nama Sekolah" name="nama" value="<?php echo htmlspecialchars($rs['nama'], ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"><?php echo htmlspecialchars($rs['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </form>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
<?php
    } else {
        echo "No records found.";
    }

    $connection->close();
}
?>