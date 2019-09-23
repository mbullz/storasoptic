<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";
require "../models/KeluarBarang.php";
require "../models/ArusKas.php";
require "../models/DBHelper.php";

$db = new DBHelper($mysqli);

$start = $_GET['start'];
$end = $_GET['end'];

$accounts = array('BIAYA OPERASIONAL', 'BIAYA LISTRIK', 'BIAYA TELEPHONE', 'BIAYA INTERNET', 'BIAYA KONSUMSI', 'BIAYA TRANSPORT', 'BIAYA PENGIRIMAN', 'BIAYA LAIN-LAIN');

$keluarbarangs = $db->getKeluarBarangByPeriode($start, $end);
$costs = $db->getAllArusKas($start, $end, '%', 'piutang');
$allcosts = $db->getAllArusKas($start, $end, '%', '%');

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

			<?php
				$cash = array();

				foreach ($keluarbarangs AS $r) {
					$c = array(
						'keluarbarang_id'	=> $r->getKeluarbarangId(),
						'tgl'				=> $r->getTgl(),
						'referensi'			=> $r->getReferensi(),
						'info'				=> $r->getClientName() . ' - PIUTANG',
						'debit'				=> $r->getTotal(),
						'kredit'			=> 0,
						'branch'			=> $r->getBranchName(),
					);

					array_push($cash, $c);
				}

				foreach ($allcosts as $r) {
					if ($r->getTipe() == 'piutang') {
						$c = array(
							'keluarbarang_id'	=> $r->getTransactionId(),
							'tgl'				=> $r->getTgl(),
							'referensi'			=> $r->getReferensi(),
							'info'				=> $r->getClientName() . ' - PEMBAYARAN PIUTANG<br />INFO: ' . $r->getInfo(),
							'debit'				=> 0,
							'kredit'			=> $r->getJumlah(),
							'branch'			=> $r->getBranchName(),
						);
					}
					else {
						$c = array(
							'keluarbarang_id'	=> $r->getTransactionId(),
							'tgl'				=> $r->getTgl(),
							'referensi'			=> $r->getReferensi(),
							'info'				=> $r->getAccount() . '<br />INFO: ' . $r->getInfo(),
							'debit'				=> 0,
							'kredit'			=> $r->getJumlah(),
							'branch'			=> $r->getBranchName(),
						);
					}

					array_push($cash, $c);
				}

				usort($cash, "date_comparator");
			?>

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
						$total_kredit = 0;
						foreach ($cash AS $c) {
							$total_debit += $c['debit'];
							$total_kredit += $c['kredit'];
							?>
								<tr>
									<td class="text-center"><?=$c['tgl']?></td>
									<td class="text-center"><?=$c['referensi']?></td>
									<td><?=$c['info']?></td>
									<td class="text-right"><?=number_format($c['debit'], 0)?></td>
									<td class="text-right"><?=number_format($c['kredit'], 0)?></td>
									<td class="text-center"><small><?=$c['branch']?></small></td>
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
						<th class="text-right"><?=number_format($total_kredit, 0)?></th>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>

			<br />

			<div class="alert alert-primary" role="alert">
				Buku Besar Hutang
			</div>

			<div class="alert alert-primary" role="alert">
				Buku Besar Piutang
			</div>

			<?php
				$credits = array();

				foreach ($keluarbarangs AS $r) {
					$credit = array(
						'keluarbarang_id'	=> $r->getKeluarbarangId(),
						'tgl'				=> $r->getTgl(),
						'referensi'			=> $r->getReferensi(),
						'info'				=> $r->getClientName() . ' - PIUTANG',
						'debit'				=> $r->getTotal(),
						'kredit'			=> 0,
						'branch'			=> $r->getBranchName(),
					);

					array_push($credits, $credit);
				}

				foreach ($costs as $r) {
					$credit = array(
						'keluarbarang_id'	=> $r->getTransactionId(),
						'tgl'				=> $r->getTgl(),
						'referensi'			=> $r->getReferensi(),
						'info'				=> $r->getClientName() . ' - PEMBAYARAN PIUTANG<br />INFO: ' . $r->getInfo(),
						'debit'				=> 0,
						'kredit'			=> $r->getJumlah(),
						'branch'			=> $r->getBranchName(),
					);

					array_push($credits, $credit);
				}

				usort($credits, "date_comparator");
			?>

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
						$total_kredit = 0;
						foreach ($credits AS $credit) {
							$total_debit += $credit['debit'];
							$total_kredit += $credit['kredit'];
							?>
								<tr>
									<td class="text-center"><?=$credit['tgl']?></td>
									<td class="text-center"><?=$credit['referensi']?></td>
									<td><?=$credit['info']?></td>
									<td class="text-right"><?=number_format($credit['debit'], 0)?></td>
									<td class="text-right"><?=number_format($credit['kredit'], 0)?></td>
									<td class="text-center"><small><?=$credit['branch']?></small></td>
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
						<th class="text-right"><?=number_format($total_kredit, 0)?></th>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>

			<br />

			<!-- Buku Besar Beban -->
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