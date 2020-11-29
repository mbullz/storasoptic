<?php
	session_start();
	include('../../../include/config_db.php');
	$mode = $_GET['mode'];
	
	switch($mode)
	{
		case 'get_info':
			$masukbarang_id = $_GET['masukbarang_id'];

			$masukbarang = array();
			$rs = $mysqli->query("SELECT * FROM masukbarang WHERE masukbarang_id = $masukbarang_id");
			if ($data = $rs->fetch_assoc())
			{
				$branch_id = $data['branch_id'];

				$masukbarang = array(
					'masukbarang_id'	=> $data['masukbarang_id'],
				);
			}

			$dmasukbarang = array();
			$grandtotal = 0;
			$rs = $mysqli->query("SELECT a.id AS dmasukbarang_id, a.product_id, a.harga AS cost, a.qty, a.subtotal, 
										b.kode, b.barang, b.frame, b.color, b.power_add, b.price2 AS price, b.kode_harga, b.info, b.ukuran, b.tipe, 
										c.jenis AS brand_name 
									FROM dmasukbarang a 
									JOIN barang b ON a.product_id = b.product_id 
									JOIN jenisbarang c ON b.brand_id = c.brand_id 
									WHERE masukbarang_id = $masukbarang_id 
									ORDER BY id ASC 
								");
			while ($data = $rs->fetch_assoc()) {
				$temp = array();

				$masukbarang['tipe'] = $data['tipe'];

				$grandtotal += $data['subtotal'];

				$temp['dmasukbarang_id'] = $data['dmasukbarang_id'];
				$temp['product_id'] = $data['product_id'];
				$temp['cost'] = $data['cost'];
				$temp['qty'] = $data['qty'];
				$temp['subtotal'] = $data['subtotal'];

				$temp['kode'] = $data['kode'];
				$temp['brand_name'] = $data['brand_name'];
				$temp['barang'] = $data['barang'];
				$temp['frame'] = $data['frame'];
				$temp['color'] = $data['color'];
				$temp['power_add'] = $data['power_add'];
				$temp['price'] = $data['price'];
				$temp['kode_harga'] = $data['kode_harga'];
				$temp['info'] = $data['info'];
				$temp['ukuran'] = $data['ukuran'];
				$temp['tipe'] = $data['tipe'];

				array_push($dmasukbarang, $temp);
			}

			$masukbarang['grandtotal'] = $grandtotal;

			$arr = array(
				'masukbarang'	=> $masukbarang,
				'dmasukbarang'	=> $dmasukbarang,
			);

			echo json_encode($arr);
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
			$search_supplier = $_GET['columns'][4]['search']['value'] ?? '';
			$search_tipe = $_GET['columns'][6]['search']['value'] ?? '';

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
			if ($search_supplier != '') {
				$search_filter .= " AND b.kontak LIKE '%$search_supplier%' ";
			}
			if ($search_tipe != '') {
				if (stripos('Frame', $search_tipe) !== false) {
					$search_filter .= " AND d.tipe = 1 ";
				}
				else if (stripos('Lensa', $search_tipe) !== false) {
					$search_filter .= " AND d.tipe = 3 ";
				}
				else if (stripos('Softlens', $search_tipe) !== false) {
					$search_filter .= " AND d.tipe = 2 ";
				}
				else if (stripos('Accessories', $search_tipe) !== false) {
					$search_filter .= " AND d.tipe = 4 ";
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
							$orderBy .= " total $dir, ";
						break;

						case 6:
							$orderBy .= " d.tipe $dir, ";
						break;
					}
				}
			}

			$query = "SELECT COUNT(DISTINCT a.masukbarang_id) AS records_total 
					FROM masukbarang a 
					JOIN kontak b ON a.supplier = b.user_id 
					JOIN dmasukbarang c ON a.masukbarang_id = c.masukbarang_id 
					JOIN barang d ON c.product_id = d.product_id 
					WHERE 1 = 1 
					$branch_filter";

			$rs = $mysqli->query($query);
			$data = $rs->fetch_assoc();
			$recordsTotal = $data['records_total'];

			$query = "SELECT COUNT(DISTINCT a.masukbarang_id) AS records_filtered 
					FROM masukbarang a 
					JOIN kontak b ON a.supplier = b.user_id 
					JOIN dmasukbarang c ON a.masukbarang_id = c.masukbarang_id 
					JOIN barang d ON c.product_id = d.product_id 
					WHERE 1 = 1 
					$branch_filter 
					$search_filter ";

			$rs = $mysqli->query($query);
			$data = $rs->fetch_assoc();
			$recordsFiltered = $data['records_filtered'];

			$query = "SELECT a.masukbarang_id, a.referensi, a.tgl, a.info, a.lunas, 
						b.kontak AS supplier_name, 
						SUM(c.subtotal) AS total, MIN(d.tipe) AS tipe, 
						e.matauang 
					FROM masukbarang a 
					JOIN kontak b ON a.supplier = b.user_id 
					JOIN dmasukbarang c ON a.masukbarang_id = c.masukbarang_id 
					JOIN barang d ON c.product_id = d.product_id 
					JOIN matauang e ON a.matauang_id = e.matauang_id 
					WHERE 1 = 1 
					$branch_filter 
					$search_filter
					GROUP BY a.masukbarang_id, a.referensi, a.tgl, a.info, a.lunas, b.kontak, e.matauang 
					ORDER BY $orderBy a.masukbarang_id DESC 
					LIMIT $start,$length ";

			$rs = $mysqli->query($query);

			$datas = array();
			while ($data = $rs->fetch_assoc()) {
				$masukbarang_id = $data['masukbarang_id'];
				$referensi = $data['referensi'];
				$tgl = $data['tgl'];
				$supplier_name = htmlspecialchars($data['supplier_name'], ENT_QUOTES);
				$total = number_format($data['total'], 0, ',', '.');
				$tipe = $data['tipe'];

				switch ($tipe) {
					case 1:
						$tipe_name = 'Frame';
					break;

					case 2:
						$tipe_name = 'Softlens';
					break;

					case 3:
						$tipe_name = 'Lensa';
					break;

					case 4:
						$tipe_name = 'Accessories';
					break;

					default:
						$tipe_name = 'Frame';
					break;
				}

				$checkbox = '<input name="data[]" type="checkbox" value="'.$masukbarang_id.'" />';

				$link_referensi = '';
				$link_referensi = '<a href="include/draft_po.php?referensi='.$referensi.'" target="_blank">'.$referensi.'</a>';

				$edit = '';
				if (strstr($_SESSION['akses'], "edit_".$c)) {
					$edit = '<a href="index.php?component='.$c.'&task=edit&id='.$masukbarang_id.'" title="Edit Data"><img src="images/edit_icon.png" width="16px" height="16px" /></a>';
				}

				$temp = array(
					"DT_RowId"			=> $masukbarang_id,
					"checkbox"			=> $checkbox,
					"tgl"				=> $tgl,
					"link_referensi"	=> $link_referensi,
					"supplier_name"		=> $supplier_name,
					"total"				=> $total,
					"tipe_name"			=> $tipe_name,
					"edit"				=> $edit,
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