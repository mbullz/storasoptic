<?php

global $mysqli;
global $klas, $c;

require "models/Kontak.php";
require "models/DBHelper.php";

$db = new DBHelper($mysqli);

$contacts = $db->getAllKontak($klas);

?>

<script type="text/javascript">
    var data = [];

	<?php
		foreach ($contacts AS $r) {
			$user_id = $r->getUserId();

			$kontak = htmlspecialchars($r->getKontak(), ENT_QUOTES);
			$alamat = str_replace("\r\n", "<br />", htmlspecialchars($r->getAlamat(), ENT_QUOTES));
			$hp = htmlspecialchars($r->getHp(), ENT_QUOTES);
			$notlp = htmlspecialchars($r->getNoTlp(), ENT_QUOTES);
			$email = htmlspecialchars($r->getEmail(), ENT_QUOTES);

			$edit = '';
			if (strstr($_SESSION['akses'], "edit_".$c)) {
				$edit = '<a href="index.php?component='.$c.'&task=add&klasifikasi='.$klas.'&id='.$user_id.'" title="Edit Data"><img src="images/edit_icon.png" width="16px" height="16px" /></a>';
			}

			$delete = '';
			if (strstr($_SESSION['akses'], "delete_" . $c)) {
				$delete = '<img src="images/delete_icon.png" height="16px" width="16px" style="cursor: pointer;" onclick="deleteData('.$user_id.')" />';
			}

			?>
				data.push([
					<?=$user_id?>,
					'',
					'<?=$kontak?>',
					'<?=$alamat?>',
					'<?=$hp?> / <?=$notlp?>',
					'<?=$email?>',
					'<?=$edit?> &nbsp; <?=$delete?>',
				]);
			<?php
		}
	?>
</script>

<script type="text/javascript" language="javascript" src="js/number_format.js"></script>
<script type="text/javascript" language="javascript" src="js/apps/masterkontak.js"></script>

<style>
	td.details-control {
		background: url('media/images/details_open.png') no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url('media/images/details_close.png') no-repeat center center;
	}

	.th {
		color: #660099;
	}
</style>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
	<input type="hidden" name="klas" id="klas" value="<?=$klas?>" />

	<h1>Data  <?php echo ucfirst($klas);?></h1>

	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?>
		<a href="index-c-<?php echo $c;?>-t-add-k-<?php echo $klas;?>.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a>
		<br /><br />
	<?php } ?>

	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<tr>
				<th width="1%" class="th">INFO</th>
				<th class="th"><?=strtoupper($klas)?></th>
				<th class="th">ALAMAT</th>
				<th class="th">CONTACT</th>
				<th class="th">EMAIL</th>
				<th class="th">&nbsp;</th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>
			<tr>
				<th></th>
				<th><?=strtoupper($klas)?></th>
				<th>ALAMAT</th>
				<th>CONTACT</th>
				<th>EMAIL</th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</form>

	<br /><br />

	<div>
		Periode:
		<span>
			<input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
		</span>
		s/d
		<span>
			<input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
		</span><br>

		<?php
			if ($klas == "customer")
			{
				?>
					<label>
						<input type="radio" id="customer1" />
						Laporan Pembelian Customer
					</label>
					<select id="user_id">
						<?php
							$rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'C001' ORDER BY kontak ASC");
							while ($data2 = mysqli_fetch_assoc($rs2))
							{
								?>
									<option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
								<?php
							}
						?>
					</select>
					<br />
				<?php
			}
			else if ($klas == "supplier")
			{
				?>
					<label>
						<input type="radio" id="supplier1" />
						Laporan Pengambilan Barang Dari Supplier
					</label>
					<select id="user_id">
						<?php
							$rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'S0001' ORDER BY kontak ASC");
							while ($data2 = mysqli_fetch_assoc($rs2))
							{
								?>
									<option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
								<?php
							}
						?>
					</select>
					<br />
				<?php
			}
			else if ($klas == "karyawan")
			{
				?>
					<label>
						<input type="radio" id="karyawan1" />
						Laporan Penjualan Karyawan
					</label>
					<select id="user_id">
						<?php
							$rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'T001' or jenis LIKE 'T002' ORDER BY kontak ASC");
							while ($data2 = mysqli_fetch_assoc($rs2))
							{
								?>
									<option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
								<?php
							}
						?>
					</select>
					<br />
				<?php
			}
			else if ($klas == "cabang")
			{
				?>
					<label>
						<input type="radio" name="radio" id="cabang1" />
						Laporan Umum Perpindahan Barang
					</label>
					<br />

					<label>
						<input type="radio" name="radio" id="cabang2" />
						Laporan Detail Perpindahan Barang
					</label>
					<select id="user_id">
						<?php
							$rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'B001' ORDER BY kontak ASC");
							while ($data2 = mysqli_fetch_assoc($rs2))
							{
								?>
									<option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
								<?php
							}
						?>
					</select>
					<br />
				<?php
			}
		?>

		<input type="button" value="Cetak" onclick="generateReport();" />
    </div>