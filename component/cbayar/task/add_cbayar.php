<?php include('include/define.php');?>
<?php if($klas <>'importcsv') { ?>
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
<h1>Cara Pembayaran Baru</h1> 
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
      <td align="right" valign="top">Tipe</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
          <input type="radio" name="tipe" value="Pembelian" id="tipe_0" />
          Pembelian</label>
        <label>
          <input type="radio" name="tipe" value="Penjualan" id="tipe_1" />
        Penjualan</label>
        <label>
          <input name="tipe" type="radio" id="tipe_2" value="Semua" checked="checked" />
      Semua</label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Cara Pembayaran *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="bayar" type="text" id="bayar" size="40" maxlength="100">
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
<?php }else { ?>
<?php
if(isset($_POST['import'])) {  ?>
<div id="result">
<?php
  $file = $_FILES['fcsv']['name'];
  $ext_f= explode(".",$file);
  $ext  = $ext_f[count($ext_f) - 1];
  if($ext <>'csv') {
	  echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">File bukan CSV, coba lagi !!!</b>";
  }else{
	  if (($handle = fopen($_FILES['fcsv']['tmp_name'], "r")) !== FALSE) { 
		$import = "insert into carabayar (kode,tipe,jenis,info) values ";
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($data[0] <>'kode') {
				$import .= "('$data[0]','$data[1]','$data[2]','$data[3]'),";
			}
		}
		$import .=",";
	  }
	  $query_import = str_replace(",,",";",$import);
	  $result = $mysqli->query($query_import) or die(mysql_error());
	  if(!$result) {
		echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Import CSV gagal, coba lagi !!!</b>";  
	  }else{
		echo "<img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Import CSV berhasil ...</b>";
		echo "<script type=\"text/javascript\">setTimeout(\"location.href='index-c-jenisbarang-t-add-k-importcsv.pos'\", 2000);</script>";
	  }
  }
?>
</div>
<?php } ?>
<h1>Import Cara Pembayaran (CSV)</h1> 
<form action="" method="post" enctype="multipart/form-data" name="import" id="import" onsubmit="return confirm('Lanjutkan Import CSV ?');">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right">Pilih CSV </td>
      <td width="1%" align="center">:</td>
      <td width="82%"><label>
        <input type="file" name="fcsv" id="fcsv" />
      </label> 
        [ <a href="formatcsv/carabayar.csv">Format data</a> ]</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="import" id="import" value="Import CSV" />
      </label><label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>
<?php } ?>