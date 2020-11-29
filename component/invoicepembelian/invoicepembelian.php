<?php

	global $mysqli, $c, $branch_id;

?>

<script type="text/javascript" language="javascript" src="js/number_format.js"></script>
<script type="text/javascript" language="javascript" src="js/apps/invoicepembelian.js"></script>

<style>
	table thead tr th {
		color: #0000CC;
	}

	td.details-control {
		background: url('media/images/details_open.png') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('media/images/details_close.png') no-repeat center center;
	}
</style>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
	<input type="hidden" name="c" id="c" value="<?=$c?>" />
	<input type="hidden" name="branch_id" id="branch_id" value="<?=$branch_id?>" />

  <div class="tablebg">
	<h1>Data Pembelian</h1>
	
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<tr>
				<th width="1%"></th>
				<th width="1%">INFO</th>
				<th>TANGGAL</th>
				<th>NO. PO</th>
				<th>SUPPLIER</th>
				<th>TOTAL</th>
				<th>TIPE</th>
				<th></th>
			</tr>
		</thead>
		
		<tbody>
		</tbody>

		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th>TANGGAL</th>
				<th>NO. PO</th>
				<th>SUPPLIER</th>
				<th></th>
				<th>TIPE</th>
				<th></th>
			</tr>
		</tfoot>
	</table>

	<br />

	  <?php if (strstr($_SESSION['akses'], "delete_".$c)) { ?>
		  <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
		  <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="javascript:if(prompt('Kode Hapus :') == '0000') return confirm('Lanjutkan Proses ... ?'); else return false;"/>
	  <?php } ?>
	  
	<br /><br /><br />

	</div>
</form>

<!--
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
-->
