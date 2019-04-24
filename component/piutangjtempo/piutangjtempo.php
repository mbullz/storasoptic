<?php

global $mysqli;
global $branch_id;

$branch_filter = '';
if ($branch_id != 0) {
    $branch_filter = " AND a.branch_id = $branch_id ";
}

$query_data  = "SELECT a.keluarbarang_id, a.referensi, a.tgl, a.jtempo, a.total, a.info, b.kontak, c.matauang, 
                		DATEDIFF(a.jtempo,CURRENT_DATE) AS 'sisa' 
                FROM keluarbarang a 
                JOIN kontak b ON b.user_id = a.client 
                JOIN matauang c ON a.matauang_id = c.matauang_id 
                WHERE a.lunas = '0' 
                $branch_filter 
                ORDER BY a.tgl DESC ";
//----
$query_all   = $query_data;

$data = $mysqli->query($query_data);

//---
$alldata = $mysqli->query($query_all);
$totalRows_data = mysqli_num_rows($alldata);

?>
<script type="text/javascript">
function generateReport()
{
    var tipe = $("#tipe").val();
	var customer = $("#customer").val();
    var sp = $("#startPeriode").val();
    var ep = $("#endPeriode").val();
    if (sp == '') {
        alert('Tanggal mulai harus diisi');
    } else if (ep == '') {
        alert('Tanggal selesai harus diisi');
    } else {
        var url = 'component/piutangjtempo/task/report_piutangjtempo.php';
        var data = '?mode=general_report&tipe=' + tipe + '&sp=' + sp + '&ep=' + ep + "&customer=" + customer;
        
        NewWindow(url + data,'name','720','520','yes');
    }
}

$(function() {
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
});

// --- show / hide info
function viewInfo(infoID) {
	$(document).ready(function() {
		$('#' + infoID).toggle();					   
	})
}

  function deleteTransaction(aruskas_id) {
    var c = confirm('Apakah anda yakin ingin menghapus transaksi ini ?');

    if (c) {
      window.location = 'component/pembayaranpiutang/p_pembayaranpiutang.php?p=delete&aruskas_id=' + aruskas_id;
    }
  }
</script>
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Pembayaran Piutang</h1>
    
	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a><?php } ?>
    
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
      <tr>
        <th align="center"><font color="#0000CC">TANGGAL</font></th>
        <th align="center"><font color="#0000CC">NO. INV</font></th>
        <th align="center"><font color="#0000CC">CUSTOMER</font></th>
        <th align="center"><font color="#0000CC">TOTAL</font></th>
        <th width="400px" align="center"><font color="#0000CC">INFO PEMBAYARAN</font></th>
        <th width="100px" align="center"><font color="#0000CC">PENGATURAN</font></th>
      </tr>
		</thead>
        
        <tbody>
      <?php $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
      <?php
		// list detail bayar
		$query_detbrg = "SELECT a.*, b.pembayaran FROM aruskas a JOIN carabayar b ON b.carabayar_id = a.carabayar_id WHERE tipe = 'piutang' AND transaction_id = $row_data[keluarbarang_id] ORDER BY tgl ASC, id ASC ";
		$detbrg       = $mysqli->query($query_detbrg);
		$row_detbrg   = mysqli_fetch_assoc($detbrg);
		$total_detbrg = mysqli_num_rows($detbrg);
	  ?>
      <tr valign="top">
        <td align="center"><?=genDate($row_data['tgl'])?></td>
        <td align="center"><?php echo $row_data['referensi'];?></td>
        <td align="left"><?php echo $row_data['kontak'];?></td>
        <td align="right"><?php echo number_format($row_data['total'],0,',','.');?> <?php echo $row_data['matauang'];?></td>
        <td align="left">
          <small style="float:right;">
            [ <a href="javascript:void(0);" onclick="viewInfo('info_<?php echo $row_data['referensi'];?>');">Lihat Info</a> ]
          </small>

          <table width="100%" border="0" cellpadding="2" cellspacing="0" id="info_<?php echo $row_data['referensi'];?>" style="display:none;">
          <tr>
            <th width="25%">Tanggal</th>
            <th width="25%">Jumlah</th>
            <th>Info</th>
            <th>&nbsp;</th>
          </tr>
          <?php $tbayar = 0; if($total_detbrg > 0) { ?>
          <?php do { ?>
          <tr>
            <td align="center" valign="top"><?php genDate($row_detbrg['tgl']);?></td>
            <td align="right" valign="top"><?php echo number_format($row_detbrg['jumlah'],0,',','.'); $tbayar += $row_detbrg['jumlah'];?></td>
            <td align="left" valign="top">
              <font color="#FFFFFF" style="background-color:#060">
                &nbsp;<?=$row_detbrg['pembayaran']?>&nbsp;
              </font>
              <br />
              &nbsp;<?php echo $row_detbrg['info'];?>&nbsp;</td>
            <td>
              <a href="index-c-pembayaranpiutang-t-add-k-<?=$row_detbrg['id']?>-<?=$row_data['keluarbarang_id']?>.pos"><img src="images/edit_icon.png" height="16px" width="16px" /></a>
              <img src="images/delete_icon.png" height="16px" width="16px" style="cursor: pointer;" onclick="deleteTransaction(<?=$row_detbrg['id']?>)" />
            </td>
          </tr>
          <?php }while($row_detbrg = mysqli_fetch_assoc($detbrg));?>
          <?php } ?>
          <tr>
            <td align="right" valign="top"><strong>Total :</strong></td>
            <td align="right" valign="top"><?php echo number_format($tbayar,0,',','.');?></td>
            <td align="left" valign="top" colspan="2"></td>
            </tr>
          <tr>
            <td align="right" valign="top"><strong>Sisa :</strong></td>
            <td align="right" valign="top"><?php echo number_format($row_data['total'] - $tbayar,0,',','.');?></td>
            <td align="left" valign="top" colspan="2"></td>
          </tr>
        </table></td>
        <td align="center"><?php if(strstr($_SESSION['akses'],"add_pembayaranpiutang")) { ?><a href="index-c-pembayaranpiutang-t-add-<?=$row_data['keluarbarang_id']?>.pos" title="Pelunasan"><img src="images/paid.png" border="0" /> Pelunasan</a><?php } ?></td>
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
        Periode: 
        <input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
        s/d 
        <input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
        <br />
        <label><input type="radio" name="laporan" id="report1" />Laporan Piutang</label>&nbsp;
        <select>
            <option>All</option>
            <option>Non Jatuh Tempo</option>
            <option>Jatuh Tempo</option>
        </select>
        <br />
        <label><input type="radio" name="laporan" id="report1" />Laporan Piutang Periode</label>&nbsp;
        <select>
            <option>&gt; 3 Bulan</option>
            <option>&gt; 6 Bulan</option>
            <option>&gt; 9 Bulan</option>
            <option>&gt; 12 Bulan</option>
        </select>
        <br />
		<input type="button" value="Cetak" onclick="generateReport();" />
	</p>
    
  </div>
</form>