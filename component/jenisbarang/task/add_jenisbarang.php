<?php 
	global $mysqli;

	include('include/define.php');

	$id = $_GET['id'] ?? 0;

	if ($id != 0) {
		$t = 'edit';
		$title = 'Edit Brand';

		$rs = $mysqli->query("SELECT * FROM jenisbarang WHERE brand_id = $id");
		$data = $rs->fetch_assoc();

		$jenis = $data['jenis'];
		$info = $data['info'];
		$tipe = $data['tipe'];
	}
	else {
		$title = 'Tambah Brand';

		$jenis = '';
		$info = '';
		$tipe = 1;
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

<form action="component/<?=$c?>/p_<?=$c?>.php?p=<?=$t?>" method="post" name="add" id="add">

	<input type="hidden" name="brand_id" id="brand_id" value="<?=$id?>" />

	<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr>
				<td align="right" valign="top">Tipe</td>
				<td align="center" valign="top">:</td>
				<td valign="top">
						<select name="tipe" id="tipe">
								<option value="1" <?=($tipe == 1 ? 'selected' : '')?> >Frame</option>
								<option value="2" <?=($tipe == 2 ? 'selected' : '')?> >Softlens</option>
								<option value="3" <?=($tipe == 3 ? 'selected' : '')?> >Lensa</option>
								<option value="4" <?=($tipe == 4 ? 'selected' : '')?> >Accessories</option>
						</select>
				</td>
		</tr>
		<tr>
			<td align="right" valign="top">Nama Brand</td>
			<td align="center" valign="top">:</td>
			<td valign="top"><label>
				<input name="jenis" type="text" id="jenis" size="30" maxlength="100" value="<?=$jenis?>" />
			</label></td>
		</tr>
		<tr valign="top">
			<td align="right">Nama Supplier Brand</td>
			<td align="center">:</td>
			<td><label>
					<select name="info" id="info">
								<option value="">-- Choose Supplier --</option>
								<?php
										$rs2 = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'S001' ORDER BY kontak ASC");
										while ($data2 = mysqli_fetch_assoc($rs2))
										{
												?>
														<option value="<?=$data2['kontak']?>" 
															<?=($data2['kontak'] == $info ? 'selected' : '')?> >
															<?=$data2['kontak']?>
														</option>
												<?php
										}
								?>
						</select>
			</label></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
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
