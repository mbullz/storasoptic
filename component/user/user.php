<?php

global $mysqli, $c;

$query = "SELECT a.user_id, a.kontak, a.mulai, a.jabatan, 
			b.kontak AS branch_name 
		FROM kontak a 
		LEFT JOIN kontak b ON a.branch_id = b.user_id 
		WHERE a.aktif = '1' 
		AND a.jenis = 'T001' 
		ORDER BY a.kontak ASC ";

?>

<script type="text/javascript">
	var data = [];

	<?php
		$rs = $mysqli->query($query);
		while ($data = $rs->fetch_assoc()) {
			$user_id = $data['user_id'];
			$kontak = htmlspecialchars($data['kontak'], ENT_QUOTES);
			$mulai = $data['mulai'];
			$jabatan = $data['jabatan'];
			$branch_name = htmlspecialchars($data['branch_name'], ENT_QUOTES);

			$globalAccess = '';
			if ($jabatan == 'Administrator' || $jabatan == 'Co-Administrator') {
				$globalAccess = '<img src="images/check.png" />';
			}

			$edit = '';
			if (strstr($_SESSION['akses'], "edit_".$c)) {
				$edit = '<a href="index-c-'.$c.'-t-edit-'.$user_id.'.pos">Edit</a>';
				$reset = '<a href="#" onclick="resetPassword('.$user_id.')">Reset Password</a>';
			}

			?>
				data.push([
					<?=$user_id?>,
					'<?=$kontak?>',
					'<?=$branch_name?>',
					'<?=$mulai?>',
					'<?=$globalAccess?>',
					'<?=$edit?> | <?=$reset?>',
				]);
			<?php
		}
	?>
</script>

<h1>User Internal</h1>

<table id="example">
	<thead>
		<tr>
			<th>Nama</th>
			<th>Cabang</th>
			<th>Mulai Bergabung</th>
			<th>Akses Semua Cabang</th>
			<th>Pengaturan</th>
		</tr>
	</thead>
</table>
