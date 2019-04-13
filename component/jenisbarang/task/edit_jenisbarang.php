<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from jenisbarang where brand_id=$id";
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
<h1>Edit Jenis Barang</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
	<input type="hidden" name="brand_id" id="brand_id" value="<?=$id?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td align="right" valign="top">Kode Brand</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="kode" type="text" id="kode" value="<?php echo $row_edit['kode'];?>" size="8" maxlength="10"/>
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top">Tipe *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select name="tipe" id="tipe">
                <option value="1" <?php echo ($row_edit['tipe'] == 1) ? 'selected' : ''; ?>>Frame</option>
                <option value="2" <?php echo ($row_edit['tipe'] == 2) ? 'selected' : ''; ?>>Softlens</option>
                <option value="3" <?php echo ($row_edit['tipe'] == 3) ? 'selected' : ''; ?>>Lensa</option>
                <option value="4" <?php echo ($row_edit['tipe'] == 4) ? 'selected' : ''; ?>>Accessories</option>
            </select>
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Nama Brand *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="jenis" type="text" id="jenis" value="<?php echo $row_edit['jenis'];?>" size="30" maxlength="100" />
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Nama Supplier Brand</td>
      <td align="center">:</td>
      <td><label>
        <select name="info" id="info">
        	<option value="">-- Choose Supplier --</option>
        	<?php
				$rs2 = $mysqli->query("SELECT kontak FROM kontak WHERE jenis LIKE 'S0001' ORDER BY kontak ASC");
				while ($data2 = mysqli_fetch_assoc($rs2))
				{
					?>
                    	<option value="<?=$data2['kontak']?>" 
                        <?php
							if ($row_edit['info'] == $data2['kontak']) echo "selected='selected'";
                        ?>><?=$data2['kontak']?></option>
                    <?php
				}
			?>
        </select>
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