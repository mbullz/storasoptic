<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-cbayar.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$kod = strtoupper(str_replace(" ","_",$_POST['kode']));
	$tip = $_POST['tipe'];
	$bay = $mysqli->real_escape_string($_POST['bayar']);
	$inf = $mysqli->real_escape_string($_POST['info']);
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
			
		if (trim($bay) == '') {
			$error[] = '- Cara Pembayaran harus diisi !!!';
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
				$where .="kode='$data[$i]'";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe = "delete from carabayar".$where;
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
			$query_exe = "UPDATE carabayar SET pembayaran = '$bay', info = '$inf' WHERE carabayar_id = $id";
			$exe = $mysqli->query($query_exe);
			
			if($exe) {
					$stat = 'Edit data berhasil';
				}else{
					$stat = 'Edit data gagal';
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
			echo "not used again ...";
			break;
			default:
				$query_exe = "INSERT INTO carabayar(pembayaran, info) values ('$bay', '$inf')";
				$exe = $mysqli->query($query_exe);

				if($exe) {
                    $stat = 'Tambah data berhasil';
				}else{
                    $stat = 'Tambah data gagal';
				}
			break;
		}
	}
?>
<script type="text/javascript">
    alert('<?php echo $stat; ?>');

    location.href = '<?=$base_url?><?php echo $url; ?>';
</script>