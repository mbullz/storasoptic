<?php

global $mysqli;
require('include/define.php');

$tipe = $_POST['tipe'] ?? 1;

$query_data  = "SELECT a.*, b.jenis 
				FROM barang a 
				JOIN jenisbarang b ON b.brand_id = a.brand_id 
				WHERE a.tipe = $tipe 
				AND qty > 0 ";
//----
$query_all   = $query_data;

$query_data .= " ORDER BY b.jenis ASC, a.barang ASC ";
$data = $mysqli->query($query_data);

//---
$alldata = $mysqli->query($query_all);
$totalRows_data = mysqli_num_rows($alldata);

$row_header = array(
	array('BRAND', 'KODE', 'FRAME', 'BARANG', 'WARNA', 'QTY', 'INFO', ''),
	array('BRAND', 'KODE', 'MINUS', 'BARANG', 'WARNA', 'QTY', 'INFO', ''),
	array('BRAND', 'KODE', 'MINUS', 'BARANG', 'SILINDER', 'QTY', 'INFO', ''),
	array('BRAND', 'KODE', '', 'BARANG', '', 'QTY', 'INFO', '')
);
//$frames = array("-", "Plastic Frame", "Metal Frame", "Sunglasses", "Frameless");

?>

<script type="text/javascript" language="javascript" src="js/apps/masterbarang.js"></script>

<style>
	.animate
	{
		transition: all 0.1s;
		-webkit-transition: all 0.1s;
	}
	
	.action-button
	{
		position: relative;
		padding: 10px 15px;
		margin: 0px 10px 10px 0px;
		float: left;
		border-radius: 0px;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 14px;
		text-decoration: none;
	}
	
	.action-button:hover
	{
		color: #FFF;
		text-decoration: none;
	}
	
	.blue
	{
		background-color: #3498DB;
		border-bottom: 5px solid #2980B9;
	}
	
	.green
	{
		background-color: #82BF56;
		border-bottom: 5px solid #669644;
	}
	
	.action-button:active
	{
		transform: translate(0px,5px);
		-webkit-transform: translate(0px,5px);
		border-bottom: 1px solid;
	}
</style>

<style>
	td.details-control {
	    background: url('media/images/details_open.png') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('media/images/details_close.png') no-repeat center center;
	}
</style>

<input type="hidden" id="totalRows_data" value="<?=$totalRows_data?>" />

<h1>Master Barang</h1>
<div>
	<?php
		if(strstr($_SESSION['akses'],"add_".$c))
		{
			?>
				<img src="images/add2.png" height="64px" title="Input Barang Baru" class="tooltip" style="cursor:pointer;" onclick="javascript:window.location='index-c-masterbarang-t-add-k-importcsv.pos';" />
			<?php
		}
	?>
	<!--<a href="export_xls.php?tabel=barang" class="action-button animate green" title="Export Data XLS">Export Data</a>-->
</div>

<div style="clear:both;margin-top:10px;">
	<form method="post" id="formTipe">
		Tipe : 
		<select name="tipe" id="tipe" onchange="document.forms['formTipe'].submit();">
			<option value="1" <?php echo ($tipe == 1) ? 'selected' : '' ?>>Frame</option>
            <option value="2" <?php echo ($tipe == 2) ? 'selected' : '' ?>>Softlens</option>
            <option value="3" <?php echo ($tipe == 3) ? 'selected' : '' ?>>Lensa</option>
            <option value="4" <?php echo ($tipe == 4) ? 'selected' : '' ?>>Accessories</option>
		</select>
	</form>
</div>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<tr>
				<th align="center">
                    <input type="checkbox" name="checkbox" value="checkbox" onclick="checkAll(this.checked)" />
                    <font color="#660099" id="totalChecked">(0)</font>
				</th>
		
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][0]?></font>
				</th>
				
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][1]?></font>
				</th>
		
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][2]?></font>
				</th>
		
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][3]?></font>
				</th>
				
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][4]?></font>
				</th>
		
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][5]?></font>
				</th>
		
				<th align="center">
					<font color="#660099"><?=$row_header[$tipe-1][6]?></font>
				</th>
				
				<th>&nbsp;
					
				</th>
			</tr>
		</thead>
        
        <tfoot>
			<tr>
				<th>
				</th>
		
				<th>
					<?=$row_header[$tipe-1][0]?>
				</th>
				
				<th>
					<?=$row_header[$tipe-1][1]?>
				</th>
		
				<th>
					<?=$row_header[$tipe-1][2]?>
				</th>
		
				<th>
					<?=$row_header[$tipe-1][3]?>
				</th>
				
				<th>
					<?=$row_header[$tipe-1][4]?>
				</th>
		
				<th>
				</th>
		
				<th>
				</th>
				
				<th>
				</th>
			</tr>
		</tfoot>
		
		<tbody>
			<?php
				$no=0;
				
				while ($row_data = mysqli_fetch_assoc($data))
				{
					?>
						<tr>
							<td align="center">
								<input type="hidden" id="hiddenNo<?=$row_data['product_id']?>" value="<?=$no?>" />
								<input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['product_id'];?>" />
							</td>
                            
                            <td id="tdBrand<?=$no-1?>" align="center">
								<?=$row_data['jenis']?>
							</td>
							
							<td align="center">
								<?=$row_data['kode']?>
								<input type="hidden" id="hiddenProductId<?=$no-1?>" value="<?=$row_data['product_id']?>" />
							</td>
							
							<td align="center">
								<?=$row_data['frame']?>
							</td>
							
							<td id="tdKode<?=$no-1?>" align="center">
								<?=$row_data['barang']?>
							</td>
	
							<td id="tdColor<?=$no-1?>" align="center">
								<?=$row_data['color']?>
							</td>
	
							<td align="center">
								<?=$row_data['qty']?>
							</td>

							<td align="center">
								
							</td>
	
							<td align="center">
								<?php
									if(strstr($_SESSION['akses'],"edit_".$c))
									{
										?>
											<a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['product_id'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" /> Edit</a>
										<?php
									}
								?>
							</td>
						</tr>
					<?php
				}
			?>
		</tbody>
	</table>
	
	<img src="images/arrow_ltr.png" />&nbsp;&nbsp;
	<?php
		if(strstr($_SESSION['akses'],"delete_".$c))
		{
			?>
				<!--<input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="javascript:if(prompt('Kode Hapus :') == '1234') return confirm('Lanjutkan Proses ... ?'); else return false;"/>-->
				<input type="button" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="deleteProduct()"/>
			<?php
		}
	?>
	<input type="button" value="Pindah Cabang" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="pindahCabang()" />
	<input type="button" value="Retur" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="returSome()" />
	<input type="button" value="Print Label" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="openDialogPrintInvoice()" />

  </div>
</form>

<div id="dialog">
	<table width="100%" id="dialogTableDetail">
	</table>

	<table width="100%">
		<tr>
			<td>
				Cabang
			</td>
			
			<td>
				:
			</td>
			
			<td>
				<select id="cabang">
					<option>-- Pilih Cabang --</option>
					<?php
					  $rs2 = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'B001' ORDER BY kontak ASC");
					  while ($data2 = mysqli_fetch_assoc($rs2))
					  {
						?>
						  <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
						<?php
					  }
					?>
				</select>
			</td>
		</tr>
	</table>	
</div>

<div id="dialog2">
	<table border="0" cellpadding="2" cellspacing="0">
		<tr>
			<td>
				Info
			</td>

			<td>
				:
			</td>

			<td>
				<textarea id="textReturInfo"></textarea>
			</td>
		</tr>

		<tr>
			<td>
				Qty
			</td>

			<td>
				:
			</td>

			<td>
				<input type="text" id="textReturQty" size="1" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" />
			</td>
		</tr>
	</table>

	<input type="hidden" id="hiddenReturProductId" value="">
</div>

<div id="dialog3">
	<h2>Print Label</h2>
</div>

<div id="dialogReturSome">
	<table width="100%" id="dialogTableDetail2">
	</table>

	<table width="100%">
		<tr>
			<td>
				Info
			</td>
			
			<td>
				:
			</td>
			
			<td>
				<textarea id="textReturInfo2"></textarea>
			</td>
		</tr>
	</table>	
</div>

<script>
	refreshJenis();
	onLoad();
</script>