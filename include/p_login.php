<?php
session_start();
include('config_db.php');
$nik    = $mysqli->real_escape_string($_POST['username']);
$pass   = $mysqli->real_escape_string($_POST['password']);

		$pass = md5($pass);
		$rs2 = $mysqli->query("SELECT *, 
				(SELECT kontak FROM kontak b WHERE b.user_id = a.branch_id) AS branch_name 
			FROM kontak a 
			WHERE kontak LIKE '$nik' 
			AND pass LIKE '$pass' ");
		if ($data2 = mysqli_fetch_assoc($rs2))
		{
			if ($data2['jabatan'] == 'Administrator') {
				$_SESSION['i_sesadmin'] = 1;
				$_SESSION['is_admin'] = true;
			}
			else {
				$_SESSION['i_sesadmin'] = 0;
				$_SESSION['is_admin'] = false;
			}

			$_SESSION['is_logged_in'] = true;
			$_SESSION['nama'] = $data2['kontak'];
			$_SESSION['akses'] = $data2['akses'];
			$_SESSION['user_id'] = $data2['user_id'];

			$_SESSION['branch_id'] = $data2['branch_id'];
			$_SESSION['branch_name'] = $data2['branch_name'] ?? '';

			$_SESSION['global_discount'] = 0;
			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $data2['branch_id']) $_SESSION['global_discount'] = $r[1];
			}

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