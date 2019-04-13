<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-jenisbarang.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'];
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
		if($p=='add') {
			// cek username
			/*
			$query_cek = "select kode from jenisbarang where kode='$kod'";
			$cek       = $mysqli->query($query_cek);
			$row_cek   = mysqli_fetch_assoc($cek);
			$total_cek = mysqli_num_rows($cek);
			if($total_cek > 0)
			{
				$error[] = '- Kode Brand <b>'.$row_cek[kode].'</b> sudah digunakan !!!';	
			}
			*/
		}
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
			case("mdelete"):
			$where = " WHERE ";
			for($i=0;$i<$jdata;$i++) {
				$where .=" brand_id = $data[$i] ";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe = "UPDATE jenisbarang SET info = 'DELETED' ".$where;
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
			$query_exe = "update jenisbarang set kode='$kod', jenis='$jen', info='$inf', tipe=$tipe where brand_id=$brand_id";
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
				$query_exe = "insert into jenisbarang values (0,'$kod','$jen','$inf',$tipe)";
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
    location.href = '/<?=$base_url?>/<?php echo $url; ?>';
    <?php } else { ?>
    history.go(-1);
    <?php } ?>
</script>