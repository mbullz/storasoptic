<?php
session_start();
include('../../include/config_db.php');
require '../../models/Barang.php';
require '../../models/DBHelper.php';

$db = new DBHelper($mysqli);

	function sphFormat($value) {
		if ($value == 0) return '000';
		else if ($value < 100 && $value > 0) return '0' . $value;
		else if ($value < 0 && $value > -100) return '-0' . $value*-1;
		else return $value;
	}

	function penjualanLensa($dkeluarbarang_id) {
		global $mysqli, $db;

		$rs = $mysqli->query("SELECT * FROM dkeluarbarang WHERE id = $dkeluarbarang_id");
		$data = $rs->fetch_assoc();

		$keluarbarang_id = $data['keluarbarang_id'];
		$lensa_id = $data['lensa'];
		$lSph = sphFormat($data['lSph']);
		$lCyl = sphFormat($data['lCyl']);
		$lAdd = sphFormat($data['lAdd']);
		$rSph = sphFormat($data['rSph']);
		$rCyl = sphFormat($data['rCyl']);
		$rAdd = sphFormat($data['rAdd']);

		$lensa = new Barang();
		$lensa->setProductId($lensa_id);
		$lensa = $db->getBarang($lensa);

		$lensa->setProductId(null);
		$lensa->setFrame($lSph);
		$lensa->setColor($lCyl);
		$lensa->setPowerAdd($lAdd);
		$lensa_left = $db->getBarang($lensa);

		$lensa->setProductId(null);
		$lensa->setFrame($rSph);
		$lensa->setColor($rCyl);
		$lensa->setPowerAdd($rAdd);
		$lensa_right = $db->getBarang($lensa);

		// update qty in barang
		$lensa_left->setQty($lensa_left->getQty() - 1);
		$lensa_left->setTglKeluarAkhir(date('Y-m-d'));
		$db->updateBarang($lensa_left);

		$lensa_right->setQty($lensa_right->getQty() - 1);
		$lensa_right->setTglKeluarAkhir(date('Y-m-d'));
		$db->updateBarang($lensa_right);

		// product sent
		$mysqli->query("INSERT INTO kirimbarang(keluarbarang_id, tgl, product_id, satuan_id, qty, gudang_id, info) VALUES($keluarbarang_id, NOW(), ".$lensa_left->getProductId().", 1, 1, 1, 'SENT')");
		$mysqli->query("INSERT INTO kirimbarang(keluarbarang_id, tgl, product_id, satuan_id, qty, gudang_id, info) VALUES($keluarbarang_id, NOW(), ".$lensa_right->getProductId().", 1, 1, 1, 'SENT')");
	}

//Define variable
$url = "index-c-invoicepenjualan.pos";
$p = $_GET['p'];
$keluarbarang_id = $_POST['keluarbarang_id'] ?? 0;
$inv = $_POST['invoice'] ?? '';
$inv = $mysqli->real_escape_string($inv);
$tgl = $_POST['tgl'] ?? date('Y-m-d');
$tgl = $mysqli->real_escape_string($tgl);
$jte = $_POST['jtempo'] ?? null;
//$matauang_id = $mysqli->real_escape_string($_POST['matauang']);
$matauang_id = 1;
$ppn = $_POST['ppn'] ?? 0;
$ppn = intval($ppn);
$total = $_POST['grand_total'] ?? 0;
$total = intval($total);
$cus = $_POST['customer'] ?? 0;
$cus = $mysqli->real_escape_string($cus);
//$sal = $mysqli->real_escape_string($_POST['sales']);
$sales = $_POST['sales'] ?? 0;
$sal = 0;
$gud = $_POST['gudang'] ?? 1;
$inf = $_POST['info'] ?? '';
$inf = $mysqli->real_escape_string($inf);
$lun = $_POST['lunas'] ?? 0;
$kode = $_SESSION['i_sesadmin'];
$tipe = $_POST['tipePembayaran'] ?? 1;
$tipe_pembayaran = $tipe == "1" ? "Cash" : "Jatuh Tempo";

$carabayar_id = $_POST['carabayar_id'] ?? 1;
$uang_muka = $_POST['uangMuka'] ?? 0;
$info_pembayaran = $_POST['textInfoPembayaran'] ?? '';

//------
$data = $_POST['data'] ?? [];
$jdata = count($data);
$stat = '';
//Validasi
if ($p <> 'mdelete' AND $p <> 'delete') {
	
	if (trim($tgl) == '') {
		$error[] = '- Tanggal harus diisi !!!';
	}
	if ($p == 'barangkeluar' OR $p == 'barangreturkeluar') {
		if (trim($gud) == '') {
			$error[] = '- Lokasi Gudang harus diisi !!!';
		}
	}
	if ($p <> 'barangkeluar' AND $p <> 'barangreturkeluar') {
		if (trim($matauang_id) == '') {
			$error[] = '- Mata Uang harus diisi !!!';
		}
		if ($tipe == 2 && trim($jte) == '') {
			$error[] = '- Jatuh Tempo harus diisi !!!';
		}
		if ((trim($cus) == '')) {
			$error[] = '- Customer harus diisi !!!';
		}
		if (is_int(($uang_muka))) {
			$error[] = '- Uang Muka harus berupa angka !!!';
		}
	}
	if (trim($total) == 0) {
		$error[] = '- Detail Transaksi harus diisi !!!';
	}
}
// End Validasi

if (isset($error)) {
	//echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Kesalahan : </b><br />".implode("<br />", $error);
	$stat = 'Kesalahan: ' . implode('\n', $error);
} else {
	switch ($p) {
		case("mdelete"):
			$where = " WHERE ";
			for ($i = 0; $i < $jdata; $i++) {
				$where .=" keluarbarang_id = $data[$i] ";
				if ($i < $jdata - 1) {
					$where .=" OR ";
				}
			}
			$query_exe = "DELETE FROM keluarbarang " . $where;
			$exe = $mysqli->query($query_exe);
			if ($exe) {
				// delete dmasukbarang
				$query_delx = "DELETE FROM dkeluarbarang " . $where;
				$delx = $mysqli->query($query_delx);
				$stat = 'Data telah dihapus...';
			} else {
				$stat = 'Data gagal dihapus, coba lagi !!!';
			}

				echo json_encode(array(
					'status'	=> 'success',
					'message'	=> 'Success',
				));

			break;
		case("edit"):
			$query_exe = "update keluarbarang set client='$cus', sales='$sal', tgl='$tgl', jtempo='$jte', total=$total, info='$inf', matauang='$matauang_id', lunas='$lun' where keluarbarang_id = $keluarbarang_id ";
			$exe = $mysqli->query($query_exe);
			if ($exe) {
				// adjustment stok
				$adj_value = $_POST['stok'] - $_POST['qtyold'];
				$stoknow = $adj_value + $qty;
				// update stok
				$updatestok = $mysqli->query("update stokbarang set qty='$stoknow' where id='$_POST[stokid]'");
				//---
				$stat = 'Data telah disimpan ...';
				//echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
			} else {
				$stat = 'Data gagal disimpan, coba lagi !!!';
				//echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
			}
			break;
		case("barangkeluar"):
			$product_id = $_POST['barang'];
			$query_exe = "INSERT INTO kirimbarang VALUES(0, $keluarbarang_id, '$tgl', $product_id, $_POST[satuan], $total, $gud, 'SENT')";
			$exe = $mysqli->query($query_exe);
			if ($exe)
			{
				// update qty in barang
				$query_barang = "update barang set qty=qty-$total, tgl_keluar_akhir=current_date where product_id=$product_id";
				$mysqli->query($query_barang);
				// cek stok
				$query_cstok = "select * from stokbarang where product_id=$product_id AND satuan_id=$_POST[satuan] AND gudang='$gud'";
				$cstok = $mysqli->query($query_cstok);
				$row_cstok = mysqli_fetch_assoc($cstok);
				$total_cstok = mysqli_num_rows($cstok);
				if ($total_cstok > 0)
				{
					$qtynow = $row_cstok[qty] - $total;
					$query_upstok = "update stokbarang set qty='$qtynow' where id='$row_cstok[id]'";
				}
				else
				{
					$query_upstok = "insert into stokbarang values(0,'$gud',$product_id,$_POST[satuan], $total)";
				}
				$upstok = $mysqli->query($query_upstok);
				$stat = 'Data telah disimpan ...';
				//echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
			} else {
				$stat = 'Data gagal disimpan, coba lagi !!!';
				//echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
			}
			break;
		case("barangreturkeluar"):
			$brg = $mysqli->real_escape_string($_POST[barang]);
			$kirimbarang_id = $_POST['kirimbarang_id'] ?? 0;

			$query_exe = "INSERT INTO kirimbarang_r VALUES (0, $kirimbarang_id, $keluarbarang_id, '$tgl', $_POST[barang], $_POST[satuan], $total, $gud, 'RETUR', 'false', '')";
			$exe = $mysqli->query($query_exe);
			if ($exe) {
				// update qty in barang
				$query_barang = "UPDATE barang SET qty=qty+$total WHERE product_id=$_POST[barang]";
				$mysqli->query($query_barang);
				// cek stok
				$query_cstok = "SELECT * FROM stokbarang WHERE product_id=$_POST[barang] AND satuan_id=$_POST[satuan] AND gudang='$gud'";
				$cstok = $mysqli->query($query_cstok);
				$row_cstok = mysqli_fetch_assoc($cstok);
				$total_cstok = mysqli_num_rows($cstok);
				if ($total_cstok > 0)
				{
					$qtynow = $row_cstok[qty] + $total;
					$query_upstok = "UPDATE stokbarang SET qty=$qtynow WHERE id=$row_cstok[id]";
				}
				$upstok = $mysqli->query($query_upstok);

				$stat = 'Data telah disimpan ...';
				//echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
			} else {
				$stat = 'Data gagal disimpan, coba lagi !!!';
				//echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
			}
			break;
		default:
			if ($total > $uang_muka) {
				$lunas = 0;
			}
			else {
				$lunas = 1;
				$uang_muka = $total;
			}

			$new_transaction = true;

			$rs = $mysqli->query("SELECT * FROM keluarbarang WHERE keluarbarang_id = $keluarbarang_id");
			$data = $rs->fetch_assoc();

			if ($data['referensi'] == '') {
				$referensi = "INV-";
				$rs = $mysqli->query("SELECT referensi FROM keluarbarang WHERE referensi LIKE '$referensi%' AND branch_id = $_SESSION[branch_id] ORDER BY referensi DESC LIMIT 0,1");
				$data = $rs->fetch_assoc();

				if ($data == null) $referensi .= '000001';
				else {
					$lastreferensi = substr('00000' . (substr($data['referensi'], -6) + 1), -6);
					$referensi .= $lastreferensi;
				}
			}
			else {
				$new_transaction = false;
				$referensi = $data['referensi'];
			}

			$query_exe = "UPDATE keluarbarang SET 
					referensi = '$referensi', 
					tgl = '$tgl', 
					jtempo = NULL, 
					client = $cus, 
					sales = $sales, 
					matauang_id = $matauang_id, 
					ppn = $ppn,
					total = $total, 
					info = '$inf', 
					lunas = '$lunas', 
					branch_id = $_SESSION[branch_id],
					updated_by = $_SESSION[user_id], 
					updated_at = NOW() 
				WHERE keluarbarang_id = $keluarbarang_id 
			";
			$exe = $mysqli->query($query_exe);

			$mysqli->query("DELETE FROM aruskas WHERE transaction_id = $keluarbarang_id AND tipe = 'piutang'");
			$mysqli->query("INSERT INTO aruskas(carabayar_id, transaction_id, tipe, account, tgl, opr, referensi, jumlah, matauang_id, info, branch_id) VALUES($carabayar_id, $keluarbarang_id, 'piutang', 'PIUTANG USAHA', '$tgl', $_SESSION[user_id], '$referensi', $uang_muka, $matauang_id, '$info_pembayaran', $_SESSION[branch_id])");
			
			if ($new_transaction) {
			// Otomatis Barang Keluar
			$rs2 = $mysqli->query("SELECT * FROM dkeluarbarang WHERE keluarbarang_id = $keluarbarang_id ORDER BY id ASC");
			while ($data2 = mysqli_fetch_assoc($rs2))
			{
				$dkeluarbarang_id = $data2['id'];
				$tipe = $data2['tipe'];

				if ($data2['special_order'] == '0' && ($tipe == 3 || $tipe == 5)) {
					penjualanLensa($dkeluarbarang_id);
				}
				
				if ($tipe != 3) {
					$product_id = $data2['product_id'];
					$satuan_id = $data2['satuan_id'];
					$qty = $data2['qty'];

					// product sent
					$mysqli->query("INSERT INTO kirimbarang(keluarbarang_id, tgl, product_id, satuan_id, qty, gudang_id, info) VALUES($keluarbarang_id, NOW(), $product_id, $satuan_id, $qty, 1, 'SENT')");

					// update qty in barang
					$mysqli->query("UPDATE barang SET qty = qty - $qty, tgl_keluar_akhir = NOW() where product_id = $product_id");
				}

				// cek stok
				/*
				$query_cstok = "SELECT * FROM stokbarang WHERE product_id = $product_id AND satuan_id = $satuan_id AND gudang_id = 1";
				$cstok = $mysqli->query($query_cstok);
				$row_cstok = mysqli_fetch_assoc($cstok);
				$total_cstok = mysqli_num_rows($cstok);
				if ($total_cstok > 0)
				{
					$stokbarang_id = $row_cstok['id'];
					$qtynow = $row_cstok['qty'] - $qty;
					$query_upstok = "UPDATE stokbarang SET qty = $qtynow WHERE id = $stokbarang_id";
				}
				else
				{
					$query_upstok = "INSERT INTO stokbarang VALUES(0, 1, $product_id, $satuan_id, 0)";
				}
				$upstok = $mysqli->query($query_upstok);
				*/
			}
			}

			if ($exe) {
				$stat = 'Data berhasil disimpan';
			} else {
				$stat = 'Data gagal disimpan, coba lagi !!!';
			}

			echo json_encode(array(
				'status'	=> 'success',
				'message'	=> 'Success',
			));
			break;
	}
}
?>
