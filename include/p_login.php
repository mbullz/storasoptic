<?php
session_start();
include('config_db.php');
$nik    = $mysqli->real_escape_string($_POST['username']);
$pass   = $mysqli->real_escape_string($_POST['password']);
// check login
/*$query_login = "select kode, kontak, akses from kontak where kode='$nik' AND pass='$pass' AND aktif='1'";
$login = $mysqli->query($query_login);
$row_login = mysqli_fetch_assoc($login);
$total_login = mysqli_num_rows($login);
if($total_login > 0) { ?>*/

	if (($nik === 'efata' && $pass === 'efata123') || ($nik === 'admin' && $pass === 'admin123')) 
	{
		$akses = $mysqli->query("select user_id,akses from kontak where user_id=1");
		$row_akses = mysqli_fetch_assoc($akses);
		$_SESSION['i_sesadmin'] = 1;
		$_SESSION['nama'] = $nik;
		$_SESSION['akses'] = $row_akses['akses'];
		$_SESSION['user_id'] = $row_akses['user_id'];
		?>
    		<script type="text/javascript">
        		alert('Login Berhasil ...');
        		location.href = '/<?=$base_url?>/index.php';
    		</script>
		<?php
	}
	else if (($nik === 'operator' && $pass === 'operator123')) 
	{
		$akses = $mysqli->query("select akses from kontak where user_id=1");
		$row_akses = mysqli_fetch_assoc($akses);
		$_SESSION['i_sesadmin'] = 0;
		$_SESSION['nama'] = $nik;
		$_SESSION['akses'] = $row_akses['akses'];
		?>
    		<script type="text/javascript">
        		alert('Login Berhasil ...');
        		location.href = '/<?=$base_url?>/index.php';
    		</script>
		<?php
	}
	else
	{
		$pass = md5($pass);
		$rs2 = $mysqli->query("SELECT * FROM kontak WHERE kontak LIKE '$nik' AND pass LIKE '$pass'");
		if ($data2 = mysqli_fetch_assoc($rs2))
		{
			$_SESSION['i_sesadmin'] = 1;
			$_SESSION['nama'] = $nik;
			$_SESSION['akses'] = $data2['akses'];
			$_SESSION['user_id'] = $data2['user_id'];
			?>
				<script type="text/javascript">
					alert('Login Berhasil ...');
					location.href = '/<?=$base_url?>/index.php';
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
	}
?>