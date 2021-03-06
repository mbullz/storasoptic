<?php

global $mysqli;
global $b, $q;

$query_data  = "SELECT a.masukbarang_id, a.referensi, a.jtempo, a.total, a.info, b.kontak, c.matauang, DATEDIFF(a.jtempo,CURRENT_DATE) AS 'sisa' 
				FROM masukbarang a 
				JOIN kontak b ON b.user_id = a.supplier 
				JOIN matauang c ON c.matauang_id = a.matauang_id 
				WHERE a.lunas LIKE '0' 
				ORDER BY a.tgl DESC , a.masukbarang_id DESC ";
//----
$query_all   = $query_data;

//----
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
        var url = 'component/hutangjtempo/task/report_hutangjtempo.php';
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
// --- show / hide info
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
    <h1>Pembayaran Hutang</h1>
    <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr valign="top">
        <td colspan="2"><?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a><?php } ?></td>
        <td colspan="6" align="right"><label>
            <input name="q" type="text" id="q" value="<?php echo $q;?>" size="30" onkeypress="return event.keyCode!=13;"/>
          </label>
          <label>
            <input name="Search" type="button" id="Search" value="Pencarian" onclick="window.location='index-c-<?php echo $_GET['component'];?>-q-' + document.getElementById('q').value.replace(/ /g,'+') + '.pos';"/>
          </label>
        </td>
      </tr>
      <tr>
        <th width="2%"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%">Jatuh Tempo</th>
        <th width="12%">No.PO</th>
        <th width="20%">Supplier</th>
        <th width="12%">Total</th>
        <th>Info Pembayaran</th>
        <th width="8%">Pengaturan</th>
      </tr>
      <?php if($totalRows_data > 0) { ?>
      <?php $no=0; do { ?>
      <?php
		// list detail bayar
		$query_detbrg = "select * from aruskas where tipe='hutang' AND referensi='$row_data[referensi]' order by tgl";
		$detbrg       = $mysqli->query($query_detbrg);
		$row_detbrg   = mysqli_fetch_assoc($detbrg);
		$total_detbrg = mysqli_num_rows($detbrg);
	  ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['referensi'];?>" /></td>
        <td align="center"><!--<?php genDate($row_data['jtempo']);?> (<font color="#FF0000"><?=$row_data['sisa']?></font>)-->-</td>
        <td align="center"><?php echo $row_data['referensi'];?></td>
        <td align="left"><?php echo $row_data['kontak'];?></td>
        <td align="right"><?php echo number_format($row_data['total'],0,',','.');?> <?php echo $row_data['matauang'];?></td>
        <td align="left"><small style="float:right;">[ <a href="javascript:void(0);" onclick="viewInfo('info_<?php echo $row_data['referensi'];?>');">Lihat Info</a> ]</small>
          <table width="100%" border="0" cellpadding="2" cellspacing="0" id="info_<?php echo $row_data['referensi'];?>" style="display:none;">
            <tr>
              <th width="25%">Tanggal</th>
              <th valign="top" width="25%">Jumlah</th>
              <th valign="top">Info</th>
            </tr>
            <?php $tbayar = 0; if($total_detbrg > 0) { ?>
            <?php do { ?>
            <tr>
              <td align="center" valign="top"><?php genDate($row_detbrg['tgl']);?></td>
              <td align="right" valign="top"><?php echo number_format($row_detbrg['jumlah'],0,',','.'); $tbayar += $row_detbrg['jumlah'];?>&nbsp;</td>
              <td align="left" valign="top"><?php echo $row_detbrg['info'];?>&nbsp;</td>
            </tr>
            <?php }while($row_detbrg = mysqli_fetch_assoc($detbrg));?>
            <?php } ?>
            <tr>
              <td align="right" valign="top"><strong>Total :</strong></td>
              <td align="right" valign="top"><?php echo number_format($tbayar,0,',','.');?></td>
              <td align="left" valign="top"><?php echo $row_data['matauang'];?></td>
            </tr>
            <tr>
              <td align="right" valign="top"><strong>Hutang :</strong></td>
              <td align="right" valign="top"><?php echo number_format($row_data['total'] - $tbayar,0,',','.');?></td>
              <td align="left" valign="top"><?php echo $row_data['matauang'];?></td>
            </tr>
          </table></td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"add_pembayaranhutang")) { ?><a href="index-c-pembayaranhutang-t-add-<?php echo str_replace("-","_",$row_data['referensi']);?>.pos" title="Bayar Hutang"><img src="images/paid.png" border="0" /> Bayar</a><?php } ?></td>
        </tr>
      <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
      <?php }else{ ?>
      <tr>
        <td colspan="7">Data tidak ada</td>
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
                Cetak Laporan Hutang Jatuh Tempo:<br>
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