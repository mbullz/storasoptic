<?php

	global $mysqli, $c, $branch_id;

	$branch_filter = '';
	if ($branch_id != 0) {
	    $branch_filter = " AND a.branch_id = $branch_id ";
	}

$query_data = "SELECT a.keluarbarang_id, a.referensi, a.tgl, a.total, a.info, 
					b.kontak AS customer_name, b.user_id as customer_id, c.matauang, 
					a.tipe_pembayaran , a.lunas, a.updated_by, 
					d.kontak AS nama_sales, e.kontak AS nama_karyawan 
				FROM keluarbarang a 
				JOIN kontak b ON b.user_id = a.client 
				JOIN matauang c ON a.matauang_id = c.matauang_id 
				LEFT JOIN kontak d ON a.sales = d.user_id 
				LEFT JOIN kontak e ON a.updated_by = e.user_id 
				WHERE 1 = 1 
				$branch_filter 
				ORDER BY a.tgl DESC, a.keluarbarang_id DESC ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);

?>

<script type="text/javascript">
	var data = [];

	<?php
		$rs = $mysqli->query($query_data);
		while ($data = $rs->fetch_assoc()) {
			$keluarbarang_id = $data['keluarbarang_id'];
			$referensi = $data['referensi'];
			$tgl = $data['tgl'];
			$customer_name = htmlspecialchars($data['customer_name'], ENT_QUOTES);
			$total = number_format($data['total'], 0, ',', '.');
			$lunas = $data['lunas'];

			$checkbox = '<input name="data[]" type="checkbox" value="'.$keluarbarang_id.'" />';

			$link_referensi = '<a href="include/draft_invoice_1.php?keluarbarang_id='.$keluarbarang_id.'" target="_blank">'.$referensi.'</a>';

			$edit = '';
			if (strstr($_SESSION['akses'], "edit_".$c)) {
				$edit = '<a href="index.php?component='.$c.'&task=edit&id='.$keluarbarang_id.'" title="Edit Data"><img src="images/edit_icon.png" width="16px" height="16px" /></a>';
			}

			if ($lunas == '1') $lunas = 'Lunas';
			else $lunas = 'Piutang';

			?>
				data.push([
					<?=$keluarbarang_id?>,
					'<?=$checkbox?>',
					'',
					'<?=$tgl?>',
					'<?=$link_referensi?>',
					'<?=$customer_name?>',
					'<?=$total?>',
					'<?=$lunas?>',
					//'<?=$edit?>',
				]);
			<?php
		}
	?>
</script>
<script type="text/javascript" language="javascript" src="js/number_format.js"></script>
<script type="text/javascript" language="javascript" src="js/apps/invoicepenjualan.js"></script>

<style>
	td.details-control {
	    background: url('media/images/details_open.png') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('media/images/details_close.png') no-repeat center center;
	}

	.th {
		color: #660099;
		/*text-align: center;*/
	}
</style>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
	<h1>Data Penjualan</h1>
	
	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?>
		<a href="index-c-<?php echo $c;?>-t-add.pos" class="btn btn-success btn-sm">Tambah Data</a>
		<br /><br />
	<?php } ?>
		  
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<tr>
				<th width="1%"></th>
				<th width="1%" class="th">INFO</th>
				<th class="th">TANGGAL</th>
				<th class="th">NO. INV</th>
				<th class="th">CUSTOMER</th>
				<th class="th">TOTAL</th>
				<th class="th">STATUS</th>
				<!--<th width="8%">Pengaturan</th>-->
			</tr>
		</thead>
		
		<tbody>
		</tbody>

		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th>TANGGAL</th>
				<th>NO. INV</th>
				<th>CUSTOMER</th>
				<th></th>
				<th>STATUS</th>
			</tr>
		</tfoot>
	</table>
	
	  <?php if(strstr($_SESSION['akses'],"delete_".$c)) { ?>
		  <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
		  <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" class="btn btn-danger btn-sm" onclick="javascript:if(prompt('Kode Hapus :') == '0000') return confirm('Lanjutkan Proses ... ?'); else return false;" />
	  <?php } ?>
	  
	  <br /><br />
	  
	  <div>
				Periode: 
				<span>
					<input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
				</span>
				s/d 
				<span>
					<input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
				</span><br>
				
				<label>
					<input type="radio" name="report" id="tipe1" />
					Laporan Data Penjualan:
				</label>
				<select id="tipe">
					<option value="1">Frame</option>
					<option value="2">Softlens</option>
					<option value="3">Lensa</option>
					<option value="4">Accessories</option>
				</select><br>
				
				<label>
					<input type="radio" name="report" id="tipe2" />
					Performance Selling:
				</label>
				<select id="urutanPenjualan">
					<option value="desc">Terbaik</option>
					<option value="asc">Terendah</option>
				</select>
				<br>
				
				<label>
					<input type="radio" name="report" id="tipe3" />
					Laporan Omset
				</label>
				<br>
				
			  <input type="button" value="Cetak" onclick="generateReport();" />
		  </div>
  </div>
</form>
