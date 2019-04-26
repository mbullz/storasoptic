<?php
	session_start();
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-masterbarang.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	$product_id = $_POST['product_id'];
	$kod = strtoupper(str_replace(" ","_",$_POST['kode']));
    $tipe = $_POST['tipe'];
    if ($_POST['frame'] != '') {
        $fra = $mysqli->real_escape_string($_POST['frame']);
    } else {
        $fra = $mysqli->real_escape_string($_POST['frame1']);
    }
	$jen = $_POST['jenis'];
	$brg = $mysqli->real_escape_string($_POST['barang']);
	//$bar = $mysqli->real_escape_string($_POST['barcode']);
    $col = $mysqli->real_escape_string($_POST['color']);
    $size = $mysqli->real_escape_string($_POST['size']);
    $qty = intval($_POST['qty']);
	$price = intval($_POST['price']);
	$price2 = intval($_POST['price2']);
	$kode_harga = $mysqli->real_escape_string($_POST['kode_harga']);
	$inf = $mysqli->real_escape_string($_POST['info']);
	$masuk = $mysqli->real_escape_string($_POST['tgl_masuk']);
	$keluar = $mysqli->real_escape_string($_POST['tgl_keluar']);

	if (empty($masuk) || !isset($masuk)) {
		$masuk = "NULL";
	} else {
		$masuk = "'$masuk'";
	}
	
	if (empty($keluar) || !isset($keluar)) {
		$keluar = "NULL";
	} else {
		$keluar = "'$keluar'";
	}

	if ($tipe == 3) {
		$fra *= 100;
		$col *= 100;
	}

	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if (trim($jen) == '') {
			$error[] = '- Jenis Barang harus diisi !!!';
		}
		if (trim($brg) == '') {
			$error[] = '- Nama Barang harus diisi !!!';
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
				$where .="product_id=$data[$i]";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe = "delete from barang ".$where;
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
				$query_exe = "UPDATE barang SET 
						kode = '$kod', 
						brand_id = $jen, 
						barang = '$brg', 
						frame = '$fra', 
						color = '$col', 
						qty = $qty, 
						price = $price, 
						price2 = $price2, 
						kode_harga = '$kode_harga', 
						info = '$inf', 
						ukuran = '$size', 
						tipe = $tipe, 
						last_update_user_id = $_SESSION[user_id], 
						last_update_date = NOW() 
					WHERE product_id = $product_id";
				$exe = $mysqli->query($query_exe);
				if ($exe) {
                	$stat = 'Edit data berhasil';
				}
				else {
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
			$stat = "not used again ...";
			break;
			default:
				$query_exe = "insert into barang values ('$kod','$jen','$brg','$fra','$col',$qty,$price,$price2,'$kode_harga','$inf','$size','$tipe',$masuk,$keluar)";
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
    location.href = '<?=$base_url?><?php echo $url; ?>';
</script>