<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from carabayar where kode='$id'";
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
<h1> Edit Cara Pembayaran</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td align="right" valign="top">Kode *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="kode" type="text" id="kode" onfocus="this.blur();" value="<?php echo $row_edit['kode'];?>" size="8" maxlength="10"/>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Tipe</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input <?php if (!(strcmp($row_edit['tipe'],"Pembelian"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipe" value="Pembelian" id="tipe_0" />
        Pembelian</label>
        <label>
          <input <?php if (!(strcmp($row_edit['tipe'],"Penjualan"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipe" value="Penjualan" id="tipe_1" />
          Penjualan</label>
        <label>
<input <?php if (!(strcmp($row_edit['tipe'],"Semua"))) {echo "checked=\"checked\"";} ?> type="radio" name="tipe" value="Semua" id="tipe_2" />
          Semua</label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Cara Pembayaran *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="bayar" type="text" id="bayar" value="<?php echo $row_edit['pembayaran'];?>" size="40" maxlength="100" />
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="85" rows="5"><?php echo $row_edit['info'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td width="12%"><em>*diisi</em></td>
      <td width="1%" align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan">
      </label>
        <label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>