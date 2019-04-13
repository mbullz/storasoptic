<?php
	include('../include/config_db.php');
	
	$category = $_POST['category'];
	$item = $mysqli->real_escape_string(strtoupper($_POST['item']));
	$tipe = $_POST['tipe'];
	
	switch ($category)
	{
		case "frame":
			$rs = $mysqli->query("SELECT * FROM frame_type WHERE frame LIKE '$item'");
			if (mysqli_fetch_assoc($rs)) {}
			else
				$mysqli->query("INSERT INTO frame_type VALUES(0,'$item')");
				
			echo $item;
		break;
		
		case "brand":
			$brand_id = "";
			$rs = $mysqli->query("SELECT * FROM jenisbarang WHERE jenis LIKE '$item' AND tipe = $tipe");
			if ($data = mysqli_fetch_assoc($rs))
			{
				$brand_id = $data['brand_id'];
			}
			else
			{
				$mysqli->query("INSERT INTO jenisbarang VALUES(0,'','$item','',$tipe)");
				$rs2 = $mysqli->query("SELECT LAST_INSERT_ID()");
				$data2 = mysqli_fetch_assoc($rs2);
				$brand_id = $data2[0];
			}
			echo $brand_id;
		break;
		
		case "color":
			$rs = $mysqli->query("SELECT * FROM color_type WHERE color LIKE '$item'");
			if (mysqli_fetch_assoc($rs)) {}
			else
				$mysqli->query("INSERT INTO color_type VALUES(0,'$item')");
			
			echo $item;
		break;
	}
?>