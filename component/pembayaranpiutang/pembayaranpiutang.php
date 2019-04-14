<?php
include('include/define.php');
include('include/config_db.php');

$query_data = "SELECT 
					a.*, c.kontak AS customer 
				FROM keluarbarang a 
				JOIN kontak c ON a.client = c.user_id 
				WHERE a.lunas LIKE '1' 
				AND referensi NOT LIKE 'PCB%' 
				ORDER BY a.tgl DESC, a.keluarbarang_id DESC ";
//----
$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);
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
        var url = 'component/pembayaranpiutang/task/report_pembayaranpiutang.php';
        var data = '?mode=general_report&tipe=' + tipe + '&sp=' + sp + '&ep=' + ep + "&customer=" + customer;
        
        NewWindow(url + data,'name','720','520','yes');
    }
}

	function deleteProduct()
	{
		if (prompt('Kode Hapus :') == '1234') 
			if (confirm('Lanjutkan Proses ... ?\n\n(* data yang terhapus akan terhapus juga di data penjualan)'))
		{
			var oTable = $("#example").dataTable();
			var data = "";

			oTable.$('input:checked').each(function()
			{
				data += $(this).val() + "#";
			});

			$.ajax(
			{
				url: 'component/pembayaranpiutang/task/_delete.php',
				type: 'POST',
				data: "data=" + data,
				success: function()
				{
					alert("Sukses Menghapus Data");

					window.location = "<?=$base_url?>index-c-pembayaranpiutang.pos";
				}
			});
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

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
    <h1>Pembayaran Lunas</h1>
    
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
	  <tr>
        <th width="12%" align="center"><font color="#0000CC">TANGGAL</font></th>
		<th width="18%" align="center"><font color="#0000CC">CUSTOMER</font></th>
        <th width="15%" align="center"><font color="#0000CC">NO. INV</font></th>
        <th width="15%" align="center"><font color="#0000CC">JUMLAH</font></th>
        <th align="center"><font color="#0000CC">INFO</font></th>
	  </tr>
		</thead>
        
        <tbody>
	  <?php $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
	  <tr valign="top">
		<td align="center"><?php echo $row_data['tgl']; ?></td>
		<td align="center"><?php echo $row_data['customer']; ?></td>
		<td align="center"><?php echo $row_data['referensi']; ?></td>
		<td align="center"><?php echo 'Rp. ' . number_format($row_data['total']); ?></td>
		<td align="center">
			<?php
				$query_detail = "SELECT a.*, b.pembayaran 
					FROM aruskas a 
					JOIN carabayar b ON b.carabayar_id = a.carabayar_id 
					WHERE tipe = 'piutang' 
					AND transaction_id = $row_data[keluarbarang_id] 
					ORDER BY tgl ASC, id ASC ";

				$detail = $mysqli->query($query_detail);
				$total_detail = mysqli_num_rows($detail);
			?>
			<small style="float:right;">[ <a href="javascript:void(0);" onclick="viewInfo('info_<?php echo $row_data['referensi'];?>');">Lihat Info</a> ]</small>
			<table width="100%" border="0" cellpadding="2" cellspacing="0" id="info_<?php echo $row_data['referensi'];?>" style="display:none;">
				<thead>
					<tr>
						<th>Tanggal Bayar</th>
						<th>Pembayaran</th>
						<th>Jumlah</th>
						<th>Info</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php while (($row_detail = mysqli_fetch_assoc($detail)) != NULL) { ?>
					<tr>
						<td><?php echo $row_detail['tgl']; ?></td>
						<td><?php echo $row_detail['pembayaran']; ?></td>
						<td><?php echo 'Rp. ' . number_format($row_detail['jumlah']); ?></td>
						<td><?php echo $row_detail['info']; ?></td>
						<td>
							<a href="index.php?component=<?=$c?>&amp;task=add&amp;id=<?=$row_data['keluarbarang_id']?>&amp;klasifikasi=<?=$row_detail['id']?>" title="Edit Data">
								<img src="images/edit_icon.png" width="16px" height="16px" />
							</a>
							<img src="images/delete_icon.png" height="16px" width="16px" style="cursor: pointer;" onclick="deleteTransaction(<?=$row_detail['id']?>)" />
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</td>
	  </tr>
	  <?php } ?>
		</tbody>
	</table>
      
	<p>
        Cetak Laporan Piutang Terbayar:<br>
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
            Customer:
        </label>
        <select id="customer">
            <option value="">All</option>
            <?php
                $rs2 = $mysqli->query("SELECT a.kode,kontak FROM kontak a JOIN jeniskontak b ON a.jenis = b.kode WHERE b.klasifikasi like 'customer'");
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
	</p>
    
  </div>
</form>