<?php
	$getval    = $_GET['val_'];
	include('../include/config_db.php');
	// get karyawan
	$query_browse = "select a.nik, a.nama from hos_karyawan a, hos_jabatan b d where a.jabatan = b.kode AND (a.nik LIKE '%$getval%' OR a.nama LIKE '%$getval%' OR b.jabatan LIKE '%$getval%') AND a.aktif='1' order by a.nama";
	$browse = $mysqli->query($query_browse);
	$row_browse = mysqli_fetch_assoc($browse);
	$total_browse = mysqli_num_rows($browse);
?>
Pencarian karyawan : <b><?php echo $getval;?></b>
<?php if($total_browse > 0) { ?>
<br />
<table width="100%" border="0" cellspacing="4" cellpadding="2">
  <tr>
  <?php $i = 1; do { ?>
    <td width="25%" style="border:solid 1px #b9dbe6;"><label>
      <input name="nik[]" type="checkbox" id="bnik[]" value="<?php echo $row_browse['nik'];?>">
    </label>
      <?php echo $row_browse['nik'];?> - <?php echo $row_browse['nama'];?></td>
  <?php if($i % 4 == 0) { ?></tr><tr><?php } $i++; ?>
  <?php }while($row_browse = mysqli_fetch_assoc($browse)); ?>
  </tr>
</table>
<?php } ?>