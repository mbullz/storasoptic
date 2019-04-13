<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$url = "index-c-user.pos";
	$p   = $_GET['p'];
	$nik = $_POST['nik'];
	$pas = $_POST['password'];
	$per = $_POST['per'];
	$jper= count($per);
	// gen per
	$genper = "";
	for($p=0;$p<$jper;$p++) {
		$genper .= $per[$p];
		if($i < $jdata-1) {
			$genper .=",";	
		}
	}
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p == 'add' OR $p == 'edit') {
		if (trim($nik) == '') {
			$error[] = '- Kontak harus diisi !!!';
		}
		if (trim($pas) == '') {
			$error[] = '- Password harus diisi !!!';
		}
	}else if($p =='mdelete') {
		if($jdata <= 0) {
			$error[] ="- Proses gagal, Pilih min 1 data yang ingin dihapus !!!";
		}
	}
	// End Validasi
	if (isset($error)) {
		//echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Kesalahan : </b> <br />".implode("<br />", $error);
        $stat = 'Kesalahan : ' . implode('\n', $error);
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
			$query_exe = "update kontak set pass='', akses=''".$where;
			$exe = $mysqli->query($query_exe);
			if($exe) {
					//echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah dihapus ...</b></center>";
                $stat = 'Data telah dihapus ...';
            }else{
                //echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal dihapus, coba lagi !!!</b></center>";
                $stat = 'Data gagal dihapus, coba lagi !!!';
            }
			break;
			case("edit"):
			$query_exe = "update kontak set pass='$pas', akses='$genper' where kode='$nik'";
			$exe = $mysqli->query($query_exe);
			if($exe) {
					//echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
				}else{
					//echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal dihapus, coba lagi !!!</b></center>";
                    $stat = 'Data gagal dihapus, coba lagi !!!';
				}
			break;
			case("delete"):
			/*$query_exe = "delete from agen where kd='$kd'";
			$exe = $mysqli->query($query_exe, $tiket) or die(mysql_error());
			if($exe) {
					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data has been deleted...</b></center>";
				}else{
					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data deleted failed, try again !!!</b></center>";
				}*/
			//echo "not used again ...";
                $stat = 'not used again';
			break;
			default:
				$query_exe = "update kontak set pass='$pas', akses='$genper' where kode='$nik'";
				$exe = $mysqli->query($query_exe);
				//echo $query_exe;
				if($exe) {
					//echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                    $stat = 'Data telah disimpan ...';
				}else{
					//echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
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
    <?php } ?>
</script>