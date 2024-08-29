<?php
if ($_GET['act'] == "input") {
?>
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><strong>Input Data Jadwal</strong></h3>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Input Data Jadwal
				</div>
				<div class="panel-body">
					<div class="row">
						<form method="post" role="form" action="././module/simpan.php?act=input_jadwal">

							<div class="col-lg-6">
								<div class="form-group">
									<label>Hari</label>
									<select class="form-control" name="hari" required>
										<option value="">--Pilih Hari--</option>
										<?php
										$sql = $connection->query("SELECT * FROM hari");
										while ($rs = $sql->fetch_assoc()) {
											echo "<option value='" . htmlspecialchars($rs['idh']) . "'>" . htmlspecialchars($rs['hari']) . "</option>";
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Jam Mulai</label>
									<input type="time" class="form-control" required placeholder="Jam Mulai" name="jam_mulai">
								</div>
								<div class="form-group">
									<label>Jam Selesai</label>
									<input type="time" class="form-control" placeholder="Jam Selesai" name="jam_selesai">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Mata Pelajaran</label>
									<select class="form-control" name="pelajaran" required>
										<option value="">--Pilih Mata Pelajaran--</option>
										<?php
										$sql = $connection->query("SELECT * FROM mata_pelajaran");
										while ($rs = $sql->fetch_assoc()) {
											echo "<option value='" . htmlspecialchars($rs['idm']) . "'>" . htmlspecialchars($rs['nama_mp']) . "</option>";
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Kelas</label>
									<select class="form-control" name="kelas" required>
										<option value="">--Pilih Kelas--</option>
										<?php
										$sql = $connection->query("SELECT * FROM kelas");
										while ($rs = $sql->fetch_assoc()) {
											echo "<option value='" . htmlspecialchars($rs['idk']) . "'>" . htmlspecialchars($rs['nama']) . "</option>";
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Guru</label>
									<select class="form-control" name="guru" required>
										<option value="">--Pilih Guru--</option>
										<?php
										$sql = $connection->query("SELECT * FROM guru");
										while ($rs = $sql->fetch_assoc()) {
											echo "<option value='" . htmlspecialchars($rs['idg']) . "'>" . htmlspecialchars($rs['nama']) . "</option>";
										}
										?>
									</select>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-lg-12" align="center">
								<button type="submit" class="btn btn-success">Simpan</button>
							</div>
							<!-- /.col-lg-6 (nested) -->
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
	if ($_GET['act'] == "edit_jadwal") {
	?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Edit Data Jadwal</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Edit Data Jadwal
					</div>
					<div class="panel-body">
						<div class="row">
							<?php
							$idj = $connection->real_escape_string($_GET['idj']);
							$sql = $connection->query("SELECT * FROM jadwal WHERE idj='$idj'");
							$rsx = $sql->fetch_assoc();
							?>
							<form method="post" role="form" action="././module/simpan.php?act=edit_jadwal">
								<input type="hidden" name="idj" value="<?php echo htmlspecialchars($_GET['idj']); ?>" />
								<div class="col-lg-6">
									<div class="form-group">
										<label>Hari</label>
										<select class="form-control" name="hari" required>
											<option value="">--Pilih Hari--</option>
											<?php
											$sqlhari = $connection->query("SELECT * FROM hari");
											while ($rshari = $sqlhari->fetch_assoc()) {
												$selected = ($rshari['idh'] == $rsx['idh']) ? 'selected' : '';
												echo "<option value='" . htmlspecialchars($rshari['idh']) . "' $selected>" . htmlspecialchars($rshari['hari']) . "</option>";
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Jam Mulai</label>
										<input type="time" class="form-control" name="jam_mulai" value="<?php echo htmlspecialchars($rsx['jam_mulai']); ?>">
									</div>
									<div class="form-group">
										<label>Jam Selesai</label>
										<input type="time" class="form-control" name="jam_selesai" value="<?php echo htmlspecialchars($rsx['jam_selesai']); ?>">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Mata Pelajaran</label>
										<select class="form-control" name="pelajaran" required>
											<option value="">--Pilih Mata Pelajaran--</option>
											<?php
											$sqlmp = $connection->query("SELECT * FROM mata_pelajaran");
											while ($rsmp = $sqlmp->fetch_assoc()) {
												$selected = ($rsmp['idm'] == $rsx['idm']) ? 'selected' : '';
												echo "<option value='" . htmlspecialchars($rsmp['idm']) . "' $selected>" . htmlspecialchars($rsmp['nama_mp']) . "</option>";
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Kelas</label>
										<select class="form-control" name="kelas" required>
											<option value="">--Pilih Kelas--</option>
											<?php
											$sqlkls = $connection->query("SELECT * FROM kelas");
											while ($rskls = $sqlkls->fetch_assoc()) {
												$selected = ($rskls['idk'] == $rsx['idk']) ? 'selected' : '';
												echo "<option value='" . htmlspecialchars($rskls['idk']) . "' $selected>" . htmlspecialchars($rskls['nama']) . "</option>";
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Guru</label>
										<select class="form-control" name="guru" required>
											<option value="">--Pilih Guru--</option>
											<?php
											$sqlgr = $connection->query("SELECT * FROM guru");
											while ($rsgr = $sqlgr->fetch_assoc()) {
												$selected = ($rsgr['idg'] == $rsx['idg']) ? 'selected' : '';
												echo "<option value='" . htmlspecialchars($rsgr['idg']) . "' $selected>" . htmlspecialchars($rsgr['nama']) . "</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12" align="center">
										<button type="submit" class="btn btn-success">Simpan</button>
									</div>
									<!-- /.col-lg-6 (nested) -->
								</div>
								<!-- /.row (nested) -->
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