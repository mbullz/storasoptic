<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from targetpm where id ='$id'";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// get sales
$query_sales  = "select a.kode, a.kontak from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi ='sales' order by a.kontak";
$sales        = $mysqli->query($query_sales);
$row_sales    = mysqli_fetch_assoc($sales);
$total_sales  = mysqli_num_rows($sales);
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
$query_detbrg = "select a.id, a.qty, b.kode, b.barang, a.subtotal, a.harga, c.satuan, d.jenis from targetpm_d a, barang b, satuan c, jenisbarang d where a.barang = b.kode AND a.satuan = c.kode AND b.jenis = d.kode AND a.periode='$row_edit[periode]' AND a.kontak='$row_edit[kontak]' order by a.id desc";
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
<h1> Edit Target Penjualan</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">Periode *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="periode" type="text" class="monthcalendar" id="periode" value="<?php echo $row_edit['periode'];?>" size="8" maxlength="8" />
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"> Salesman *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="sales" id="sales">
          <option value="">Pilih Salesman</option>
          <?php if($total_sales > 0) { do { ?>
          <option value="<?php echo $row_sales['kode'];?>" <?php if($row_sales['kode']==$row_edit['kontak']) { ?>selected="selected"<?php } ?>><?php echo $row_sales['kontak'];?></option>
          <?php }while($row_sales = mysqli_fetch_assoc($sales)); } ?>
        </select>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Detail Barang</td>
      <td align="center">:</td>
      <td>
      <div id="divManageTarget">
      <table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
        <tr>
          <th>Nama Barang</th>
          <th width="6%">Qty</th>
          <th width="10%">Satuan</th>
          <th width="10%">Harga Satuan</th>
          <th width="10%">Sub Total</th>
          <th width="8%">Pengaturan</th>
        </tr>
        <?php if($total_detbrg > 0) { $gtotal = 0; do { ?>
        <tr valign="top">
          <td><?php echo $row_detbrg['jenis'];?> - <?php echo $row_detbrg['barang'];?></td>
          <td align="center"><?php echo $row_detbrg['qty'];?></td>
          <td align="center"><?php echo $row_detbrg['satuan'];?></td>
          <td align="right"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
          <td align="right"><?php echo number_format($row_detbrg['subtotal'],0,',','.'); $gtotal += $row_detbrg['subtotal'];?></td>
          <td align="center"><a href="javascript:void(0);" onclick="manageTargetJual('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
        </tr>
        <?php } while($row_detbrg = mysqli_fetch_assoc($detbrg)); ?>
        <tr valign="top">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">Target Total :</td>
          <td align="right"><?php echo number_format($gtotal,0,',','.');?></td>
          <td align="center"><input type="hidden" name="target" id="target" value="<?php echo $gtotal;?>" /></td>
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
            <input name="qty" type="text" id="qty" size="6" maxlength="8" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.hsatuan.value; }else{ this.value=0;}"/>
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
            <input name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value="0" onfocus="this.blur();" style="background:#DDD;border:solid 1px #BBB;"/>
          </label></td>
          <td align="center"><a href="javascript:void(0);" onclick="manageTargetJual('add','');"><img src="images/add.png" border="0" /> Tambah</a></td>
        </tr>
      </table>
      </div>
      </td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="85" rows="5"><?php echo $row_edit['info'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan" />
      </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
          <input name="id" type="hidden" id="id" value="<?php echo $row_edit['id'];?>" />
        </label></td>
    </tr>
  </table>
</form>