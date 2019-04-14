<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-jenisbarang.pos";
	$p   = $_GET['p'];
	$id = $_GET['id'];
	$brand_id = $_POST['brand_id'];
    $tipe = $_POST['tipe'];
	$kod = strtoupper(str_replace(" ","_",$_POST['kode']));
	$jen = $mysqli->real_escape_string(strtoupper($_POST['jenis']));
	$inf = $mysqli->real_escape_string(strtoupper($_POST['info']));
	$inf = $inf==NULL?'':$inf;
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if (trim($jen) == '') {
			$error[] = '- Nama Brand harus diisi !!!';
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
			case("edit"):
				$query_exe = "UPDATE jenisbarang SET jenis = '$jen', info = '$inf', tipe = $tipe WHERE brand_id = $brand_id";
				$exe = $mysqli->query($query_exe);
				if($exe) {
                	$stat = 'Edit data berhasil';
				}
				else {
                    $stat = 'Edit data gagal';
				}
			break;
			case("delete"):
				$query_exe = "UPDATE jenisbarang SET info = 'DELETED' WHERE brand_id = $id";
				$exe = $mysqli->query($query_exe);
				if($exe) {
                	$stat = 'Delete data berhasil';
				}
				else {
                    $stat = 'Delete data gagal';
				}
			break;
			case 'add':
				$query_exe = "INSERT INTO jenisbarang(brand_id, kode, jenis, info, tipe) VALUES(0, '$kod', '$jen', '$inf', $tipe)";
				$exe = $mysqli->query($query_exe);
				if($exe) {
                    $stat = 'Tambah data berhasil';
				}
				else {
                    $stat = 'Tambah data gagal';
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