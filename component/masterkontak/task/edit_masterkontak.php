<?php

  global $mysqli;

  include('include/define.php');

$id = $_GET['id'];
// query edit
$query_edit = "select * from kontak where user_id='$id'";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// get jenis barang
$query_jkontak = "select kode, jenis from jeniskontak where klasifikasi='$klas' order by jenis";
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
<h1> Edit <?php echo ucfirst($klas);?></h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>&klas=<?php echo $klas;?>" method="post" name="edit" id="edit">
  <input type="hidden" name="kode" value="<?=$row_edit['user_id']?>" />
  <input type="hidden" name="klas" value="<?=$klas?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%"  align="right" valign="top">Jenis Kontak *</td>
      <td width="1%"  align="center" valign="top">:</td>
      <td width="15%"  valign="top"><label>
		<?php if ($total_jkontak == 1) { ?>
		<input type="hidden" name="jenis" value="<?php echo $row_jkontak['kode']; ?>" />
		<?php echo $row_jkontak['jenis']; ?>
		<?php } else { ?>
        <select name="jenis" id="jenis">
          <option value="">Pilih Jenis Kontak</option>
          <?php if($total_jkontak > 0) { do { ?>
          <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_jkontak['kode']==$row_edit['jenis']) { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['jenis'];?></option>
          <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
        </select>
		<?php } ?>
      </label></td>
      <td width="12%" align="right" valign="top">&nbsp;</td>
      <td width="1%" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
	<tr>
        <td align="right" valign="top">Nama <?php echo ucfirst($klas);?> *</td>
        <td valign="top">:</td>
        <td valign="top"><input name="kontak" type="text" id="kontak" size="30" maxlength="100" value="<?php echo $row_edit['kontak']; ?>" /></td>
        <?php if ($klas != 'supplier' && $klas != 'cabang') { ?>
        <td align="right" valign="top">Jenis Kelamin *</td>
        <td valign="top">:</td>
        <td>
            <label><input type="radio" name="gender" value="1" <?php echo ($row_edit['gender']=='1') ? "checked" : ""; ?> />Laki-laki</label>
            <label><input type="radio" name="gender" value="0" <?php echo ($row_edit['gender']=='0') ? "checked" : ""; ?> />Perempuan</label>
        </td>
        <?php } ?>
    </tr>
    <tr valign="top">
      <td align="right">Alamat *</td>
      <td align="center">:</td>
      <td colspan="4"><label>
        <textarea name="alamat" cols="85" rows="3" id="alamat"><?php echo $row_edit['alamat'];?></textarea>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">No. Telp</td>
      <td align="center">:</td>
      <td><label>
        <input name="notlp" type="text" id="notlp" value="<?php echo $row_edit['notlp'];?>" size="25" maxlength="100" />
      </label></td>
      <td align="right">No. Telp 2</td>
      <td>:</td>
      <td><label>
        <input name="notlp2" type="text" id="notlp2" value="<?php echo $row_edit['notlp2'];?>" size="25" maxlength="100" />
      </label></td>
    </tr>
    <?php /*<tr valign="top">
      <td align="right">Kontak Person</td>
      <td align="center">:</td>
      <td><label>
        <input name="kperson" type="text" id="kperson"  value="<?php echo $row_edit['kperson'];?>" size="30" maxlength="100" <?php if($klas=='karyawan' OR $klas=='sales') { ?>readonly="readonly" style="background:#EDEDED;border:solid 1px #D8D8D8;"<?php } ?>/>
      </label></td>
      <td align="right">Jabatan</td>
      <td>:</td>
      <td><label>
        <input name="jabatan" type="text" id="jabatan" value="<?php echo $row_edit['jabatan'];?>" size="30" maxlength="100" />
      </label></td>
    </tr> */ ?>
    <tr valign="top">
      <td align="right">PIN BB</td>
      <td align="center">:</td>
      <td><label>
        <input name="pinbb" type="text" id="pinbb" value="<?php echo $row_edit['pinbb'];?>" size="15" maxlength="30" />
      </label></td>
      <td align="right">Email</td>
      <td>:</td>
      <td><label>
        <input name="email" type="text" id="email" value="<?php echo $row_edit['email'];?>" size="30" maxlength="100" />
      </label></td>
    </tr>
    <?php /*<tr valign="top">
      <td align="right">Handphone</td>
      <td align="center">:</td>
      <td><label>
        <input name="hp" type="text" id="hp" value="<?php echo $row_edit['hp'];?>" size="15" maxlength="30" />
      </label></td>
      <td align="right">Fax</td>
      <td>:</td>
      <td><label>
        <input name="fax" type="text" id="fax" value="<?php echo $row_edit['fax'];?>" size="15" maxlength="30" />
      </label></td>
    </tr> */ ?>
    <tr valign="top">
      <td align="right">Keterangan Lain-lain</td>
      <td align="center">:</td>
      <td colspan="4"><label>
        <textarea name="info" id="info" cols="85" rows="5"><?php echo $row_edit['info'];?></textarea>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Mulai Bergabung</td>
      <td align="center">:</td>
      <td><label>
        <input name="mulai" type="text" id="mulai" value="<?php echo $row_edit['mulai'];?>" size="10" maxlength="10" class="calendar"/>
      </label></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Status</td>
      <td align="center" valign="top">:</td>
      <td colspan="4"><label>
        <input <?php if (!(strcmp($row_edit['aktif'],"1"))) {echo "checked=\"checked\"";} ?> name="status" type="radio" id="status_0" value="1" />
        Aktif </label>
        <label>
<input <?php if (!(strcmp($row_edit['aktif'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="status" value="0" id="status_1" />
          Tidak Aktif</label></td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td colspan="4"><label>
        <input name="Save" type="submit" id="Save" value="Simpan" />
      </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
        </label></td>
    </tr>
  </table>
</form>