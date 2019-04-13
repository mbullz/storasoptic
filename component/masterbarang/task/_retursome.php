<?php
	session_start();
	include('../../../include/config_db.php');
	
	$data = $_POST['data'];
	
	$data = explode("#", $data);

	for ($i=1;$i<sizeof($data);$i++)
	{
		$temp = explode("-", $data[$i]);

		$mysqli->query("INSERT INTO terimabarang_r VALUES(0,NOW(),'',$temp[0],1,$temp[1],'GDG_A','$data[0]','false','')");

		$mysqli->query("UPDATE barang SET qty = qty - $temp[1] WHERE product_id = $temp[0]");
	}
?>