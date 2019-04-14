<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-barangreturkeluar.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$tgl = $_POST['tgl'];
	$qty = $_POST['qty'];
	$inf = $mysqli->real_escape_string($_POST['info']);
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if (trim($tgl) == '') {
			$error[] = '- Tanggal harus diisi !!!';
		}
		if (!is_numeric($qty)) {
			$error[] = '- Jumlah Barang harus angka !!!';
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
			$query_exe = "delete from kirimbarang_r".$where;
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
			
			$processed = $_POST['processed'];
			$processed_info = $mysqli->real_escape_string($_POST['processed_info']);
	
			$query_exe = "update kirimbarang_r set tgl='$tgl', qty='$qty', info='$inf' , processed='$processed' , processed_info='$processed_info' where id='$id'";
			$exe = $mysqli->query($query_exe);
			if($exe) {
					// adjustment stok
					$adj_value =  $_POST['stok'] - $_POST['qtyold'];
					$stoknow   = $adj_value + $qty;
					// update stok
					$updatestok= $mysqli->query("update stokbarang set qty='$stoknow' where id='$_POST[stokid]'");
					//---
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
				// not used
				/*$query_exe = "insert into barang values ('$kod','$jen','$brg','$bar','$inf')";
				$exe = $mysqli->query($query_exe);
				//echo $query_exe;
				if($exe) {
					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
				}else{
					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
				}
			break;*/
		}
	}
?>
<script type="text/javascript">
    alert('<?php echo $stat; ?>');
    <?php if ($exe) { ?>
    location.href = '<?=$base_url?><?php echo $url; ?>';
    <?php } ?>
</script>