<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";

$start = $_GET['start'];
$end = $_GET['end'];

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter_in = '';
$branch_filter_out = '';
if ($branch_id != 0) {
	$branch_filter_in = " AND a.destination_branch_id = $branch_id ";
	$branch_filter_out = " AND a.origin_branch_id = $branch_id ";
}

$queryIn = "SELECT a.qty, a.created_at, 
				b.kontak AS origin_branch_name, c.kontak AS destination_branch_name, 
				e.jenis AS brand_name, d.kode, d.barang, 
				d.frame, d.color, d.power_add, d.tipe 
			FROM mutation a 
			JOIN kontak b ON a.origin_branch_id = b.user_id 
			JOIN kontak c ON a.destination_branch_id = c.user_id 
			JOIN barang d ON a.new_product_id = d.product_id 
			JOIN jenisbarang e ON d.brand_id = e.brand_id 
			WHERE a.created_at BETWEEN '$start 00:00:00' AND '$end 23:59:59' 
			$branch_filter_in 
			ORDER BY destination_branch_name ASC, tipe ASC, origin_branch_name ASC, created_at ASC ";

$queryOut = "SELECT a.qty, a.created_at, 
				b.kontak AS origin_branch_name, c.kontak AS destination_branch_name, 
				e.jenis AS brand_name, d.kode, d.barang, 
				d.frame, d.color, d.power_add, d.tipe 
			FROM mutation a 
			JOIN kontak b ON a.origin_branch_id = b.user_id 
			JOIN kontak c ON a.destination_branch_id = c.user_id 
			JOIN barang d ON a.old_product_id = d.product_id 
			JOIN jenisbarang e ON d.brand_id = e.brand_id 
			WHERE a.created_at BETWEEN '$start 00:00:00' AND '$end 23:59:59' 
			$branch_filter_out 
			ORDER BY origin_branch_name ASC, tipe ASC, destination_branch_name ASC, created_at ASC ";

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

		<title>Mutasi Barang</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h4 class="text-center mt-3">
				<font color="#2B9FDC">Mutasi Barang</font>
			</h4>
			<div class="text-center text-muted"><?=$start?> s/d <?=$end?></div>

			<div class="alert alert-primary mt-4" role="alert">
				Mutasi Barang Masuk
			</div>

			<table class="table table-hover table-sm table-responsive mt-3">
				<thead>
					<tr>
						<th scope="col" class="text-nowrap">Cabang</th>
						<th scope="col" class="text-nowrap">Tipe</th>
						<th scope="col" class="text-nowrap">Brand</th>
						<th scope="col" class="text-nowrap">Produk</th>
						<th scope="col" class="text-center text-nowrap">Qty</th>
						<th scope="col" class="text-nowrap">Asal</th>
						<th scope="col" class="text-nowrap">Tanggal</th>
					</tr>
				</thead>

				<tbody>
					<?php
						$rs = $mysqli->query($queryIn);

						while ($data = $rs->fetch_assoc()) {
							$tipe = $data['tipe'];
							
							if ($tipe == 1) $tipeName = 'Frame';
							else if ($tipe == 2) $tipeName = 'Softlens';
							else if ($tipe == 3) $tipeName = 'Lensa';
							else $tipeName = 'Accessories';

							?>
								<tbody>
									<tr>
										<td><?=$data['destination_branch_name']?></td>
										<td><?=$tipeName?></td>
										<td><?=$data['brand_name']?></td>
										<td>
											<font class="pr-2"><?=$data['kode']?></font>
											<font class="pr-2"><?=$data['barang']?></font>
											<font class="pr-2"><?=$data['frame']?></font>
											<font class="pr-2"><?=$data['color']?></font>
											<font class="pr-2"><?=$data['power_add']?></font>
										</td>
										<td class="text-center"><?=$data['qty']?></td>
										<td><?=$data['origin_branch_name']?></td>
										<td class="align-middle"><small><?=$data['created_at']?></small></td>
									</tr>
								</tbody>
							<?php
						}
					?>
				</tbody>
			</table>

			<div class="alert alert-primary mt-5" role="alert">
				Mutasi Barang Keluar
			</div>

			<table class="table table-hover table-sm table-responsive mt-3">
				<thead>
					<tr>
						<th scope="col" class="text-nowrap">Cabang</th>
						<th scope="col" class="text-nowrap">Tipe</th>
						<th scope="col" class="text-nowrap">Brand</th>
						<th scope="col" class="text-nowrap">Produk</th>
						<th scope="col" class="text-center text-nowrap">Qty</th>
						<th scope="col" class="text-nowrap">Tujuan</th>
						<th scope="col" class="text-nowrap">Tanggal</th>
					</tr>
				</thead>

				<tbody>
					<?php
						$rs = $mysqli->query($queryOut);

						while ($data = $rs->fetch_assoc()) {
							$tipe = $data['tipe'];
							
							if ($tipe == 1) $tipeName = 'Frame';
							else if ($tipe == 2) $tipeName = 'Softlens';
							else if ($tipe == 3) $tipeName = 'Lensa';
							else $tipeName = 'Accessories';

							?>
								<tbody>
									<tr>
										<td><?=$data['origin_branch_name']?></td>
										<td><?=$tipeName?></td>
										<td><?=$data['brand_name']?></td>
										<td>
											<font class="pr-2"><?=$data['kode']?></font>
											<font class="pr-2"><?=$data['barang']?></font>
											<font class="pr-2"><?=$data['frame']?></font>
											<font class="pr-2"><?=$data['color']?></font>
											<font class="pr-2"><?=$data['power_add']?></font>
										</td>
										<td class="text-center"><?=$data['qty']?></td>
										<td><?=$data['destination_branch_name']?></td>
										<td class="align-middle"><small><?=$data['created_at']?></small></td>
									</tr>
								</tbody>
							<?php
						}
					?>
				</tbody>
			</table>

		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha512-ubuT8Z88WxezgSqf3RLuNi5lmjstiJcyezx34yIU2gAHonIi27Na7atqzUZCOoY4CExaoFumzOsFQ2Ch+I/HCw==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>

	</body>
</html>
