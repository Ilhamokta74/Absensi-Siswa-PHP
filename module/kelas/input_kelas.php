<?php
if ($_GET['act'] === "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Kelas</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Input Data Kelas
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="./module/simpan.php?act=input_kelas">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Sekolah</label>
                                    <select class="form-control" name="id">
                                        <?php
                                        // Use prepared statements to prevent SQL injection
                                        $stmt = $connection->prepare("SELECT * FROM sekolah");
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            // Display options based on user level
                                            if ($_SESSION['level'] === "admin_guru") {
                                                if ($row['id'] === $_SESSION['id']) {
                                                    echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                                                }
                                            } else {
                                                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Kelas</label>
                                    <input class="form-control" placeholder="Kelas" name="nama">
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

if ($_GET['act'] === "edit_kelas") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Data Kelas</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data Kelas
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        // Use prepared statements to prevent SQL injection
                        $stmt = $connection->prepare("SELECT * FROM kelas WHERE idk = ?");
                        $stmt->bind_param("i", $_GET['idk']);
                        $stmt->execute();
                        $kelas = $stmt->get_result()->fetch_assoc();

                        ?>
                        <form method="post" role="form" action="./module/simpan.php?act=edit_kelas">
                            <input type="hidden" name="idk" value="<?php echo htmlspecialchars($_GET['idk']); ?>" />
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" name="id">
                                        <?php
                                        $stmt_sekolah = $connection->prepare("SELECT * FROM sekolah");
                                        $stmt_sekolah->execute();
                                        $result_sekolah = $stmt_sekolah->get_result();

                                        while ($row = $result_sekolah->fetch_assoc()) {
                                            $selected = ($kelas['id'] === $row['id']) ? 'selected="selected"' : '';
                                            if ($_SESSION['level'] === "admin_guru") {
                                                if ($row['id'] === $_SESSION['id']) {
                                                    echo "<option value='{$row['id']}' $selected>{$row['nama']}</option>";
                                                }
                                            } else {
                                                echo "<option value='{$row['id']}' $selected>{$row['nama']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Sekolah</label>
                                    <input class="form-control" placeholder="Kelas" name="nama" value="<?php echo htmlspecialchars($kelas['nama']); ?>">
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