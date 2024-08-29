<?php
// Assume $connection is your mysqli connection

if (isset($_GET['act']) && $_GET['act'] === "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Guru</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Input Data Guru
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="module/simpan.php?act=input_guru">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input class="form-control" placeholder="NIP" name="nip" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" placeholder="Nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="L" checked>Laki - Laki
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="P">Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" placeholder="Password" name="k_password" type="password" required>
                                </div>
                                <br>
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
} elseif (isset($_GET['act']) && $_GET['act'] === "edit_guru") {
    $idg = $connection->real_escape_string($_GET['idg']);
    $stmt = $connection->prepare("SELECT * FROM guru WHERE idg = ?");
    $stmt->bind_param("i", $idg);
    $stmt->execute();
    $result = $stmt->get_result();
    $rs = $result->fetch_assoc();
    $stmt->close();
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Edit Data Guru</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data Guru
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="module/simpan.php?act=edit_guru">
                            <input type="hidden" name="idg" value="<?php echo htmlspecialchars($idg); ?>">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input class="form-control" required placeholder="NIP" name="nip" value="<?php echo htmlspecialchars($rs['nip']); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" placeholder="Nama" name="nama" value="<?php echo htmlspecialchars($rs['nama']); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="L" <?php echo $rs['jk'] === "L" ? "checked" : ""; ?>>Laki - Laki
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="P" <?php echo $rs['jk'] === "P" ? "checked" : ""; ?>>Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"><?php echo htmlspecialchars($rs['alamat']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" placeholder="Password" name="k_password" type="password">
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
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