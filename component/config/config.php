<?php
	global $mysqli;

	$rs = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount'");
	$data = $rs->fetch_assoc();
	$temp = $data['value'];
	$temp = explode('#', $temp);
	foreach ($temp AS $r) {
		$r = explode('_', $r);
		if (sizeof($r) <= 1) continue;
		$global_discount[$r[0]] = $r[1];
	}

	$rs = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount_lensa'");
	$data = $rs->fetch_assoc();
	$temp = $data['value'];
	$temp = explode('#', $temp);
	foreach ($temp AS $r) {
		$r = explode('_', $r);
		if (sizeof($r) <= 1) continue;
		$global_discount_lensa[$r[0]] = $r[1];
	}

	$rs = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount_softlens'");
	$data = $rs->fetch_assoc();
	$temp = $data['value'];
	$temp = explode('#', $temp);
	foreach ($temp AS $r) {
		$r = explode('_', $r);
		if (sizeof($r) <= 1) continue;
		$global_discount_softlens[$r[0]] = $r[1];
	}

	$rs = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount_accessories'");
	$data = $rs->fetch_assoc();
	$temp = $data['value'];
	$temp = explode('#', $temp);
	foreach ($temp AS $r) {
		$r = explode('_', $r);
		if (sizeof($r) <= 1) continue;
		$global_discount_accessories[$r[0]] = $r[1];
	}

	$rs = $mysqli->query("SELECT * FROM config WHERE config = 'editable_price'");
	$data = $rs->fetch_assoc();
	$temp = $data['value'];
	$temp = explode('#', $temp);
	foreach ($temp AS $r) {
		$r = explode('_', $r);
		if (sizeof($r) <= 1) continue;
		$editable_price[$r[0]] = $r[1];
	}
?>

<script type="text/javascript" language="javascript">
	$(function() {
		$('.form_global_discount').submit(function() {
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(data) {
					$('#result').html(data);
				}
			});
			return false;
		});
	});
</script>

<div id="result" style="display: none;"></div>

<h1>Toko</h1>

<div class="container">

<div class="row">
<div class="col-sm">
	<form name="form_global_discount" class="form_global_discount" method="POST" action="component/config/p_config.php?p=global_discount">
		<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
			<thead>
				<tr>
					<th colspan="3" align="center">
						<h1 style="margin: 5px;">Discount Frame</h1>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
					while ($data = $rs->fetch_assoc()) {
						$id = $data['user_id'];
						?>
							<tr>
								<td><?=$data['kontak']?></td>
								<td>:</td>
								<td>
									<input type="number" name="<?=$id?>" value="<?=($global_discount[$id] ?? 0)?>" />
								</td>
							</tr>
						<?php
					}
				?>

				<tr>
					<td colspan="2">&nbsp;</td>
					<td>
						<input type="submit" value="Update" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

<div class="col-sm">
	<form name="form_global_discount_lensa" class="form_global_discount" method="POST" action="component/config/p_config.php?p=global_discount_lensa">
		<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
			<thead>
				<tr>
					<th colspan="3" align="center">
						<h1 style="margin: 5px;">Discount Lensa</h1>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
					while ($data = $rs->fetch_assoc()) {
						$id = $data['user_id'];
						?>
							<tr>
								<td><?=$data['kontak']?></td>
								<td>:</td>
								<td>
									<input type="number" name="<?=$id?>" value="<?=($global_discount_lensa[$id] ?? 0)?>" />
								</td>
							</tr>
						<?php
					}
				?>

				<tr>
					<td colspan="2">&nbsp;</td>
					<td>
						<input type="submit" value="Update" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
</div>

<br />

<div class="row">
<div class="col-sm">
	<form name="form_global_discount_softlens" class="form_global_discount" method="POST" action="component/config/p_config.php?p=global_discount_softlens">
		<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
			<thead>
				<tr>
					<th colspan="3" align="center">
						<h1 style="margin: 5px;">Discount Softlens</h1>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
					while ($data = $rs->fetch_assoc()) {
						$id = $data['user_id'];
						?>
							<tr>
								<td><?=$data['kontak']?></td>
								<td>:</td>
								<td>
									<input type="number" name="<?=$id?>" value="<?=($global_discount_softlens[$id] ?? 0)?>" />
								</td>
							</tr>
						<?php
					}
				?>

				<tr>
					<td colspan="2">&nbsp;</td>
					<td>
						<input type="submit" value="Update" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

<div class="col-sm">
	<form name="form_global_discount_accessories" class="form_global_discount" method="POST" action="component/config/p_config.php?p=global_discount_accessories">
		<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
			<thead>
				<tr>
					<th colspan="3" align="center">
						<h1 style="margin: 5px;">Discount Accessories</h1>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
					while ($data = $rs->fetch_assoc()) {
						$id = $data['user_id'];
						?>
							<tr>
								<td><?=$data['kontak']?></td>
								<td>:</td>
								<td>
									<input type="number" name="<?=$id?>" value="<?=($global_discount_accessories[$id] ?? 0)?>" />
								</td>
							</tr>
						<?php
					}
				?>

				<tr>
					<td colspan="2">&nbsp;</td>
					<td>
						<input type="submit" value="Update" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
</div>

<br />

<div class="row">
	<div class="col-sm">
		<form name="form_editable_price" class="form_global_discount" method="POST" action="component/config/p_config.php?p=editable_price">
			<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
				<thead>
					<tr>
						<th colspan="3" align="center">
							<h1 style="margin: 5px;">Editable Price</h1>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
						while ($data = $rs->fetch_assoc()) {
							$id = $data['user_id'];
							?>
								<tr>
									<td><?=$data['kontak']?></td>
									<td>:</td>
									<td>
									    &nbsp;&nbsp;&nbsp;<input type="checkbox" class="form-check-input" name="<?=$id?>" <?=($editable_price[$id] == 1 ? 'checked="checked"' : '')?> />&nbsp;
									</td>
								</tr>
							<?php
						}
					?>

					<tr>
						<td colspan="2">&nbsp;</td>
						<td>
							<input type="submit" value="Update" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>

<br />

<div class="row">
	<div class="col">
		<h1 style="text-align: left;margin-top: 8px;">Promo</h1>
		
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Cabang</th>
					<th>Promo</th>
					<th>Periode</th>
					<th>Tipe</th>
					<th>Potongan</th>
					<th>&nbsp;</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$tipes = array(
						'0'	=> 'SEMUA',
						'1'	=> 'FRAME',
						'2'	=> 'SOFTLENS',
						'3'	=> 'LENSA',
						'4'	=> 'ACCESSORIES',
					);

					$rs = $mysqli->query('SELECT a.*, b.kontak FROM promo a LEFT JOIN kontak b ON a.branch_id = b.user_id WHERE end_date >= NOW() ORDER BY kontak ASC, end_date ASC');
					while ($data = $rs->fetch_assoc()) {
						$branch = $data['branch_id'] == 0 ? 'SEMUA' : $data['kontak'];
						$category = $data['category'];
						?>
							<tr>
								<td><?=$branch?></td>
								<td><?=$data['name']?></td>
								<td><?=$data['start_date']?> - <?=$data['end_date']?></td>
								<td><?=$tipes[$category]?></td>
								<td><?=number_format($data['discount'], 0)?><?=$data['discount_type']=='1'?'%':''?></td>
								<td>
									<a href="component/config/p_config.php?p=delete_promo&id=<?=$data['id']?>" class="btn btn-danger btn-sm">Delete</a>
								</td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>

		<div class="card">
			<div class="card-body">
				<form name="form_promo" method="POST" action="component/config/p_config.php?p=create_promo">
					<h4>Add Promo</h4>
					<br />
					<div class="form-group">
						<label>Cabang</label>
						<select name="branch_id" class="form-control form-control-sm">
							<option value="0">SEMUA</option>
							<?php
								$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
								while ($data = $rs->fetch_assoc()) {
									$id = $data['user_id'];
									?>
										<option value="<?=$id?>"><?=$data['kontak']?></option>
									<?php
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Nama Promo</label>
						<input type="text" name="name" class="form-control form-control-sm" />
					</div>
					<div class="form-group">
						<label>Periode&nbsp;&nbsp;&nbsp;</label>
						<input type="date" name="start_date" class="form_control form-control-sm" />
						-
						<input type="date" name="end_date" class="form_control form-control-sm" />
					</div>
					<div class="form-group">
						<label>Tipe</label>
						<select name="category" class="form-control form-control-sm">
							<option value="0">SEMUA</option>
							<option value="1">FRAME</option>
							<option value="2">SOFTLENS</option>
							<option value="3">LENSA</option>
							<option value="4">ACCESSORIES</option>
						</select>
					</div>
					<div class="form-group row">
						<label class="col-12">Potongan</label>
						<div class="col-2">
							<select name="discount_type" class="form-control form-control-sm">
								<option value="0">Cash</option>
								<option value="1">%</option>
							</select>
						</div>
						<div class="col-10">
							<input type="number" name="discount" class="form-control form-control-sm" placeholder="0" />
						</div>
					</div>
					<div class="form-group">
						<input type="submit" value="Create" class="btn btn-primary btn-sm" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

</div>
