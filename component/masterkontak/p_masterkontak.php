<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$klas = $_POST['klas'];
	$url = "index-c-masterkontak-k-$klas-q-.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$kod = intval($_POST['kode']);
	$jen = $_POST['jenis'];
    $gen = intval($_POST['gender']);
	$kon = $mysqli->real_escape_string($_POST['kontak']);
	$pass = md5($mysqli->real_escape_string($_POST['pass']));
	$ala = $mysqli->real_escape_string($_POST['alamat']);
	$kpe = $mysqli->real_escape_string($_POST['kperson']);
	$pbb = $mysqli->real_escape_string($_POST['pinbb']);
	$jab = $mysqli->real_escape_string($_POST['jabatan']);
	$tlp = $mysqli->real_escape_string($_POST['notlp']);
	$tlp2= $mysqli->real_escape_string($_POST['notlp2']);
	$hp  = $mysqli->real_escape_string($_POST['hp']);
	$fax = $mysqli->real_escape_string($_POST['fax']);
	$ema = $mysqli->real_escape_string($_POST['email']);
	$inf = $mysqli->real_escape_string($_POST['info']);
	$sta = $_POST['status'];
	$mul = $_POST['mulai'];
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if (trim($jen) == '') {
			$error[] = '- Jenis Kontak harus diisi';
		}
		if (trim($kon) == '') {
			$error[] = '- Nama '.ucfirst($_GET['klas']).' harus diisi';
		}
		if ($klas != 'customer' && trim($ala) == '')
		{
			$error[] = '- Alamat harus diisi';
		}
		if ($klas == 'customer' && trim($tlp) == '')
		{
			$error[] = '- Telephone harus diisi';
		}
	}else if($p =='mdelete'){
		if($jdata <= 0) {
			$error[] ="- Proses gagal, Pilih min 1 data yang ingin dihapus !!!";	
		}
	}
	// End Validasi
	if (isset($error)) {
//		echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Kesalahan : </b><br />".implode("<br />", $error);
        $stat = 'Kesalahan:\n' . implode('\n', $error);
	} else {
		switch($p) {
			case("mdelete"):
			$where = " where ";
			for($i=0;$i<$jdata;$i++) {
				$where .="user_id='$data[$i]'";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe = "delete from kontak".$where;
			$exe = $mysqli->query($query_exe);
			if($exe) {
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah dihapus ...</b></center>";
                $stat = 'Data telah dihapus ...';
				}else{
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal dihapus, coba lagi !!!</b></center>";
                    $stat = 'Data gagal dihapus, coba lagi !!!';
				}
			break;
			case("edit"):
			$query_exe = "UPDATE kontak SET kontak='$kon', gender=$gen, jenis='$jen', alamat='$ala', kperson='$kpe', pinbb='$pbb', jabatan='$jab', notlp='$tlp', notlp2='$tlp2', hp='$hp', fax='$fax', email='$ema', mulai='$mul', aktif='$sta', info='$inf' where user_id = $kod";
			$exe = $mysqli->query($query_exe);
			if($exe) {
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
				}else{
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
                    $stat = 'Data gagal disimpan, coba lagi !!!';
				}
			break;
			case("delete"):
			/*$query_exe = "delete from agen where kd='$kd'";
			$exe = $mysqli->query($query_exe, $tiket) or die(mysql_error());
			if($exe) {
					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah dihapus ...</b></center>";
				}else{
					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal dihapus, coba lagi !!!</b></center>";
				}*/
			$stat = "not used again ...";
			break;
			default:
				if ($klas == "karyawan")
				{
					$query_exe = "insert into kontak(pass,gender,akses,jenis,kontak,alamat,kperson,pinbb,mulai,aktif,jabatan,notlp,notlp2,hp,fax,email,info) values ('$pass', '$gen','','$jen','$kon','$ala','$kpe','$pbb','$mul','$sta','$jab','$tlp','$tlp2','$hp','$fax','$ema','$inf')";
				}
				else
				{
					$query_exe = "insert into kontak(pass,gender,akses,jenis,kontak,alamat,kperson,pinbb,mulai,aktif,jabatan,notlp,notlp2,hp,fax,email,info) values ('', '$gen','','$jen','$kon','$ala','$kpe','$pbb','$mul','$sta','$jab','$tlp','$tlp2','$hp','$fax','$ema','$inf')";
				}
				$exe = $mysqli->query($query_exe);
				//echo $query_exe;
				if($exe) {
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                    $stat = "Data telah disimpan ...";
				}else{
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
                    $stat = 'Data gagal disimpan, coba lagi !!!';
				}
			break;
		}
	}
?>
<script type="text/javascript">
	alert('<?php echo $stat; ?>');
    <?php if ($exe) { ?>
   	location.href = '/<?=$base_url?>/<?=$url?>';
    <?php }
		else
		{
			?>
				location.href = '/<?=$base_url?>/<?=$url?>';
			<?php
		}
	?>
</script>