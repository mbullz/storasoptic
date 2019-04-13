<?php include('include/define.php');?>
<?php
	$query_kar = "select a.kode, a.kontak from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi='karyawan' AND a.aktif='1' AND a.pass='' order by a.kode, a.kontak";
	$kar       = $mysqli->query($query_kar);
	$row_kar   = mysqli_fetch_assoc($kar);
	$total_kar = mysqli_num_rows($kar);
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
<h1>User Baru</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">Kontak *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="q_ajax" type="text" id="q_ajax" size="10" maxlength="30" onchange="getKaryawan(this.value);" value="Kode / Nama" onclick="this.value='';"/>
      </label>
        <label>
        <select name="nik" id="nik">
          <option value="">Pilih Kontak</option>
          <?php if($total_kar > 0) { do { ?>
          <option value="<?php echo $row_kar['kode'];?>"><?php echo $row_kar['nik'];?> - <?php echo $row_kar['kontak'];?></option>
          <?php }while($row_kar = mysqli_fetch_assoc($kar)); } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Password *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="password" type="password" id="password" size="20" maxlength="30" />
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Hak Akses</td>
      <td align="center" valign="top">:</td>
      <td valign="top">
      <div style="heights:220px;overflow:scroll">
      <table width="100%" border="0" cellspacing="1" cellpadding="4" class="datatable">
        <tr>
          <th width="20%" valign="top">Setting User</th>
<!--          <th width="20%" valign="top">Lokasi Gudang</th>
          <th width="20%" valign="top">Mata Uang</th>-->
          <th width="20%" valign="top">Satuan</th>
          <th width="20%" valign="top">Jenis Barang</th>
          <th width="20%" valign="top">Master Barang</th>
          </tr>
        <tr>
          <td valign="top">
            <label><input name="per[]" type="checkbox" id="per[]" value="user" /></label> 
            View Data<br /><label><input name="per[]" type="checkbox" id="per[]" value="add_user" /></label> 
            Add Data<br />
            <label>
              <input name="per[]2" type="checkbox" id="per[]2" value="edit_user" />
            </label>            Edit Data<br />
            <label><input name="per[]" type="checkbox" id="per[]" value="delete_user" /></label> 
            Delete Data
            <br /></td>
<!--          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="lokasigudang" />
          </label>
            View Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="add_lokasigudang" />
  </label>
            Add Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="edit_lokasigudang" />
  </label>
            Edit Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="delete_lokasigudang" />
  </label>
            Delete Data </td>-->
<!--          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="matauang" />
            </label>
            View Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="add_matauang" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_matauang" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_matauang" />
              </label>
            Delete Data </td>-->
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="satuan" />
            </label>
            View Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="add_satuan" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_satuan" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_satuan" />
              </label>
            Delete Data </td>
          <td valign="top"><label>
            </label>
            <input name="per[]" type="checkbox" id="per[]" value="jenisbarang" />
            <label>
            View Data<br />
              <input name="per[]" type="checkbox" id="per[]" value="add_jenisbarang" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_jenisbarang" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_jenisbarang" />
              </label>
            Delete Data </td>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="masterbarang" />
            </label>
            View Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="add_masterbarang" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_masterbarang" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_masterbarang" />
              </label>
            Delete Data </td>
          </tr>
        <tr>
          <th valign="top">Jenis Kontak</th>
          <th valign="top">Master Kontak</th>
          <th valign="top">Stok Barang</th>
          <th valign="top">Data Pembelian</th>
          </tr>
        <tr>
          <td valign="top"><label> </label>
            <input name="per[]" type="checkbox" id="per[]" value="jeniskontak" />
            <label> View Data<br />
              <input name="per[]" type="checkbox" id="per[]" value="add_jeniskontak" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_jeniskontak" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_jenisbarang" />
              </label>
            Delete Data </td>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="masterbarang" />
          </label>
            View Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="add_masterkontak" />
  </label>
            Add Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="edit_masterkontak" />
  </label>
            Edit Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="delete_masterkontak" />
  </label>
            Delete Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="detail_masterkontak" />
            </label>
Detail Data <br />
            </td>
            <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="stokbarang" />
            </label>
            View Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="add_stokbarang" />
              </label>
            Import Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_stokbarang" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_stokbarang" />
              </label>
            Delete Data </td>
            <td valign="top"><label> </label>
            <input name="per[]" type="checkbox" id="per[]" value="invoicepembelian" />
            <label> View Data<br />
              <input name="per[]" type="checkbox" id="per[]" value="add_invoicepembelian" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_invoicepembelian" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_invoicepembelian" />
              </label>
            Delete Data
          </tr>
        <tr>
          <th valign="top">Data Penjualan</th>
          <th valign="top">Penerimaan Barang</th>
          <th valign="top">Pengiriman Barang</th>
          <th valign="top">Pembayaran - Hutang</th>
        </tr>
        <tr>
          <td valign="top"><label> </label>
            <input name="per[]" type="checkbox" id="per[]" value="invoicepenjualan" />
            <label> View Data<br />
              <input name="per[]" type="checkbox" id="per[]" value="add_invoicepenjualan" />
            </label>
            Add Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="edit_invoicepenjualan" />
  </label>
            Edit Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="delete_invoicepenjualan" />
  </label>
            Delete Data<br />
  <label>
    </td>
          <td valign="top">
              <label>
              <input name="per[]" type="checkbox" id="per[]" value="barangmasuk_invoicepembelian" />
              </label>
            Penerimaan Barang <br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_barangmasuk" />
              </label>
            Edit Penerimaan Barang<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_barangmasuk" />
              </label>
            Delete Penerimaan Barang<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="barangreturmasuk" />
              </label>
            Retur Penerimaan Barang<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="barangreturmasuk_invoicepembelian" />
              </label>
            Add Retur Penerimaan Barang<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_barangreturmasuk" />
              </label>
            Edit Retur Penerimaan Barang<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_barangreturmasuk" />
              </label>
            Delete Retur Penerimaan Barang</td>
          </td>
          <td>
              <input name="per[]" type="checkbox" id="per[]" value="barangkeluar_invoicepenjualan" />
  </label>
            Pengiriman Barang<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="edit_barangkeluar" />
  </label>
            Edit Pengiriman Barang<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="delete_barangkeluar" />
  </label>
            Delete Pengiriman Barang<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="barangreturkeluar" />
  </label>
            Retur Pengiriman Barang<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="barangreturkeluar_invoicepembelian" />
  </label>
            Add Retur Pengiriman Barang<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="edit_barangreturkeluar" />
  </label>
            Edit Retur Pengiriman Barang<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="delete_barangreturmasuk" />
  </label>
            Delete Retur Pengiriman Barang
          </td>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="hutangjtempo" />
          </label> Hutang Jatuh Tempo <br /><label>
            <input name="per[]" type="checkbox" id="per[]" value="pembayaranhutang" />
          </label> Pembayaran Hutang <br /><label>
            <input name="per[]" type="checkbox" id="per[]" value="add_pembayaranhutang" />
          </label> Add Data<br /><label>
            <input name="per[]" type="checkbox" id="per[]" value="edit_pembayaranhutang" />
          </label> Edit Data<br /><label>
            <input name="per[]" type="checkbox" id="per[]" value="delete_pembayaranhutang" />
          </label> Delete Data</td>
        </tr>
        <tr>
          <th valign="top">Pembayaran - Piutang</th>
          <th valign="top">Biaya Operasional</th>
          <th valign="top">Cara Pembayaran</th>
          <th valign="top">Laporan</th>
          </tr>
        <tr>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="piutangjtempo" />
            </label>
            Piutang Jatuh Tempo <br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="pembayaranpiutang" />
              </label>
            Pembayaran Piutang <br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="add_pembayaranpiutang" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_pembayaranpiutang" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_pembayaranpiutang" />
              </label>
            Delete Data</td>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="biayaops" />
            </label>
            View Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="add_biayaops" />
              </label>
            Add Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="edit_biayaops" />
              </label>
            Edit Data<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="delete_biayaops" />
              </label>
            Delete Data </td>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="cbayar" />
          </label>
            View Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="add_cbayar" />
  </label>
            Add Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="edit_cbayar" />
  </label>
            Edit Data<br />
  <label>
    <input name="per[]" type="checkbox" id="per[]" value="delete_cbayar" />
  </label>
            Delete Data </td>
          <td valign="top"><label>
            <input name="per[]" type="checkbox" id="per[]" value="reportjualper_pm" />
            </label>
            Penjualan per Sales<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="reportjualper_customer" />
              </label>
            Penjualan per Customer<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]" value="reportjualper_barang" />
              </label>
            Penjualan per Barang<br />
            <label>
              <input name="per[]" type="checkbox" id="per[]3" value="reportrugilaba" />
              </label> 
            Rugi Laba Perusahaan
</td>
          </tr>
      </table>
      </div>
      </td>
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