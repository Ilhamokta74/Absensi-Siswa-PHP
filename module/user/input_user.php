<?php
if (isset($_GET['act']) && $_GET['act'] == "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Input Data User</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Input Data User
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="./module/simpan.php?act=input_user">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" placeholder="Username" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="pass" required>
                                </div>
                                <div class="form-group">
                                    <label>Sekolah</label>
                                    <select class="form-control" name="sekolah" required>
                                        <?php
                                        // Use MySQLi to fetch data
                                        $result = $connection->query("SELECT * FROM sekolah");
                                        while ($rsa = $result->fetch_assoc()) {
                                            echo "<option value='{$rsa['id']}'>{$rsa['nama']}</option>";
                                        }
                                        ?>
                                    </select>
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

<?php
if (isset($_GET['act']) && $_GET['act'] == "edit_user") {
    // Fetch user data
    $idu = intval($_GET['idu']);
    $stmt = $connection->prepare("SELECT * FROM user WHERE idu = ?");
    $stmt->bind_param('i', $idu);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Data User</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data User
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="./module/simpan.php?act=edit_user">
                            <input type="hidden" name="idu" value="<?php echo htmlspecialchars($user['idu']); ?>" />
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" placeholder="Username" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="pass">
                                    <small class="form-text text-muted">Leave blank if not changing.</small>
                                </div>
                                <div class="form-group">
                                    <label>Sekolah</label>
                                    <select class="form-control" name="sekolah" required>
                                        <?php
                                        $result_sekolah = $connection->query("SELECT * FROM sekolah");
                                        while ($rsa = $result_sekolah->fetch_assoc()) {
                                            $selected = ($rsa['id'] == $user['id']) ? 'selected' : '';
                                            echo "<option value='{$rsa['id']}' $selected>{$rsa['nama']}</option>";
                                        }
                                        ?>
                                    </select>
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