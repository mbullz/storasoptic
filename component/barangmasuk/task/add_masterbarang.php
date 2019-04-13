<?php include('include/define.php');?>
<?php
// get jenis barang
$query_jbarang = "select kode, jenis from jenisbarang order by jenis";
$jbarang       = $mysqli->query($query_jbarang);
$row_jbarang   = mysqli_fetch_assoc($jbarang);
$total_jbarang = mysqli_num_rows($jbarang);
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
<h1>Master Barang Baru</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">Kode *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="kode" type="text" id="kode" size="8" maxlength="10">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Jenis Barang *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="jenis" id="jenis">
          <option value="">Pilih Jenis Barang</option>
          <?php if($total_jbarang > 0) { do { ?>
          <option value="<?php echo $row_jbarang['kode'];?>"><?php echo $row_jbarang['jenis'];?></option>
          <?php }while($row_jbarang = mysqli_fetch_assoc($jbarang)); } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Nama Barang *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="barang" type="text" id="barang" size="30" maxlength="100">
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Barcode</td>
      <td align="center">:</td>
      <td><label>
        <input name="barcode" type="text" id="barcode" size="30" maxlength="100" />
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="85" rows="5"></textarea>
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