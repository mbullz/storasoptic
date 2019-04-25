<?php
	session_start();
	include('../../include/config_db.php');

	$url = "index-c-config.pos";
	$p = $_GET['p'];
	$user_id  = $_SESSION['user_id'] ?? 0;

	if (isset($error)) {
		$stat = 'Kesalahan:\n' . implode('\n', $error);
	}
	else {
		switch ($p) {
			case 'global_discount':
				$value = '';

				$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY user_id ASC");
				while ($data = $rs->fetch_assoc()) {
					$id = $data['user_id'];
					$discount = $_POST[$id] ?? 0;

					$value .= $id . '_' . $discount . '#';
				}
				
				$exe = $mysqli->query("UPDATE config SET value = '$value' WHERE config = 'global_discount'");

				if ($exe) {
					$stat = 'Edit global discount berhasil';
				}
				else{
					$stat = 'Edit global discount gagal';
				}
			break;
		}
	}
?>

<script type="text/javascript" language="javascript">
	alert('<?=$stat?>');
	location.href = '<?=$base_url?><?=$url?>';
</script>