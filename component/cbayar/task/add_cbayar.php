<?php 
  global $mysqli;

  include('include/define.php');

  $id = $_GET['id'] ?? 0;

  if ($id != 0) {
    $t = 'edit';
    $title = 'Edit Cara Pembayaran';

    // query edit
    $query_edit = "SELECT * FROM carabayar WHERE carabayar_id = $id";
    $edit = $mysqli->query($query_edit);
    $row_edit = mysqli_fetch_assoc($edit);
    $total_edit = mysqli_num_rows($edit);

    $pembayaran = $row_edit['pembayaran'];
    $info = $row_edit['info'];
  }
  else {
    $title = 'Tambah Cara Pembayaran';

    $pembayaran = '';
    $info = '';
  }
?>

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

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>

<h1><?=$title?></h1>

<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <input type="hidden" name="id" id="id" value="<?=$id?>" />

  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="14%" align="right" valign="top">Cara Pembayaran</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="85%" valign="top"><label>
        <input name="bayar" type="text" id="bayar" maxlength="100" size="50" value="<?=$pembayaran?>" />
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="75" rows="5"><?=$info?></textarea>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td><label>
        <input name="Save" type="submit" id="Save" value="Simpan">
      </label>
        <label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>
