<?php

    global $mysqli;

    $periode = isset($_POST['periode']) ? $_POST['periode'] : date("Y-m-d");

    $hariini      = date("Y-m");
    $j_hari       = jumlah_hari(date("m"), date("Y"));

?>

<script type="text/javascript" src="js/jquery.fusioncharts.js"></script>

<link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="media/css/dataTables.tableTools.min.css">

<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="media/js/dataTables.tableTools.min.js"></script>

<script type="text/javascript">
/*
$.FusionCharts.config.extend({
	swfPath: '',
	product: 'v3',
	width: '1280'
});
*/
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
	});
</script>
<style>
/*
#fusioncharts {
	border:solid 1px red;
	overflow:scroll;
}
*/
</style>
<!--<meta http-equiv="refresh" content="30" />-->
<h1>General Info
<?php genPeriod($hariini);?>
</h1>
<div style="width:100%">
	<div style="float:left;width:23%;padding:5px;border:solid 1px #0000FF;background-color:#EEE;font-weight:normal;margin-right:5px">
    	<strong>Barang Baru (7 Hari Terakhir)</strong>
        <br />
        <ul>
        <?php
			$query = "SELECT a.referensi, a.tgl, (SELECT SUM(qty) FROM dmasukbarang WHERE noreferensi LIKE a.referensi) AS qty, b.kontak 
					FROM masukbarang a 
					JOIN kontak b ON b.user_id = a.supplier 
					WHERE a.tgl BETWEEN CURDATE()-INTERVAL 7 DAY AND CURDATE() 
					ORDER BY tgl DESC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				?>
                	<li style="font-size:10px">
                    	<strong>Tanggal :</strong> <?=$data['tgl']?><br />
						<strong>Nomor PO :</strong> <?=$data['referensi']?><br />
						<strong>Supplier :</strong> <?=$data['kontak']?><br />
						<strong>Qty :</strong> <?=$data['qty']?> Pcs
					</li>
                <?php
			}
		?>
        </ul>
    </div>
    
    <div style="float:left;width:23%;padding:5px;border:solid 1px #0000FF;background-color:#EEE;font-weight:normal;margin-right:5px">
    	<strong>Retur Stok Barang (7 Hari Terakhir)</strong>
        <br />
        <ul>
        <?php
			$query = "SELECT a.tgl, b.info, SUM(a.qty) AS qty
					FROM terimabarang_r a 
					JOIN barang b ON b.product_id = a.product_id 
					WHERE a.tgl BETWEEN CURDATE()-INTERVAL 7 DAY AND CURDATE() 
					GROUP BY a.tgl, b.info 
					ORDER BY tgl DESC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				?>
                	<li style="font-size:10px">
						<strong>Tanggal :</strong> <?=$data['tgl']?><br />
						<strong>Supplier :</strong> <?=$data['info']?><br />
						<strong>Qty :</strong> <?=$data['qty']?> Pcs
					</li>
                <?php
			}
		?>
        </ul>
    </div>
    
    <div style="float:left;width:23%;padding:5px;border:solid 1px #0000FF;background-color:#EEE;font-weight:normal;margin-right:5px">
    	<strong>Barang Pindah Cabang (7 Hari Terakhir)</strong>
        <br />
        <ul>
        <?php
			$query = "SELECT a.tgl, (SELECT SUM(qty) FROM dkeluarbarang WHERE keluarbarang_id = a.keluarbarang_id) AS qty, b.kontak 
					FROM keluarbarang a 
					JOIN kontak b ON b.user_id = a.client 
					WHERE a.tgl BETWEEN CURDATE()-INTERVAL 7 DAY AND CURDATE() 
					AND b.jenis LIKE 'B001' 
					ORDER BY tgl DESC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				?>
                	<li style="font-size:10px">
                        <strong>Tanggal :</strong> <?=$data['tgl']?><br />
                        <strong>Cabang :</strong> <?=$data['kontak']?><br />
                        <strong>Qty :</strong> <?=$data['qty']?> Pcs
                   	</li>
                <?php
			}
		?>
        </ul>
    </div>
    
    <div style="float:left;width:23%;padding:5px;border:solid 1px #0000FF;background-color:#EEE;font-weight:normal;margin-right:5px">
    	<strong>Penjualan Baru (7 Hari Terakhir)</strong>
        <br />
        <ul>
        <?php
			$query = "SELECT a.referensi, a.tgl, a.total, (SELECT SUM(qty) FROM dkeluarbarang WHERE keluarbarang_id = a.keluarbarang_id) AS qty, b.kontak 
					FROM keluarbarang a 
					JOIN kontak b ON b.user_id = a.client 
					WHERE a.tgl BETWEEN CURDATE()-INTERVAL 7 DAY AND CURDATE() 
					AND b.jenis NOT LIKE 'B001' 
					ORDER BY tgl DESC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				?>
                	<li style="font-size:10px">
						<strong>Tanggal :</strong> <?=$data['tgl']?><br />
						<strong>Nomor Invoice :</strong> <?=$data['referensi']?><br />
						<strong>Customer :</strong> <?=$data['kontak']?><br />
						<strong>Qty :</strong> <?=$data['qty']?> Pcs<br />
                        <strong>Total :</strong> Rp <?=number_format($data['total'],0,".",",")?>
					</li>
                <?php
			}
		?>
        </ul>
    </div>
</div>
<div style="clear:both">&nbsp;</div>
<hr noshade="noshade" size="1" /><br />

<form method="post" id="formPeriode">
    Aktivitas Toko Periode : 
   	<input type="text" class="calendar" name="periode" value="<?=$periode?>" onchange="document.forms['formPeriode'].submit();" />
</form>

<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
	<thead>
    	<tr>
        	<th width="5%"><font color="#660099">&nbsp;</font></th>
            <th align="center" width="20%"><font color="#660099">AKTIVITAS</font></th>
            <th align="center"><font color="#660099">DETAIL</font></th>
            <th align="center" width="15%"><font color="#660099">DEBIT</font></th>
            <th align="center" width="15%"><font color="#660099">KREDIT</font></th>
        </tr>
    </thead>
    
    <tbody>
    	<?php
			$i = 0;
		
			$query = "SELECT a.referensi, a.tgl, a.total, (SELECT SUM(qty) FROM dkeluarbarang WHERE keluarbarang_id = a.keluarbarang_id) AS qty, b.kontak 
					FROM keluarbarang a 
					JOIN kontak b ON b.user_id = a.client 
					WHERE a.tgl = '$periode' 
					AND b.jenis NOT LIKE 'B001' 
					ORDER BY a.referensi ASC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				$i++;
				?>
					<tr>
                        <td align="center"><?=$i?></td>
                        <td style="color:#090">PENJUALAN</td>
                        <td>
                            <div style="float:left;width:100px">
                                Nomor Invoice
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
								<?=$data['referensi']?>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div style="float:left;width:100px">
                                Customer
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                                <?=$data['kontak']?>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div style="float:left;width:100px">
                                Qty
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                              	<?=$data['qty']?> Pcs
                            </div>
                            
                            <div style="clear:both"></div>
                        </td>
                        <td align="center" style="color:#999"><?=number_format($data['total'],0,",",".")?></td>
                        <td align="center">&nbsp;</td>
                    </tr>
                <?php
				
				$query2 = "SELECT a.jumlah, a.info, b.pembayaran 
					FROM aruskas a 
					JOIN carabayar b ON b.carabayar_id = a.carabayar_id 
					WHERE a.tgl = '$periode' 
					AND a.referensi LIKE '$data[referensi]' 
					ORDER BY a.id ASC";
				$rs2 = $mysqli->query($query2);
				while ($data2 = mysqli_fetch_assoc($rs2))
				{
					$i++;
					?>
                    	<tr>
                            <td align="center"><?=$i?></td>
                            <td style="color:#FC0">ARUS KAS</td>
                            <td>
                                <div style="float:left;width:100px">
                                   	Nomor Invoice
                                </div>
                                
                                <div style="float:left;width:25px;text-align:center">
                                    :
                                </div>
                                
                                <div style="float:left;font-weight:normal">
                                    <?=$data['referensi']?>
                                </div>
                                
                                <div style="clear:both"></div>
                                
                                <div style="float:left;width:100px">
                                   	Cara Bayar
                                </div>
                                
                                <div style="float:left;width:25px;text-align:center">
                                    :
                                </div>
                                
                                <div style="float:left;font-weight:normal">
                                    <?=$data2['pembayaran']?>
                                </div>
                                
                                <div style="clear:both"></div>
                                
                                <div style="float:left;width:100px">
                                   	Info
                                </div>
                                
                                <div style="float:left;width:25px;text-align:center">
                                    :
                                </div>
                                
                                <div style="float:left;font-weight:normal">
                                    <?=$data2['info']?>
                                </div>
                                
                                <div style="clear:both"></div>
                            </td>
                            <td align="center" style="color:#090"><?=number_format($data2['jumlah'],0,",",".")?></td>
                            <td align="center">&nbsp;</td>
                        </tr>
                    <?php
				}
			}
			
			$query = "SELECT a.referensi, a.tgl, (SELECT SUM(qty) FROM dmasukbarang WHERE noreferensi LIKE a.referensi) AS qty, b.kontak, (SELECT SUM(subtotal) FROM dmasukbarang WHERE noreferensi = a.referensi) AS total 
					FROM masukbarang a 
					JOIN kontak b ON b.user_id = a.supplier 
					WHERE a.tgl = '$periode' 
					ORDER BY referensi ASC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				$i++;
				?>
                	<tr>
                        <td align="center"><?=$i?></td>
                        <td style="color:#00F">PEMBELIAN</td>
                        <td>
                            <div style="float:left;width:100px">
                                Nomor PO
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
								<?=$data['referensi']?>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div style="float:left;width:100px">
                                Supplier
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                                <?=$data['kontak']?>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div style="float:left;width:100px">
                                Qty
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                              	<?=$data['qty']?> Pcs
                            </div>
                            
                            <div style="clear:both"></div>
                        </td>
                        <td align="center">&nbsp;</td>
                        <td align="center" style="color:#F00"><?=number_format($data['total'],0,",",".")?></td>
                    </tr>
                <?php
			}
			
			$query = "SELECT a.tgl, b.info, SUM(a.qty) AS qty
					FROM terimabarang_r a 
					JOIN barang b ON b.product_id = a.product_id 
					WHERE a.tgl = '$periode' 
					GROUP BY a.tgl, b.info 
					ORDER BY id ASC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				$i++;
				?>
                	<tr>
                        <td align="center"><?=$i?></td>
                        <td style="color:#F00">RETUR</td>
                        <td>
                            <div style="float:left;width:100px">
                                Supplier
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                                <?=$data['info']?>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div style="float:left;width:100px">
                                Qty
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                              	<?=$data['qty']?> Pcs
                            </div>
                            
                            <div style="clear:both"></div>
                        </td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                <?php
			}
			
			$query = "SELECT a.tgl, (SELECT SUM(qty) FROM dkeluarbarang WHERE keluarbarang_id = a.keluarbarang_id) AS qty, b.kontak 
					FROM keluarbarang a 
					JOIN kontak b ON b.user_id = a.client 
					WHERE a.tgl = '$periode' 
					AND b.jenis LIKE 'B001' 
					ORDER BY referensi ASC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				$i++;
				?>
                	<tr>
                        <td align="center"><?=$i?></td>
                        <td style="color:#909">PINDAH CABANG</td>
                        <td>
                            <div style="float:left;width:100px">
                                Supplier
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                                <?=$data['kontak']?>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div style="float:left;width:100px">
                                Qty
                            </div>
                            
                            <div style="float:left;width:25px;text-align:center">
                                :
                            </div>
                            
                            <div style="float:left;font-weight:normal">
                              	<?=$data['qty']?> Pcs
                            </div>
                            
                            <div style="clear:both"></div>
                        </td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                <?php
			}
			
			$query = "SELECT a.jumlah, a.info, b.pembayaran 
				FROM aruskas a 
				JOIN carabayar b ON b.carabayar_id = a.carabayar_id 
				WHERE a.tgl = '$periode' 
				AND tipe LIKE 'operasional'
				ORDER BY a.id ASC";
			$rs = $mysqli->query($query);
			while ($data = mysqli_fetch_assoc($rs))
			{
				$i++;
				?>
					<tr>
						<td align="center"><?=$i?></td>
						<td style="color:#FC0">BIAYA OPERASIONAL</td>
						<td>
							<div style="float:left;width:100px">
								Info
							</div>
							
							<div style="float:left;width:25px;text-align:center">
								:
							</div>
							
							<div style="float:left;font-weight:normal">
								<?=$data['info']?>
							</div>
							
							<div style="clear:both"></div>
							
							<div style="float:left;width:100px">
								Cara Bayar
							</div>
							
							<div style="float:left;width:25px;text-align:center">
								:
							</div>
							
							<div style="float:left;font-weight:normal">
								<?=$data['pembayaran']?>
							</div>
							
							<div style="clear:both"></div>
						</td>
						<td align="center">&nbsp;</td>
						<td align="center" style="color:#F00"><?=number_format($data['jumlah'],0,",",".")?></td>
					</tr>
				<?php
			}
		?>
    </tbody>
</table>
