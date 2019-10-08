<?php
	session_start();
	include('../../../include/config_db.php');

	require '../../../models/Barang.php';
	require '../../../models/DBHelper.php';

	$db = new DBHelper($mysqli);
	
	$totalsuccess = 0;
	$masukbarang_id = array();
	for ($i=0;$i<sizeof($_POST['data']);$i++)
	{
		if (trim($_POST['data'][$i][1]) != "")
		{
			$tipe = $_POST['tipe'];

			$ukuran = '';
			$power_add = '';
			
			switch ($tipe)
			{
				case '1':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper(trim($_POST['data'][$i][2]));
					$frame = strtoupper(trim($_POST['data'][$i][3]));
					$color = strtoupper(trim($_POST['data'][$i][4]));
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][5];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][6];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][7];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][8]));
					$diskon = 0;
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][9]));
					$tgl_masuk_akhir = $_POST['data'][$i][10]==""?date("Y-m-d"):$_POST['data'][$i][10];
					
					$rs = $mysqli->query("SELECT * FROM frame_type WHERE frame LIKE '$frame'");
					if (!mysqli_fetch_assoc($rs))
					{
						$mysqli->query("INSERT INTO frame_type VALUES(0,'$frame')");
					}
					
					$rs = $mysqli->query("SELECT * FROM color_type WHERE color LIKE '$color'");
					if (!mysqli_fetch_assoc($rs))
					{
						$mysqli->query("INSERT INTO color_type VALUES(0,'$color')");
					}
				break;
				
				case '2':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper(trim($_POST['data'][$i][2]));
					$ukuran = strtoupper($_POST['data'][$i][3]); //expiry date
					$frame = strtoupper($_POST['data'][$i][4]); //minus
					$color = strtoupper(trim($_POST['data'][$i][5]));
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][6];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][7];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][8];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][9]));
					$diskon = 0;
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][10]));
					$tgl_masuk_akhir = $_POST['data'][$i][11]==""?date("Y-m-d"):$_POST['data'][$i][11];
					
					$rs = $mysqli->query("SELECT * FROM color_type WHERE color LIKE '$color'");
					if (!mysqli_fetch_assoc($rs))
					{
						$mysqli->query("INSERT INTO color_type VALUES(0,'$color')");
					}
				break;
				
				case '3':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper(trim($_POST['data'][$i][2]));
					$frame = $_POST['data'][$i][3]; //SPH
					$color = $_POST['data'][$i][4]; //CYL
					$power_add = $_POST['data'][$i][5]; //ADD
					$qty = $_POST['data'][$i][6] == "" ? 0 : $_POST['data'][$i][6];
					$price = $_POST['data'][$i][7] == "" ? 0 : $_POST['data'][$i][7];
					$price2 = $_POST['data'][$i][8] == "" ? 0 : $_POST['data'][$i][8];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][9]));
					$diskon = 0;
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][10]));
					$tgl_masuk_akhir = $_POST['data'][$i][11] == "" ? date("Y-m-d") : $_POST['data'][$i][11];

					if ($frame == '') $frame = '000';
					if ($color == '') $color = '000';
					if ($power_add == '') $power_add = '000';
				break;
				
				case '4':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper(trim($_POST['data'][$i][2]));
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][3];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][4];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][5];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][6]));
					$diskon = 0;
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][7]));
					$tgl_masuk_akhir = $_POST['data'][$i][8]==""?date("Y-m-d"):$_POST['data'][$i][8];
					
					$frame = '';
					$color = '';
				break;
			}
			
			$info = $info == "" ? "BY SYSTEM" : $info;
			
			if (!array_search($info, $masukbarang_id))
			{
				$rs2 = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'S001' AND kontak LIKE '$info'");
				if ($data2 = mysqli_fetch_assoc($rs2))
				{
					$supplier_id = $data2['user_id'];
				}
			 	else
				{
					$mysqli->query("INSERT INTO kontak(jenis,kontak,mulai,aktif) VALUES('S001','$info',NOW(),'1')");
					$rs2 = $mysqli->query("SELECT LAST_INSERT_ID()");
					$data2 = mysqli_fetch_assoc($rs2);
					$supplier_id = $data2[0];
				}

				$referensi = "PO-" . date("dmHis") . $i;
				$mysqli->query("INSERT INTO masukbarang(referensi, tgl, jtempo, sales, supplier, matauang_id, total, info, lunas, tipe_pembayaran, branch_id, created_by, created_at) VALUES('$referensi','$tgl_masuk_akhir', NULL,0,$supplier_id, 1,0,'','0','Cash', $_SESSION[branch_id], $_SESSION[user_id], NOW())");
				$id = $mysqli->insert_id;

				$masukbarang_id += array($id => $info);
			}
			else
			{
				$id = array_search($info, $masukbarang_id);
			}
			
			$brand_id = "";
			$rs = $mysqli->query("SELECT * FROM jenisbarang WHERE jenis LIKE '$jenis' AND tipe = $tipe AND info != 'DELETED'");
			if ($data = mysqli_fetch_assoc($rs))
			{
				$brand_id = $data['brand_id'];
			}
			else
			{
				$mysqli->query("INSERT INTO jenisbarang VALUES(0,'','$jenis','$info',$tipe)");
				$rs2 = $mysqli->query("SELECT LAST_INSERT_ID()");
				$data2 = mysqli_fetch_assoc($rs2);
				$brand_id = $data2[0];
			}

			$b = new Barang();
			$b->setKode($kode);
			$b->setBrandId($brand_id);
			$b->setBarang($barang);
			$b->setFrame($frame);
			$b->setColor($color);
			$b->setPowerAdd($power_add);
			$b->setQty($qty);
			$b->setPrice($price);
			$b->setPrice2($price2);
			$b->setKodeHarga($kode_harga);
			$b->setInfo($info);
			$b->setUkuran($ukuran);
			$b->setTipe($tipe);
			$b->setTglMasukAkhir($tgl_masuk_akhir);
			$b->setTglKeluarAkhir('NULL');
			$b->setBranchId($_SESSION['branch_id']);
			$b->setCreatedUserId($_SESSION['user_id']);
			$b->setCreatedDate('NOW()');
			$b->setLastUpdateUserId($_SESSION['user_id']);
			$b->setLastUpdateDate('NOW()');
			
			$existingBarang = $db->getBarang($b);
			if ($existingBarang != null) //if product already exists, only update quantity
			{
				$b = $existingBarang;

				$oldQty = $b->getQty();
				$newQty = $oldQty + $qty;

				$b->setQty($newQty);
				$b->setLastUpdateUserId($_SESSION['user_id']);

				$result = $db->updateBarang($b);
			}
			else //new product, do insert
			{
				$result = $db->insertBarang($b);
			}

			if ($result->status == 'success') {
				$totalsuccess++;

				$product_id = $result->id;

				$mysqli->query("INSERT INTO dmasukbarang(id, masukbarang_id, product_id, satuan_id, harga, qty, tdiskon, diskon, subtotal) VALUES(0, $id, ".$b->getProductId().", 1, $price, $qty, '0', 0, '".($qty*$price)."')");
			}
			
		}
	}
	
	echo json_encode("$totalsuccess Data Sukses Di Tambah");
?>