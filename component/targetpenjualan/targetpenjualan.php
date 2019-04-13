<?php
include('include/define.php');
$query_data  = "select a.id, a.periode, a.target, a.info, b.kode, b.kontak from targetpm a, kontak b where a.kontak = b.kode";
//----
$query_all   = $query_data;
//---- filter data
if($q <>'') {
	$query_data .= " AND (b.kode LIKE '%$q%' OR b.kontak LIKE '%$q%' OR a.periode LIKE '%$q%')";	
	$query_all  .= " AND (b.kode LIKE '%$q%' OR b.kontak LIKE '%$q%' OR a.periode LIKE '%$q%')";
}
//----
$query_data .= " order by a.periode desc limit $b offset $bp";
$data = $mysqli->query($query_data);
$row_data = mysqli_fetch_assoc($data);
//---
$alldata = $mysqli->query($query_all);
$totalRows_data = mysqli_num_rows($alldata);
// --
$totalPages_data = ceil($totalRows_data / $b) - 1;
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

	$('#formdata').submit(function() {
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
// --- show / hide kontak
function viewTarget(infoID) {
	$(document).ready(function() {
		$('#' + infoID).toggle();					   
	})
}
</script>
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Target Penjualan</h1>
    <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr valign="top">
        <td colspan="2"><?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a><?php } ?></td>
        <td colspan="5" align="right"><label>
            <input name="q" type="text" id="q" value="<?php echo $q;?>" size="30" onkeypress="return event.keyCode!=13;"/>
          </label>
          <label>
            <input name="Search" type="button" id="Search" value="Pencarian" onclick="window.location='index-c-<?php echo $_GET['component'];?>-q-' + document.getElementById('q').value.replace(/ /g,'+') + '.pos';"/>
          </label>
        </td>
      </tr>
      <tr>
        <th width="2%"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%">Periode</th>
        <th width="24%">Kontak</th>
        <th width="12%">Target</th>
        <th>Info</th>
        <th width="8%">Pengaturan</th>
      </tr>
      <?php if($totalRows_data > 0) { ?>
      <?php $no=0; do { ?>
      <?php
	  // get detail target
	  $query_detar = "select a.qty, a.harga, a.subtotal, b.barang, c.satuan from targetpm_d a, barang b, satuan c where a.periode='$row_data[periode]' AND a.kontak='$row_data[kode]' AND b.kode = a.barang AND c.kode = a.satuan order by a.id";
	  $detar       = $mysqli->query($query_detar);
	  $row_detar   = mysqli_fetch_assoc($detar);
	  ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['periode'];?>,<?php echo $row_data['kode'];?>" /></td>
        <td align="center"><?php genPeriod($row_data['periode']);?></td>
        <td align="left"><?php echo $row_data['kode'];?> - <?php echo $row_data['kontak'];?></td>
        <td align="right"><?php echo number_format($row_data['target'],0,',','.');?></td>
        <td align="left"><?php echo $row_data['info'];?><small style="float:right;">[ <a href="javascript:void(0);" onclick="viewTarget('infotable_<?php echo $row_data['id'];?>');">Lihat Info</a> ]</small><table width="100%" border="0" cellspacing="0" cellpadding="4" id="infotable_<?php echo $row_data['id'];?>" style="display:none;">
          <tr>
            <th valign="top">Barang</th>
            <th width="15%" valign="top">Qty</th>
            <th width="20%" valign="top">Harga</th>
            <th width="20%" valign="top">Total</th>
          </tr>
          <?php do { ?>
          <tr>
            <td width="30%" valign="top"><?php echo $row_detar['barang'];?></td>
            <td align="right" valign="top"><?php echo $row_detar['qty'];?> <?php echo $row_detar['satuan'];?></td>
            <td align="right" valign="top"><?php echo number_format($row_detar['harga'],0,',','.');?></td>
            <td align="right" valign="top"><?php echo number_format($row_detar['subtotal'],0,',','.');?></td>
          </tr>
          <?php }while($row_detar = mysqli_fetch_assoc($detar)); ?>
          <tr>
            <td colspan="3" align="right" valign="top"><strong>Grand Total :</strong></td>
            <td align="right" valign="top"><?php echo number_format($row_data['target'],0,',','.');?></td>
          </tr>
        </table></td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['id'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" />Edit</a><?php } ?></td>
        </tr>
      <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
      <?php }else{ ?>
      <tr>
        <td colspan="6">Data tidak ada</td>
      </tr>
      <?php } ?>
      <?php if($totalRows_data > $b) { ?>
      <tr>
        <td colspan="6"><table width="10%" border="0" align="left" cellpadding="5">
            <tr>
              <td align="center" style="border:none;"><?php if ($p > 0) { // Show if not first page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-0.pos"><img src="images/first.png" border="0"/></a>
                  <?php } // Show if not first page ?>              </td>
              <td align="center" style="border:none;"><?php if ($p > 0) { // Show if not first page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-<?php echo $p-1;?>.pos"><img src="images/prev.png" border="0"/></a>
                  <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center" style="border:none;"><select id="paging" name="paging" onchange="javascript:window.location='<?php echo str_replace(".pos","",$currentPage);?>-p-' + document.getElementById('paging').value + '.pos';" style="text-align:center;">
                <option value="0" <?php if(empty($p) or $p==0) { ?>selected="selected"<?php } ?>>Pilih Halaman</option>
                <?php for($pn=1;$pn<=$totalPages_data;$pn++) { ?>
                <option value="<?php echo $pn;?>" <?php if($p==$pn) { ?>selected="selected"<?php } ?>><?php echo $pn." dari ".$totalPages_data;?></option>
                <?php } ?>
              </select></td>
              <td align="center" style="border:none;"><?php if ($p < $totalPages_data) { // Show if not last page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-<?php echo $p+1;?>.pos"><img src="images/next.png" border="0"/></a>
                  <?php } // Show if not last page ?>              </td>
              <td align="center" style="border:none;"><?php if ($p < $totalPages_data) { // Show if not last page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-<?php echo $totalPages_data;?>.pos"><img src="images/last.png" border="0"/></a>
                  <?php } // Show if not last page ?>              </td>
            </tr>
        </table></td>
      </tr>
      <?php } ?>
      <?php if(strstr($_SESSION['akses'],"delete_".$c)) { ?>
	  <tr>
        <td colspan="6" valign="middle">
          <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
          <label>
          <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="return confirm('Lanjutkan Proses ... ?');"/>
        </label><a href="export_xls.php?tabel=targetpenjualan" title="Export Data XLS"><img src="images/_xls.png" width="20" height="20" border="0" align="right" /></a></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="6" align="right"><span style="border-bottom:double #333333;padding:2px;"><?php echo $totalRows_data." Data";?></span> </td>
      </tr>
    </table>
  </div>
</form>