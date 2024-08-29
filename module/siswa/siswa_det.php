<?php
include "../config/conn.php";

// Retrieve user data
$id = $_SESSION['idu'];
$stmt = $connection->prepare("SELECT * FROM siswa WHERE nis = ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$rs = $stmt->get_result()->fetch_assoc();
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Siswa</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Siswa
            </div>
            <div class="panel-body">
                <div class="row">
                    <form method="post" role="form" action="././module/simpan.php?act=siswa_det">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($rs['ids'], ENT_QUOTES, 'UTF-8'); ?>" />

                        <div class="col-lg-6">
                            <fieldset disabled>
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input class="form-control" placeholder="NIS" name="nis" value="<?php echo htmlspecialchars($rs['nis'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" placeholder="Nama" name="nama" value="<?php echo htmlspecialchars($rs['nama'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="L" <?php echo $rs['jk'] == 'L' ? 'checked' : ''; ?>> Laki - Laki
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="P" <?php echo $rs['jk'] == 'P' ? 'checked' : ''; ?>> Perempuan
                                        </label>
                                    </div>
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

                                            if ($_SESSION['level'] == "admin_guru" && $rsa['id'] == $_SESSION['id'] || $_SESSION['level'] != "admin_guru") {
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
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <fieldset disabled>
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
                            </fieldset>
                            <div class="form-group">
                                <label>Ganti Password</label>
                                <input class="form-control" placeholder="Password baru" name="pass">
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
$connection->close();
?>