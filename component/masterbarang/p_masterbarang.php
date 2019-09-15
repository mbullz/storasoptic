<?php
	session_start();
	include('../../include/config_db.php');
	require '../../models/Barang.php';
	require '../../models/DBHelper.php';

	$db = new DBHelper($mysqli);

	$b = new Barang();
	$b->setProductId($_POST['product_id']);
	$b = $db->getBarang($b);

	//Define variable
    $stat = '';
	$url = "index-c-masterbarang.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
	
	$b->setKode(strtoupper($_POST['kode']));
	$b->setBrandId($_POST['jenis']);
	$b->setBarang($mysqli->real_escape_string($_POST['barang']));
	$b->setFrame($mysqli->real_escape_string($_POST['frame']));
	$b->setColor($mysqli->real_escape_string($_POST['color']));
	$b->setPowerAdd($mysqli->real_escape_string($_POST['power_add']));
	$b->setQty(intval($_POST['qty']));
	$b->setPrice(intval($_POST['price']));
	$b->setPrice2(intval($_POST['price2']));
	$b->setKodeHarga($mysqli->real_escape_string($_POST['kode_harga']));
	$b->setInfo($mysqli->real_escape_string($_POST['info']));
	$b->setUkuran($mysqli->real_escape_string($_POST['size']));
    $b->setTipe($_POST['tipe']);
    $b->setLastUpdateUserId($_SESSION['user_id']);

	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if ($b->getBrandId() == '') {
			$error[] = '- Brand harus di pilih';
		}
		if ($b->getBarang() == '') {
			$error[] = '- Nama Product harus diisi';
		}
	}
	else if($p == 'mdelete') {
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
	                $stat = 'Data telah dihapus ...';
				}
				else {
	                $stat = 'Data gagal dihapus, coba lagi !!!';
				}
			break;
			case("edit"):
				$result = $db->updateBarang($b);
				if ($result->status == 'success') {
                	$stat = 'Edit data berhasil';
				}
				else {
                    $stat = 'Edit data gagal';
				}
			break;
		}
	}
?>

<script type="text/javascript">
    alert('<?php echo $stat; ?>');
    location.href = '<?=$base_url?><?php echo $url; ?>';
</script>