<?php
	session_start();
	include('../../include/config_db.php');

	$url = "index-c-config.pos";
	$p   = $_GET['p'];
	$user_id  = $_SESSION['user_id'] ?? 0;
	$currentPassword = $_POST['currentPassword'] ?? '';
	$newPassword = $_POST['newPassword'] ?? '';
	$confirmPassword = $_POST['confirmPassword'] ?? '';
	
	if($p == 'change_password') {
		if ($currentPassword == '' || $newPassword == '' || $confirmPassword == '') {
			$error[] = '- Semua field harus diisi';
		}
		if ($newPassword != $confirmPassword) {
			$error[] = '- Confirm Password salah';
		}
	}

	if (isset($error)) {
		$stat = 'Kesalahan:\n' . implode('\n', $error);
	}
	else {
		switch ($p) {
			case 'change_password':
				$currentPassword = md5($currentPassword);
				$newPassword = md5($newPassword);

				$rs = $mysqli->query("SELECT * FROM kontak WHERE user_id = $user_id AND pass = '$currentPassword'");
				if ($rs->fetch_assoc()) {

				}
				else {
					$stat = 'Current Password salah';
					continue;
				}
				
				$exe = $mysqli->query("UPDATE kontak SET pass = '$newPassword' WHERE user_id = $user_id");

				if ($exe) {
					$stat = 'Change Password berhasil';
				}
				else{
					$stat = 'Change Password gagal';
				}
			break;
		}
	}
?>

<script type="text/javascript" language="javascript">
	alert('<?=$stat?>');
	location.href = '<?=$base_url?><?=$url?>';
</script>