<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from keluarbarang where referensi='$id'";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// get matauang
$query_jkontak = "select kode, matauang from matauang order by matauang";
$jkontak       = $mysqli->query($query_jkontak);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);
// get masterbarang
$query_mbarang = "select a.kode, a.barang, b.jenis from barang a join jenisbarang b on a.jenis = b.kode where qty > 0 and b.tipe=1 order by b.jenis, a.barang";
$mbarang       = $mysqli->query($query_mbarang);
$row_mbarang   = mysqli_fetch_assoc($mbarang);
$total_mbarang = mysqli_num_rows($mbarang);
// getsatuan
$query_satuan = "select kode,satuan from satuan order by satuan";
$satuan       = $mysqli->query($query_satuan);
$row_satuan   = mysqli_fetch_assoc($satuan);
$total_satuan = mysqli_num_rows($satuan);
// get client
$query_client = "select a.kode, a.kontak from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi ='customer' order by a.kontak";
$client       = $mysqli->query($query_client);
$row_client   = mysqli_fetch_assoc($client);
$total_client = mysqli_num_rows($client);
// get sales
$query_sales  = "select a.kode, a.kontak from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi ='sales' order by a.kontak";
$sales        = $mysqli->query($query_sales);
$row_sales    = mysqli_fetch_assoc($sales);
$total_sales  = mysqli_num_rows($sales);
// list detail barang
$query_detbrg = "select a.id,a.qty,b.kode,b.barang,a.subtotal,a.harga,a.tdiskon,a.diskon,a.frame,a.lensa,a.rSph,a.rCyl,a.rAxis,a.rAdd,a.rPd,a.lSph,a.lCyl,a.lAxis,a.lAdd,a.lPd,c.satuan,d.jenis from dkeluarbarang a join barang b on a.barang = b.kode join satuan c on a.satuan = c.kode join jenisbarang d on b.jenis = d.kode where a.noreferensi='$row_edit[referensi]' order by a.id desc";
$detbrg       = $mysqli->query($query_detbrg);
$row_detbrg   = mysqli_fetch_assoc($detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
// get down payment/uang muka
$query_uangmuka = "select * from aruskas where referensi='$row_edit[referensi]'";
$uangmuka       = $mysqli->query($query_uangmuka);
$row_uangmuka   = mysqli_fetch_assoc($uangmuka);
$total_uangmuka = mysqli_num_rows($uangmuka);
?>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript">
function refreshTipe() {
    var tipe = $("#tipe").val();
    $.ajax({
        url: 'component/masterbarang/task/ajax_masterbarang.php',
        type: 'GET',
        dataType: 'json',
        data: 'mode=get_barang&tipe=' + tipe,
        success: function(result) {
            var html = '<option value="">Pilih Type Brand</option>';
            for (i=0; i<result.length; i++) {
                html += '<option value="' + result[i].kode + '">' + result[i].kode + ' - ' + result[i].type_brand + ' - ' + result[i].barang + '</option>';
            }
            $("#barang").html(html);
        }
    });
}
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
<h1> Edit  Penjualan</h1> 
<?php /*<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. Invoice *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="invoice" type="text" id="invoice" value="<?php echo $row_edit['referensi'];?>" size="10" maxlength="10" onfocus="this.blur();" /></label><label>      
        <select name="matauang" id="matauang">
          <option value="">Pilih Mata Uang</option>
          <?php if($total_jkontak > 0) { do { ?>
          <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_edit['matauang'] == $row_jkontak['kode']) { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['matauang'];?></option>
          <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Tanggal *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?php echo $row_edit['tgl'];?>" size="10" maxlength="10"/>
      </label> 
        Jatuh Tempo * : 
        <label>
          <input name="jtempo" type="text" class="calendar" id="jtempo" value="<?php echo $row_edit['jtempo'];?>" size="10" maxlength="10"/>
        </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Customer - Sales *</td>
      <td align="center">:</td>
      <td><label>
        <select name="customer" id="customer">
          <option value="">Pilih Customer</option>
          <?php if($total_client > 0) { do { ?>
          <option value="<?php echo $row_client['kode'];?>" <?php if($row_client['kode']==$row_edit['client']) { ?>selected="selected"<?php } ?>><?php echo $row_client['kontak'];?></option>
          <?php }while($row_client = mysqli_fetch_assoc($client)); } ?>
        </select>
      </label>
        -
        <label>
          <select name="sales" id="sales">
            <option value="">Pilih Sales</option>
            <?php if($total_sales > 0) { do { ?>
            <option value="<?php echo $row_sales['kode'];?>" <?php if($row_sales['kode']==$row_edit['sales']) { ?>selected="selected"<?php } ?>><?php echo $row_sales['kontak'];?></option>
            <?php }while($row_sales = mysqli_fetch_assoc($sales)); } ?>
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
          <td><?php echo $row_detbrg['jenis'];?> -  <?php echo $row_detbrg['barang'];?></td>
          <td align="center"><?php echo $row_detbrg['qty'];?></td>
          <td align="center"><?php echo $row_detbrg['satuan'];?></td>
          <td align="right"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
          <td align="right"><?php if($row_detbrg['tdiskon']=='1') { echo $row_detbrg['diskon']." %"; }else{ echo number_format($row_detbrg['diskon'],0,',','.');}?></td>
          <td align="right"><?php echo number_format($row_detbrg['subtotal'],0,',','.'); $gtotal += $row_detbrg['subtotal'];?></td>
          <td align="center"><a href="javascript:void(0);" onclick="manageInvoiceJual('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
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
            <td align="center"><a href="javascript:void(0);" onclick="manageInvoiceJual('add','');"><img src="images/add.png" border="0" /> Tambah</a></td>
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
      </label> <small> Cek jika sudah lunas</small></td>
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
</form>*/ ?>

<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. Invoice *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="invoice" type="text" id="invoice" value="<?php echo $row_edit['referensi'];?>" size="10" maxlength="10" onfocus="this.blur();">
      </label>
        <?php if ($total_jkontak == 1) { ?>
            <input type="hidden" name="matauang" id="matauang" value="<?php echo $row_jkontak['matauang']; ?>" />
        <?php } else { ?>
        <label>
            <select name="matauang" id="matauang">
                <option value="">Pilih Mata Uang</option>
                <?php if($total_jkontak > 0) { do { ?>
                <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_edit['matauang'] == $row_jkontak['kode']) { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['matauang'];?></option>
                <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
            </select>
        </label>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top">Tanggal *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?php echo $row_edit['tgl'];?>" size="10" maxlength="10"/>
      </label> 
      Jatuh Tempo * :
      <label>
        <input name="jtempo" type="text" class="calendar" id="jtempo" value="<?php echo $row_edit['jtempo'];?>" size="10" maxlength="10"/>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Customer *</td>
      <td align="center">:</td>
      <td><label>
        <select name="customer" id="customer">
          <option value="">Pilih Customer</option>
          <?php if($total_client > 0) { do { ?>
          <option value="<?php echo $row_client['kode'];?>" <?php if($row_client['kode']==$row_edit['client']) { ?>selected="selected"<?php } ?>><?php echo $row_client['kontak'];?></option>
          <?php }while($row_client = mysqli_fetch_assoc($client)); } ?>
        </select>
      </label></td>
    </tr>
    <tr valign="top">
        <td align="right">Info</td>
        <td align="center">:</td>
        <td><label>
          <textarea name="info" id="info" cols="85" rows="5"><?php echo $row_edit['info'];?></textarea>
        </label></td>
    </tr>
  </table>
    <br><br>
    <fieldset>
    <table width="100%" border="0" cellspacing="0" class="datatable">
        <tr>
            <td align="right">Tipe</td>
            <td>:</td>
            <td>
                <select id="tipe" onchange="refreshTipe();">
                    <option value="1">Frame</option>
                    <option value="2">Softlens</option>
                    <option value="3">Lensa</option>
                </select>
            </td>
            <td rowspan="5" width="50%" valign="top">
                Bentuk Detail Ukuran: <br>
                <table>
                    <tr>
                        <td>&nbsp;</td>
                        <td>SpH</td>
                        <td>Cyl</td>
                        <td>Axis</td>
                        <td>Add</td>
                        <td>PD</td>
                    </tr>
                    <tr>
                        <td>Right</td>
                        <td>
                            <select name="rSph" id="rSph">
                                <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="rCyl" id="rCyl">
                                <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="rAxis" id="rAxis">
                                <?php for ($r = 0; $r <= 180; $r = $r + 5) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="rAdd" id="rAdd">
                                <?php for ($r = 15; $r >= 0; $r = $r - 0.25) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="rPd" id="rPd">
                                <?php for ($r = 40; $r <= 80; $r = $r + 2) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 56 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Left</td>
                        <td>
                            <select name="lSph" id="lSph">
                                <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="lCyl" id="lCyl">
                                <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="lAxis" id="lAxis">
                                <?php for ($r = 0; $r <= 180; $r = $r + 5) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="lAdd" id="lAdd">
                                <?php for ($r = 15; $r >= 0; $r = $r - 0.25) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="lPd" id="lPd">
                                <?php for ($r = 40; $r <= 80; $r = $r + 2) { ?>
                                <option value="<?php echo $r; ?>" <?php echo ($r == 56 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label>Frame: <input type="text" size="15" maxlength="20" id="frame" name="frame" /></label>
                        </td>
                        <td colspan="3">
                            <label>Lensa: <input type="text" size="15" maxlength="20" id="lensa" name="lensa" /></label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="right" width="10%">Nama Barang</td>
            <td>:</td>
            <td width="35%">
                <label>
                    <input name="qbrg" type="text" id="qbrg" size="16" maxlength="30" placeholder="Cari Type Brand" onchange="getMasterBarang(this.value, document.getElementById('tipe').value);"/>
                </label>
                <label id="divMBarang">
                    <select name="barang" id="barang">
                        <option value="">Pilih Type Brand</option>
                        <?php /*if($total_mbarang > 0) { do { ?>
                        <option value="<?php echo $row_mbarang['kode'];?>"><?php echo $row_mbarang['jenis'];?> - <?php echo $row_mbarang['barang'];?></option>
                        <?php }while($row_mbarang = mysqli_fetch_assoc($mbarang)); }*/ ?>
                    </select>
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">Qty</td>
            <td>:</td>
            <td>
                <input name="qty" type="text" id="qty" size="4" maxlength="8" value="0" onchange="javascript:if(this.value > 0) { this.form.subtotal.value = this.value * this.form.hsatuan.value; }else{ this.value=0;}"/>
                <label>
                    <?php if ($total_satuan == 1) { ?>
                    <input type="hidden" name="satuan" id="satuan" value="<?php echo $row_satuan['kode']; ?>" />
                    <?php echo $row_satuan['satuan']; ?>
                    <?php } else { ?>
                    <select name="satuan" id="satuan">
                        <option value="">Pilih Satuan</option>
                        <?php if($total_satuan > 0) { do { ?>
                        <option value="<?php echo $row_satuan['kode'];?>"><?php echo $row_satuan['satuan'];?></option>
                        <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
                    </select>
                    <?php } ?>
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">Harga Satuan</td>
            <td>:</td>
            <td>
                <input name="hsatuan" type="text" id="hsatuan" size="20" maxlength="10" value="0" onchange="javascript:if(this.value > 0) { this.form.subtotal.value = this.value * this.form.qty.value; }else{ this.value=0;}"/>
            </td>
        </tr>
        <tr>
            <td align="right">Diskon</td>
            <td>:</td>
            <td>
                <label>
                    <input name="diskon" type="text" id="diskon" size="8" maxlength="8" value="0" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }" style="font-size:9px;"/>
                </label>
                <label>
                    <select name="tdiskon" id="tdiskon" style="font-size:9px;" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.form.diskon.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }">
                        <option value="0">Normal</option>
                        <option value="1">%</option>
                    </select>
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">Subtotal</td>
            <td>:</td>
            <td>
                <label>
                    <input name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value="0" onfocus="this.blur();" style="background:#DDD;border:solid 1px #BBB;"/>
                </label>
                <a href="javascript:void(0);" onclick="manageInvoiceJual('add','');"><img src="images/add.png" border="0" /> Tambah</a>
            </td>
        </tr>
    </table>
    </fieldset>
    <br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr valign="top">
      <td align="right">Detail Transaksi *</td>
      <td align="center">:</td>
      <td>
      <div id="divManageInvoice">
      <table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
        <tr>
          <th>Nama Barang</th>
          <th width="6%">Qty</th>
          <th width="10%">Satuan</th>
          <th width="10%">Harga Satuan</th>
          <th width="14%">Pot. Diskon</th>
          <th width="10%">Sub Total</th>
          <th width="8%">Hapus</th>
        </tr>
        <?php if($total_detbrg > 0) { $gtotal = 0 ; do { ?>
        <tr valign="top">
          <td>
              <?php echo $row_detbrg['jenis'];?> -  <?php echo $row_detbrg['barang'];?><br>
              <table rules="all" border="1">
                  <tr>
                      <td width="15%">&nbsp;</td>
                      <td width="13%">SpH</td>
                      <td width="13%">Cyl</td>
                      <td width="13%">Axis</td>
                      <td width="13%">Add</td>
                      <td width="13%">PD</td>
                  </tr>
                  <tr>
                      <td>Right</td>
                      <td align="center"><?php echo $row_detbrg['rSph']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['rCyl']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['rAxis']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['rAdd']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['rPd']; ?></td>
                  </tr>
                  <tr>
                      <td>Left</td>
                      <td align="center"><?php echo $row_detbrg['lSph']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['lCyl']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['lAxis']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['lAdd']/100; ?></td>
                      <td align="center"><?php echo $row_detbrg['lPd']; ?></td>
                  </tr>
              </table><br>
              Frame: <?php echo $row_detbrg['frame']; ?> - Lensa: <?php echo $row_detbrg['lensa']; ?>
          </td>
          <td align="center"><?php echo $row_detbrg['qty'];?></td>
          <td align="center"><?php echo $row_detbrg['satuan'];?></td>
          <td align="right"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
          <td align="right"><?php if($row_detbrg['tdiskon']=='1') { echo $row_detbrg['diskon']." %"; }else{ echo number_format($row_detbrg['diskon'],0,',','.');}?></td>
          <td align="right"><?php echo number_format($row_detbrg['subtotal'],0,',','.'); $gtotal += $row_detbrg['subtotal'];?></td>
          <td align="center"><a href="javascript:void(0);" onclick="manageInvoiceJual('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
        </tr>
        <?php } while($row_detbrg = mysqli_fetch_assoc($detbrg)); } ?>
      </table>
      </div>
      </td>
    </tr>
    <tr>
        <td align="right">Uang Muka *</td>
        <td align="center">:</td>
        <td>
            <input type="hidden" name="idUangMuka" value="<?php $row_uangmuka['id']; ?>" />
            <input type="text" name="uangMuka" id="uangMuka" size="20" maxlength="20" value="<?php $row_uangmuka['jumlah']; ?>" />
        </td>
    </tr>
    <tr>
        <td><em>*diisi</em></td>
        <td align="center" valign="top">&nbsp;</td>
        <td width="82%">
            <label>
                <input type="button" onclick="printInvoice();" value="Cetak Invoice" />
            </label>
            <label>
                <input name="Save" type="submit" id="Save" value="Simpan">
            </label>
            <label>
                <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
            </label>
        </td>
    </tr>
  </table>
</form>

<script>
    refreshTipe();
</script>