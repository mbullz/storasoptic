<?php
	include('../../include/config_db.php');
	//Define variable
	$url = "index-c-pembayaranhutang.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$bay = $_POST['bayar'];
	$tgl = $_POST['tgl'];
	$jum = $_POST['jumlah'];
	$inf = $mysqli->real_escape_string($_POST['info']);
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
			$error[] = '- Jumlah Pembayaran harus angka !!!';
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
			$query_exe = "update aruskas set carabayar='$bay', tgl='$tgl', jumlah='$jum', info='$inf' where id='$id'";
			$exe = $mysqli->query($query_exe);
			if($exe) {
					// get total bayar
					$query_tbayar = "select sum(jumlah) as bayar from aruskas where referensi='$_POST[referensi]'";
					$tbayar       = $mysqli->query($query_tbayar);
					$row_tbayar   = mysqli_fetch_assoc($tbayar);
					// ---
					$lunas = intval($_POST['sisa'] - $row_tbayar['bayar']);
					if($lunas <= 0) {
						// update lunas
						$mysqli->query("update masukbarang set lunas='1' where referensi='$_POST[referensi]'");
						// ---
					}else {
						// update hutang
						$mysqli->query("update masukbarang set lunas='0' where referensi='$_POST[referensi]'");
						// ---
					}
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
				$query_exe = "insert into aruskas (id,carabayar,tipe,tgl,opr,referensi,jumlah,info) values ('$id','$bay','$_POST[tipe]','$tgl','$_POST[opr]','$_POST[referensi]','$jum','$inf')";
				$exe = $mysqli->query($query_exe) or die(mysql_error());
				//echo $query_exe;
				if($exe) {
					// get total bayar
					$query_tbayar = "select sum(jumlah) as bayar from aruskas where referensi='$_POST[referensi]'";
					$tbayar       = $mysqli->query($query_tbayar);
					$row_tbayar   = mysqli_fetch_assoc($tbayar);
					// ---
					$lunas = intval($_POST['sisa'] - $row_tbayar['bayar']);
					if($lunas <= 0) {
						// update lunas
						$mysqli->query("update masukbarang set lunas='1' where referensi='$_POST[referensi]'");
						// ---
					}else {
						// update hutang
						$mysqli->query("update masukbarang set lunas='0' where referensi='$_POST[referensi]'");
						// ---
					}
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                    $stat = 'Data telah disimpan ...';
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
    location.href = '<?=$base_url?><?php echo $url; ?>';
    <?php } else { ?>
    history.go(-1);
    <?php } ?>
</script>