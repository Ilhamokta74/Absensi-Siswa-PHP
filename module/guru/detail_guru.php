<?php
// Ensure the connection is established
// Assuming $connection is your mysqli connection
$idg = $_GET['idg'];
$sql = "SELECT * FROM guru WHERE idg = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('i', $idg); // Assuming idg is an integer; use 's' if it's a string
$stmt->execute();
$rs = $stmt->get_result()->fetch_assoc();
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Guru: <?php echo htmlspecialchars($rs['nama']); ?></strong></h3>
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
            <div class="panel-body">
                <div class="row">
                    <form>
                        <div class="col-lg-6">
                            <fieldset disabled>
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
                                            <input type="radio" name="jk" value="L" <?php echo ($rs['jk'] == 'L') ? 'checked' : ''; ?>> Laki - Laki
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="P" <?php echo ($rs['jk'] == 'P') ? 'checked' : ''; ?>> Perempuan
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3" disabled><?php echo htmlspecialchars($rs['alamat']); ?></textarea>
                            </div>
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