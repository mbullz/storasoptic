<?php
	session_start();
	include('../../../include/config_db.php');
	
	$data = $_POST['data'];
	$method = $_POST['method'];
	
	switch ($method)
	{
		case "get_supplier":
			$rs = $mysqli->query("SELECT info FROM jenisbarang WHERE jenis LIKE '$data'");
			if ($data = mysqli_fetch_assoc($rs))
				echo $data['info'];
		break;
	}
?>