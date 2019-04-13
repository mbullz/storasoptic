<?php
include('../include/config_db.php');
$dep = $_GET['departemen'];
$query_asub = "select * from subdepartemen where departemen='$dep' order by subdepartemen";
$asub       = $mysqli->query($query_asub);
$row_asub   = mysqli_fetch_assoc($asub);
$total_asub = mysqli_num_rows($asub);
?>
<select name="subdepartemen" id="subdepartemen">
<option value="all">Semua Sub Departemen</option>
<?php if($total_asub > 0) { do { ?>
<option value="<?php echo $row_asub['kode'];?>"><?php echo $row_asub['subdepartemen'];?></option>
<?php }while($row_asub = mysqli_fetch_assoc($asub)); } ?>
</select>