<?php

	global $mysqli, $c, $branch_id;

?>

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

	tr.status-order {
		background-color: #ffeeba !important;
	}

	tr.status-ready {
		background-color: #c3e6cb !important;
	}
</style>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
	<input type="hidden" name="c" id="c" value="<?=$c?>" />
	<input type="hidden" name="branch_id" id="branch_id" value="<?=$branch_id?>" />

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
	  

		<!--
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
		-->

	</div>
</form>
