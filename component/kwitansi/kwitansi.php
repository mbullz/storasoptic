<?php

	global $mysqli, $c, $branch_id;

?>

<script type="text/javascript" language="javascript" src="js/apps/kwitansi.js"></script>

<style>
	
</style>

<input type="hidden" name="c" id="c" value="<?=$c?>" />
<input type="hidden" name="branch_id" id="branch_id" value="<?=$branch_id?>" />

<div class="tablebg">
	<h1>Data Pembayaran</h1>
		  
	<table id="example" class="display">
		<thead>
			<tr>
				<th scope="col" width="10%">TANGGAL</th>
				<th scope="col" width="10%">NO. INV</th>
				<th scope="col">CUSTOMER</th>
				<th scope="col">JUMLAH</th>
                <th scope="col">KETERANGAN</th>
                <th></th>
			</tr>
		</thead>
		
		<tbody>
		</tbody>

		<tfoot>
			<tr>
				<th>TANGGAL</th>
				<th>NO. INV</th>
				<th>CUSTOMER</th>
				<th></th>
                <th></th>
                <th></th>
			</tr>
		</tfoot>
	</table>

</div>
