<?php
	session_start();
	include('../../../include/config_db.php');

	$data = $_POST['data'];

	$data = explode("#", $data);

	$branch_id = $data[0] ?? 0;

	//$referensi = "PCB-" . date("ymd");
	//$rs = $mysqli->query("SELECT referensi FROM keluarbarang WHERE referensi like '".$referensi."%'");
	//$totalreferensi = mysqli_num_rows($rs);

	//if ($totalreferensi < 9) $referensi .= "00" . ($totalreferensi+1);
	//else if ($totalreferensi < 99) $referensi .= "0" . ($totalreferensi+1);
	//else $referensi .= ($totalreferensi+1);

	//echo $mysqli->query("INSERT INTO keluarbarang VALUES('$referensi',NOW(),NULL,$data[0],0,'',0,'Pindah Cabang','1','Cash')");

	for ($i=1;$i<sizeof($data);$i++)
	{
		$temp = explode("-", $data[$i]);
		$product_id = $temp[0];
		$qty = $temp[1];

		$rs = $mysqli->query("SELECT * FROM barang WHERE product_id = $product_id");

		if ($data2 = $rs->fetch_assoc()) {
			if ($data2['qty'] == $qty) {
				$mysqli->query("UPDATE barang SET branch_id = $branch_id WHERE product_id = $product_id");
			}
			else if ($qty < $data2['qty']) {
				$mysqli->query("UPDATE barang SET qty = qty - $qty WHERE product_id = $product_id");
				$mysqli->query("INSERT INTO barang(kode, brand_id, barang, frame, color, qty, price, price2, kode_harga, info, ukuran, tipe, tgl_masuk_akhir, tgl_keluar_akhir, branch_id, created_user_id, created_date) VALUES('$data2[kode]', $data2[brand_id], '$data2[barang]', '$data2[frame]', '$data2[color]', $data2[qty], $data2[price], $data2[price2], '$data2[kode_harga]', '$data2[info]', '$data2[ukuran]', $data2[tipe], '$data2[tgl_masuk_akhir]', '$data2[tgl_keluar_akhir]', $branch_id, $_SESSION[user_id], 'NOW()')");
			}
		}

		//echo $mysqli->query("INSERT INTO dkeluarbarang VALUES(0,$temp[0],1,0,$temp[1],'0',0,'0','$referensi','',0,0,0,0,0,0,0,0,0,0,1,0,'0','0','')");

		
	}
?>