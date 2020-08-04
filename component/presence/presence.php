<?php

global $mysqli;
global $c;
global $branch_id;

$rows = $mysqli->query("SELECT a.*, TIME(a.presence_date) AS presence_time, b.kontak, c.kontak AS branch 
						FROM presence a 
						JOIN kontak b ON a.user_id = b.user_id 
						LEFT JOIN kontak c ON b.branch_id = c.user_id 
						WHERE date(presence_date) = date(NOW()) 
						ORDER BY a.presence_date DESC ");

?>

<style>
	body {
	}

	.card-header label {
		font-size: 18px;
		font-weight: bold;
		margin: 0px;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<div class="card">
				<div class="card-header">
					<label>Absensi</label>
				</div>

				<div class="card-body">
					<?php if (isset($_SESSION['flash_status'])): ?>
						<div class="alert <?=$_SESSION['flash_status']=='success'?'alert-success':'alert-danger'?> text-center" role="alert" id="flash">
							<?php
								echo $_SESSION['flash'];

								unset($_SESSION['flash_status']);
								unset($_SESSION['flash']);
							?>
						</div>

						<script type="text/javascript">
							setTimeout(function() {
								var flash = document.getElementById("flash");
								flash.remove();
							}, 3000);
						</script>
					<?php endif; ?>

					<form name="form" id="form" method="POST" action="component/<?=$c?>/p_<?=$c?>.php">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control form-control-sm" id="username" name="username" />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control form-control-sm" id="password" name="password" />
						</div>
						<div class="form-group">
							<label for="note">Keterangan</label>
							<textarea class="form-control form-control-sm" id="note" name="note" rows="2" aria-describedby="noteHelp"></textarea>
							<small id="noteHelp" class="form-text text-muted">
								Tidak wajib, kosongkan apabila tidak ada keterangan tambahan.
							</small>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-sm">Absen</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-sm-9">
			<div class="card">
				<div class="card-body">
					<h6 class="card-title mb-1 text-muted">Daftar Absensi - <?=date('D, j F Y')?></h6>

					<br /><br />

					<table class="table">
						<thead>
							<tr>
								<th width="5%" scope="col"></th>
								<th scope="col">Nama</th>
								<th scope="col">Cabang</th>
								<th scope="col">Waktu Absen</th>
								<th scope="col">Keterangan</th>
							</tr>
						</thead>

						<tbody>
							<?php $i = 1; ?>
							<?php while ($row = $rows->fetch_assoc()): ?>
								<tr>
									<td scope="row"><?=$i?></td>
									<td scope="row"><?=$row['kontak']?></td>
									<td scope="row"><?=$row['branch']?></td>
									<td scope="row"><?=$row['presence_time']?></td>
									<td scope="row"><?=$row['note']?></td>
								</tr>
								<?php $i++; ?>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
 	</div>
</div>

<script type="text/javascript">
	$(function() {
		$('#username').focus();
	});
</script>
