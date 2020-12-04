<?php
	session_start();
	include('../../../include/config_db.php');
	$mode = $_GET['mode'];
	
	switch($mode)
	{
		case 'get_data':

			$c = $_GET['c'];
			$branch_id = $_GET['branch_id'] ?? -1;

			$draw = $_GET['draw'];
			$start = $_GET['start'];
			$length = $_GET['length'];

			$search = $_GET['search']['value'] ?? '';
			$search_tgl = $_GET['columns'][0]['search']['value'] ?? '';
			$search_referensi = $_GET['columns'][1]['search']['value'] ?? '';
			$search_customer = $_GET['columns'][2]['search']['value'] ?? '';

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
										OR b.referensi LIKE '%$search%' 
										OR c.kontak LIKE '%$search%' 
									) ";
			}
			if ($search_tgl != '') {
				$search_filter .= " AND a.tgl LIKE '%$search_tgl%' ";
			}
			if ($search_referensi != '') {
				$search_filter .= " AND b.referensi LIKE '%$search_referensi%' ";
			}
			if ($search_customer != '') {
				$search_filter .= " AND c.kontak LIKE '%$search_customer%' ";
			}

			$orderBy = '';
			if ($orderCount <= 0) {
				$orderBy .= ' a.tgl DESC, ';
			}
			else {
				for ($i = 0; $i < $orderCount; $i++) {
					$dir = $order[$i]['dir'];

					switch ($order[$i]['column']) {
						case 0:
							$orderBy .= " a.tgl $dir, ";
						break;

						case 1:
							$orderBy .= " b.referensi $dir, ";
						break;

						case 2:
							$orderBy .= " c.kontak $dir, ";
						break;

						case 3:
							$orderBy .= " a.jumlah $dir, ";
						break;
					}
				}
			}

			$query = "SELECT COUNT(*) AS records_total 
					FROM aruskas a 
					WHERE a.tipe = 'piutang' 
                    AND a.tgl BETWEEN NOW() - INTERVAL 90 DAY AND NOW() 
					$branch_filter";

			$rs = $mysqli->query($query);
			$data = $rs->fetch_assoc();
			$recordsTotal = $data['records_total'];

			$query = "SELECT COUNT(*) AS records_filtered 
					FROM aruskas a 
					JOIN keluarbarang b ON a.transaction_id = b.keluarbarang_id 
					JOIN kontak c ON b.client = c.user_id 
					WHERE a.tipe = 'piutang' 
                    AND a.tgl BETWEEN NOW() - INTERVAL 90 DAY AND NOW() 
					$branch_filter 
					$search_filter ";

			$rs = $mysqli->query($query);
			$data = $rs->fetch_assoc();
			$recordsFiltered = $data['records_filtered'];

			$query = "SELECT a.id AS aruskas_id, a.tgl, a.jumlah, a.info, 
                        b.referensi, c.kontak AS customer_name, d.pembayaran AS carabayar 
					FROM aruskas a
                    JOIN keluarbarang b ON a.transaction_id = b.keluarbarang_id 
					JOIN kontak c ON b.client = c.user_id 
					LEFT JOIN carabayar d ON a.carabayar_id = d.carabayar_id 
					WHERE a.tipe = 'piutang' 
                    AND a.tgl BETWEEN NOW() - INTERVAL 90 DAY AND NOW() 
					$branch_filter 
					$search_filter 
					ORDER BY $orderBy aruskas_id DESC 
					LIMIT $start,$length ";

			$rs = $mysqli->query($query);

			$datas = array();
			while ($data = $rs->fetch_assoc()) {
                $aruskas_id = $data['aruskas_id'];
                $tgl = $data['tgl'];
                $jumlah = number_format($data['jumlah'], 0);
                $info = htmlspecialchars($data['info'], ENT_QUOTES);
				$referensi = $data['referensi'];
                $customer_name = htmlspecialchars($data['customer_name'], ENT_QUOTES);
                $carabayar = $data['carabayar'];

				$link_kwitansi = '<a href="include/draft_kwitansi.php?aruskas_id='.$aruskas_id.'" target="_blank">Kwitansi</a>';

				$temp = array(
					"DT_RowId"			=> $aruskas_id,
                    "tgl"				=> $tgl,
                    "jumlah"			=> '<span class="badge badge-primary mr-1">' . $carabayar . '</span>' . $jumlah,
                    "info"              => $info,
                    "referensi"         => $referensi,
					"customer_name"		=> $customer_name,
                    "link_kwitansi"     => $link_kwitansi,
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
