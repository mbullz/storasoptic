<?php
	session_start();

	include('../../include/config_db.php');

	function refreshLunas($keluarbarang_id) {
		global $mysqli;

		// get grand total
		$rs = $mysqli->query("SELECT * FROM keluarbarang WHERE keluarbarang_id = $keluarbarang_id");
		$data = $rs->fetch_assoc();
		$total = $data['total'];

		// get total bayar
		$query_tbayar = "SELECT SUM(jumlah) AS bayar FROM aruskas WHERE transaction_id = $keluarbarang_id AND tipe = 'piutang' ";
		$tbayar       = $mysqli->query($query_tbayar);
		$row_tbayar   = mysqli_fetch_assoc($tbayar);
		
		$sisa = intval($total - $row_tbayar['bayar']);
		
		if ($sisa <= 0) $lunas = 1;
		else $lunas = 0;

		$mysqli->query("UPDATE keluarbarang SET lunas = '$lunas' WHERE keluarbarang_id = $keluarbarang_id");
	}

	//Define variable
    $stat = '';
	$url = "index-c-pembayaranpiutang.pos";
	$p   = $_GET['p'];
	$keluarbarang_id = $_POST['keluarbarang_id'] ?? 0;
	$referensi = $_POST['referensi'] ?? 0;
	$aruskas_id = $_GET['aruskas_id'] ?? 0;
	$id  = $_POST['id'] ?? 0;
	$bay = $_POST['bayar'] ?? 0;
	$tgl = $_POST['tgl'] ?? null;
	$jum = $_POST['jumlah'] ?? 0;
	$inf = $_POST['info'] ?? '';
	$inf = $mysqli->real_escape_string($inf);
	$opr = $_SESSION['user_id'];
	$tipe = 'piutang';

	//------
	$data = $_POST['data'] ?? [];
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
			$where = " WHERE ";
			for($i=0;$i<$jdata;$i++) {
				$where .=" referensi LIKE '$data[$i]' ";
				if($i < $jdata-1) {
					$where .=" OR ";	
				}
			}
			$query_exe1 = "DELETE FROM aruskas " . $where;
			$exe1 = $mysqli->query($query_exe1);
			
			$query_exe2 = "DELETE FROM keluarbarang " . $where;
			$exe2 = $mysqli->query($query_exe2);
			
			if($exe1 && $exe2)
			{
				$stat = 'Data telah dihapus ...';
			}
			else
			{
				$stat = 'Data gagal dihapus, coba lagi !!!';
			}
			break;
			case("edit"):
				$query = "UPDATE aruskas SET 
						carabayar_id = '$bay', 
						tgl = '$tgl', 
						opr = $opr, 
						jumlah = $jum, 
						info = '$inf' 
					WHERE id = $id";
				$mysqli->query($query);

				refreshLunas($keluarbarang_id);
			break;
			case("delete"):
				// get keluarbarang
				$rs = $mysqli->query("SELECT * FROM aruskas WHERE id = $aruskas_id");
				$data = $rs->fetch_assoc();
				$keluarbarang_id = $data['transaction_id'];

				$mysqli->query("DELETE FROM aruskas WHERE id = $aruskas_id");

				refreshLunas($keluarbarang_id);

				header("location:/$base_url/index-c-piutangjtempo.pos");
			break;
			default:
				$query_exe = "INSERT INTO aruskas VALUES (0, $bay, $keluarbarang_id, '$tipe', '$tgl', $opr, '$referensi', $jum, 1, '$inf')";
				$exe = $mysqli->query($query_exe);

				refreshLunas($keluarbarang_id);
			break;
		}
	}
?>
