<?php

	global $mysqli, $c, $branch_id;

	$branch_filter = '';
	if ($branch_id != 0) {
	    $branch_filter = " AND a.branch_id = $branch_id ";
	}

$query_data = "SELECT a.keluarbarang_id, a.referensi, a.tgl, a.total, a.info, 
					b.kontak AS customer_name, b.user_id as customer_id, c.matauang, 
					a.tipe_pembayaran , a.lunas, a.updated_by, 
					d.kontak AS nama_sales, e.kontak AS nama_karyawan, 
					f.id AS keluarbarang_order_id, f.status AS status_order 
				FROM keluarbarang a 
				JOIN kontak b ON b.user_id = a.client 
				JOIN matauang c ON a.matauang_id = c.matauang_id 
				LEFT JOIN kontak d ON a.sales = d.user_id 
				LEFT JOIN kontak e ON a.updated_by = e.user_id 
				LEFT JOIN keluarbarang_order f ON a.keluarbarang_id = f.keluarbarang_id 
				WHERE 1 = 1 
				AND f.status < 3 
				$branch_filter 
				ORDER BY f.status DESC, f.updated_at DESC, a.keluarbarang_id DESC ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);

?>

<script type="text/javascript">
	var data = [];

	<?php
		$rs = $mysqli->query($query_data);
		while ($data = $rs->fetch_assoc()) {
			$keluarbarang_id = $data['keluarbarang_id'];
			$keluarbarang_order_id = $data['keluarbarang_order_id'];
			$referensi = $data['referensi'];
			$tgl = $data['tgl'];
			$customer_name = htmlspecialchars($data['customer_name'], ENT_QUOTES);
			$total = number_format($data['total'], 0, ',', '.');
			$lunas = $data['lunas'];
			$status_order = $data['status_order'] ?? 0;
			$status_order_name = $status_order == 1 ? 'Order' : 'Ready';
			$next_status = $status_order == 1 ? 'Ready' : 'Complete';

			$link_referensi = '<a href="include/draft_invoice_1.php?keluarbarang_id='.$keluarbarang_id.'" target="_blank">'.$referensi.'</a>';

			$buttonUpdate = '<button type="button" class="btn btn-primary btn-sm" onclick="updateStatus(' . $keluarbarang_order_id . ')">' . $next_status . '</button>';

			?>
				data.push([
					<?=$keluarbarang_id?>,
					'',
					'<?=$tgl?>',
					'<?=$link_referensi?>',
					'<?=$customer_name?>',
					'<?=$status_order_name?>',
					'<?=$buttonUpdate?>',
					<?=$status_order?>,
				]);
			<?php
		}
	?>
</script>
<script type="text/javascript" language="javascript" src="js/number_format.js"></script>
<script type="text/javascript" language="javascript" src="js/apps/penjualanorder.js"></script>

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

	tr.status-order {
		background-color: #ffeeba !important;
	}

	tr.status-ready {
		background-color: #c3e6cb !important;
	}
</style>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>

  <div class="tablebg">
	<h1>Penjualan Order</h1>
		  
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<tr>
				<th width="1%" class="th">INFO</th>
				<th class="th">TANGGAL</th>
				<th class="th">NO. INV</th>
				<th class="th">CUSTOMER</th>
				<th class="th">STATUS</th>
				<th width="1%">&nbsp;</th>
			</tr>
		</thead>
		
		<tbody>
		</tbody>

		<tfoot>
			<tr>
				<th></th>
				<th>TANGGAL</th>
				<th>NO. INV</th>
				<th>CUSTOMER</th>
				<th>STATUS</th>
				<th></th>
			</tr>
		</tfoot>
	</table>
	  
  </div>
