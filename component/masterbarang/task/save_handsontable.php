<?php
	session_start();
	include('../../../include/config_db.php');
	
	$totalsuccess = 0;
	$masukbarang_id = array();
	for ($i=0;$i<sizeof($_POST['data']);$i++)
	{
		if (trim($_POST['data'][$i][1]) != "")
		{
			$tipe = $_POST['tipe'];
			
			switch ($tipe)
			{
				case '1':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper($_POST['data'][$i][2]);
					$frame = strtoupper($_POST['data'][$i][3]);
					$color = strtoupper($_POST['data'][$i][4]);
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][5];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][6];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][7];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][8]));
					$diskon = $mysqli->real_escape_string($_POST['data'][$i][9]);
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][10]));
					$tgl_masuk_akhir = $_POST['data'][$i][11]==""?date("Y-m-d"):$_POST['data'][$i][11];
					
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
					$barang = strtoupper($_POST['data'][$i][2]);
					$ukuran = strtoupper($_POST['data'][$i][3]); //expiry date
					$frame = strtoupper($_POST['data'][$i][4]); //minus
					$color = strtoupper($_POST['data'][$i][5]);
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][6];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][7];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][8];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][9]));
					$diskon = $mysqli->real_escape_string($_POST['data'][$i][10]);
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][11]));
					$tgl_masuk_akhir = $_POST['data'][$i][12]==""?date("Y-m-d"):$_POST['data'][$i][12];
					
					$rs = $mysqli->query("SELECT * FROM color_type WHERE color LIKE '$color'");
					if (!mysqli_fetch_assoc($rs))
					{
						$mysqli->query("INSERT INTO color_type VALUES(0,'$color')");
					}
				break;
				
				case '3':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper($_POST['data'][$i][2]);
					$frame = strtoupper($_POST['data'][$i][3]); //minus
					$color = strtoupper($_POST['data'][$i][4]); //silinder
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][5];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][6];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][7];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][8]));
					$diskon = $mysqli->real_escape_string($_POST['data'][$i][9]);
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][10]));
					$tgl_masuk_akhir = $_POST['data'][$i][11]==""?date("Y-m-d"):$_POST['data'][$i][11];
				break;
				
				case '4':
					$kode = trim(strtoupper($_POST['data'][$i][0]));
					$jenis = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][1]));
					$barang = strtoupper($_POST['data'][$i][2]);
					$qty = $_POST['data'][$i][5]==""?0:$_POST['data'][$i][3];
					$price = $_POST['data'][$i][6]==""?0:$_POST['data'][$i][4];
					$price2 = $_POST['data'][$i][7]==""?0:$_POST['data'][$i][5];
					$kode_harga = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][6]));
					$diskon = $mysqli->real_escape_string($_POST['data'][$i][7]);
					$info = $mysqli->real_escape_string(strtoupper($_POST['data'][$i][8]));
					$tgl_masuk_akhir = $_POST['data'][$i][11]==""?date("Y-m-d"):$_POST['data'][$i][9];
					
					$frame = '';
					$color = '';
				break;
			}
			
			$info = $info==""?"BY SYSTEM":$info;
			
			if (!array_search($info, $masukbarang_id))
			{
				$rs2 = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'S0001' AND kontak LIKE '$info'");
				if ($data2 = mysqli_fetch_assoc($rs2))
				{
					$supplier_id = $data2['user_id'];
				}
			 	else
				{
					$mysqli->query("INSERT INTO kontak(jenis,kontak,mulai,aktif) VALUES('S0001','$info',NOW(),'1')");
					$rs2 = $mysqli->query("SELECT LAST_INSERT_ID()");
					$data2 = mysqli_fetch_assoc($rs2);
					$supplier_id = $data2[0];
				}

				$referensi = "PO-" . date("dmHis") . $i;
				$mysqli->query("INSERT INTO masukbarang VALUES('$referensi','$tgl_masuk_akhir','1900-01-01',0,$supplier_id,'IDR',0,'','0','Cash')");
				$id = $referensi;

				$masukbarang_id += array($id=>$info);
			}
			else
			{
				$id = array_search($info, $masukbarang_id);
			}
			
			$brand_id = "";
			$rs = $mysqli->query("SELECT * FROM jenisbarang WHERE jenis LIKE '$jenis' AND tipe = $tipe");
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
			
			$rs2 = $mysqli->query("SELECT * FROM barang WHERE brand_id = $brand_id AND barang LIKE '$barang' AND frame LIKE '$frame' AND color LIKE '$color'");
			if ($data2 = mysqli_fetch_assoc($rs2))
			{
				$mysqli->query("UPDATE barang SET qty = qty + $qty WHERE product_id = $data2[product_id]");

				$mysqli->query("INSERT INTO dmasukbarang VALUES(0,$data2[product_id],1,$price,$qty,'0',0,'".($qty*$price)."','$id')");

				$totalsuccess++;
			}
			else
			{
				$query = "INSERT INTO barang VALUES (0,'$kode',$brand_id,'$barang','$frame','$color',$qty,$price,$price2,'$kode_harga','$info','$ukuran',$tipe,'$tgl_masuk_akhir','',$_SESSION[user_id],NOW(),NULL,'')";
				
				$result = $mysqli->query($query);				
				if ($result) $totalsuccess++;
				
				$rs3 = $mysqli->query("SELECT LAST_INSERT_ID()");
				$data3 = mysqli_fetch_assoc($rs3);
				$product_id = $data3[0];
				$mysqli->query("INSERT INTO dmasukbarang VALUES(0,$product_id,1,$price,$qty,'0',0,'".($qty*$price)."','$id')");
			}
			
		}
	}
	
	echo json_encode("$totalsuccess Data Sukses Di Tambah");
?>