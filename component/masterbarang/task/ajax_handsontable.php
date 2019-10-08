<?php

session_start();
include('../../../include/config_db.php');
require '../../../models/Barang.php';
require '../../../models/DBHelper.php';

$db = new DBHelper($mysqli);

$data = $_POST['data'] ?? '';
$method = $_POST['method'];
$arr = array();

switch ($method)
{
	case "get_supplier":
		$rs = $mysqli->query("SELECT info FROM jenisbarang WHERE jenis LIKE '$data'");
		if ($data = mysqli_fetch_assoc($rs))
			echo $data['info'];
	break;

	case 'get_barang':
		$kode = $_POST['kode'];
		$tipe = $_POST['tipe'];

		$b = $db->getBarangByKode($kode, $tipe);

		if ($b != null) {
			$arr = array(
				'brand_name'	=> $b->getBrandName(),
				'barang'		=> $b->getBarang(),
				'frame'			=> $b->getFrame(),
				'color'			=> $b->getColor(),
				'power_add'		=> $b->getPowerAdd(),
				'price'			=> $b->getPrice(),
				'price2'		=> $b->getPrice2(),
				'kode_harga'	=> $b->getKodeHarga(),
				'info'			=> $b->getInfo(),
			);
		}

		echo json_encode($arr);
	break;
}

?>
