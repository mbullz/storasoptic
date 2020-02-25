<?php
	session_start();
	include('config_db.php');

	$mode = $_POST['mode'] ?? '';

	switch ($mode) {
		case 'change_branch':
			$branch_id = $_POST['branch_id'] ?? 0;
			$_SESSION['branch_id'] = $branch_id;

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $branch_id) $_SESSION['global_discount'] = $r[1];
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount_lensa'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $branch_id) $_SESSION['global_discount_lensa'] = $r[1];
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount_softlens'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $branch_id) $_SESSION['global_discount_softlens'] = $r[1];
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount_accessories'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $branch_id) $_SESSION['global_discount_accessories'] = $r[1];
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'editable_price'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $branch_id) $_SESSION['editable_price'] = $r[1];
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'bpjs_promo_enabled'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				if ($r[0] == $branch_id) $_SESSION['bpjs_promo_enabled'] = $r[1];
			}

			$rs3 = $mysqli->query("SELECT * FROM config WHERE config = 'bpjs_promo_discount'");
			$data3 = $rs3->fetch_assoc();
			$temp = $data3['value'];
			$temp = explode('#', $temp);
			foreach ($temp AS $r) {
				$r = explode('_', $r);
				if (sizeof($r) <= 1) continue;

				$_SESSION['bpjs_promo_discount_' . $r[0]] = $r[1];
			}

			echo json_encode(array(
				'status'	=> 'success',
				'message'	=> 'Success',
			));

			break;

		case 'open_cash_drawer':
			system("cmd /c C:\\RP58\\open_cash_drawer.bat");
			break;
	}
?>
