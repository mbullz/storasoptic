<?php

	global $mysqli;

	include('include/define.php');

	$user_id = $_GET['id'] ?? 0;

	if ($user_id != 0) {
		$t = 'edit';
		$title = 'Edit';

		$rs = $mysqli->query("SELECT * FROM kontak WHERE user_id = $user_id");
		$data = $rs->fetch_assoc();

		$gender = $data['gender'];
		$kontak = $data['kontak'];
		$alamat = $data['alamat'];
		$mulai = $data['mulai'];
		$aktif = $data['aktif'];
		$notlp = $data['notlp'];
		$notlp2 = $data['notlp2'];
		$hp = $data['hp'];
		$email = $data['email'];
		$info = $data['info'];
	}
	else {
		$title = 'Tambah';

		$gender = '1';
		$kontak = '';
		$alamat = '';
		$mulai = date("Y-m-d");
		$aktif = '1';
		$notlp = '';
		$notlp2 = '';
		$hp = '';
		$email = '';
		$info = '';
	}

// get jenis kontak
$query_jkontak = "SELECT * FROM jeniskontak where klasifikasi = '$klas' ORDER BY jenis ASC";
$jkontak       = $mysqli->query($query_jkontak);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);
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
<h1><?=$title?> <?php echo ucfirst($klas);?></h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>&klas=<?php echo $klas;?>" method="post" name="add" id="add">
	<input type="hidden" name="kode" value="<?=$user_id?>" />
	<input type="hidden" name="klas" value="<?=$klas?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td width="12%" align="right" valign="top">Jenis Kontak *</td>
			<td width="1%" align="center" valign="top">:</td>
			<td width="15%" valign="top">
				<label>
					<input type="hidden" name="jenis" value="<?=$row_jkontak['kode']?>" />
					<?=$row_jkontak['jenis']?>
				</label>
			</td>
		<td width="12%" align="right" valign="top">&nbsp;</td>
			<td width="1%" valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
		</tr>
		<tr>
				<td align="right" valign="top">Nama <?php echo ucfirst($klas);?> *</td>
				<td valign="top">:</td>
				<td valign="top">
					<input name="kontak" type="text" id="kontak" size="30" maxlength="100" value="<?=$kontak?>" />
				</td>
				
				<?php if ($klas != 'supplier' && $klas != 'cabang'): ?>
					<td align="right" valign="top">Jenis Kelamin *</td>
					<td valign="top">:</td>
					<td>
						<label>
							<input type="radio" name="gender" value="1" <?=($gender == '1') ? 'checked' : ''?> />Laki-laki
						</label>
						<label>
							<input type="radio" name="gender" value="0" <?=($gender == '0') ? 'checked' : ''?> />Perempuan
						</label>
					</td>
				<?php endif; ?>
		</tr>
		
		<tr valign="top">
			<td align="right">Alamat *</td>
			<td align="center">:</td>
			<td colspan="4">
				<label>
					<textarea name="alamat" cols="85" rows="3" id="alamat"><?=$alamat?></textarea>
				</label>
			</td>
		</tr>
		<tr valign="top">
			<td align="right">Phone 1 *</td>
			<td align="center">:</td>
			<td><label>
				<input name="notlp" type="number" id="notlp" size="25" maxlength="100" value="<?=$notlp?>" />
			</label></td>
			<td align="right">Phone 2</td>
			<td>:</td>
			<td><label>
				<input name="notlp2" type="number" id="notlp2" size="25" maxlength="100" value="<?=$notlp2?>" />
			</label></td>
		</tr>

		<tr valign="top">
			<td align="right">Phone 3</td>
			<td align="center">:</td>
			<td><label>
				<input name="hp" type="number" id="hp" size="25" maxlength="100" value="<?=$hp?>" />
			</label></td>
			<td align="right">Email</td>
			<td>:</td>
			<td><label>
				<input name="email" type="email" id="email" size="30" maxlength="100" value="<?=$email?>" />
			</label></td>
		</tr>

		<tr valign="top">
			<td align="right">Keterangan</td>
			<td align="center">:</td>
			<td colspan="4"><label>
				<textarea name="info" id="info" cols="85" rows="5"><?=$info?></textarea>
			</label></td>
		</tr>
		<tr valign="top">
			<td align="right">Mulai Bergabung</td>
			<td align="center">:</td>
			<td>
				<label>
					<input name="mulai" type="text" id="mulai" value="<?=$mulai?>" class="calendar" />
				</label>
			</td>
			<td align="right">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="right">Status</td>
			<td align="center" valign="top">:</td>
			<td colspan="4">
				<label>
					<input name="status" type="radio" id="status_0" value="1" <?=($aktif == '1') ? 'checked' : ''?> />Aktif
				</label>
				<label>
					<input type="radio" name="status" value="0" id="status_1" <?=($aktif == '0') ? 'checked' : ''?> />Tidak Aktif
				</label>
			</td>
		</tr>
		<tr>
			<td><em>*diisi</em></td>
			<td align="center" valign="top">&nbsp;</td>
			<td colspan="4"><label>
				<input name="Save" type="submit" id="Save" value="Simpan">
			</label>
				<label>
					<input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
			</label></td>
		</tr>
	</table>
</form>