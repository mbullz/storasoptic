<?php
	include('../../../include/config_db.php');
	$mode = $_GET['mode'];
	
	switch($mode)
	{
		case "get_brand":
			$tipe = $_GET['tipe'];
			
			$arr = array();
			$rs = $mysqli->query("SELECT * FROM jenisbarang WHERE tipe = $tipe ORDER BY jenis ASC");
			while ($data = mysqli_fetch_assoc($rs))
			{
				array_push($arr, array(
					'brand_id' => $data['brand_id'],
					'jenis' => $data['jenis']
				));
			}
			
			echo json_encode($arr);
		break;
		
		case "get_barang":
        	$tipe = $_GET['tipe'] ?? 0;
        	$search = $_GET['search'] ?? '';
			
			$arr = array();
			$rs = $mysqli->query("
				SELECT a.*, b.jenis AS type_brand, b.info AS supplier 
				FROM barang a 
				JOIN jenisbarang b ON a.brand_id = b.brand_id 
				WHERE qty > 0 
				AND a.tipe = $tipe 
				AND 
				(
					b.jenis LIKE '%$search%' OR 
					a.kode LIKE '%$search%' OR 
					a.barang LIKE '%$search%' 
				)
				ORDER BY b.jenis ASC, a.barang ASC ");
			
			while ($data = mysqli_fetch_assoc($rs))
			{
				array_push($arr, array(
					'product_id' => $data['product_id'],
					'kode' => $data['kode'], 
					'barang' => $data['barang'],
					'frame' => $data['frame'],
					'color' => $data['color'],
					'info' => $data['info'],
					'ukuran' => $data['ukuran'],
					'type_brand' => $data['type_brand'],
					'supplier' => $data['supplier']
				));
			}
			
			echo json_encode($arr);
        break;
	}
?>