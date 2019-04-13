<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "SELECT a.id, a.noreferensi, a.tgl, a.qty, a.info, a.processed, a.processed_info, 
					b.product_id, b.kode, b.barang, b.color, b.info AS supplier, e.jenis, 
					c.gudang, d.satuan 
				FROM terimabarang_r a 
				JOIN barang b ON b.product_id = a.product_id 
				JOIN gudang c ON c.kode = a.gudang 
				JOIN satuan d ON d.satuan_id = a.satuan_id 
				JOIN jenisbarang e ON e.brand_id = b.brand_id 
				WHERE a.id = $id";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
?>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#edit').submit(function() {
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
$(function()
  {
      $('#keterangan').wysiwyg();
  });
</script>
<style type="text/css">
#result{ 
	background-color: #F0FFED;
	border: 1px solid #215800;
	padding: 10px;
	width: 400px;
	margin-bottom: 20px;
	position:absolute;
	z-index:4;
	margin-left:30%;
}
a.close {
	float:right;
}
table, input, textarea, button {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}
table ul {
	padding:0;
	margin:0;
}
table ul li {
	padding-left:20px;
	list-style:none;	
}
</style>
<link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<h1> Edit Retur Penerimaan Barang</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
	<input type="hidden" name="product_id" value="<?=$row_edit['product_id']?>" />
    <input type="hidden" name="old_processed" value="<?=$row_edit['processed']?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">Tanggal *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="tgl" type="text" id="tgl" size="10" maxlength="10" value="<?php echo $row_edit['tgl'];?>" class="calendar"/>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Supplier</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><?php echo $row_edit['supplier'];?></td>
    </tr>
    <tr valign="top">
      <td align="right">Nama Barang</td>
      <td align="center">:</td>
      <td><?php if ($row_edit['kode'] != "") echo $row_edit['kode'] . " # ";?><?=$row_edit['jenis']?> # <?=$row_edit['barang']?> # <?=$row_edit['color']?></td>
    </tr>
    <tr valign="top">
      <td align="right">Jumlah Barang *</td>
      <td align="center">:</td>
      <td><label>
        <input name="qty" type="text" id="qty" value="<?php echo $row_edit['qty'];?>" size="6" maxlength="8" />
      </label> <?php echo $row_edit['satuan'];?>
      <input name="qtyold" type="hidden" id="qtyold" value="<?php echo $row_edit['qty'];?>" />
      <input name="stok" type="hidden" id="stok" value="<?php echo $row_edit['stok'];?>" />
      <input name="id" type="hidden" id="id" value="<?php echo $row_edit['id'];?>" />
      <input name="stokid" type="hidden" id="stokid" value="<?php echo $row_edit['stokid'];?>" /></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="85" rows="5"><?php echo $row_edit['info'];?></textarea>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Proses</td>
      <td align="center">:</td>
      <td>
      	<select name="processed" id="processed">
        	<option value="false" 
            <?php
				if ($row_edit['processed'] == "false") echo "selected='selected'";
            ?>>Belum</option>
            <option value="true"
            <?php
				if ($row_edit['processed'] == "true") echo "selected='selected'";
            ?>>Sudah</option>
        </select>
      </td>
    </tr>
    <tr valign="top">
      <td align="right">Proses Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="processed_info" id="processed_info" cols="85" rows="5"><?php echo $row_edit['processed_info'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan" />
      </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
        </label></td>
    </tr>
  </table>
</form>