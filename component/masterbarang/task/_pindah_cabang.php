<?php
	session_start();
	include('../../../include/config_db.php');

	$data = $_POST['data'];

	$data = explode("#", $data);

	$referensi = "PCB-" . date("ymd");
	$rs = $mysqli->query("SELECT referensi FROM keluarbarang WHERE referensi like '".$referensi."%'");
	$totalreferensi = mysqli_num_rows($rs);

	if ($totalreferensi < 9) $referensi .= "00" . ($totalreferensi+1);
	else if ($totalreferensi < 99) $referensi .= "0" . ($totalreferensi+1);
	else $referensi .= ($totalreferensi+1);

	echo $mysqli->query("INSERT INTO keluarbarang VALUES('$referensi',NOW(),NULL,$data[0],0,'',0,'Pindah Cabang','1','Cash')");

	for ($i=1;$i<sizeof($data);$i++)
	{
		$temp = explode("-", $data[$i]);

		echo $mysqli->query("INSERT INTO dkeluarbarang VALUES(0,$temp[0],1,0,$temp[1],'0',0,'0','$referensi','',0,0,0,0,0,0,0,0,0,0,1,0,'0','0','')");

		echo $mysqli->query("UPDATE barang SET qty = qty - $temp[1] WHERE product_id = $temp[0]");
	}
?>