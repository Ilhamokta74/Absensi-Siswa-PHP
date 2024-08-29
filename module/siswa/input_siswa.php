<?php
// Assume connection is established elsewhere in your project
// and $connection is the MySQLi connection object.

if ($_GET['act'] == "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Siswa</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Input Data Siswa
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="././module/simpan.php?act=input_siswa">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input class="form-control" placeholder="Nis" name="nis">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" placeholder="Nama" name="nama">
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
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" name="kelas">
                                        <?php
                                        $sql = $connection->query("SELECT * FROM kelas");
                                        while ($rs = $sql->fetch_assoc()) {
                                            $sqla = $connection->prepare("SELECT * FROM sekolah WHERE id = ?");
                                            $sqla->bind_param('i', $rs['id']);
                                            $sqla->execute();
                                            $rsa = $sqla->get_result()->fetch_assoc();

                                            if ($_SESSION['level'] == "admin_guru") {
                                                if ($rsa['id'] == $_SESSION['id']) {
                                                    echo "<option value='" . htmlspecialchars($rs['idk'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($rs['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                                                }
                                            } else {
                                                echo "<option value='" . htmlspecialchars($rs['idk'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($rs['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">+62</span>
                                    <input type="text" class="form-control" placeholder="No Telepon" name="tlp">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input class="form-control" placeholder="Nama" name="bapak">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input class="form-control" placeholder="Pekerjaan" name="k_bapak">
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input class="form-control" placeholder="Nama" name="ibu">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input class="form-control" placeholder="Pekerjaan" name="k_ibu">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" placeholder="Password" name="k_password" type="password">
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

if ($_GET['act'] == "edit") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Edit Data Siswa</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data Siswa
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        $stmt = $connection->prepare("SELECT * FROM siswa WHERE ids = ?");
                        $stmt->bind_param('i', $_GET['ids']);
                        $stmt->execute();
                        $rs = $stmt->get_result()->fetch_assoc();
                        ?>
                        <form method="post" role="form" action="././module/simpan.php?act=edit_siswa">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['ids'], ENT_QUOTES, 'UTF-8'); ?>" />
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input class="form-control" required placeholder="Nis" name="nis" value="<?php echo htmlspecialchars($rs['nis'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" placeholder="Nama" name="nama" value="<?php echo htmlspecialchars($rs['nama'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <?php if ($rs['jk'] == "L") { ?>
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
                                    <?php } ?>
                                    <?php if ($rs['jk'] == "P") { ?>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="jk" value="L">Laki - Laki
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="jk" value="P" checked>Perempuan
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"><?php echo htmlspecialchars($rs['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" name="kelas">
                                        <?php
                                        $sqlc = $connection->query("SELECT * FROM kelas");
                                        while ($rsc = $sqlc->fetch_assoc()) {
                                            $sqla = $connection->prepare("SELECT * FROM sekolah WHERE id = ?");
                                            $sqla->bind_param('i', $rsc['id']);
                                            $sqla->execute();
                                            $rsa = $sqla->get_result()->fetch_assoc();

                                            if ($_SESSION['level'] == "admin_guru") {
                                                if ($rsa['id'] == $_SESSION['id']) {
                                                    $selected = $rs['idk'] == $rsc['idk'] ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($rsc['idk'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($rsc['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                                                }
                                            } else {
                                                $selected = $rs['idk'] == $rsc['idk'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($rsc['idk'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($rsc['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">+62</span>
                                    <input type="text" class="form-control" placeholder="No Telepon" name="tlp" value="<?php echo htmlspecialchars($rs['tlp'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input class="form-control" placeholder="Nama" name="bapak" value="<?php echo htmlspecialchars($rs['bapak'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input class="form-control" placeholder="Pekerjaan" name="k_bapak" value="<?php echo htmlspecialchars($rs['k_bapak'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input class="form-control" placeholder="Nama" name="ibu" value="<?php echo htmlspecialchars($rs['ibu'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input class="form-control" placeholder="Pekerjaan" name="k_ibu" value="<?php echo htmlspecialchars($rs['k_ibu'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" placeholder="Password" name="k_password" value="" type="password">
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