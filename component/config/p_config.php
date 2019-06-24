<?php
	session_start();
	include('../../include/config_db.php');

	function update_global_discount($config) {
		global $mysqli;

		$value = '';

		$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY user_id ASC");
		while ($data = $rs->fetch_assoc()) {
			$id = $data['user_id'];
			$discount = $_POST[$id] ?? 0;

			$value .= $id . '_' . $discount . '#';
		}
		
		$exe = $mysqli->query("UPDATE config SET value = '$value' WHERE config = '$config'");

		return $exe;
	}

	$url = "index-c-config.pos";
	$p = $_GET['p'];
	$user_id  = $_SESSION['user_id'] ?? 0;

	if (isset($error)) {
		$stat = 'Kesalahan:\n' . implode('\n', $error);
	}
	else {
		switch ($p) {
			case 'global_discount':
				$exe = update_global_discount('global_discount');

				if ($exe) {
					$stat = 'Edit global discount frame berhasil';
				}
				else{
					$stat = 'Edit global discount frame gagal';
				}
			break;

			case 'global_discount_lensa':
				$exe = update_global_discount('global_discount_lensa');

				if ($exe) {
					$stat = 'Edit global discount lensa berhasil';
				}
				else{
					$stat = 'Edit global discount lensa gagal';
				}
			break;

			case 'global_discount_softlens':
				$exe = update_global_discount('global_discount_softlens');

				if ($exe) {
					$stat = 'Edit global discount softlens berhasil';
				}
				else{
					$stat = 'Edit global discount softlens gagal';
				}
			break;

			case 'global_discount_accessories':
				$exe = update_global_discount('global_discount_accessories');

				if ($exe) {
					$stat = 'Edit global discount accessories berhasil';
				}
				else{
					$stat = 'Edit global discount accessories gagal';
				}
			break;

			case 'editable_price':
				$value = '';

				$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY user_id ASC");
				while ($data = $rs->fetch_assoc()) {
					$id = $data['user_id'];
					$editable = $_POST[$id] == 'on' ? 1 : 0;

					$value .= $id . '_' . $editable . '#';
				}
				
				$exe = $mysqli->query("UPDATE config SET value = '$value' WHERE config = 'editable_price'");

				if ($exe) {
					$stat = 'Edit editable price berhasil';
				}
				else{
					$stat = 'Edit editable price gagal';
				}
			break;
		}
	}
?>

<script type="text/javascript" language="javascript">
	alert('<?=$stat?>');
	location.href = '<?=$base_url?><?=$url?>';
</script>