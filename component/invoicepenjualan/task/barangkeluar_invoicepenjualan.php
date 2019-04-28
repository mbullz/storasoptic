<?php 
global $mysqli;
include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select a.noreferensi, a.qty, b.product_id, b.kode, b.barang, b.color, c.satuan_id as sid, c.satuan, d.jenis 
				from dkeluarbarang a 
				join barang b on b.product_id = a.product_id 
				join satuan c on c.satuan_id = a.satuan_id 
				join jenisbarang d on d.brand_id = b.brand_id 
				where a.id='$id'";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// terima barang
$query_terbrg = "select sum(qty) as kirim from kirimbarang where noreferensi='$row_edit[noreferensi]' AND barang='$row_edit[kode]' AND satuan='$row_edit[sid]'";
$terbrg       = $mysqli->query($query_terbrg);
$row_terbrg   = mysqli_fetch_assoc($terbrg);
// retur barang
$query_retur  = "select sum(qty) as retur from kirimbarang_r where noreferensi='$row_edit[noreferensi]' AND barang='$row_edit[kode]' AND satuan='$row_edit[sid]'";
$retur        = $mysqli->query($query_retur);
$row_retur    = mysqli_fetch_assoc($retur);
// ---
$kirim       = intval($row_terbrg['kirim'] - $row_retur['retur']);
// get matauang
$query_jkontak = "select kode, gudang from gudang order by gudang";
$jkontak       = $mysqli->query($query_jkontak);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);
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

	$('#add').submit(function() {
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
<h1>Pengiriman Barang Baru</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. Invoice *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="invoice" type="text" id="invoice" value="<?php echo $row_edit['noreferensi'];?>" size="20" onfocus="this.blur();">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Tanggal *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="tgl" type="text" id="tgl" size="10" maxlength="10" class="calendar" value="<?php echo date('Y-m-d'); ?>"/>
		<input type="hidden" name="gudang" id="gudang" value="<?php echo $row_jkontak['kode']; ?>" />
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Barang Info *</td>
      <td align="center">:</td>
      <td>
	  	<?php
			if ($row_edit['kode'] != "") echo $row_edit['kode'] . " # ";
		?><?php echo $row_edit['jenis'];?> # <?php echo $row_edit['barang'];?> # <?=$row_edit['color']?>
        <label>
          <input name="total" type="text" id="total" value="<?php echo intval($row_edit['qty'] - $kirim);?>" size="8" maxlength="10" />
        </label>
        <?php echo $row_edit['satuan'];?>
      <input name="barang" type="hidden" id="barang" value="<?php echo $row_edit['product_id'];?>" />
      <input name="satuan" type="hidden" id="satuan" value="<?php echo $row_edit['sid'];?>" /></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="75" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan">
      </label>
        <label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>