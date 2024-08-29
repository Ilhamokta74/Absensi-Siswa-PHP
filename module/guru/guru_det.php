<?php
session_start(); // Make sure session is started if you haven't already

// Assume $connection is your mysqli connection
$uid = $_SESSION['idu']; // Using session variable
$sql = "SELECT * FROM guru WHERE nip = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('s', $uid);
$stmt->execute();
$rs = $stmt->get_result()->fetch_assoc();
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Input Guru</strong></h3>
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
                    <form method="post" role="form" action="././module/simpan.php?act=guru_det">
                        <input type="hidden" name="idg" value="<?php echo htmlspecialchars($rs['idg']); ?>" />
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>NIP</label><br>
                                <label><?php echo htmlspecialchars($rs['nip']); ?></label>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" placeholder="Nama" name="nama" value="<?php echo htmlspecialchars($rs['nama']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="jk" value="L" <?php echo ($rs['jk'] == "L") ? 'checked' : ''; ?>> Laki - Laki
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="jk" value="P" <?php echo ($rs['jk'] == "P") ? 'checked' : ''; ?>> Perempuan
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
                                <label>Ganti Password</label>
                                <input class="form-control" placeholder="Password Baru" name="pass" type="password">
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