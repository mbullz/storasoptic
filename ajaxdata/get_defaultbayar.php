<?php
include('../include/config_db.php');
	$g_id = explode("*|*",$_GET['id']);
	$id   = $g_id[0];
	$nom  = $_GET['nominal'];
	if($id <>'') {
		$query_gbayar = "select klaim from alokasimedis where id='$id'";
		$gbayar = $mysqli->query($query_gbayar);
		$row_gbayar = mysqli_fetch_assoc($gbayar);
		$d_bayar = round(($row_gbayar['klaim'] * $nom) / 100);
	}
?>
<label><input name="bayar" type="text" id="bayar" value="<?php echo $d_bayar;?>" size="10" maxlength="10" /> IDR</label>