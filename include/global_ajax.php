<?php
	session_start();
	include('config_db.php');

	$mode = $_POST['mode'] ?? '';

	switch ($mode) {
		case 'change_branch':
			$branch_id = $_POST['branch_id'] ?? 0;
			$_SESSION['branch_id'] = $branch_id;

			echo json_encode(array(
				'status'	=> 'success',
				'message'	=> 'Success',
			));

			break;
	}
?>
