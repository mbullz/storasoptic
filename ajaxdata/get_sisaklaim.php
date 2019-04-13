<?php
	include('../include/config_db.php');
	$g_id = explode("*|*",$_GET['id']);
	$id   = $g_id[0];
	if($id <>'') { 
		// query_ sisaklaim
		$query_sklaim = "select sisa from alokasimedis where id='$id'";
		$sklaim = $mysqli->query($query_sklaim);
		$row_sklaim = mysqli_fetch_assoc($sklaim);
		$sisa_ = $row_sklaim['sisa'];
	}else{
		$sisa_ = 0;
	}
?>
<label><input name="klaim" type="text" id="klaim" value="<?php echo round($sisa_);?>" size="10" maxlength="10" onChange="getDefaultBayar();"/> IDR</label> <label><input name="dbay" type="checkbox" id="dbay" value="1" onClick="if(this.checked) { getDefaultBayar(); }"/> Default Bayar</label>