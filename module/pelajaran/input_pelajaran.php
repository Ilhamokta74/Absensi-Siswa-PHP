<?php
if (isset($_GET['act']) && $_GET['act'] === "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Mata Pelajaran</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Input Data Mata Pelajaran
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="././module/simpan.php?act=input_pelajaran">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <input type="text" class="form-control" placeholder="Mata Pelajaran" name="nama_mp" required>
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
}
?>

<?php
if (isset($_GET['act']) && $_GET['act'] === "edit_pelajaran") {
    // Sanitize the `idm` parameter to prevent SQL Injection
    $idm = intval($_GET['idm']);

    // Prepare and execute the SQL query
    $stmt = $connection->prepare("SELECT * FROM mata_pelajaran WHERE idm = ?");
    $stmt->bind_param("i", $idm);
    $stmt->execute();
    $result = $stmt->get_result();
    $rs = $result->fetch_assoc();
?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Data Mata Pelajaran</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data Mata Pelajaran
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="././module/simpan.php?act=edit_pelajaran">
                            <input type="hidden" name="idm" value="<?php echo htmlspecialchars($idm, ENT_QUOTES, 'UTF-8'); ?>" />
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <input class="form-control" placeholder="Mata Pelajaran" name="nama_mp" value="<?php echo htmlspecialchars($rs['nama_mp'], ENT_QUOTES, 'UTF-8'); ?>" required>
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
}
?>