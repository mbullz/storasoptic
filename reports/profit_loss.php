<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";

$start = $_GET['start'];
$end = $_GET['end'];

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter = '';
if ($branch_id != 0) {
	$branch_filter = " AND a.branch_id = $branch_id ";
}

//net sales
$query = "SELECT SUM(total) AS net_sales 
		FROM keluarbarang a 
		WHERE a.tgl BETWEEN '$start' AND '$end' 
		$branch_filter ";
$rs = $mysqli->query($query);
$data = $rs->fetch_assoc();
$netSales = $data['net_sales'];

$salesDiscount = 0;
$netSalesRevenue = $netSales - $salesDiscount;

//cost of goods sold
$costOfGoodsSold = 0;

$query = "SELECT b.product_id, b.harga, b.qty, b.lensa AS lensa_id, b.tipe, b.harga_lensa, 
			c.price AS frame_cost, d.price AS lensa_cost 
		FROM keluarbarang a 
		JOIN dkeluarbarang b ON a.keluarbarang_id = b.keluarbarang_id 
		LEFT JOIN barang c ON b.product_id = c.product_id 
		LEFT JOIN barang d ON b.lensa = d.product_id 
		WHERE a.referensi != '' 
		AND a.tgl BETWEEN '$start' AND '$end' 
		$branch_filter ";
$rs = $mysqli->query($query);
while ($data = $rs->fetch_assoc()) {
	$product_id = $data['product_id'];
	$harga = $data['harga'];
	$qty = $data['qty'];
	$lensa_id = $data['lensa_id'];
	$tipe = $data['tipe'];
	$harga_lensa = $data['harga_lensa'];
	$frame_cost = $data['frame_cost'];
	$lensa_cost = $data['lensa_cost'];

	if ($tipe != 3) {
		if ($product_id != 0) {
			$costOfGoodsSold += ($frame_cost * $qty);
		}
		else {
			$costOfGoodsSold += ($harga * $qty);
		}
	}

	if ($tipe == 3 || $tipe == 5) {
		if ($lensa_id != 0) {
			$costOfGoodsSold += ($lensa_cost * 2);
		}
		else {
			$costOfGoodsSold += ($harga_lensa * 2);
		}
	}
}

$grossProfit = $netSalesRevenue - $costOfGoodsSold;

//operating expenses
$totalOperatingExpenses = 0;
$operatingExpensesType = array('BIAYA OPERASIONAL', 'BIAYA LISTRIK', 'BIAYA TELEPHONE', 'BIAYA INTERNET', 'BIAYA KONSUMSI', 'BIAYA TRANSPORT', 'BIAYA PENGIRIMAN', 'BIAYA GAJI', 'BIAYA SERVICE CHARGE', 'BIAYA SEWA', 'BIAYA PENYUSUTAN', 'BIAYA PARKIR', 'BIAYA LAIN-LAIN');

$query = "SELECT a.account, 
			SUM(jumlah) AS total 
		FROM aruskas a 
		WHERE a.tipe = 'operasional' 
		AND a.tgl BETWEEN '$start' AND '$end' 
		$branch_filter 
		GROUP BY account ";
$rs = $mysqli->query($query);
$operatingExpenses = array();
while ($data = $rs->fetch_assoc()) {
	$account = $data['account'];
	$operatingExpenses[$account] = $data['total'];
	$totalOperatingExpenses += $data['total'];
}

$operatingProfit = $grossProfit - $totalOperatingExpenses;

$otherIncomesAndProfits = 0;
$otherExpensesAndLosses = 0;

$netProfitLoss = $operatingProfit + $otherIncomesAndProfits - $otherExpensesAndLosses;

if ($netProfitLoss > 0) {
	$netProfitLossTableRowClass = ' table-success ';
}
else {
	$netProfitLossTableRowClass = ' table-danger ';
}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

		<title>Laba Rugi</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h4 class="text-center mt-3">
				<font color="#2B9FDC">Laba Rugi - <?=$_SESSION['branch_name']?></font>
			</h4>
			<div class="text-center text-muted"><?=$start?> s/d <?=$end?></div>

			<table class="table table-hover table-responsive mt-4 mb-5">
				<tbody>
					<tr>
						<th scope="row">Pendapatan Penjualan</th>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td class="pl-4">Penjualan Bersih</td>
						<td></td>
						<td class="text-right"><?=number_format($netSales, 0)?></td>
					</tr>

					<tr class="table-secondary">
						<th>Pendapatan Penjualan Bersih</th>
						<td></td>
						<th class="text-right"><?=number_format($netSalesRevenue, 0)?></th>
					</tr>

					<tr>
						<th scope="row">Harga Pokok Penjualan</th>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>Harga Pokok Penjualan</td>
						<td></td>
						<td class="text-right text-danger"><?=number_format($costOfGoodsSold, 0)?></td>
					</tr>

					<tr class="table-secondary">
						<th>Laba Kotor</th>
						<td></td>
						<th class="text-right"><?=number_format($grossProfit, 0)?></th>
					</tr>

					<tr>
						<th scope="row">Beban Operasional</th>
						<td></td>
						<td></td>
					</tr>

					<?php
						foreach ($operatingExpensesType as $account) {
							?>
								<tr>
									<td class="pl-4"><?=ucwords(strtolower($account))?></td>
									<td class="text-right"><?=number_format($operatingExpenses[$account] ?? 0, 0)?></td>
									<td></td>
								</tr>
							<?php
						}
					?>

					<tr>
						<td>Total Beban Operasional</td>
						<td></td>
						<td class="text-right text-danger"><?=number_format($totalOperatingExpenses, 0)?></td>
					</tr>

					<tr class="table-secondary">
						<th>Laba Operasional</th>
						<td></td>
						<th class="text-right"><?=number_format($operatingProfit, 0)?></th>
					</tr>

					<tr>
						<th scope="row">Pendapatan dan Keuntungan Lain-Lain</th>
						<td></td>
						<td class="text-right"><?=number_format($otherIncomesAndProfits, 0)?></td>
					</tr>

					<tr>
						<th scope="row">Beban dan Kerugian Lain-Lain</th>
						<td></td>
						<td class="text-right text-danger"><?=number_format($otherExpensesAndLosses, 0)?></td>
					</tr>

					<tr class="<?=$netProfitLossTableRowClass?>">
						<th>Laba/Rugi Bersih</th>
						<td></td>
						<th class="text-right"><?=number_format($netProfitLoss, 0)?></th>
					</tr>
				</tbody>
			</table>

		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha512-ubuT8Z88WxezgSqf3RLuNi5lmjstiJcyezx34yIU2gAHonIi27Na7atqzUZCOoY4CExaoFumzOsFQ2Ch+I/HCw==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>

	</body>
</html>
