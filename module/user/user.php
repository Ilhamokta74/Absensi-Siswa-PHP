<?php
include 'config/conn.php'; // Include your database connection

$level = $_SESSION['level'];
$idu = $_SESSION['idu'];

// Prepare and execute the SQL query based on user level
if ($level == "admin_guru") {
    $stmt = $connection->prepare("SELECT * FROM user WHERE idu = ?");
    $stmt->bind_param('i', $idu);
} else {
    $stmt = $connection->prepare("SELECT * FROM user WHERE idu <> 1");
}

$stmt->execute();
$result = $stmt->get_result();

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Data User</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data User
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Level</th>
                                <th class="text-center">Sekolah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($rs = $result->fetch_assoc()) {
                                // Prepare and execute the query to get the school name
                                $stmt_school = $connection->prepare("SELECT * FROM sekolah WHERE id = ?");
                                $stmt_school->bind_param('i', $rs['id']);
                                $stmt_school->execute();
                                $result_school = $stmt_school->get_result();
                                $rsa = $result_school->fetch_assoc();
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo htmlspecialchars($rs['nama']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($rs['level']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($rsa['nama']); ?></td>
                                    <td class="text-center">
                                        <a href="media.php?module=input_user&act=edit_user&idu=<?php echo htmlspecialchars($rs['idu']); ?>">
                                            <button type="button" class="btn btn-info">Edit</button>
                                        </a>
                                        <?php if ($level != "admin_guru") { ?>
                                            <a href="module/simpan.php?act=hapus_user&idu=<?php echo htmlspecialchars($rs['idu']); ?>">
                                                <button type="button" class="btn btn-danger">Hapus</button>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                                $stmt_school->close();
                            }
                            $stmt->close();
                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->