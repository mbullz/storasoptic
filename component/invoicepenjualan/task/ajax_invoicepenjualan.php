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

		case "get_softlens":
			$search = $_GET['search'] ?? '';
			
			$arr = array();
			$rs = $mysqli->query("
				SELECT DISTINCT a.kode, a.barang, a.color, b.jenis AS type_brand 
				FROM barang a 
				JOIN jenisbarang b ON a.brand_id = b.brand_id 
				WHERE a.tipe = 2 
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
					'product_id'	=> 0,
					'kode' 			=> $data['kode'], 
					'barang' 		=> $data['barang'],
					'color' 		=> $data['color'],
					'type_brand' 	=> $data['type_brand'],
				));
			}
			
			echo json_encode($arr);
		break;

		case 'get_info':
			$keluarbarang_id = $_GET['keluarbarang_id'];

			$keluarbarang = array();
			$rs = $mysqli->query("SELECT * FROM keluarbarang WHERE keluarbarang_id = $keluarbarang_id");
			if ($data = $rs->fetch_assoc())
			{
				$branch_id = $data['branch_id'];

				$keluarbarang = array(
					'keluarbarang_id'	=> $data['keluarbarang_id'],
					'ppn'				=> $data['ppn'],
					'total'				=> $data['total'],
					'lunas'				=> $data['lunas'],
				);
			}

			$dkeluarbarang = array();
			$rs = $mysqli->query("SELECT * 
									FROM dkeluarbarang 
									WHERE keluarbarang_id = $keluarbarang_id 
									ORDER BY id ASC 
								");
			while ($data = $rs->fetch_assoc()) {
				$temp = array();

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

					$kode = '';
					$brand_id = 0;
					$brand_name = '';
					$barang = '';
					$lensa_id_left = 0;
					$lensa_id_right = 0;

					if ($data['special_order'] == '0') {
						$rs2 = $mysqli->query("SELECT a.*, b.jenis AS brand_name FROM barang a JOIN jenisbarang b ON a.brand_id = b.brand_id WHERE product_id = $lensa_id");
						$data2 = $rs2->fetch_assoc();

						$kode = $data2['kode'];
						$brand_id = $data2['brand_id'];
						$brand_name = $data2['brand_name'];
						$barang = $data2['barang'];

						$rs2 = $mysqli->query("SELECT * FROM barang WHERE kode = '$kode' AND brand_id = $brand_id AND barang = '$barang' AND frame = '$lSph' AND color = '$lCyl' AND tipe = 3 AND branch_id = $branch_id");
						$data2 = $rs2->fetch_assoc();

						$lensa_id_left = $data2['product_id'] ?? 0;

						$rs2 = $mysqli->query("SELECT * FROM barang WHERE kode = '$kode' AND brand_id = $brand_id AND barang = '$barang' AND frame = '$rSph' AND color = '$rCyl' AND tipe = 3 AND branch_id = $branch_id");
						$data2 = $rs2->fetch_assoc();

						$lensa_id_right = $data2['product_id'] ?? 0;
					}
					else if ($data['special_order'] == '1') {
						$brand_name = 'LENSA SO';
					}
					

					$temp['lensa_kode'] = $kode;
					$temp['lensa_brand_name'] = $brand_name;
					$temp['lensa_barang'] = $barang;

					$temp['lensa_id_left'] = $lensa_id_left;
					$temp['lSph'] = $lSph/100;
					$temp['lCyl'] = $lCyl/100;
					$temp['lAxis'] = $lAxis/100;
					$temp['lAdd'] = $lAdd/100;
					$temp['lPd'] = $lPd;

					$temp['lensa_id_right'] = $lensa_id_right;
					$temp['rSph'] = $rSph/100;
					$temp['rCyl'] = $rCyl/100;
					$temp['rAxis'] = $rAxis/100;
					$temp['rAdd'] = $rAdd/100;
					$temp['rPd'] = $rPd;

					$temp['harga_lensa'] = $data['harga_lensa'];
				}

				if ($tipe != 3) {
					$product_id = $data['product_id'];

					$rs2 = $mysqli->query("SELECT a.*, b.jenis AS brand_name FROM barang a JOIN jenisbarang b ON a.brand_id = b.brand_id WHERE product_id = $product_id");
					$data2 = $rs2->fetch_assoc();

					$temp['kode'] = $data2['kode'];
					$temp['brand_name'] = $data2['brand_name'];
					$temp['barang'] = $data2['barang'];
					$temp['frame'] = $data2['frame'];
					$temp['color'] = $data2['color'];

					$temp['product_id'] = $product_id;
					$temp['harga'] = $data['harga'];
					$temp['qty'] = $data['qty'];
				}

				$temp['tipe'] = $tipe;
				$temp['dkeluarbarang_id'] = $data['id'];
				$temp['tdiskon'] = $data['tdiskon'];
				$temp['diskon'] = $data['diskon'];
				$temp['diskon_lensa'] = $data['diskon_lensa'];
				$temp['subtotal'] = $data['subtotal'];
				$temp['info'] = $data['info'];
				$temp['info_special_order'] = $data['info_special_order'];
				$temp['special_order'] = $data['special_order'];

				array_push($dkeluarbarang, $temp);
			}

			$payments = array();
			$rs = $mysqli->query("SELECT 
					a.*, b.pembayaran 
				FROM aruskas a 
				JOIN carabayar b ON a.carabayar_id = b.carabayar_id 
				WHERE transaction_id = $keluarbarang_id 
				AND tipe = 'piutang' 
				ORDER BY tgl ASC, id ASC 
			");
			while ($data = $rs->fetch_assoc()) {
				$row = array(
					'aruskas_id'	=> $data['id'],
					'pembayaran'	=> $data['pembayaran'],
					'tgl'			=> $data['tgl'],
					'jumlah'		=> $data['jumlah'],
					'info'			=> $data['info'],
				);

				array_push($payments, $row);
			}

			$arr = array(
				'keluarbarang'	=> $keluarbarang,
				'dkeluarbarang'	=> $dkeluarbarang,
				'payments'		=> $payments,
			);

			echo json_encode($arr);
		break;

		case 'get_customer_last_lens_size':
			$customer_id = $_GET['customer_id'] ?? 0;

			$rs = $mysqli->query("SELECT a.rSph, a.rCyl, a.rAxis, a.rAdd, a.rPd, 
										a.lSph, a.lCyl, a.lAxis, a.lAdd, a.lPd 
									FROM dkeluarbarang a 
									JOIN keluarbarang b ON a.keluarbarang_id = b.keluarbarang_id 
									WHERE b.client = $customer_id 
									AND (a.tipe = 3 OR a.tipe = 5)
									ORDER BY b.tgl DESC, b.keluarbarang_id DESC, a.id DESC 
									LIMIT 0,1 ");

			$data = $rs->fetch_assoc();

			echo json_encode($data);
		break;

		case 'get_data':

			$c = $_GET['c'];
			$branch_id = $_GET['branch_id'] ?? -1;

			$draw = $_GET['draw'];
			$start = $_GET['start'];
			$length = $_GET['length'];

			$search = $_GET['search']['value'] ?? '';
			$search_tgl = $_GET['columns'][2]['search']['value'] ?? '';
			$search_referensi = $_GET['columns'][3]['search']['value'] ?? '';
			$search_customer = $_GET['columns'][4]['search']['value'] ?? '';
			$search_lunas = $_GET['columns'][6]['search']['value'] ?? '';

			$order = $_GET['order'] ?? [];
			$orderCount = sizeof($order);

			$branch_filter = '';
			if ($branch_id != 0) {
				$branch_filter = " AND a.branch_id = $branch_id ";
			}

			$search_filter = '';
			if ($search != '') {
				$search_filter .= " AND 
									(
										a.tgl LIKE '%$search%' 
										OR a.referensi LIKE '%$search%' 
										OR b.kontak LIKE '%$search%' 
									) ";
			}
			if ($search_tgl != '') {
				$search_filter .= " AND a.tgl LIKE '%$search_tgl%' ";
			}
			if ($search_referensi != '') {
				$search_filter .= " AND a.referensi LIKE '%$search_referensi%' ";
			}
			if ($search_customer != '') {
				$search_filter .= " AND b.kontak LIKE '%$search_customer%' ";
			}
			if ($search_lunas != '') {
				if (stripos('Lunas', $search_lunas) !== false) {
					$search_filter .= " AND a.lunas = '1' ";
				}
				else if (stripos('Piutang', $search_lunas) !== false) {
					$search_filter .= " AND a.lunas = '0' ";
				}
			}

			$orderBy = '';
			if ($orderCount <= 0) {
				$orderBy .= ' a.tgl DESC, ';
			}
			else {
				for ($i = 0; $i < $orderCount; $i++) {
					$dir = $order[$i]['dir'];

					switch ($order[$i]['column']) {
						case 2:
							$orderBy .= " a.tgl $dir, ";
						break;

						case 3:
							$orderBy .= " a.referensi $dir, ";
						break;

						case 4:
							$orderBy .= " b.kontak $dir, ";
						break;

						case 5:
							$orderBy .= " a.total $dir, ";
						break;

						case 6:
							$orderBy .= " a.lunas $dir, ";
						break;
					}
				}
			}

			$query = "SELECT COUNT(*) AS records_total 
					FROM keluarbarang a 
					WHERE referensi != '' 
					$branch_filter";

			$rs = $mysqli->query($query);
			$data = $rs->fetch_assoc();
			$recordsTotal = $data['records_total'];

			$query = "SELECT COUNT(*) AS records_filtered 
					FROM keluarbarang a 
					JOIN kontak b ON a.client = b.user_id 
					WHERE 1 = 1 
					$branch_filter 
					$search_filter ";

			$rs = $mysqli->query($query);
			$data = $rs->fetch_assoc();
			$recordsFiltered = $data['records_filtered'];

			$query = "SELECT a.keluarbarang_id, a.referensi, a.tgl, a.total, a.info, 
						b.kontak AS customer_name, b.user_id as customer_id, 
						a.tipe_pembayaran , a.lunas, a.updated_by, 
						f.status AS status_order 
					FROM keluarbarang a 
					JOIN kontak b ON b.user_id = a.client 
					LEFT JOIN keluarbarang_order f ON a.keluarbarang_id = f.keluarbarang_id 
					WHERE 1 = 1 
					$branch_filter 
					$search_filter 
					ORDER BY $orderBy a.keluarbarang_id DESC 
					LIMIT $start,$length ";

			$rs = $mysqli->query($query);

			$datas = array();
			while ($data = $rs->fetch_assoc()) {
				$keluarbarang_id = $data['keluarbarang_id'];
				$referensi = $data['referensi'];
				$tgl = $data['tgl'];
				$customer_name = htmlspecialchars($data['customer_name'], ENT_QUOTES);
				$total = number_format($data['total'], 0, ',', '.');
				$lunas = $data['lunas'];
				$status_order = $data['status_order'] ?? 0;

				$checkbox = '<input name="data[]" type="checkbox" value="'.$keluarbarang_id.'" />';

				$link_referensi = '<a href="include/draft_invoice_1.php?keluarbarang_id='.$keluarbarang_id.'" target="_blank">'.$referensi.'</a>';

				$edit = '';
				if (strstr($_SESSION['akses'], "edit_".$c)) {
					$edit = '<a href="index.php?component='.$c.'&task=edit&id='.$keluarbarang_id.'" title="Edit Data"><img src="images/edit_icon.png" width="16px" height="16px" /></a>';
				}

				if ($lunas == '1') $lunas = 'Lunas';
				else $lunas = 'Piutang';

				$temp = array(
					"blank"				=> '',
					"DT_RowId"			=> $keluarbarang_id,
					"checkbox"			=> $checkbox,
					"tgl"				=> $tgl,
					"link_referensi"	=> $link_referensi,
					"customer_name"		=> $customer_name,
					"total"				=> $total,
					"lunas"				=> $lunas,
					"status_order"		=> $status_order,
				);

				array_push($datas, $temp);
			}

			$arr = array(
				"draw"				=> $draw,
				"recordsTotal"		=> $recordsTotal,
				"recordsFiltered"	=> $recordsFiltered,
				"data"				=> $datas,
			);

			echo json_encode($arr);

		break;
	}
?>