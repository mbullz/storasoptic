<?php
	$getval    = $_GET['val_'];
	include('../include/config_db.php');
	$query_kar = "select a.user_id, a.kontak from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi='karyawan' AND a.aktif='1' AND a.pass='' AND (a.kode LIKE '%$getval%' OR a.kontak LIKE '%$getval%') order by a.user_id, a.kontak";
	$kar       = $mysqli->query($query_kar);
	$row_kar   = mysqli_fetch_assoc($kar);
	$total_kar = mysqli_num_rows($kar);
?>
<select name="nik" id="nik">
  <option value="">Pilih Kontak</option>
  <?php if($total_kar > 0) { do { ?>
  <option value="<?php echo $row_kar['nik'];?>"><?php echo $row_kar['nik'];?> - <?php echo $row_kar['nama'];?></option>
  <?php }while($row_kar = mysqli_fetch_assoc($kar)); } ?>
</select>