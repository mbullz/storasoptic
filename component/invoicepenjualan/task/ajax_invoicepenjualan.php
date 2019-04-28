<?php
	session_start();
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
				AND a.branch_id = $_SESSION[branch_id] 
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

        case "get_lensa":
        	$search = $_GET['search'] ?? '';
			
			$arr = array();
			$rs = $mysqli->query("
				SELECT DISTINCT b.jenis, a.kode, a.barang 
				FROM barang a 
				JOIN jenisbarang b ON a.brand_id = b.brand_id 
				WHERE a.tipe = 3 
				AND 
				(
					b.jenis LIKE '%$search%' OR 
					a.kode LIKE '%$search%' OR 
					a.barang LIKE '%$search%' 
				) 
				AND a.branch_id = $_SESSION[branch_id] 
				ORDER BY b.jenis ASC, a.barang ASC ");
			
			while ($data = mysqli_fetch_assoc($rs))
			{
				array_push($arr, array(
					'kode'		=> $data['kode'], 
					'barang'	=> $data['barang'],
					'jenis'		=> $data['jenis'],
				));
			}
			
			echo json_encode($arr);
        break;

        case 'get_info':
	        $keluarbarang_id = $_GET['keluarbarang_id'];
	        $arr = array();

	        $keluarbarang = array();
	        $rs = $mysqli->query("SELECT * FROM keluarbarang WHERE keluarbarang_id = $keluarbarang_id");
	        if ($data = $rs->fetch_assoc())
	        {
	        	$branch_id = $data['branch_id'];

	            $keluarbarang = array(
            		'keluarbarang_id'	=> $data['keluarbarang_id'],
            		'status'			=> $data['status'],
            		'currency_id'		=> $data['currency_id'],
            		'currency'			=> $data['currency'],
                );
	        }

	        $dkeluarbarang = array();
	        $rs = $mysqli->query("SELECT * 
	        						FROM dkeluarbarang 
	        						WHERE keluarbarang_id = $keluarbarang_id 
	        						ORDER BY id ASC 
	        					");
	        while ($data = $rs->fetch_assoc()) {
	        	$tipe = $data['tipe'];

	        	if ($tipe == 3 || $tipe == 5) {
	        		$lensa_id = $data['lensa'];
					$lSph = $data['lSph'];
					$lCyl = $data['lCyl'];
					$lAxis = $data['lAxis'];
					$lAdd = $data['lAdd'];
					$lPd = $data['lPd'];
					$rSph = $data['rSph'];
					$rCyl = $data['rCyl'];
					$rAxis = $data['rAxis'];
					$rAdd = $data['rAdd'];
					$rPd = $data['rPd'];

					$rs2 = $mysqli->query("SELECT * FROM barang WHERE product_id = $lensa_id");
					$data2 = $rs2->fetch_assoc();

					$kode = $data2['kode'];
					$brand_id = $data2['brand_id'];
					$barang = $data2['barang'];
					$branch_id = $data2['branch_id'];

					$rs = $mysqli->query("SELECT * FROM barang WHERE kode = '$kode' AND brand_id = $brand_id AND barang = '$barang' AND frame = '$lSph' AND color = '$lCyl' AND tipe = 3 AND branch_id = $branch_id");
					$data = $rs->fetch_assoc();

					$lensa_id_left = $data['product_id'] ?? 0;

					$rs = $mysqli->query("SELECT * FROM barang WHERE kode = '$kode' AND brand_id = $brand_id AND barang = '$barang' AND frame = '$rSph' AND color = '$rCyl' AND tipe = 3 AND branch_id = $branch_id");
					$data = $rs->fetch_assoc();

					$lensa_id_right = $data['product_id'] ?? 0;
	        	}

	        	$temp = array(
	        				'id'				=> $data['id'],
	        				'spp'				=> $data['spp'],
	        				'harga'				=> $data['harga'],
	        				'qty'				=> $data['qty'],
	        				'width_qty'			=> $data['width_qty'],
	        				'tdiskon'			=> $data['tdiskon'],
	        				'diskon'			=> $data['diskon'],
	        				'subtotal'			=> $data['subtotal'],
	        				'preview'			=> $data['preview'],
	        				'info'				=> $data['info'],
	        				'is_given'			=> $data['is_given'],
	        				'is_made'			=> $data['is_made'],
	        				'is_arrived'		=> $data['is_arrived'],
	        				'is_received'		=> $data['is_received'],
	        				'note'				=> $data['note'],
	        				'spec3'				=> $data['spec3'],
	        				'formula_value'		=> $data['formula_value'],
	        				'width_value'		=> $data['width_value'],
	        				'satuan'			=> $data['satuan'],
	        				'formula_satuan'	=> $data['formula_satuan'],
	        				'width_satuan'		=> $data['width_satuan']
	        			);

	        	array_push($dkeluarbarang, $temp);
	        }

	        array_push($arr, array(
	                'keluarbarang'	=> $keluarbarang,
	                'dkeluarbarang'	=> $dkeluarbarang,
	                'empty'			=> array()
	            ));

	        echo json_encode($arr);
        break;
	}
?>