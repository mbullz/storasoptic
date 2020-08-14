<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";
require '../vendor/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonImmutable;

$start = $_GET['start'];
$end = $_GET['end'];

$startDate = CarbonImmutable::parse($start);

$countDays = Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter = '';
if ($branch_id != 0) {
	$branch_filter = " AND b.branch_id = $branch_id ";
}

//$presence[$user_id][$date][0] = $time;
//$presence[$user_id][$date][1] = $note;
//$presence[$user_id][$date]['late'] = true/false;

$users = array();
$presence = array();
$maxPresenceTime = Carbon::parse('10:00:00');

//get users
$rs = $mysqli->query("SELECT a.user_id, a.kontak, b.user_id AS branch_id, b.kontak AS branch_name 
						FROM kontak a 
						LEFT JOIN kontak b ON a.branch_id = b.user_id 
						WHERE a.aktif = '1' 
						AND a.jenis = 'T001' 
						$branch_filter 
						ORDER BY b.kontak ASC, a.kontak ASC");


while ($data = $rs->fetch_assoc()) {
	$user_id = $data['user_id'];

	array_push($users, (object) [
		'user_id'		=> $data['user_id'],
		'kontak'		=> $data['kontak'],
		'branch_id'		=> $data['branch_id'],
		'branch_name'	=> $data['branch_name'],
	]);

	$presence[$user_id]['presence_count'] = 0;
	$presence[$user_id]['late_count'] = 0;
}

//get presence
$rs = $mysqli->query("SELECT a.* 
						FROM presence a 
						JOIN kontak b ON a.user_id = b.user_id 
						WHERE a.presence_date BETWEEN '$start' AND '$end' 
						$branch_filter 
						ORDER BY a.presence_date ASC");

while ($data = $rs->fetch_assoc()) {
	$user_id = $data['user_id'];
	$presence_date = $data['presence_date'];
	$note = $data['note'];

	$date = substr($presence_date, 0, 10);
	$time = substr($presence_date, 11, 5);

	if (isset($presence[$user_id][$date])) continue;

	$presence[$user_id]['presence_count'] += 1;

	if (Carbon::parse($time)->isAfter($maxPresenceTime)) {
		$presence[$user_id]['late_count'] += 1;
		$presence[$user_id][$date]['late'] = true;
	}

	$presence[$user_id][$date][0] = $time;
	$presence[$user_id][$date][1] = $note;
}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

		<title>Absensi</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}

			.info {
				text-decoration: underline;
				text-decoration-style: dotted;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h4 class="text-center mt-3">
				<font color="#2B9FDC">Absensi</font>
				<br />
				<small class="text-muted"><?=$start?> s/d <?=$end?></small>
			</h4>

			<table class="table table-hover table-sm table-responsive mt-3">
				<thead>
					<tr>
						<th scope="col" class="text-center text-nowrap align-middle">Nama</th>
						<th scope="col" class="text-center text-nowrap align-middle">Cabang</th>
						<th scope="col" class="text-center text-nowrap align-middle">Masuk</th>
						<th scope="col" class="text-center text-nowrap align-middle">Tidak Masuk</th>
						<th scope="col" class="text-center text-nowrap align-middle">Telat</th>
						<?php
							for ($i = 0; $i < $countDays; $i++) {
								?>
									<th scope="col" class="text-center text-nowrap">
										<?=$startDate->addDays($i)->format('j')?>
										<br />
										<?=$startDate->addDays($i)->format('D')?>
									</th>
								<?
							}
						?>
					</tr>
				</thead>

				<tbody>
					<?php
						foreach ($users as $user) {
							$user_id = $user->user_id;
							$presenceCount = $presence[$user_id]['presence_count'];
							$absenceCount = $countDays - $presence[$user_id]['presence_count'];
							$lateCount = $presence[$user_id]['late_count'];
							?>
								<tr>
									<td scope="row" class="text-nowrap"><?=$user->kontak?></td>
									<td scope="row" class="text-nowrap"><?=$user->branch_name?></td>
									<td scope="row" class="text-center"><?=$presenceCount?></td>
									<td scope="row" class="text-center"><?=$absenceCount?></td>
									<td scope="row" class="text-center"><?=$lateCount?></td>
									<?php
										for ($i = 0; $i < $countDays; $i++) {
											$date = $startDate->addDays($i)->format('Y-m-d');
											$time = $presence[$user_id][$date][0] ?? null;
											$note = $presence[$user_id][$date][1] ?? null;
											$isLate = $presence[$user_id][$date]['late'] ?? false;
											$tooltip = ($note != null) ? 'data-toggle="tooltip" data-placement="top" title="'.$note.'"' : '';
											$classLate = ($isLate) ? ' text-danger ' : '';
											$classTooltip = ($note != null) ? ' info ' : '';
											?>
												<td scope="row" class="text-center text-nowrap <?=$classLate?> <?=$classTooltip?> " <?=$tooltip?> >
													<?=$time?>
												</td>
											<?
										}
									?>
								</tr>
							<?php
						}
					?>
				</tbody>

				<!--
				<tfoot>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<th class="text-center text-nowrap"></th>
						<th class="text-nowrap"></th>
					</tr>
				</tfoot>
				-->
			</table>

		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha512-ubuT8Z88WxezgSqf3RLuNi5lmjstiJcyezx34yIU2gAHonIi27Na7atqzUZCOoY4CExaoFumzOsFQ2Ch+I/HCw==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>

		<script type="text/javascript">
			$(function () {
				$('[data-toggle="tooltip"]').tooltip();
			})
		</script>
	</body>
</html>
