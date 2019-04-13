<?php

global $mysqli;

$query_data  = "SELECT a.masukbarang_id, a.referensi, a.tgl, (SELECT SUM(subtotal) FROM dmasukbarang WHERE noreferensi LIKE a.referensi) AS total, a.info, b.kontak, c.matauang, a.lunas 
				FROM masukbarang a 
				JOIN kontak b ON a.supplier = b.user_id 
				JOIN matauang c ON a.matauang_id = c.matauang_id 
				ORDER BY a.tgl DESC , a.masukbarang_id DESC ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);
?>
<script type="text/javascript">
function generateReport(){
    var tipe = $("#tipe").val();
	var supplier = $("#supplier").val();
    var sp = $("#startPeriode").val();
    var ep = $("#endPeriode").val();
    if (sp == '') {
        alert('Tanggal mulai harus diisi');
    } else if (ep == '') {
        alert('Tanggal selesai harus diisi');
    } else {
        var url = 'component/invoicepembelian/task/report_invoicepembelian.php';
        var data = '?mode=general_report&tipe=' + tipe + '&sp=' + sp + '&ep=' + ep + "&supplier=" + supplier;
        
        NewWindow(url + data,'name','900','600','yes');
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
	
	$().ajaxStart(function()
	{
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function()
	{
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#formdata').submit(function()
	{
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
	
	$('#result').click(function()
	{
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
    <h1>Data Barang Masuk</h1>
    
	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><!--<a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a>--><?php } ?>
    
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
      <tr>
        <th width="2%" align="center"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
        <th width="12%" align="center"><font color="#0000CC">TANGGAL</font></th>
        <!--<th width="12%" align="center"><font color="#0000CC">NO. PO</font></th>-->
        <th width="20%" align="center"><font color="#0000CC">SUPPLIER</font></th>
        <th width="13%" align="center"><font color="#0000CC">TOTAL PRICE LIST</font></th>
        <th align="center"><font color="#0000CC">INFO</font></th>
		<!--<th width="8%" align="center"><font color="#0000CC">PENGATURAN</font></th>-->
      </tr>
		</thead>
        
        <tbody>
      <?php $doneList = array(); $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
      <?php
		// list detail barang
		$query_detbrg = "select a.id, a.qty, b.product_id, b.barang, b.color, a.subtotal, a.harga, c.satuan_id as sid, c.satuan, d.jenis from dmasukbarang a join barang b on a.product_id=b.product_id join satuan c on a.satuan_id=c.satuan_id join jenisbarang d on b.brand_id = d.brand_id where a.noreferensi='$row_data[referensi]' order by a.id desc";
		$detbrg       = $mysqli->query($query_detbrg);
		$row_detbrg   = mysqli_fetch_assoc($detbrg);
		$total_detbrg = mysqli_num_rows($detbrg);
	  ?>
      <tr valign="top">
        <td align="center"><input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['referensi'];?>" /></td>
        <td align="center"><?php genDate($row_data['tgl']);?></td>
        <!--<td align="center"><a href="include/draft_po.php?referensi=<?php echo $row_data['referensi'];?>" onclick="NewWindow(this.href,'name','720','520','yes');return false" title="Draft PO <?php echo $row_data['referensi'];?>"><?php echo $row_data['referensi'];?></a></td>-->
        <td align="left"><?php echo $row_data['kontak'];?></td>
        <td align="right"><?php echo number_format($row_data['total'],0,',','.');?> <?php echo $row_data['matauang'];?></td>
        <td align="left">
        <small style="float:right;"><img id="stat-<?php echo $row_data['referensi']; ?>" src="images/done.png" style="display:none" /> [ <a href="javascript:void(0);" onclick="viewInfo('info_<?php echo $row_data['referensi'];?>');">Lihat Info</a> ]</small>
        <table width="100%" border="0" cellpadding="2" cellspacing="0" id="info_<?php echo $row_data['referensi'];?>" style="display:none">
          <tr>
            <th valign="top">Barang</th>
            <th valign="top" width="15%">Qty</th>
            <th valign="top" width="30%">Subtotal</th>
          </tr>
          <?php $done = true; do { ?>
          <?php 
		  // terima barang
		  $query_terbrg = "select sum(qty) as terima from terimabarang where noreferensi='$row_data[referensi]' AND product_id='$row_detbrg[product_id]' AND satuan_id='$row_detbrg[sid]'";
		  $terbrg       = $mysqli->query($query_terbrg);
		  $row_terbrg   = mysqli_fetch_assoc($terbrg);
		  // retur barang
		  $query_retur  = "select sum(qty) as retur from terimabarang_r where noreferensi='$row_data[referensi]' AND product_id='$row_detbrg[product_id]' AND satuan_id='$row_detbrg[sid]'";
		  $retur        = $mysqli->query($query_retur);
		  $row_retur    = mysqli_fetch_assoc($retur);
		  // ---
		  $terima       = intval($row_terbrg['terima'] - $row_retur['retur']);
		  ?>
          <tr>
            <td valign="middle">
                <?=$row_detbrg['jenis']?>
                <br />
                <?=$row_detbrg['barang']?> # <?=$row_detbrg['color']?>
                <img src="images/done.png" />
                <?php
					/*
                	if($row_detbrg['qty'] > $terima)
					{
						$done = false;
						?>
                            <!--
                            <a href="index-c-<?php echo $c;?>-t-barangmasuk-<?php echo $row_detbrg['id'];?>.pos" title="Input Penerimaan Barang">
                            <img src="images/delivery.png" border="0" /></a>
                            -->
							<img src="images/done.png" />
                		<?php
					}
					else
					{
						?>
							<img src="images/done.png" />
                		<?php
					}
					
					if($terima > 0)
					{
						?>
                    		<a href="index-c-<?php echo $c;?>-t-barangreturmasuk-<?php echo $row_detbrg['id'];?>.pos" title="Retur Penerimaan Barang">
							<img src="images/trash.png" width="16" height="16" border="0" /></a>
                		<?php
					}
					*/
				?>
            </td>
            <td align="center" valign="middle"><?php echo number_format($row_detbrg['qty'],0,',','.');?> <?php echo $row_detbrg['satuan'];?></td>
            <td align="right" valign="middle">
            	<font style="font-weight:normal">( @<?=number_format($row_detbrg['harga'],0,',','.')?> )</font><br /><?=number_format($row_detbrg['subtotal'],0,',','.')?>
			</td>
          </tr>
          <?php 
			} while($row_detbrg = mysqli_fetch_assoc($detbrg)); 
			
			if ($done) {
				array_push($doneList, $row_data['referensi']);
			}
		  ?>
        </table></td>
        <!--
        <td align="center">
            <?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?>
            <?php if ($row_data['lunas'] == 0) { ?>
            <a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['referensi'];?>" title="Edit Data">
                <img src="images/edit-icon.png" border="0" />
                Edit
            </a>
            <?php } else { ?>
                <img src="images/edit-icon.png" border="0" />
                <strike>&nbsp;Edit&nbsp;</strike>
            <?php } ?>
            <?php } ?>
        </td>
        -->
        </tr>
      <?php } ?>
		</tbody>
	</table>

      <?php if(strstr($_SESSION['akses'],"delete_".$c)) { ?>
          <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
          <label>
          <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="javascript:if(prompt('Kode Hapus :') == '1234') return confirm('Lanjutkan Proses ... ?'); else return false;"/>
        </label>
        <!--<a href="export_xls.php?tabel=masukbarang" title="Export Data XLS"><img src="images/_xls.png" width="20" height="20" border="0" align="right" /></a>-->
      <?php } ?>
      
	<br /><br />

</div>
</form>

<style>
	.gradientBoxesWithOuterShadows
	{
		width: 80%;
		padding: 20px;
		background-color: white; 
		border:solid 1px #000000;
		line-height: 2;
		font-weight: normal;
		font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
		
		/* outer shadows  (note the rgba is red, green, blue, alpha) */
		-webkit-box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.4); 
		-moz-box-shadow: 0px 1px 6px rgba(23, 69, 88, 0.5);
		box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.4);
		
		/* rounded corners */
		/*
		-webkit-border-radius: 12px;
		-moz-border-radius: 7px; 
		border-radius: 7px;
		*/
		
		/* gradients */
		background: -webkit-gradient(linear, left top, left bottom, 
		color-stop(0%, white), color-stop(15%, white), color-stop(100%, #D7E9F5)); 
		background: -moz-linear-gradient(top, white 0%, white 55%, #D5E4F3 130%);
	}
</style>

<div class="gradientBoxesWithOuterShadows">
	<font style="font-size:14px">CETAK LAPORAN PEMBELIAN</font>
	<br />
    Tipe : 
    <select id="tipe">
        <option value="1">Frame</option>
        <option value="2">Softlens</option>
        <option value="4">Accessories</option>
    </select><br>
    Periode : 
    <span>
        <input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
    </span>
    s/d 
    <span>
        <input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
    </span><br>
    <label>
        Perusahaan : 
    </label>
    <select id="supplier">
        <option value="">All</option>
        <?php
            $rs2 = $mysqli->query("SELECT a.user_id , kontak FROM kontak a JOIN jeniskontak b ON a.jenis = b.kode WHERE b.klasifikasi like 'supplier' ORDER BY kontak ASC");
            while ($data2 = mysqli_fetch_assoc($rs2))
            {
                ?>
                    <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
                <?php
            }
        ?>
    </select>
    <br />
    <input type="button" value="Cetak" onclick="generateReport();" />
</div>
<br />

<?php if (count($doneList) > 0) { ?>
<script type="text/javascript">
	<?php foreach($doneList as $lst) { ?>
	$("#stat-<?php echo $lst; ?>").show();
	<?php } ?>
</script>
<?php } ?>