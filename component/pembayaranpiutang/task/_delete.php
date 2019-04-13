<?php
	session_start();
	include('../../../include/config_db.php');

	$data = $_POST['data'];

	$data = explode("#", $data);

	for ($i=0;$i<sizeof($data)-1;$i++)
	{
		$mysqli->query("DELETE FROM keluarbarang WHERE referensi LIKE '$data[$i]'");
		$mysqli->query("DELETE FROM aruskas WHERE referensi LIKE '$data[$i]'");
	}
?>