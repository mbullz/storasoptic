<?php
include('include/define.php');
$query_data  = "select * from divisi";
//----
$query_all   = $query_data;
//---- filter data
if($q <>'') {
	$query_data .= " where kode LIKE '%$q%' OR divisi LIKE '%$q%'";	
	$query_all  .= " where kode LIKE '%$q%' OR divisi LIKE '%$q%'";
}
//----
$query_data .= " order by kode limit $b offset $bp";
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
</script>
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Divisi</h1>
    <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr valign="top">
        <td colspan="2"><?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a><?php } ?></td>
        <td colspan="4" align="right"><label>
            <input name="q" type="text" id="q" value="<?php echo $q;?>" size="30" onkeypress="return event.keyCode!=13;"/>
          </label>
          <label>
            <input name="Search" type="button" id="Search" value="Pencarian" onclick="window.location='index-c-<?php echo $_GET['component'];?>-q-' + document.getElementById('q').value.replace(/ /g,'+') + '.pos';"/>
          </label>
        </td>
      </tr>
      <tr>
        <th width="2%"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%">Kode</th>
        <th width="28%">Divisi</th>
        <th>Info</th>
        <th width="8%">Pengaturan</th>
      </tr>
      <?php if($totalRows_data > 0) { ?>
      <?php $no=0; do { ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['kode'];?>" /></td>
        <td align="center"><?php echo $row_data['kode'];?></td>
        <td align="left"><?php echo $row_data['divisi'];?></td>
        <td align="left"><?php echo $row_data['info'];?></td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['kode'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" />Edit</a><?php } ?></td>
        </tr>
      <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
      <?php }else{ ?>
      <tr>
        <td colspan="5">Data tidak ada</td>
      </tr>
      <?php } ?>
      <?php if($totalRows_data > $b) { ?>
      <tr>
        <td colspan="5"><table width="10%" border="0" align="left" cellpadding="5">
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
        <td colspan="5" valign="middle">
          <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
          <label>
          <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="return confirm('Lanjutkan Proses ... ?');"/>
        </label></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="5" align="right"><span style="border-bottom:double #333333;padding:2px;"><?php echo $totalRows_data." Data";?></span> </td>
      </tr>
    </table>
  </div>
</form>