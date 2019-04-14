<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-targetpenjualan.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$sal = $_POST['sales'];
	$per = $_POST['periode'];
	$tar = $_POST['target'];
	$inf = $mysqli->real_escape_string($_POST['info']);
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if($per <>'' AND $sal <>'') {
		// cek periode
		$query_cekp = "select id from targetpm where periode='$per' AND kontak='$sal'";
		$cekp       = $mysqli->query($query_cekp);
		$total_cekp = mysqli_num_rows($cekp);
			if($p=='add' AND $total_cekp > 0) {
				$error[] = '- Target Penjualan sudah ada, coba lagi !!!';				
			}
		}
		// ----
		if (trim($per) == '') {
			$error[] = '- Periode harus diisi !!!';
		}
		if (trim($sal) == '') {
			$error[] = '- Salesman harus diisi !!!';
		}
		if (!is_numeric($tar)) {
			$error[] = '- Target harus diisi ( angka ) !!!';
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
				$e_data = explode(",",$data[$i]);
				$where .="(periode='$e_data[0]' AND kontak='$e_data[1]')";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe = "delete from targetpm".$where;
			$exe = $mysqli->query($query_exe);
			if($exe) {
					// delete target detail
					$mysqli->query("delete from targetpm_d".$where) or die(mysql_error());
					// ---
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah dihapus ...</b></center>";
                    $stat = 'Data telah dihapus ...';
				}else{
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal dihapus, coba lagi !!!</b></center>";
                    $stat = 'Data gagal dihapus, coba lagi !!!';
				}
			break;
			case("edit"):
			$query_exe = "update targetpm set periode='$per', kontak='$sal', target='$tar', info='$inf' where id='$id'";
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
				$query_exe = "insert into targetpm values (NULL,'$sal','$per','$tar','$inf')";
				$exe = $mysqli->query($query_exe);
				//echo $query_exe;
				if($exe) {
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
    <?php } ?>
</script>