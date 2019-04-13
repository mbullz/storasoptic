<?php

global $mysqli;
global $c, $t, $klas;

$keluarbarang_id = $_GET['id'];

// get jumlah hutang
$query_ghut = "SELECT * FROM keluarbarang WHERE keluarbarang_id = $keluarbarang_id ";
$ghut       = $mysqli->query($query_ghut);
$row_ghut   = mysqli_fetch_assoc($ghut);

  if ($klas != '') {
    $t = 'edit';
    $title = 'Edit Pembayaran';
    $aruskas_id = $klas;

    $rs = $mysqli->query("SELECT * FROM aruskas WHERE id = $aruskas_id");
    $data = $rs->fetch_assoc();

    $tgl = $data['tgl'];
    $carabayar_id = $data['carabayar_id'];
    $sisa = $data['jumlah'];
    $info = $data['info'];
  }
  else {
    $title = 'Pelunasan Piutang';
    $aruskas_id = 0;

    // get pembayaran
    $query_gbay = "SELECT SUM(jumlah) AS bayar FROM aruskas WHERE transaction_id = $keluarbarang_id AND tipe = 'piutang' ";
    $gbay       = $mysqli->query($query_gbay);
    $row_gbay   = mysqli_fetch_assoc($gbay);

    $tgl = date("Y-m-d");
    $carabayar_id = 0;
    $sisa = intval($row_ghut['total'] - $row_gbay['bayar']);
    $info = '';
  }

// cara bayar
$query_cbyr = "SELECT * FROM carabayar ORDER BY carabayar_id";
$cbyr       = $mysqli->query($query_cbyr);
$row_cbyr   = mysqli_fetch_assoc($cbyr);
$total_cbyr = mysqli_num_rows($cbyr);

?>

<input type="hidden" name="t" id="t" value="<?=$t?>" />

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
        var t = $('#t').val();

        if (t == 'add') {
          alert('Pembayaran piutang berhasil');
          window.location = 'index-c-piutangjtempo.pos';
        }
        else if (t == 'edit') {
          alert('Edit pembayaran berhasil');
          window.location = 'index-c-piutangjtempo.pos';
        }
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

<h1><?=$title?></h1>

<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?=$t?>" method="post" name="add" id="add">
  <input type="hidden" name="keluarbarang_id" id="keluarbarang_id" value="<?=$keluarbarang_id?>" />
  <input type="hidden" name="referensi" id="referensi" value="<?=$row_ghut['referensi']?>" />
  <input type="hidden" name="id" id="id" value="<?=$aruskas_id?>" />

  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. INV *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top">
        <label>
          <input name="referensi" type="text" id="referensi" value="<?=$row_ghut['referensi']?>" size="15" readonly="readonly">
        </label>
      Tanggal * : <label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?=$tgl?>" size="10" maxlength="10"/>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Cara Pembayaran *</td>
      <td align="center">:</td>
      <td><label>
        <select name="bayar" id="bayar">
          <?php
            if ($total_cbyr > 0) {
              do {
                ?>
                  <option value="<?=$row_cbyr['carabayar_id']?>" 
                  <?=$row_cbyr['carabayar_id'] == $carabayar_id ? 'selected="selected"' : ''?> >
                    <?php echo $row_cbyr['pembayaran'];?>
                  </option>
                <?php
              }
              while ($row_cbyr = mysqli_fetch_assoc($cbyr));
            }
          ?>
        </select>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Jumlah Pembayaran *</td>
      <td align="center">:</td>
      <td><label>
        <input type="number" name="jumlah" id="jumlah" value="<?=$sisa?>" size="10" maxlength="11" />
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="85" rows="5"><?=$info?></textarea>
      </label></td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%">
        <label>
          <input name="Save" type="submit" id="Save" value="Simpan">
        </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
        </label>
      <input type="hidden" name="sisa" id="sisa" value="<?php echo $row_ghut['total'];?>" /></td>
    </tr>
  </table>
</form>