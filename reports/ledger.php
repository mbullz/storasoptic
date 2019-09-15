<?php

session_start();

require "../include/config_db.php";
require "../models/ArusKas.php";
require "../models/DBHelper.php";

$db = new DBHelper($mysqli);

$start = $_GET['start'];
$end = $_GET['end'];

$accounts = array('BIAYA OPERASIONAL', 'BIAYA LISTRIK', 'BIAYA TELEPHONE', 'BIAYA INTERNET', 'BIAYA KONSUMSI', 'BIAYA TRANSPORT', 'BIAYA PENGIRIMAN', 'BIAYA LAIN-LAIN');

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />

		<title>Ledger</title>
	</head>
	
	<body>
		<div class="container">
			<h2 class="text-center">
				<font color="#2B9FDC">Buku Besar</font>
				<br />
				<small class="text-muted"><?=$start?> s/d <?=$end?></small>
			</h2>

			<br />

			<div class="alert alert-primary" role="alert">
				Buku Besar Kas
			</div>

			<div class="alert alert-primary" role="alert">
				Buku Besar Hutang
			</div>

			<div class="alert alert-primary" role="alert">
				Buku Besar Piutang
			</div>

			<?php

				$rs = $mysqli->query("SELECT a.keluarbarang_id, a.referensi, a.tgl, a.client AS customer_id, b.kontak AS customer_name, a.total FROM keluarbarang a JOIN kontak b ON a.client = b.user_id WHERE a.tgl >= '$start' AND a.tgl <= '$end' AND a.branch_id = $_SESSION[branch_id] ORDER BY a.tgl ASC");

				while ($data = $rs->fetch_assoc()) {
					$tgl = $data['tgl'];
				}
			?>

			<br />

			<?php
				foreach ($accounts AS $account) {
					$costs = $db->getAllArusKas($start, $end, $account, 'operasional');

					?>
						<div class="alert alert-primary" role="alert">
							Buku Besar <?=ucwords(strtolower($account))?>
						</div>

						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col" class="text-center">Tanggal</th>
									<th scope="col" class="text-center">No. Ref.</th>
									<th scope="col" class="text-center">Keterangan</th>
									<th scope="col" class="text-center">Debit</th>
									<th scope="col" class="text-center">Kredit</th>
									<th scope="col" class="text-center">Cabang</th>
								</tr>
							</thead>

							<tbody>
								<?php
									$total_debit = 0;
									foreach ($costs AS $cost) {
										$total_debit += $cost->getJumlah();
										?>
											<tr>
												<td class="text-center"><?=$cost->getTgl()?></td>
												<td class="text-center"><?=$cost->getReferensi()?></td>
												<td><?=$cost->getInfo()?></td>
												<td class="text-right"><?=number_format($cost->getJumlah(), 0)?></td>
												<td class="text-right">0</td>
												<td class="text-center"><small><?=$cost->getBranchName()?></small></td>
											</tr>
										<?php
									}
								?>
							</tbody>

							<tfoot>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<th class="text-center">Total</th>
									<th class="text-right"><?=number_format($total_debit, 0)?></th>
									<th class="text-right">0</th>
									<td>&nbsp;</td>
								</tr>
							</tfoot>
						</table>

						<br />
					<?php
				}
			?>

		</div>

		<script type="text/javascript" language="javascript" src="../js/jquery-3.4.0.min.js"></script>
		<script type="text/javascript" language="javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" language="javascript" src="../js/bootstrap.min.js"></script>
	</body>
</html>