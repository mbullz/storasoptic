<?php
	$getval    = $_GET['val_'];
	include('../include/config_db.php');
	$query_kar = "select nik, nama from karyawan where aktif='1' AND (nik LIKE '%$getval%' OR nama LIKE '%$getval%') order by nik, nama";
	$kar       = $mysqli->query($query_kar);
	$row_kar   = mysqli_fetch_assoc($kar);
	$total_kar = mysqli_num_rows($kar);
?>
<select name="leader" id="leader">
  <option value="">Pilih Karyawan</option>
  <?php if($total_kar > 0) { do { ?>
  <option value="<?php echo $row_kar['nik'];?>"><?php echo $row_kar['nik'];?> - <?php echo $row_kar['nama'];?></option>
  <?php }while($row_kar = mysqli_fetch_assoc($kar)); } ?>
</select>