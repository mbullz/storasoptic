<?php include('include/define.php');?>
<?php
$id = str_replace("_","-",$_GET['id']);
// cara bayar
$query_cbyr = "select kode, pembayaran from carabayar where tipe <>'Penjualan' order by pembayaran";
$cbyr       = $mysqli->query($query_cbyr);
$row_cbyr   = mysqli_fetch_assoc($cbyr);
$total_cbyr = mysqli_num_rows($cbyr);
// get jumlah hutang
$query_ghut = "select total from masukbarang where referensi='$id'";
$ghut       = $mysqli->query($query_ghut);
$row_ghut   = mysqli_fetch_assoc($ghut);
// get pembayaran
$query_gbay = "select sum(jumlah) as bayar from aruskas where referensi='$id'";
$gbay       = $mysqli->query($query_gbay);
$row_gbay   = mysqli_fetch_assoc($gbay);
// ---
$sisa       = intval($row_ghut['total'] - $row_gbay['bayar']);
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
<h1>Pembayaran Hutang Baru</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. PO *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="referensi" type="text" id="referensi" value="<?php echo $id;?>" size="10" maxlength="10" readonly="readonly">
      </label>
      Tanggal * : <label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?php echo date("Y-m-d");?>" size="10" maxlength="10"/>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Cara Pembayaran *</td>
      <td align="center">:</td>
      <td><label>
        <select name="bayar" id="bayar">
          <option value="">Cara Pembayaran</option>
          <?php if($total_cbyr > 0) { do { ?>
          <option value="<?php echo $row_cbyr['kode'];?>"><?php echo $row_cbyr['pembayaran'];?></option>
          <?php }while($row_cbyr = mysqli_fetch_assoc($cbyr)); } ?>
        </select>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Jumlah Pembayaran *</td>
      <td align="center">:</td>
      <td><label>
        <input name="jumlah" type="text" id="jumlah" value="<?php echo $sisa;?>" size="10" maxlength="11" />
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
      </label>
      <input name="opr" type="hidden" id="opr" value="<?php echo $_SESSION['i_sesadmin'];?>" />
      <input name="tipe" type="hidden" id="tipe" value="hutang" />
      <input type="hidden" name="id" id="id" />
      <input name="sisa" type="hidden" id="sisa" value="<?php echo $row_ghut['total'];?>" /></td>
    </tr>
  </table>
</form>