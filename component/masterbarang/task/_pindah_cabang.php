<?php
	session_start();
	include('../../../include/config_db.php');

	$data = $_POST['data'];

	$data = explode("#", $data);

	$branch_id = $data[0] ?? 0;

	for ($i=1;$i<sizeof($data);$i++)
	{
		$temp = explode("-", $data[$i]);
		$product_id = $temp[0];
		$qty = $temp[1];

		$rs = $mysqli->query("SELECT * FROM barang WHERE product_id = $product_id");

		if ($data2 = $rs->fetch_assoc()) {
			$origin_branch_id = $data2['branch_id'];

			if ($data2['qty'] == $qty) {
				$mysqli->query("UPDATE barang SET branch_id = $branch_id WHERE product_id = $product_id");

				$mysqli->query("INSERT INTO mutation(origin_branch_id, destination_branch_id, old_product_id, new_product_id, qty, created_by, created_at) VALUES($origin_branch_id, $branch_id, $product_id, $product_id, $qty, $_SESSION[user_id], NOW())");
			}
			else if ($qty < $data2['qty']) {
				$rs3 = $mysqli->query("SELECT * FROM barang WHERE kode = '$data2[kode]' AND brand_id = $data2[brand_id] AND barang = '$data2[barang]' AND frame = '$data2[frame]' AND color = '$data2[color]' AND power_add = '$data2[power_add]' AND info = '$data2[info]' AND tipe = $data2[tipe] AND branch_id = $branch_id");

				//product exists in destination, update qty
				if ($data3 = $rs3->fetch_assoc()) {
					$mysqli->query("UPDATE barang SET qty = qty + $qty WHERE product_id = $data3[product_id]");
					$new_product_id = $data3['product_id'];
				}
				//new product
				else {
					$mysqli->query("INSERT INTO barang(kode, brand_id, barang, frame, color, power_add, qty, price, price2, kode_harga, info, ukuran, tipe, branch_id, created_user_id, created_date) VALUES('$data2[kode]', $data2[brand_id], '$data2[barang]', '$data2[frame]', '$data2[color]', '$data2[power_add]', $qty, $data2[price], $data2[price2], '$data2[kode_harga]', '$data2[info]', '$data2[ukuran]', $data2[tipe], $branch_id, $_SESSION[user_id], NOW())");
					$new_product_id = $mysqli->insert_id;
				}

				$mysqli->query("UPDATE barang SET qty = qty - $qty WHERE product_id = $product_id");

				$mysqli->query("INSERT INTO mutation(origin_branch_id, destination_branch_id, old_product_id, new_product_id, qty, created_by, created_at) VALUES($origin_branch_id, $branch_id, $product_id, $new_product_id, $qty, $_SESSION[user_id], NOW())");
			}
		}
	}
?>