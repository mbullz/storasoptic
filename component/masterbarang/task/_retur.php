<?php
	session_start();
	include('../../../include/config_db.php');

	$product_id = $_POST['product_id'];
	$qty = $_POST['qty'];
	$info = $_POST['info'];

	$mysqli->query("INSERT INTO terimabarang_r VALUES(0,NOW(),'',$product_id,1,$qty,'GDG_A','$info','false','')");
	$mysqli->query("UPDATE barang SET qty = qty - $qty WHERE product_id = $product_id");
?>