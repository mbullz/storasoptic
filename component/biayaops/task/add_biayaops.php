<?php

global $mysqli;
global $c, $t;

$id = $_GET['id'] ?? 0;

// cara bayar
$query_cbyr = "SELECT * FROM carabayar";
$cbyr       = $mysqli->query($query_cbyr);
$row_cbyr   = mysqli_fetch_assoc($cbyr);
$total_cbyr = mysqli_num_rows($cbyr);

// get mata uang
$query_muang   = "SELECT * FROM matauang ORDER BY matauang";
$muang         = $mysqli->query($query_muang);
$row_muang     = mysqli_fetch_assoc($muang);
$total_muang   = mysqli_num_rows($muang);
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
    if ($('#branch_id').val() == 0) {
      alert('Pilih cabang terlebih dahulu sebelum menambahkan data');
    }
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
<h1>Biaya Operasional Baru</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right">No. Ref *</td>
      <td width="1%" align="center">:</td>
      <td width="82%"><label>
        <input name="referensi" type="text" id="referensi" value="BO-<?php echo date("His");?>" size="10" maxlength="10" readonly="readonly">
      </label>
      Tanggal * : <label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?php echo date("Y-m-d");?>" size="10" maxlength="10"/>
      </label></td>
    </tr>
    <tr>
      <td align="right">Jenis *</td>
      <td align="center">:</td>
      <td>
        <select name="jenis" id="jenis">
          <option value="BIAYA OPERASIONAL">BIAYA OPERASIONAL</option>
          <option value="BIAYA LISTRIK">BIAYA LISTRIK</option>
          <option value="BIAYA TELEPHONE">BIAYA TELEPHONE</option>
          <option value="BIAYA INTERNET">BIAYA INTERNET</option>
          <option value="BIAYA KONSUMSI">BIAYA KONSUMSI</option>
          <option value="BIAYA TRANSPORT">BIAYA TRANSPORT</option>
          <option value="BIAYA PENGIRIMAN">BIAYA PENGIRIMAN</option>
          <option value="BIAYA GAJI">BIAYA GAJI</option>
          <option value="BIAYA SERVICE CHARGE">BIAYA SERVICE CHARGE</option>
          <option value="BIAYA SEWA">BIAYA SEWA</option>
          <option value="BIAYA PENYUSUTAN">BIAYA PENYUSUTAN</option>
          <option value="BIAYA PARKIR">BIAYA PARKIR</option>
          <option value="BIAYA LAIN-LAIN">BIAYA LAIN-LAIN</option>
        </select>
      </td>
    </tr>
    <tr valign="top">
      <td align="right">Cara Pembayaran *</td>
      <td align="center">:</td>
      <td><label>
        <select name="bayar" id="bayar">
          <?php if($total_cbyr > 0) { do { ?>
          <option value="<?=$row_cbyr['carabayar_id']?>"><?=$row_cbyr['pembayaran']?></option>
          <?php }while($row_cbyr = mysqli_fetch_assoc($cbyr)); } ?>
        </select>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Jumlah Biaya *</td>
      <td align="center">:</td>
      <td><label>
        <input name="jumlah" type="number" id="jumlah" value="" size="10" />
      </label>
        <label>
          <select name="matauang" id="matauang">
            <?php if($total_muang > 0) { do { ?>
            <option value="<?=$row_muang['matauang_id']?>" <?php if($row_muang['kode']=='IDR') { ?>selected="selected"<?php } ?>><?php echo $row_muang['matauang'];?></option>
            <?php }while($row_muang = mysqli_fetch_assoc($muang)); } ?>
          </select>
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
      <input name="tipe" type="hidden" id="tipe" value="operasional" />
      <input type="hidden" name="id" id="id" />
      <input name="sisa" type="hidden" id="sisa" value="<?php echo $row_ghut['total'];?>" /></td>
    </tr>
  </table>
</form>