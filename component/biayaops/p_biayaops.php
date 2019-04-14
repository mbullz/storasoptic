<?php
	session_start();
	include('../../include/config_db.php');
	
	//Define variable
    $stat = '';
	$url = "index-c-biayaops.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$jenis = $_POST['jenis'];
	$bay = $_POST['bayar'];
	$tgl = $_POST['tgl'];
	$jum = $_POST['jumlah'];
	$mat = $_POST['matauang'];
	$inf = $mysqli->real_escape_string($_POST['info']);
	$opr = $_SESSION['user_id'];
	$referensi = $_POST['referensi'] ?? '';
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if (trim($tgl) == '') {
			$error[] = '- Tgl harus diisi !!!';
		}
		if (trim($bay) == '') {
			$error[] = '- Cara Pembayaran harus diisi !!!';
		}
		if (!is_numeric($jum)) {
			$error[] = '- Jumlah Biaya harus angka !!!';
		}
		if (trim($mat) == '') {
			$error[] = '- Mata Uang harus diisi !!!';
		}
	}else if($p =='mdelete'){
		if($jdata <= 0) {
			$error[] ="- Proses gagal, Pilih min 1 data yang ingin dihapus !!!";	
		}
	}
	// End Validasi
	if (isset($error)) {
//		echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Kesalahan : </b><br />".implode("<br />", $error);
        $stat = 'Kesalahan: ' . implode('\n', $error);
	} else {
		switch($p) {
			case("mdelete"):
			$where = " where ";
			for($i=0;$i<$jdata;$i++) {
				$where .="id='$data[$i]'";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe = "delete from aruskas".$where;
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
			$query_exe = "update aruskas set carabayar='$bay', tgl='$tgl', jumlah='$jum', matauang='$mat', info='$inf' where id='$id'";
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
				$query_exe = "INSERT INTO aruskas VALUES(0, $bay, 0, 'operasional', '$tgl', $opr, '$referensi', $jum, $mat, '$jenis # $inf')";
				$exe = $mysqli->query($query_exe);
				
				if ($exe) {
                    $stat = 'Data telah disimpan ...';
				} else{
                    $stat = 'Data gagal disimpan, coba lagi !!!';
				}
			break;
		}
	}
?>

<script type="text/javascript">
    alert('<?php echo $stat; ?>');
    <?php if ($exe) { ?>
    location.href = '<?=$base_url?><?php echo $url; ?>';
    <?php } else { ?>
    location.href = '<?=$base_url?>index-c-biayaops-t-add.pos';
    <?php } ?>
</script>