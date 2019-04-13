<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from stokbarang where id='$id'";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// get gudang
$query_jkontak = "select kode, gudang from gudang order by gudang";
$jkontak       = $mysqli->query($query_jkontak);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);
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
<h1> Edit Stok Barang</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td align="right" valign="top">Lokasi Gudang *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="gudang" id="gudang">
          <option value="">Pilih Lokasi Gudang</option>
          <?php if($total_jkontak > 0) { do { ?>
          <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_edit['gudang']==$row_jkontak['kode']) { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['gudang'];?></option>
          <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Nama Barang *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
            <input name="qbrg" type="text" id="qbrg" size="18" maxlength="30" placeholder="Cari Master Barang ..." onchange="getMasterBarang(this.value);"/>
          </label><label id="divMBarang">
            <select name="barang" id="barang">
              <option value="">Pilih Master Barang</option>
              <?php if($total_mbarang > 0) { do { ?>
              <option value="<?php echo $row_mbarang['kode'];?>" <?php if($row_mbarang['kode']==$row_edit['barang']) { ?>selected="selected"<?php } ?>><?php echo $row_mbarang['jenis'];?> - <?php echo $row_mbarang['kode'];?> | <?php echo $row_mbarang['barang'];?></option>
              <?php }while($row_mbarang = mysqli_fetch_assoc($mbarang)); } ?>
            </select>
          </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Stok Barang *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="qty" type="text" id="qty" value="<?php echo $row_edit['qty'];?>" size="8" maxlength="10" />
      </label>
        <label>
            <select name="satuan" id="satuan">
              <option value="">Pilih Satuan</option>
              <?php if($total_satuan > 0) { do { ?>
              <option value="<?php echo $row_satuan['kode'];?>" <?php if($row_satuan['kode']==$row_edit['satuan']) { ?>selected="selected"<?php } ?>><?php echo $row_satuan['satuan'];?></option>
              <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
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
        <input name="id" type="hidden" id="id" value="<?php echo $row_edit['id'];?>" />
      </label></td>
    </tr>
  </table>
</form>