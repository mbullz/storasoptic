<?php
	session_start();
	include('../../include/config_db.php');
	
    $stat = '';
	$url = "index-c-penjualanorder.pos";
	$id  = $_POST['keluarbarang_order_id'];
	
	$exe = $mysqli->query("UPDATE keluarbarang_order SET status = status + 1, updated_by = $_SESSION[user_id], updated_at = NOW() WHERE id = $id");

	if ($exe) {
		$stat = 'Success!';
	}
	else{
		$stat = 'Failed!';
	}
?>

<script type="text/javascript">
    alert('<?php echo $stat; ?>');
    <?php if ($exe) { ?>
    location.href = '<?=$base_url?><?php echo $url; ?>';
    <?php } ?>
</script>