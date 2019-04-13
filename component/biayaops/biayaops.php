<?php

global $mysqli;
global $c;

$query_data = "SELECT 
		a.id, a.tgl, a.referensi, a.jumlah, a.info, b.matauang, d.pembayaran 
	FROM aruskas a 
	JOIN matauang b ON a.matauang_id = b.matauang_id 
	JOIN carabayar d ON a.carabayar_id = d.carabayar_id 
	WHERE a.tipe='operasional' 
	ORDER BY a.tgl DESC ";

$data = $mysqli->query($query_data);
?>
<script type="text/javascript">
function generateReport() {
	var startDt = $("#startDt").val();
	var endDt = $("#endDt").val();
	if (startDt == '' || endDt == '') {
		alert('Pilih tanggal periode');
		return;
	}
	if ($("#tipe1").prop('checked') == true) {
		NewWindow('component/biayaops/task/report_biayaops.php?mode=general_report&start=' + startDt + '&end=' + endDt,'name','720','520','yes');
	} else {
		alert('Pilih jenis laporan !!!');
	}
}
$(document).ready(function()
{
	$("#example").dataTable(
	{
		dom: 'T<"clear">lfrtip',
		tableTools:
		{
			"sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
		}
	});
		
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

<style>
	td.details-control {
	    background: url('media/images/details_open.png') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('media/images/details_close.png') no-repeat center center;
	}
</style>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Biaya Operasional</h1>
    
	<a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a>
    
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
      <tr>
        <th width="2%" align="center"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%" align="center"><font color="#0000CC">TANGGAL</font></th>
        <th width="16%" align="center"><font color="#0000CC">PEMBAYARAN</font></th>
        <th width="18%" align="center"><font color="#0000CC">NO. REF</font></th>
        <th width="15%" align="center"><font color="#0000CC">JUMLAH</font></th>
        <th align="center"><font color="#0000CC">INFO</font></th>
        <th width="8%" align="center"><font color="#0000CC">PENGATURAN</font></th>
      </tr>
		</thead>
        
        <tbody>
      <?php $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['id'];?>" /></td>
        <td align="center"><?php genDate($row_data['tgl']);?></td>
        <td align="center"><?php echo $row_data['pembayaran'];?></td>
        <td align="center"><?php echo $row_data['referensi'];?></td>
        <td align="right"><?php echo number_format($row_data['jumlah'],0,',','.');?> <?php echo $row_data['matauang'];?></td>
        <td align="left"><?php echo $row_data['info'];?></td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['id'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" />Edit</a><?php } ?></td>
        </tr>
      <?php } ?>
		</tbody>
	</table>
      
      <?php if(strstr($_SESSION['akses'],"delete_".$c)) { ?>
          <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
          <label>
          <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="return confirm('Lanjutkan Proses ... ?');"/>
        </label>
      <?php } ?>
      
    <p>
		Periode Tanggal : 
		<input type="text" class="calendar" id="startDt" size="10" /> - 
		<input type="text" class="calendar" id="endDt" size="10" />
		<br/>
		Cetak Laporan:
		<br />
		<label>
			<input type="radio" name="report" id="tipe1" />
			Laporan Biaya Operasional
		</label>
		<br />
		<input type="button" value="Cetak Laporan" onclick="generateReport();" />
	</p>
    
  </div>
</form>