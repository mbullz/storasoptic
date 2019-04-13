<?php
include('../include/config_db.php');
$nik = $_GET['nik'];
$tgl = $_GET['tgl'];
if($tgl <>'') { 
	// ---
	$query_alokasi = "select a.id, b.kode, b.jenismedis from alokasimedis a, jenismedis b where a.nik = '$nik' AND a.jenismedis = b.kode AND a.mulai <='$tgl' AND a.sampai >='$tgl' order by b.jenismedis";
	$alokasi = $mysqli->query($query_alokasi);
	$row_alokasi = mysqli_fetch_assoc($alokasi);
	$total_alokasi = mysqli_num_rows($alokasi);
}
?>
<select name="jenismedis" id="jenismedis" onChange="getSisaKlaim(this.value);">
  <option value="">Pilih Jenis Medis</option>
  <?php if($total_alokasi > 0) { do { ?>
  <option value="<?php echo $row_alokasi['id'];?>*|*<?php echo $row_alokasi['kode'];?>"><?php echo $row_alokasi['jenismedis'];?></option>
  <?php }while($row_alokasi = mysqli_fetch_assoc($alokasi)); } ?>
</select>