<?php
include('../include/config_db.php');
$ajax_q = $mysqli->real_escape_string($_GET['q']);
$ajax_t = $mysqli->real_escape_string($_GET['t']);
// get masterbarang
$query_abarang = "select a.product_id, a.kode, a.barang, b.jenis, a.color from barang a join jenisbarang b on a.brand_id = b.brand_id where b.tipe = $ajax_t AND (b.brand_id LIKE '%$ajax_q%' OR b.jenis LIKE '%$ajax_q%' OR a.barang LIKE '%$ajax_q%') AND qty > 0 order by b.jenis, a.barang";
$abarang       = $mysqli->query($query_abarang);
$row_abarang   = mysqli_fetch_assoc($abarang);
$total_abarang = mysqli_num_rows($abarang);
?>
  
<select name="barang" id="barang" onchange="getDetailBarang(this.value);">
	<option value="">-- Choose Product --</option>
	<?php
    	if($total_abarang > 0)
		{
			do
			{
				?>
    				<option value="<?=$row_abarang['product_id']?>">
						<?php
							if ($row_abarang['kode'] != '') echo $row_abarang['kode'] . ' # ';
						?>
						<?=$row_abarang['jenis']?> # <?=$row_abarang['barang']?> # <?=$row_abarang['color']?>
					</option>
				<?php
			}
			while ($row_abarang = mysqli_fetch_assoc($abarang));
		}
	?>
</select>