<?php
	global $mysqli;

	include('include/define.php');

$id = $_GET['id'];

// query edit
$query_edit = "SELECT * FROM kontak WHERE user_id = $id ";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// --
$query_kar = "SELECT a.user_id, a.kontak 
				FROM kontak a 
				JOIN jeniskontak b ON b.kode = a.jenis 
				WHERE b.klasifikasi LIKE 'karyawan' 
				AND a.aktif LIKE '1' 
				ORDER BY a.user_id, a.kontak ";
$kar = $mysqli->query($query_kar);
$row_kar = mysqli_fetch_assoc($kar);
$total_kar = mysqli_num_rows($kar);
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

input[type='checkbox'] {
	margin-bottom: 10px;
}

</style>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<h1>Edit User</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
	<input type="hidden" name="user_id" id="user_id" value="<?=$id?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td width="12%" align="right" valign="top">Karyawan</td>
			<td width="1%" align="center" valign="top">:</td>
			<td width="82%" valign="top">
				<label>
					<?=$row_edit['kontak']?>
				</label>
			</td>
		</tr>
		<tr>
			<td align="right" valign="top">Hak Akses</td>
			<td align="center" valign="top">:</td>
			<td valign="top"><div style="heights:220px;overflow:scroll">
				<table width="100%" border="0" cellspacing="1" cellpadding="4" class="datatable">
					<tr>
						<th valign="top">Setting User</th>
						<th valign="top">Satuan</th>
						<th valign="top">Jenis Barang</th>
						<th valign="top">Master Barang</th>
						</tr>
					<tr>
						<td width="25%" valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="user" <?php if(strstr($row_edit['akses'],'user')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_user" <?php if(strstr($row_edit['akses'],'add_user')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_user" <?php if(strstr($row_edit['akses'],'edit_user')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_user" <?php if(strstr($row_edit['akses'],'delete_user')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data</td>
						<td width="25%" valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="satuan" <?php if(strstr($row_edit['akses'],'satuan')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_satuan" <?php if(strstr($row_edit['akses'],'add_satuan')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_satuan" <?php if(strstr($row_edit['akses'],'edit_satuan')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_satuan" <?php if(strstr($row_edit['akses'],'delete_satuan')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data </td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="jenisbarang" <?php if(strstr($row_edit['akses'],'jenisbarang')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_jenisbarang" <?php if(strstr($row_edit['akses'],'add_jenisbarang')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_jenisbarang" <?php if(strstr($row_edit['akses'],'edit_jenisbarang')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_jenisbarang" <?php if(strstr($row_edit['akses'],'delete_jenisbarang')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data </td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="masterbarang" <?php if(strstr($row_edit['akses'],'masterbarang')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_masterbarang" <?php if(strstr($row_edit['akses'],'add_masterbarang')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_masterbarang" <?php if(strstr($row_edit['akses'],'edit_masterbarang')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_masterbarang" <?php if(strstr($row_edit['akses'],'delete_masterbarang')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data</td>
						</tr>
					<tr>
						<th valign="top">Jenis Kontak</th>
						<th valign="top">Master Kontak</th>
						<th valign="top">Stok Barang</th>
						<th valign="top">Data Pembelian</th>
						</tr>
					<tr>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="jeniskontak" <?php if(strstr($row_edit['akses'],'jeniskontak')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_jeniskontak" <?php if(strstr($row_edit['akses'],'add_jeniskontak')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_jeniskontak" <?php if(strstr($row_edit['akses'],'edit_jeniskontak')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_jeniskontak" <?php if(strstr($row_edit['akses'],'delete_jeniskontak')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data </td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="masterkontak" <?php if(strstr($row_edit['akses'],'masterkontak')) { ?>checked="checked"<?php } ?>/>
						
							View Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="add_masterkontak" <?php if(strstr($row_edit['akses'],'add_masterkontak')) { ?>checked="checked"<?php } ?>/>
	
							Add Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_masterkontak" <?php if(strstr($row_edit['akses'],'edit_masterkontak')) { ?>checked="checked"<?php } ?>/>
	
							Edit Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_masterkontak" <?php if(strstr($row_edit['akses'],'delete_masterkontak')) { ?>checked="checked"<?php } ?>/>
	
							Delete Data<br />
							
								<input name="per[]" type="checkbox" id="per[]6" value="detail_masterkontak" <?php if(strstr($row_edit['akses'],'detail_masterkontak')) { ?>checked="checked"<?php } ?>/>
							
Detail Data <br />
							</td>
							<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="stokbarang" <?php if(strstr($row_edit['akses'],'stokbarang')) { ?>checked="checked"<?php } ?>/>
						
							View Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="add_stokbarang" <?php if(strstr($row_edit['akses'],'add_stokbarang')) { ?>checked="checked"<?php } ?>/>
	 Import Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_stokbarang" <?php if(strstr($row_edit['akses'],'edit_stokbarang')) { ?>checked="checked"<?php } ?>/>
	
							Edit Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_stokbarang" <?php if(strstr($row_edit['akses'],'delete_stokbarang')) { ?>checked="checked"<?php } ?>/>
	
							Delete Data </td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="invoicepembelian" <?php if(strstr($row_edit['akses'],'invoicepembelian')) { ?>checked="checked"<?php } ?>/>
						
							View Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="add_invoicepembelian" <?php if(strstr($row_edit['akses'],'add_invoicepembelian')) { ?>checked="checked"<?php } ?>/>
	
							Add Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_invoicepembelian" <?php if(strstr($row_edit['akses'],'edit_invoicepembelian')) { ?>checked="checked"<?php } ?>/>
	
							Edit Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_invoicepembelian" <?php if(strstr($row_edit['akses'],'delete_invoicepembelian')) { ?>checked="checked"<?php } ?>/>
	
							Delete Data<br />
	</td>
						</tr>
					<tr>
						<th valign="top">Data Penjualan</th>
						<th valign="top">Penerimaan Barang</th>
						<th valign="top">Pengiriman Barang</th>
						<th valign="top">Pembayaran - Hutang</th>
						</tr>
					<tr>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="invoicepenjualan" <?php if(strstr($row_edit['akses'],'invoicepenjualan')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_invoicepenjualan" <?php if(strstr($row_edit['akses'],'add_invoicepenjualan')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_invoicepenjualan" <?php if(strstr($row_edit['akses'],'edit_invoicepenjualan')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_invoicepenjualan" <?php if(strstr($row_edit['akses'],'delete_invoicepenjualan')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data<br />
							</td>
						<td valign="top">
								<input name="per[]" type="checkbox" id="per[]" value="barangmasuk_invoicepembelian" <?php if(strstr($row_edit['akses'],'barangmasuk_invoicepembelian')) { ?>checked="checked"<?php } ?>/>
	
							Penerimaan Barang<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_barangmasuk" <?php if(strstr($row_edit['akses'],'edit_barangmasuk')) { ?>checked="checked"<?php } ?>/>
	
							Edit Penerimaan Barang<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_barangmasuk" <?php if(strstr($row_edit['akses'],'delete_barangmasuk')) { ?>checked="checked"<?php } ?>/>
	
							Delete Penerimaan Barang<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="barangreturmasuk" <?php if(strstr($row_edit['akses'],'barangreturmasuk')) { ?>checked="checked"<?php } ?>/>
	
							Retur Penerimaan Barang<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="barangreturmasuk_invoicepembelian" <?php if(strstr($row_edit['akses'],'barangreturmasuk_invoicepembelian')) { ?>checked="checked"<?php } ?>/>
	
							Add Retur Penerimaan Barang<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_barangreturmasuk" <?php if(strstr($row_edit['akses'],'edit_barangreturmasuk')) { ?>checked="checked"<?php } ?>/>
	
							Edit Retur Penerimaan Barang<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_barangreturmasuk" <?php if(strstr($row_edit['akses'],'delete_barangreturmasuk')) { ?>checked="checked"<?php } ?>/>
	
							Delete Retur Penerimaan Barang
						</td>
						<td valign="top">
								
								<input name="per[]" type="checkbox" id="per[]" value="barangkeluar_invoicepenjualan" <?php if(strstr($row_edit['akses'],'barangkeluar_invoicepenjualan')) { ?>checked="checked"<?php } ?>/>
								
							Pengiriman Barang<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_barangkeluar" <?php if(strstr($row_edit['akses'],'edit_barangkeluar')) { ?>checked="checked"<?php } ?>/>
								
							Edit Pengiriman Barang<br />
							
								<input name="per[]3" type="checkbox" id="per[]4" value="delete_barangkeluar" <?php if(strstr($row_edit['akses'],'delete_barangmasuk')) { ?>checked="checked"<?php } ?>/>
								
							Delete Pengiriman Barang <br />
							
								<input name="per[]" type="checkbox" id="per[]" value="barangreturkeluar" <?php if(strstr($row_edit['akses'],'barangreturkeluar')) { ?>checked="checked"<?php } ?>/>
								
							Retur Pengiriman Barang<br />
							
								<input name="per[]4" type="checkbox" id="per[]5" value="barangreturkeluar_invoicepenjualan" <?php if(strstr($row_edit['akses'],'barangreturkeluar_invoicepenjualan')) { ?>checked="checked"<?php } ?>/>
								
							Add Retur Pengiriman Barang<br />
							
								<input name="per[]4" type="checkbox" id="per[]" value="edit_barangreturkeluar" <?php if(strstr($row_edit['akses'],'edit_barangreturkeluar')) { ?>checked="checked"<?php } ?>/>
								
							Edit Retur Pengiriman Barang<br />
							
								<input name="per[]4" type="checkbox" id="per[]" value="delete_barangreturkeluar" <?php if(strstr($row_edit['akses'],'delete_barangreturkeluar')) { ?>checked="checked"<?php } ?>/>
								
							Delete Retur Pengiriman Barang
						</td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="hutangjtempo" <?php if(strstr($row_edit['akses'],'hutangjtempo')) { ?>checked="checked"<?php } ?>/>
						
							Hutang Jatuh Tempo <br />
	
		<input name="per[]" type="checkbox" id="per[]" value="pembayaranhutang" <?php if(strstr($row_edit['akses'],'pembayaranhutang')) { ?>checked="checked"<?php } ?>/>
	
							Pembayaran Hutang <br />
	
		<input name="per[]" type="checkbox" id="per[]" value="add_pembayaranhutang" <?php if(strstr($row_edit['akses'],'add_pembayaranhutang')) { ?>checked="checked"<?php } ?>/>
	
							Add Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_pembayaranhutang" <?php if(strstr($row_edit['akses'],'edit_pembayaranhutang')) { ?>checked="checked"<?php } ?>/>
	
							Edit Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_pembayaranhutang" <?php if(strstr($row_edit['akses'],'delete_pembayaranhutang')) { ?>checked="checked"<?php } ?>/>
	
							Delete Data</td>
						</tr>
					<tr>
						<th valign="top">Pembayaran - Piutang</th>
						<th valign="top">Biaya Operasional</th>
						<th valign="top">Cara Pembayaran</th>
						<th valign="top">Laporan</th>
						</tr>
					<tr>
						<td valign="top">
							
							
								<input name="per[]" type="checkbox" id="per[]" value="piutangjtempo" <?php if(strstr($row_edit['akses'],'piutangjtempo')) { ?>checked="checked"<?php } ?> /> Piutang Jatuh Tempo 
							
							
							<br />
							
							
								<input name="per[]" type="checkbox" id="per[]" value="pembayaranpiutang" <?php if(strstr($row_edit['akses'],'pembayaranpiutang')) { ?>checked="checked"<?php } ?>/> Pembayaran Piutang 
							
							
							<br />

							
								<input name="per[]" type="checkbox" id="per[]" value="add_pembayaranpiutang" <?php if(strstr($row_edit['akses'],'add_pembayaranpiutang')) { ?>checked="checked"<?php } ?>/>
							
							Add Data

							<br />
							
							
		<input name="per[]" type="checkbox" id="per[]" value="edit_pembayaranpiutang" <?php if(strstr($row_edit['akses'],'edit_pembayaranpiutang')) { ?>checked="checked"<?php } ?>/>
	
							Edit Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_pembayaranpiutang" <?php if(strstr($row_edit['akses'],'delete_pembayaranpiutang')) { ?>checked="checked"<?php } ?>/>
	
							Delete Data</td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="biayaops" <?php if(strstr($row_edit['akses'],'biayaops')) { ?>checked="checked"<?php } ?>/>
							
							View Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="add_biayaops" <?php if(strstr($row_edit['akses'],'add_biayaops')) { ?>checked="checked"<?php } ?>/>
								
							Add Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="edit_biayaops" <?php if(strstr($row_edit['akses'],'edit_biayaops')) { ?>checked="checked"<?php } ?>/>
								
							Edit Data<br />
							
								<input name="per[]" type="checkbox" id="per[]" value="delete_biayaops" <?php if(strstr($row_edit['akses'],'delete_biayaops')) { ?>checked="checked"<?php } ?>/>
								
							Delete Data </td>
						<td valign="top">
							<input name="per[]" type="checkbox" id="per[]" value="cbayar" <?php if(strstr($row_edit['akses'],'cbayar')) { ?>checked="checked"<?php } ?>/>
						
							View Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="add_cbayar" <?php if(strstr($row_edit['akses'],'add_cbayar')) { ?>checked="checked"<?php } ?>/>
	
							Add Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="edit_cbayar" <?php if(strstr($row_edit['akses'],'edit_cbayar')) { ?>checked="checked"<?php } ?>/>
	
							Edit Data<br />
	
		<input name="per[]" type="checkbox" id="per[]" value="delete_cbayar" <?php if(strstr($row_edit['akses'],'delete_cbayar')) { ?>checked="checked"<?php } ?>/>
	
							Delete Data </td>

						<td valign="top">
							<!--
							<input name="per[]" type="checkbox" id="per[]" value="reportjualper_pm" <?php if(strstr($row_edit['akses'],'reportjualper_pm')) { ?>checked="checked"<?php } ?>/> Penjualan per Sales<br />
							<input name="per[]" type="checkbox" id="per[]" value="reportjualper_customer" <?php if(strstr($row_edit['akses'],'reportjualper_customer')) { ?>checked="checked"<?php } ?>/> Penjualan per Customer<br />
							<input name="per[]" type="checkbox" id="per[]" value="reportjualper_barang" <?php if(strstr($row_edit['akses'],'reportjualper_barang')) { ?>checked="checked"<?php } ?>/> Penjualan per Barang<br />
							<input name="per[]" type="checkbox" id="per[]3" value="reportrugilaba" <?php if(strstr($row_edit['akses'],'reportrugilaba')) { ?>checked="checked"<?php } ?>/> Rugi Laba Perusahaan
							-->
							<input name="per[]" type="checkbox" id="per[]" value="report_all" <?php if(strstr($row_edit['akses'],'report_all')) echo 'checked="checked"'; ?> /> Laporan
						</td>
					</tr>
				</table>
			</div></td>
		</tr>
		<tr>
			<td><em>*diisi</em></td>
			<td align="center" valign="top">&nbsp;</td>
			<td width="82%">
				<label>
					<input name="Save" type="submit" id="Save" value="Simpan" />
				</label>
				<label>
					<input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
			</label></td>
		</tr>
	</table>
</form>