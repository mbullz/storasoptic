<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from masukbarang where referensi='$id'";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// get supplier
$query_jkontak = "select a.kontak, a.kode, b.jenis from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi ='supplier' AND a.aktif='1' order by b.jenis, a.kontak";
$jkontak       = $mysqli->query($query_jkontak);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);
// get mata uang
$query_muang   = "select kode, matauang from matauang order by matauang";
$muang         = $mysqli->query($query_muang);
$row_muang     = mysqli_fetch_assoc($muang);
$total_muang   = mysqli_num_rows($muang);
// get masterbarang
$query_mbarang = "select a.kode, a.barang, b.jenis from barang a, jenisbarang b where a.jenis = b.kode order by b.jenis, a.barang";
$mbarang       = $mysqli->query($query_mbarang);
$row_mbarang   = mysqli_fetch_assoc($mbarang);
$total_mbarang = mysqli_num_rows($mbarang);
// getsatuan
$query_satuan = "select kode,satuan from satuan order by satuan";
$satuan       = $mysqli->query($query_satuan);
$row_satuan   = mysqli_fetch_assoc($satuan);
$total_satuan = mysqli_num_rows($satuan);
// list detail barang
$query_detbrg = "select a.id, a.qty, b.kode, b.barang, a.subtotal, a.harga, a.tdiskon, a.diskon, c.satuan, d.jenis from dmasukbarang a, barang b, satuan c, jenisbarang d where a.barang = b.kode AND a.satuan = c.kode AND b.jenis = d.kode AND a.noreferensi='$row_edit[referensi]' order by a.id desc";
$detbrg       = $mysqli->query($query_detbrg);
$row_detbrg   = mysqli_fetch_assoc($detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
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

function setTipePembayaran(val) {
    if (val == 1) { //cash
        $("#jtempo").attr('disabled', 'disabled');
    } else if (val == 2) { //jtempo
        $("#jtempo").removeAttr('disabled');
    }
}

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
<h1> Edit Pembelian</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. PO *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="invoice" type="text" id="invoice" value="<?php echo $row_edit['referensi'];?>" size="10" maxlength="10" onfocus="this.blur();" />
      </label><label>
        <select name="matauang" id="matauang">
          <option value="">Pilih Mata Uang</option>
          <?php if($total_muang > 0) { do { ?>
          <option value="<?php echo $row_muang['kode'];?>" <?php if($row_edit['matauang'] == $row_muang['kode']) { ?>selected="selected"<?php } ?>><?php echo $row_muang['matauang'];?></option>
          <?php }while($row_muang = mysqli_fetch_assoc($muang)); } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Tanggal *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?php echo $row_edit['tgl'];?>" size="10" maxlength="10"/>
      </label>
      </td>
    </tr>
    <tr>
        <td align="right" valign="top">Pembayaran *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select id="tipePembayaran" name="tipePembayaran" onchange="setTipePembayaran(this.value);">
                <option value="1" disabled="disabled">Cash</option>
                <option value="2">Jatuh Tempo</option>
            </select>
            <label>
                <input name="jtempo" type="text" class="calendar" id="jtempo" value="<?php echo date("Y-m-d");?>" size="10" maxlength="10" />
            </label>
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Supplier *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="supplier" id="supplier">
          <option value="">Pilih Supplier</option>
          <?php if($total_jkontak > 0) { do { ?>
          <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_jkontak['kode']==$row_edit['supplier']) { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['jenis'];?> - <?php echo $row_jkontak['kontak'];?></option>
          <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
        </select>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Detail Transaksi *</td>
      <td align="center">:</td>
      <td><div id="divManageInvoice">
        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
          <tr>
            <th>Nama Barang</th>
            <th width="6%">Qty</th>
            <th width="10%">Satuan</th>
            <th width="10%">Harga Satuan</th>
            <th width="14%">Pot. Diskon</th>
            <th width="10%">Sub Total</th>
            <th width="8%">Pengaturan</th>
          </tr>
          <?php if($total_detbrg > 0) { $gtotal = 0; do { ?>
        <tr valign="top">
          <td><?php echo $row_detbrg['jenis'];?> - <?php echo $row_detbrg['barang'];?></td>
          <td align="center"><?php echo $row_detbrg['qty'];?></td>
          <td align="center"><?php echo $row_detbrg['satuan'];?></td>
          <td align="right"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
          <td align="right"><?php if($row_detbrg['tdiskon']=='1') { echo $row_detbrg['diskon']." %"; }else{ echo number_format($row_detbrg['diskon'],0,',','.');}?></td>
          <td align="right"><?php echo number_format($row_detbrg['subtotal'],0,',','.'); $gtotal += $row_detbrg['subtotal'];?></td>
          <td width="10%" align="center"><a href="javascript:void(0);" onclick="manageInvoiceBeli('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
        </tr>
        <?php } while($row_detbrg = mysqli_fetch_assoc($detbrg)); ?>
        <tr valign="top">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">Grand Total :</td>
          <td align="right">&nbsp;</td>
          <td align="right"><?php echo number_format($gtotal,0,',','.');?></td>
          <td align="center"><input type="hidden" name="total" id="total" value="<?php echo $gtotal;?>"></td>
        </tr>
        <?php } ?>
          <tr valign="top">
            <td><label>
              <input name="qbrg" type="text" id="qbrg" size="16" maxlength="30" placeholder="Cari Master Barang ..." onchange="getMasterBarang(this.value);"/>
            </label>
              <label id="divMBarang">
                <select name="barang" id="barang">
                  <option value="">Pilih Master Barang</option>
                  <?php if($total_mbarang > 0) { do { ?>
                  <option value="<?php echo $row_mbarang['kode'];?>"><?php echo $row_mbarang['jenis'];?> - <?php echo $row_mbarang['barang'];?></option>
                  <?php }while($row_mbarang = mysqli_fetch_assoc($mbarang)); } ?>
                </select>
              </label></td>
            <td align="center"><label>
              <input name="qty" type="text" id="qty" size="4" maxlength="8" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.hsatuan.value; }else{ this.value=0;}"/>
            </label></td>
            <td align="center"><label>
              <select name="satuan" id="satuan">
                <option value="">Pilih Satuan</option>
                <?php if($total_satuan > 0) { do { ?>
                <option value="<?php echo $row_satuan['kode'];?>"><?php echo $row_satuan['satuan'];?></option>
                <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
              </select>
            </label></td>
            <td align="center"><label>
              <input name="hsatuan" type="text" id="hsatuan" size="10" maxlength="10" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.qty.value; }else{ this.value=0;}"/>
            </label></td>
            <td align="center"><label>
              <select name="tdiskon" id="tdiskon" style="font-size:9px;" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.form.diskon.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }">
                <option value="0">Normal</option>
                <option value="1">%</option>
              </select>
            </label>
              <label>
                <input name="diskon" type="text" id="diskon" size="8" maxlength="8" value="0" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }" style="font-size:9px;"/>
              </label></td>
            <td align="center"><label>
              <input name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value="0" onfocus="this.blur();" style="background:#DDD;border:solid 1px #BBB;"/>
            </label></td>
            <td align="center"><a href="javascript:void(0);" onclick="manageInvoiceBeli('add','');"><img src="images/add.png" border="0" /> Tambah</a></td>
          </tr>
        </table>
      </div></td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="85" rows="5"><?php echo $row_edit['info'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="right">Lunas</td>
      <td align="center" valign="top">:</td>
      <td><label>
        <input <?php if (!(strcmp($row_edit['lunas'],1))) {echo "checked=\"checked\"";} ?> name="lunas" type="checkbox" id="lunas" value="1" />
      </label>
        <small> Cek jika sudah lunas</small></td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan" />
      </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
        </label></td>
    </tr>
  </table>
</form>