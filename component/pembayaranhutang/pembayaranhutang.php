<?php
global $mysqli;
global $q, $b, $bp;

$query_data = "SELECT a.*, c.kontak AS supplier FROM masukbarang a JOIN kontak c ON a.supplier=c.user_id WHERE a.lunas LIKE '1' order by a.tgl desc limit $b offset $bp";
//----
$query_all   = $query_data;

//----
$query_data .= " ";
$data = $mysqli->query($query_data);
$row_data = mysqli_fetch_assoc($data);
//---
$alldata = $mysqli->query($query_all);
$totalRows_data = mysqli_num_rows($alldata);
// --
$totalPages_data = ceil($totalRows_data / $b) - 1;
?>
<script type="text/javascript">
function generateReport()
{
    var tipe = $("#tipe").val();
	var supplier = $("#supplier").val();
    var sp = $("#startPeriode").val();
    var ep = $("#endPeriode").val();
    if (sp == '') {
        alert('Tanggal mulai harus diisi');
    } else if (ep == '') {
        alert('Tanggal selesai harus diisi');
    } else {
        var url = 'component/pembayaranhutang/task/report_pembayaranhutang.php';
        var data = '?mode=general_report&tipe=' + tipe + '&sp=' + sp + '&ep=' + ep + "&supplier=" + supplier;
        
        NewWindow(url + data,'name','720','520','yes');
    }
}

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

function viewInfo(infoID) {
	$(document).ready(function() {
		$('#' + infoID).toggle();					   
	})
}

</script>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Hutang Lunas</h1>
    <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr valign="top">
        <td colspan="2">&nbsp;</td>
        <td colspan="6" align="right"><label>
            <input name="q" type="text" id="q" value="<?php echo $q;?>" size="30" onkeypress="return event.keyCode!=13;"/>
          </label>
          <label>
            <input name="Search" type="button" id="Search" value="Pencarian" onclick="window.location='index-c-<?php echo $_GET['component'];?>-q-' + document.getElementById('q').value.replace(/ /g,'+') + '.pos';"/>
          </label>
        </td>
      </tr>
	  <?php /*
      <tr>
        <th width="2%"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%">Tanggal</th>
		<th>Supplier</th>
        <th width="16%">Pembayaran </th>
        <th width="18%">No. PO</th>
        <th width="15%">Jumlah</th>
        <th>Info</th>
        <th width="8%">Pengaturan</th>
      </tr>
      <?php if($totalRows_data > 0) { ?>
      <?php $no=0; do { ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['id'];?>" /></td>
        <td align="center"><?php genDate($row_data['tgl']);?></td>
		<td align="center"><?php echo $row_data['supplier']; ?></td>
        <td align="center"><?php echo $row_data['pembayaran'];?></td>
        <td align="center"><?php echo $row_data['referensi'];?></td>
        <td align="right"><?php echo number_format($row_data['jumlah'],0,',','.');?> <?php echo $row_data['matauang'];?></td>
        <td align="left"><?php echo $row_data['info'];?></td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['id'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" />Edit</a><?php } ?></td>
        </tr>
      <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
      <?php }else{ ?>
      <tr>
        <td colspan="7">Data tidak ada</td>
      </tr>
      <?php } ?>
	  <?php */ ?>
	  <tr>
		<th width="2%"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%">Tanggal</th>
		<th width="18%">Customer</th>
        <th width="15%">No. Inv</th>
        <th width="15%">Jumlah</th>
        <th>Info</th>
	  </tr>
	  <?php if($totalRows_data > 0) { ?>
	  <?php $no=0; do { ?>
	  <tr valign="top">
		<td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['id'];?>" /></td>
		<td align="center"><?php echo $row_data['tgl']; ?></td>
		<td align="center"><?php echo $row_data['supplier']; ?></td>
		<td align="center"><?php echo $row_data['referensi']; ?></td>
		<td align="center"><?php echo 'Rp. ' . number_format($row_data['total']); ?></td>
		<td align="center">
			<?php
				$query_detail = "select * from aruskas where tipe='hutang' and referensi='$row_data[referensi]' order by tgl asc";
				$detail = $mysqli->query($query_detail);
				$total_detail = mysqli_num_rows($detail);
			?>
			<small style="float:right;">[ <a href="javascript:void(0);" onclick="viewInfo('info_<?php echo $row_data['referensi'];?>');">Lihat Info</a> ]</small>
			<table width="100%" border="0" cellpadding="2" cellspacing="0" id="info_<?php echo $row_data['referensi'];?>" style="display:none;">
				<thead>
					<tr>
						<th width="80px">Tanggal</th>
						<th width="90px">Pembayaran</th>
						<th width="100px">Jumlah</th>
						<th>Info</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php while (($row_detail = mysqli_fetch_assoc($detail)) != NULL) { ?>
					<tr>
						<td align="center"><?php echo $row_detail['tgl']; ?></td>
						<td align="center"><?php echo $row_detail['carabayar']; ?></td>
						<td align="center"><?php echo 'Rp. ' . number_format($row_detail['jumlah']); ?></td>
						<td><?php echo nl2br($row_detail['info']); ?></td>
						<td>
							<a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_detail['id'];?>" title="Edit Data">
								<img src="images/edit-icon.png" border="0" />
							</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</td>
	  </tr>
	  <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
	  <?php } else { ?>
	  <tr>
		<td colspan="6">Data tidak ada</td>
	  </tr>
	  <?php } ?>
      <?php if($totalRows_data > $b) { ?>
      <tr>
        <td colspan="7"><table width="10%" border="0" align="left" cellpadding="5">
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
        <td colspan="7" valign="middle">
          <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
          <label>
          <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="return confirm('Lanjutkan Proses ... ?');"/>
        </label></td>
      </tr>
      <?php } ?>
      <tr>
          <td colspan="7" valign="top">
                Cetak Laporan Hutang Terbayar:<br>
                Tipe:
                <select id="tipe">
                    <option value="1">Frame</option>
                    <option value="2">Softlens</option>
                    <option value="3">Lensa</option>
                </select><br>
                Periode: 
                <span>
                    <input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
                </span>
                s/d 
                <span>
                    <input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
                </span><br>
				<label>
                	Perusahaan:
                </label>
                <select id="supplier">
                	<option value="">All</option>
                    <?php
						$rs2 = $mysqli->query("SELECT a.kode,kontak FROM kontak a JOIN jeniskontak b ON a.jenis = b.kode WHERE b.klasifikasi like 'supplier'");
						while ($data2 = mysqli_fetch_assoc($rs2))
						{
							?>
                            	<option value="<?=$data2['kode']?>"><?=$data2['kontak']?></option>
                            <?php
						}
					?>
                </select>
                <br />
              <input type="button" value="Cetak" onclick="generateReport();" />
          </td>
      </tr>
      <tr>
        <td colspan="7" align="right"><span style="border-bottom:double #333333;padding:2px;"><?php echo $totalRows_data." Data";?></span> </td>
      </tr>
    </table>
  </div>
</form>