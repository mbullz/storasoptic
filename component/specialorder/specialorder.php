<?php

global $mysqli;

$tipe = $_POST['tipe'] ?? 1;

$query_data  = "SELECT a.*, b.tgl, barang, frame, c.info AS supplier, d.jenis AS brand, e.kontak AS customer 
				FROM dkeluarbarang a 
				JOIN keluarbarang b ON b.keluarbarang_id = a.keluarbarang_id 
				JOIN barang c ON c.product_id = a.lensa 
				JOIN jenisbarang d ON d.brand_id = c.brand_id 
				JOIN kontak e ON e.user_id = b.client 
				WHERE a.special_order = '1' 
				AND a.special_order_done = '0' ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);
?>
<script type="text/javascript">
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
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<h1>Special Order <?=$tipe=='2'?"Softlens":"Lensa"?></h1>

    <form method="post" id="formTipe">
        Tipe : 
        <select name="tipe" id="tipe" onchange="document.forms['formTipe'].submit();">
            <option value="3" <?php echo ($tipe == 3) ? 'selected' : '' ?>>Lensa</option>
            <option value="2" <?php echo ($tipe == 2) ? 'selected' : '' ?>>Softlens</option>
        </select>
    </form>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">    
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
      <tr>
        <th width="2%" align="center"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th align="center"><font color="#0000CC">TANGGAL</font></th>
        <th align="center"><font color="#0000CC">NO. INV</font></th>
        <th align="center"><font color="#0000CC">SUPPLIER</font></th>
        <th align="center"><font color="#0000CC">CUSTOMER</font></th>
        <th align="center"><font color="#0000CC">PRODUCT</font></th>
        <th width="20%" align="center"><font color="#0000CC">INFO</font></th>
        <th align="center">&nbsp;</th>
      </tr>
		</thead>
        
        <tbody>
      <?php $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['id'];?>" /></td>
        <td align="center"><?php genDate($row_data['tgl']);?></td>
        <td align="center"><?php echo $row_data['noreferensi'];?></td>
        <td align="left"><?=$row_data['supplier']?></td>
        <td align="center"><?=$row_data['customer']?></td>
        <td align="center"><?=$row_data['brand']?> # <?=$row_data['barang']?> # <?=$row_data['frame']?></td>
        <td align="left">&nbsp;</td>
        <td align="center"><input type="button" value="Done" /></td>
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
        <span>
            <input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
        </span>
        s/d 
        <span>
            <input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
        </span><br>
        
        <label>
            <input type="radio" id="cabang1" />
            Laporan Special Order
        </label>
        <select>
            <option>Done</option>
            <option>On Process</option>
        </select>
        <br />
        
        <label>
            <input type="radio" id="cabang2" />
            Laporan Special Order Per Supplier 
        </label>
        <select id="user_id">
            <?php
                $rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'S0001' ORDER BY kontak ASC");
                while ($data2 = mysqli_fetch_assoc($rs2))
                {
                    ?>
                        <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
                    <?php
                }
            ?>
        </select>
        <br />
        
        <label>
            <input type="radio" id="cabang1" />
            Laporan Special Order Terlaris 
        </label>
        <br />
        
		<input type="button" value="Cetak" onclick="generateReport();" />
	</p>
    
  </div>
</form>