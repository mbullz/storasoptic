<?php
session_start();
include('config_db.php');
$nik    = $mysqli->real_escape_string($_POST['username']);
$pass   = $mysqli->real_escape_string($_POST['password']);

		$pass = md5($pass);
		$rs2 = $mysqli->query("SELECT * FROM kontak WHERE kontak LIKE '$nik' AND pass LIKE '$pass'");
		if ($data2 = mysqli_fetch_assoc($rs2))
		{
			if ($data2['jabatan'] == 'Administrator') $_SESSION['i_sesadmin'] = 1;
			else $_SESSION['i_sesadmin'] = 0;

			$_SESSION['nama'] = $data2['kontak'];
			$_SESSION['akses'] = $data2['akses'];
			$_SESSION['user_id'] = $data2['user_id'];
			?>
				<script type="text/javascript">
					alert('Login Berhasil ...');
					location.href = '<?=$base_url?>index.php';
				</script>
			<?php
		}
		else
		{
			?>
				<script type="text/javascript">
					alert('Username & Password salah, coba lagi !!!');
				</script>
			<?php
		}

?>