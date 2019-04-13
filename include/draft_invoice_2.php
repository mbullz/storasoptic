<?php
session_start();
include('config_db.php');
include('function.php');
include('config.php');
$ref = $mysqli->real_escape_string($_GET['ref']);
$tgl = $_GET['tgl'];
$dp = $_GET['dp'];
$c = $_GET['cust'];
$karyawan = $_GET['karyawan'];
$tipe_pembayaran = $_GET['tipe_pembayaran'];
$sudahbayar = $_GET['sudahbayar'];
// get order
/* $query_gorder = "select a.referensi, a.tgl, a.total, a.info, a.sales, b.kontak, b.kperson, b.alamat, b.notlp, b.notlp2, b.hp, c.matauang from keluarbarang a, kontak b, matauang c where a.client = b.kode AND a.matauang = c.kode AND a.referensi='$ref'";
  $gorder       = $mysqli->query($query_gorder);
  $row_gorder   = mysqli_fetch_assoc($gorder); */
// get customer
$query_cust = "SELECT * FROM kontak WHERE user_id = $c";
$cust = $mysqli->query($query_cust);
$row_cust = mysqli_fetch_assoc($cust);
$total_cust = mysqli_num_rows($cust);
// list detail barang
$query_detbrg = "SELECT a.*, c.satuan, d.jenis, 
                        b.kode, b.barang, b.color
                FROM dkeluarbarang a 
                LEFT JOIN barang b ON b.product_id = a.product_id 
                LEFT JOIN satuan c ON c.satuan_id = a.satuan_id 
                LEFT JOIN jenisbarang d ON d.brand_id = b.brand_id 
                WHERE a.noreferensi LIKE '$ref' 
                ORDER BY a.id";
$detbrg = $mysqli->query($query_detbrg);
$total_detbrg = mysqli_num_rows($detbrg);

// get sales / kary
$query_gkary = "select kontak from kontak where user_id = $karyawan";
$gkary       = $mysqli->query($query_gkary);
$row_gkary   = mysqli_fetch_assoc($gkary);
?>
<style type="text/css" media="all">
    body {
        margin:1px;
        padding:0;
        font-family: tahoma;
		letter-spacing: 1.5px;
        color:#000;
    }
    .divInvoice {
        /*border:solid 1px #030303;*/

    }
    .divInvoice tr td {
        font-size:10px;
    }
    .garisbawah {
        border-bottom:solid 2px #000;	
    }
    #divOrder {
        border:solid 2px #000;	
    }
    #divOrder tr th {
        font-size:11px;
        font-weight:bold;
       	background:#CCC;
    }
</style>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="divInvoice">
        <tr>
            <td align="left">
                <h2><?=$GLOBALS['company_name']?></h2>
                <p>
                   	<?=$GLOBALS['company_address']?>
                </p>
            </td>
            
            <td align="center" valign="bottom" class="garisbawah" width="40%">
            	<strong>No. Invoice / Tanggal</strong> : <?=$ref?> / <?=$tgl?>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="divInvoice">
        <tr>
            <td width="25%"><strong>Customer</strong></td>
            <td width="2%" align="center"><strong>:</strong></td>
            <td>
                <?php if ($total_cust > 0) { ?>
                <?php echo $row_cust['kontak']; ?>
                <?php } else { ?>
                &nbsp;
                <?php } ?>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td align="center"><strong>:</strong></td>
            <td>
                <?php if ($total_cust > 0) { ?>
                <?php echo $row_cust['alamat']; ?>
                <?php } else { ?>
                &nbsp;
                <?php } ?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>No. Tlp / Handphone</strong></td>
            <td align="center"><strong>:</strong></td>
            <td>
                <?php if ($total_cust > 0) { ?>
                <?php echo $row_cust['notlp'] . ' / ' . $row_cust['notlp2']; ?>
                <?php } else { ?>
                &nbsp;
                <?php } ?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="5" id="divOrder">
                    <tr>
                        <th width="4%" style="border-bottom:solid 2px #000000;border-right:solid 2px #000000;">No</th>
                        <th style="border-bottom:solid 2px #000000;border-right:solid 2px #000000;">Deskripsi Barang</th>
                        <th width="12%" style="border-bottom:solid 2px #000000;border-right:solid 2px #000000;">Qty</th>
                        <th width="12%" style="border-bottom:solid 2px #000000;border-right:solid 2px #000000;">Harga</th>
                        <th width="12%" style="border-bottom:solid 2px #000000;border-right:solid 2px #000000;">Diskon</th>
                        <th width="18%" style="border-bottom:solid 2px #000000">Subtotal</th>
                    </tr>
                    <?php 
						$gTot = 0;
						$no = 1;
						while ($row_detbrg = mysqli_fetch_assoc($detbrg))
						{
							if ($row_detbrg['tipe'] != '3')
							{
								$gTot += $row_detbrg['subtotal'];
								?>
									<tr valign="top">
										<td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											<?php echo $no++; ?>.
										</td>
										<td style="border-right:solid 1px #FFF;border-bottom:solid 1px #DDD;">
											<?php
												if ($row_detbrg['kode'] != '') echo $row_detbrg['kode'] . " # ";
											?>
											<?=$row_detbrg['jenis']?> # <?=$row_detbrg['barang']?> # <?=$row_detbrg['color']?>
										</td>
										<td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											<?php echo $row_detbrg['qty']; ?> <?php echo $row_detbrg['satuan']; ?>
										</td>
										<td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											<?php echo number_format($row_detbrg['harga'], 0, ',', '.'); ?>
										</td>
										<td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											<?php if ($row_detbrg['tdiskon'] == 0) {
												echo number_format($row_detbrg['diskon'], 0, ',', '.');
												} else {
													echo $row_detbrg['diskon'] . " %";
												} 
											?>
										</td>
										<td align="right" style="border-bottom:solid 1px #DDD;">
											<?php echo number_format($row_detbrg['subtotal'], 0, ',', '.'); ?> Rupiah
										</td>
									</tr>
								<?php
							}
							
							if ($row_detbrg['tipe'] == '3' || $row_detbrg['tipe'] == '5')
							{
								$gTot += $row_detbrg['harga_lensa'];
								?>
									<tr valign="top">
										<td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											<?=$no++?>.
										</td>
										<td style="border-right:solid 1px #FFF;border-bottom:solid 1px #DDD;">
											<?php
												$rs2 = $mysqli->query("SELECT * FROM barang WHERE product_id = $row_detbrg[lensa]");
												$data2 = mysqli_fetch_assoc($rs2);
											?>
											LENSA <?=$data2['barang']?>
										</td>
										<td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											1 pcs
										</td>
										<td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											<?php echo number_format($row_detbrg['harga_lensa'], 0, ',', '.'); ?>
										</td>
										<td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;">
											-
										</td>
										<td align="right" style="border-bottom:solid 1px #DDD;">
											<?php echo number_format($row_detbrg['harga_lensa'], 0, ',', '.'); ?> Rupiah
										</td>
									</tr>
								<?php
							}
						}
					?>
                    <?php /* $no = 1; do { ?>
                      <tr valign="top">
                      <td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo $no;$no++;?>.</td>
                      <td style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo $row_detbrg['jenis'];?> - <?php echo $row_detbrg['barang'];?></td>
                      <td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo $row_detbrg['qty'];?> <?php echo $row_detbrg['satuan'];?></td>
                      <td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
                      <td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php if($row_detbrg['tdiskon']==0) { echo number_format($row_detbrg['diskon'],0,',','.'); }else{ echo $row_detbrg['diskon']." %"; } ?></td>
                      <td align="right" style="border-bottom:solid 1px #DDD;"><?php echo number_format($row_detbrg['subtotal'],0,',','.');?> <?php echo $row_gorder['matauang'];?></td>
                      </tr>
                      <?php }while($row_detbrg = mysqli_fetch_assoc($detbrg)); */ ?>
                    <tr>
                        <th>&nbsp;</th>
                        <th colspan="4" align="right">Grand Total :</th>
                        <td align="right" style="border-bottom:solid 1px #DDD;"><?php echo number_format($gTot, 0, ',', '.'); ?> Rupiah</td>
                    </tr>

                    <tr>
                        <th>&nbsp;</th>
                        <th colspan="4" align="right">
                            Pelunasan :
                        </th>
                        <td align="right" style="border-bottom:solid 1px #DDD;"><?php echo number_format($dp, 0, ',', '.'); ?> Rupiah</td>
                    </tr>
					
                    <tr>
                        <th>&nbsp;</th>
                        <th colspan="4" align="right">Sisa :</th>
                        <td align="right" style="border-bottom:solid 1px #DDD;"><?php echo number_format($gTot - $dp - $sudahbayar, 0, ',', '.'); ?> Rupiah</td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td align="right"><strong>Terbilang </strong></td>
            <td align="center">:</td>
            <td align="left" class="garisbawah"><i><?php 
			if ($gTot-$dp-$sudahbayar == 0) echo "Lunas";
			else echo terBilang($gTot - $dp - $sudahbayar) . " Rupiah"; ?></i></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php
			// list detail barang
			$query_detbrg = "SELECT a.*, c.satuan, d.jenis, b.frame 
                            FROM dkeluarbarang a 
                            LEFT JOIN barang b ON b.product_id = a.product_id 
                            LEFT JOIN satuan c ON c.satuan_id = a.satuan_id 
                            LEFT JOIN jenisbarang d ON d.brand_id = b.brand_id 
                            WHERE a.noreferensi LIKE '$ref' 
                            ORDER BY a.id";
			$detbrg = $mysqli->query($query_detbrg);
			$row_detbrg = mysqli_fetch_assoc($detbrg);
		?>
        <tr>
            <td colspan="6">
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <strong style="font-size: 12px;">Detail Ukuran</strong>:<br>
                            <table align="left" width="85%" border="1" rules="all" bordercolor="#000000">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="center"><strong>SpH</strong></td>
                                    <td align="center"><strong>Cyl</strong></td>
                                    <td align="center"><strong>Axis</strong></td>
                                    <td align="center"><strong>Add</strong></td>
                                    <td align="center"><strong>PD</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Right</strong></td>
                                    <td align="center"><?php echo ($row_detbrg['rSph'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['rCyl'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['rAxis'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['rAdd'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['rPd']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Left</strong></td>
                                    <td align="center"><?php echo ($row_detbrg['lSph'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['lCyl'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['lAxis'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['lAdd'] / 100); ?></td>
                                    <td align="center"><?php echo ($row_detbrg['lPd']); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Lensa: <?php echo $row_detbrg['lensa']; ?></td>
                                    <td colspan="3">Frame: <?php echo $row_detbrg['frame']; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="40%">
                            <ul>
                                <li>Pesanan sesudah 1(satu) bulan tidak diambil, perusahaan tidak bertanggung jawab.</li>
                                <li>Pesanan yang dibatalkan, uang muka dianggap hilang.</li>
                                <li>Barang yang sudah dibeli tidak dapat dikembalikan/ditukar.</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--
        <tr>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        -->
        <tr>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="right"><strong>Karyawan</strong></td>
            <td align="center"><strong>:</strong></td>
            <td align="center"><?=$row_gkary['kontak']?></td>
        </tr>
    </table>
</body>