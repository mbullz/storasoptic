<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";
require "../models/KeluarBarang.php";
require "../models/ArusKas.php";
require "../models/CaraBayar.php";
require "../models/DBHelper.php";

$db = new DBHelper($mysqli);

$start = $_GET['start'];
$end = $_GET['end'];

$keluarbarangs = $db->getKeluarBarangByPeriode($start, $end);
$costs = $db->getAllArusKas($start, $end, '%', 'piutang');
$carabayars = $db->getAllCaraBayar();

foreach ($carabayars AS $carabayar) {
	$carabayar_id = $carabayar->getCarabayarId();
	$subtotal[$carabayar_id] = 0;
}

$total = 0;

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />

		<title>Jurnal Penerimaan Kas</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h2 class="text-center">
				<font color="#2B9FDC">Jurnal Penerimaan Kas</font>
				<br />
				<small class="text-muted"><?=$start?> s/d <?=$end?></small>
			</h2>

			<br />

			<div class="alert alert-primary" role="alert">
				Penerimaan Kas
			</div>

			<table class="table table-hover table-sm table-responsive">
				<thead>
					<tr>
						<th style="vertical-align: middle;" scope="col" class="text-center text-nowrap" rowspan="2">Tanggal</th>
						<th style="vertical-align: middle;" scope="col" class="text-center text-nowrap" rowspan="2">No. Inv.</th>
						<th style="vertical-align: middle;" scope="col" class="text-center text-nowrap" rowspan="2">Customer</th>
						<th scope="col" class="text-center text-nowrap" colspan="<?=sizeof($carabayars)?>">Pembayaran</th>
						<th style="vertical-align: middle;" scope="col" class="text-center text-nowrap" rowspan="2">Cabang</th>
					</tr>

					<tr>
						<?php
							foreach ($carabayars AS $carabayar) {
								?>
									<th scope="col" class="text-center text-nowrap"><?=$carabayar->getPembayaran()?></th>
								<?php
							}
						?>
					</tr>
				</thead>

				<tbody>
					<?php
						foreach ($costs AS $c) {
							?>
								<tr>
									<td class="text-center text-nowrap"><?=$c->getTgl()?></td>
									<td class="text-center text-nowrap"><?=$c->getReferensi()?></td>
									<td class="text-nowrap"><?=$c->getClientName()?></td>

									<?php
										foreach ($carabayars AS $carabayar) {
											$carabayar_id = $carabayar->getCarabayarId();
											$jumlah = $c->getCarabayarId() == $carabayar->getCarabayarId() ? $c->getJumlah() : 0;
											$subtotal[$carabayar_id] += $jumlah;
											$total += $jumlah;
											?>
												<td class="text-right text-nowrap">
													<?=$jumlah > 0 ? number_format($jumlah, 0) : ''?>
												</td>
											<?php
										}
									?>

									<td class="text-center text-nowrap"><small><?=$c->getBranchName()?></small></td>
								</tr>
							<?php
						}
					?>
				</tbody>

				<tfoot>
					<tr>
						<td rowspan="2">&nbsp;</td>
						<td rowspan="2">&nbsp;</td>
						<th style="vertical-align: middle;" class="text-center text-nowrap" rowspan="2">Total</th>

						<?php
							foreach ($carabayars AS $carabayar) {
								?>
									<th class="text-center text-nowrap"><?=$carabayar->getPembayaran()?></th>
								<?php
							}
						?>

						<td rowspan="2">&nbsp;</td>
					</tr>

					<tr>
						<?php
							foreach ($carabayars AS $carabayar) {
								$carabayar_id = $carabayar->getCarabayarId();
								?>
									<th class="text-right text-nowrap"><?=number_format($subtotal[$carabayar_id], 0)?></th>
								<?php
							}
						?>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<th class="text-center text-nowrap">Grand Total</th>
						<th class="text-nowrap" colspan="<?=sizeof($carabayars)+1?>"><?=number_format($total, 0)?></th>
					</tr>
				</tfoot>
			</table>

			<br />

			<div class="alert alert-primary" role="alert">
				Sisa Piutang
			</div>

			<table class="table table-hover table-sm table-responsive">
				<thead>
					<tr>
						<th scope="col" class="text-center text-nowrap">No. Inv.</th>
						<th scope="col" class="text-center text-nowrap">Customer</th>
						<th scope="col" class="text-center text-nowrap">Piutang</th>
						<th scope="col" class="text-center text-nowrap">Cabang</th>
					</tr>
				</thead>

				<tbody>
					<?php
						$total_credit = 0;
						foreach ($keluarbarangs AS $k) {
							if ($k->getLunas() == '0'):
								$credit = $k->getTotal() - $k->getTotalPayment();
								$total_credit += $credit;
							?>
								<tr>
									<td class="text-center text-nowrap"><?=$k->getReferensi()?></td>
									<td class="text-nowrap"><?=$k->getClientName()?></td>
									<td class="text-right text-nowrap"><?=number_format($credit, 0)?></td>
									<td class="text-center text-nowrap"><small><?=$c->getBranchName()?></small></td>
								</tr>
							<?php
							endif;
						}
					?>
				</tbody>

				<tfoot>
					<tr>
						<td>&nbsp;</td>
						<th class="text-center text-nowrap">Total</th>
						<th class="text-right text-nowrap"><?=number_format($total_credit, 0)?></th>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>

		</div>

		<script type="text/javascript" language="javascript" src="../js/jquery-3.4.0.min.js"></script>
		<script type="text/javascript" language="javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" language="javascript" src="../js/bootstrap.min.js"></script>
	</body>
</html>