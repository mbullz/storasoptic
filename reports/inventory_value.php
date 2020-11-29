<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter = '';
if ($branch_id != 0) {
	$branch_filter = " AND a.user_id = $branch_id ";
}

$query = "SELECT a.user_id AS branch_id, a.kontak AS branch_name, 
			b.tipe, 
			SUM(b.qty) AS stock, SUM(b.price * b.qty) AS cost, SUM(b.price2 * b.qty) AS price 
		FROM kontak a 
		JOIN barang b ON a.user_id = b.branch_id 
		WHERE a.jenis = 'B001' 
		AND b.qty > 0 
		$branch_filter 
		GROUP BY branch_id, branch_name, tipe ";

$rs = $mysqli->query($query);

$rows = array();
while ($data = $rs->fetch_assoc()) {
	$branch_id = $data['branch_id'];
	$branch_name = $data['branch_name'];
	$tipe = $data['tipe'];
	$stock = $data['stock'];
	$cost = $data['cost'];
	$price = $data['price'];

	$rows[$branch_id]['branch_name'] = $branch_name;
	$rows[$branch_id][$tipe]['stock'] = $stock;
	$rows[$branch_id][$tipe]['cost'] = $cost;
	$rows[$branch_id][$tipe]['price'] = $price;
}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

		<title>Nilai Persediaan Barang</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h4 class="text-center mt-3">
				<font color="#2B9FDC">Nilai Persediaan Barang</font>
			</h4>
			<div class="text-center text-muted">Data per tanggal : <?=date('j F Y H:i:s')?></div>

			<table class="table table-hover table-bordered table-sm mt-4">
				<thead>
					<tr>
						<th scope="col" rowspan="2" class="text-center text-nowrap align-middle">Cabang</th>
						<th scope="col" colspan="2" class="text-center text-nowrap">Frame</th>
						<th scope="col" colspan="2" class="text-center text-nowrap">Softlens</th>
						<th scope="col" colspan="2" class="text-center text-nowrap">Lensa</th>
						<th scope="col" colspan="2" class="text-center text-nowrap">Accessories</th>
						<th scope="col" rowspan="2" class="text-center text-nowrap align-middle">Total</th>
					</tr>
					
					<tr>
						<th scope="col" class="text-center text-nowrap align-middle">Stock (Pcs)</th>
						<th scope="col" class="text-center text-nowrap align-middle">Nilai Harga Beli <br /><font class="text-muted">Nilai Harga Jual</font></th>
						<th scope="col" class="text-center text-nowrap align-middle">Stock (Pcs)</th>
						<th scope="col" class="text-center text-nowrap align-middle">Nilai Harga Beli <br /><font class="text-muted">Nilai Harga Jual</font></th>
						<th scope="col" class="text-center text-nowrap align-middle">Stock (Pcs)</th>
						<th scope="col" class="text-center text-nowrap align-middle">Nilai Harga Beli <br /><font class="text-muted">Nilai Harga Jual</font></th>
						<th scope="col" class="text-center text-nowrap align-middle">Stock (Pcs)</th>
						<th scope="col" class="text-center text-nowrap align-middle">Nilai Harga Beli <br /><font class="text-muted">Nilai Harga Jual</font></th>
					</tr>
				</thead>

				<tbody>
					<?php
						$grandTotalCost = 0;
						$grandTotalPrice = 0;
						foreach ($rows as $key => $row) {
							$branch_name = $row['branch_name'];
							$frame_stock = $row[1]['stock'] ?? 0;
							$frame_cost = $row[1]['cost'] ?? 0;
							$frame_price = $row[1]['price'] ?? 0;
							$softlens_stock = $row[2]['stock'] ?? 0;
							$softlens_cost = $row[2]['cost'] ?? 0;
							$softlens_price = $row[2]['price'] ?? 0;
							$lensa_stock = $row[3]['stock'] ?? 0;
							$lensa_cost = $row[3]['cost'] ?? 0;
							$lensa_price = $row[3]['price'] ?? 0;
							$accessories_stock = $row[4]['stock'] ?? 0;
							$accessories_cost = $row[4]['cost'] ?? 0;
							$accessories_price = $row[4]['price'] ?? 0;

							$totalCost = $frame_cost + $softlens_cost + $lensa_cost + $accessories_cost;
							$totalPrice = $frame_price + $softlens_price + $lensa_price + $accessories_price;
							$grandTotalCost += $totalCost;
							$grandTotalPrice += $totalPrice;
							?>
								<tr>
									<td>
										<?=$branch_name?>
									</td>
									<td class="text-center">
										<?=number_format($frame_stock, 0)?>
									</td>
									<td class="text-right">
										<?=number_format($frame_cost, 0)?>
										<br />
										<font class="text-muted"><?=number_format($frame_price, 0)?></font></td>
									<td class="text-center">
										<?=number_format($softlens_stock, 0)?>
									</td>
									<td class="text-right">
										<?=number_format($softlens_cost, 0)?>
										<br />
										<font class="text-muted"><?=number_format($softlens_price, 0)?></font></td>
									</td>
									<td class="text-center">
										<?=number_format($lensa_stock, 0)?>
									</td>
									<td class="text-right">
										<?=number_format($lensa_cost, 0)?>
										<br />
										<font class="text-muted"><?=number_format($lensa_price, 0)?></font></td>
									</td>
									<td class="text-center">
										<?=number_format($accessories_stock, 0)?>
									</td>
									<td class="text-right">
										<?=number_format($accessories_cost, 0)?>
										<br />
										<font class="text-muted"><?=number_format($accessories_price, 0)?></font></td>
									</td>
									<td class="text-right">
										<?=number_format($totalCost, 0)?>
										<br />
										<font class="text-muted"><?=number_format($totalPrice, 0)?></font></td>
									</td>
								</tr>
							<?php
						}
					?>
				</tbody>

				<tfoot>
					<tr>
						<th scope="col" colspan="9" class="text-right align-middle">Grand Total</th>
						<th scope="col" class="text-right">
							<?=number_format($grandTotalCost, 0)?>
							<br />
							<font class="text-muted"><?=number_format($grandTotalPrice, 0)?></font></td>
						</th>
					</tr>
				</tfoot>
			</table>

		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha512-ubuT8Z88WxezgSqf3RLuNi5lmjstiJcyezx34yIU2gAHonIi27Na7atqzUZCOoY4CExaoFumzOsFQ2Ch+I/HCw==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>

	</body>
</html>
