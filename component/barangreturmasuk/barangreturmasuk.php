<?php

global $mysqli;

$query_data  = "SELECT a.id, a.tgl, a.noreferensi, a.qty, a.info, a.processed, a.processed_info, 
					b.barang, c.gudang, d.satuan, b.info AS kontak, h.jenis, b.color 
				FROM terimabarang_r a 
				JOIN barang b ON a.product_id = b.product_id 
				JOIN gudang c ON a.gudang_id = c.gudang_id 
				JOIN satuan d ON a.satuan_id = d.satuan_id 
				JOIN jenisbarang h ON b.brand_id = h.brand_id 
				ORDER BY a.tgl DESC ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);
?>
<script type="text/javascript">
$(document).ready(function()
{
	$("#example").dataTable(
	{
		dom: 'T<"clear">lfrtip',
		tableTools:
		{
			"sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
		}
	});

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#formdata').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#result').html(data);
			}
		})
		return false;
	});
  $('#result').click(function(){
  $(this).hide();
  });
})
</script>
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Retur Penerimaan Barang</h1>
    
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
      <tr>
        <th width="2%" align="center"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="10%" align="center"><font color="#0000CC">TANGGAL</font></th>
		<th align="center"><font color="#0000CC">SUPPLIER</font></th>
        <th align="center"><font color="#0000CC">NAMA BARANG</font></th>
        <th width="10%" align="center"><font color="#0000CC">QTY</font></th>
        <th align="center"><font color="#0000CC">INFO</font></th>
        <th width="8%" align="center"><font color="#0000CC">PENGATURAN</font></th>
      </tr>
		</thead>
        
        <tbody>
      <?php $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['id'];?>" /></td>
        <td align="center"><?php genDate($row_data['tgl']);?></td>
        <td align="left"><?php echo $row_data['kontak'];?></td>
        <td align="left"><?php echo $row_data['jenis'];?> # <?php echo $row_data['barang'];?> # <?=$row_data['color']?></td>
        <td align="center"><?php echo $row_data['qty'];?> <?php echo $row_data['satuan'];?></td>
        <td align="left">
        	<?php
				if ($row_data['processed'] == "true")
				{
					?>
                    	<img src="images/done.png" />&nbsp;
                    <?php
				}
			?>
			<?php echo $row_data['info'];?>
            <?php
				if ($row_data['processed_info'] != "") echo " --> " . $row_data['processed_info'];
			?>
		</td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['id'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" />Edit</a><?php } ?></td>
        </tr>
      <?php } ?>
		</tbody>
	</table>

      <?php if(strstr($_SESSION['akses'],"delete_".$c)) { ?>
          <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
          <label>
          <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="return confirm('Lanjutkan Proses ... ?');"/>
        </label>
        <!--<a href="export_xls.php?tabel=terimabarang_r" title="Export Data XLS"><img src="images/_xls.png" width="20" height="20" border="0" align="right" /></a>-->
      <?php } ?>
      
  </div>
</form>