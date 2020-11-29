<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";
require '../vendor/autoload.php';

use Carbon\Carbon;

$start = $_GET['start'];
$end = $_GET['end'];
$limit = $_GET['limit'];

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter = '';
if ($branch_id != 0) {
	$branch_filter = " AND a.branch_id = $branch_id ";
}

$query = "SELECT a.kontak AS customer_name, a.alamat, a.notlp, c.kontak AS branch_name, 
			COUNT(b.keluarbarang_id) AS transaction_count, SUM(b.total) AS spent, MAX(b.tgl) AS last_purchase_date 
		FROM kontak a 
		JOIN keluarbarang b ON a.user_id = b.client 
		JOIN kontak c ON a.branch_id = c.user_id 
		WHERE b.tgl BETWEEN '$start' AND '$end' 
		$branch_filter 
		GROUP BY customer_name, alamat, notlp, branch_name 
		ORDER BY spent DESC 
		LIMIT 0,$limit ";

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

		<title>Pembelian Customer Terbanyak</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h4 class="text-center mt-3">
				<font color="#2B9FDC">Pembelian Customer Terbanyak</font>
			</h4>
			<div class="text-center text-muted"><?=$start?> s/d <?=$end?></div>

			<table class="table table-hover table-sm mt-4">
				<thead>
					<tr>
						<th scope="col" class="text-center text-nowrap">No.</th>
						<th scope="col" class="text-nowrap">Cabang</th>
						<th scope="col" class="text-nowrap">Nama</th>
						<th scope="col" class="text-nowrap">Alamat</th>
						<th scope="col" class="text-nowrap">HP</th>
						<th scope="col" class="text-center text-nowrap">Jumlah Transaksi</th>
						<th scope="col" class="text-right text-nowrap">Total Pembelian</th>
						<th scope="col" class="text-center text-nowrap">Pembelian Terakhir</th>
					</tr>
				</thead>

				<tbody>
					<?php
						$rs = $mysqli->query($query);

						$i = 0;
						while ($data = $rs->fetch_assoc()) {
							$i++;
							?>
								<tr>
									<td scope="row" class="text-center"><?=$i?></td>
									<td><?=$data['branch_name']?></td>
									<td><?=$data['customer_name']?></td>
									<td><?=$data['alamat']?></td>
									<td><?=$data['notlp']?></td>
									<td class="text-center"><?=$data['transaction_count']?></td>
									<td class="text-right"><?=number_format($data['spent'], 0)?></td>
									<td class="text-center"><?=Carbon::parse($data['last_purchase_date'])->diffForHumans()?></td>
								</tr>
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
