<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Siswa Per-Kelas</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Pilih Kelas
            </div>
            <div class="panel-body">
                <div class="row">
                    <form method="get" role="form" action="./media.php?module=siswa">
                        <div class="col-lg-6">
                            <input type="hidden" name="module" value="siswa">

                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" name="kls">
                                    <?php
                                    // Prepare query based on user level
                                    if ($_SESSION['level'] == "guru") {
                                        $stmt = $connection->prepare("SELECT * FROM kelas WHERE idk = ?");
                                        $stmt->bind_param('i', $_SESSION['idk']);
                                    } else {
                                        $stmt = $connection->prepare("SELECT * FROM kelas");
                                    }
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Add "semua" option
                                    if ($_SESSION['level'] != "guru") {
                                        echo "<option value=''>semua</option>";
                                    }

                                    // Fetch and display options
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['idk']) . "'>" . htmlspecialchars($row['nama']) . "</option>";
                                    }

                                    // Close statement
                                    $stmt->close();
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