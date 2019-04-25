<?php

global $mysqli;
global $klas, $c;

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter = '';
if ($branch_id != 0 && ($klas == 'karyawan' || $klas == 'customer' || $klas == 'sales')) {
    $branch_filter = " AND a.branch_id = $branch_id ";
}

$query_data  = "SELECT 
                    a.user_id, a.gender, a.kontak, a.alamat, a.kperson, a.pinbb, a.mulai, a.jabatan, a.notlp, a.notlp2, a.hp, a.fax, a.email, a.info, b.jenis 
				FROM kontak a 
				JOIN jeniskontak b ON b.kode = a.jenis 
                WHERE b.klasifikasi = '$klas' 
                $branch_filter 
                ORDER BY a.user_id ASC ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);
?>

<script type="text/javascript" language="javascript" src="js/apps/masterkontak.js"></script>

<style>
    td.details-control {
        background: url('media/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('media/images/details_close.png') no-repeat center center;
    }
</style>

<div id="result" style="display: none;"></div>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
	<input type="hidden" name="klas" value="<?=$klas?>" />
  <div class="tablebg">
    <h1>Data  <?php echo ucfirst($klas);?></h1>
    
	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add-k-<?php echo $klas;?>.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a><?php } ?>

	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
    	<thead>
      <tr>
        <th width="16%" align="center"><font color="#0000CC"><?php echo strtoupper($klas);?></font></th>
        <th width="18%" align="center"><font color="#0000CC">ALAMAT</font></th>
        <th width="12%" align="center"><font color="#0000CC">PHONE</font></th>
        <th width="10%" align="center"><font color="#0000CC">BERGABUNG</font></th>
        <th align="center"><font color="#0000CC">KONTAK INFO</font></th>
        <th width="8%" align="center"><font color="#0000CC"></font></th>
      </tr>
		</thead>
        
        <tbody>
      		<?php
	  			$no=0;
	   			while ($row_data = mysqli_fetch_assoc($data)) { 
                        $user_id = $row_data['user_id'];
                    ?>
        <td align="left"><?php echo $row_data['kontak'];?></td>
        <td align="left"><?php echo $row_data['alamat'];?></td>
        <td align="center"><?php echo $row_data['notlp'];?></td>
        <td align="center"><?php genDate($row_data['mulai']);?></td>
        <td><small style="float:right;">[ <a href="javascript:void(0);" onclick="viewKontak('infotable_<?php echo $row_data['user_id'];?>');">Lihat Info</a> ]</small>
          <table width="100%" border="0" cellspacing="0" cellpadding="4" id="infotable_<?php echo $row_data['user_id'];?>" style="display:none;">
          <tr>
            <td width="40%" align="right" valign="top"><strong>Phone 2 :</strong></td>
            <td valign="top"><?php echo $row_data['notlp2'];?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong>Phone 3 :</strong></td>
            <td valign="top"><?php echo $row_data['hp'];?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong>Email :</strong></td>
            <td valign="top"><?php echo $row_data['email'];?></td>
          </tr>
          <?php if ($klas != 'supplier' && $klas != 'cabang') { ?>
          <tr>
            <td align="right" valign="top"><strong>Gender :</strong></td>
            <td valign="top"><?php echo ($row_data['gender'] == 1 ? 'Laki-laki' : 'Perempuan');?></td>
          </tr>
          <?php } ?>
          <tr>
            <td align="right" valign="top"><strong>Keterangan :</strong></td>
            <td valign="top"><?php echo $row_data['info'];?></td>
          </tr>
          <?php
		  	if ($klas == "customer")
			{
				?>
                	<tr>
                        <td colspan="2">
                            <!--
                            <input type="button" value="General" onclick="generateReport2('customer', 'general', '<?=$user_id?>')" />
                            -->
                            <table width="100%" border="1" cellspacing="0">
                            <?php
                                $rs2 = $mysqli->query("SELECT * FROM keluarbarang WHERE client = $user_id AND referensi != '' ORDER BY tgl DESC");
                                while ($data2 = $rs2->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?=$data2['tgl']?></td>
                                            <td>
                                                <a href="include/draft_invoice_1.php?keluarbarang_id=<?=$data2['keluarbarang_id']?>" onclick="NewWindow(this.href,'name','720','520','yes'); return false;" style="color: blue;">
                                                    <?=$data2['referensi']?>
                                                </a>
                                            </td>
                                            <td><?=number_format($data2['total'], 0)?></td>
                                        </tr>
                                    <?php
                                }
                            ?>
                            </table>
                        </td>
                      </tr>
                <?php
			}
		  ?>
        </table></td>
        <td align="center">
            <?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index-c-<?=$c?>-t-add-k-<?=$klas?>-<?=$row_data['user_id']?>.pos" title="Edit Data"><img src="images/edit_icon.png" border="0" height="16px" width="16px" /></a><?php } ?>
            &nbsp;
            <?php if (strstr($_SESSION['akses'], "delete_" . $c)): ?>
                <img src="images/delete_icon.png" height="16px" width="16px" style="cursor: pointer;" onclick="deleteData('<?=$klas?>', '<?=$row_data['user_id']?>')" />
            <?php endif; ?>
        </td>
        </tr>
      <?php } ?>
		</tbody>
	</table>
    
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
        
        <?php
            if ($klas == "customer")
            {
                ?>
                    <label>
                        <input type="radio" id="customer1" />
                        Laporan Pembelian Customer
                    </label>
                    <select id="user_id">
                        <?php
                            $rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'C001' ORDER BY kontak ASC");
                            while ($data2 = mysqli_fetch_assoc($rs2))
                            {
                                ?>
                                    <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <br />
                <?php
            }
            else if ($klas == "supplier")
            {
                ?>
                    <label>
                        <input type="radio" id="supplier1" />
                        Laporan Pengambilan Barang Dari Supplier
                    </label>
                    <select id="user_id">
                        <?php
                            $rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'S0001' ORDER BY kontak ASC");
                            while ($data2 = mysqli_fetch_assoc($rs2))
                            {
                                ?>
                                    <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <br />
                <?php
            }
            else if ($klas == "karyawan")
            {
                ?>
                    <label>
                        <input type="radio" id="karyawan1" />
                        Laporan Penjualan Karyawan
                    </label>
                    <select id="user_id">
                        <?php
                            $rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'T001' or jenis LIKE 'T002' ORDER BY kontak ASC");
                            while ($data2 = mysqli_fetch_assoc($rs2))
                            {
                                ?>
                                    <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <br />
                <?php
            }
            else if ($klas == "cabang")
            {
                ?>
                    <label>
                        <input type="radio" name="radio" id="cabang1" />
                        Laporan Umum Perpindahan Barang
                    </label>
                    <br />
                    
                    <label>
                        <input type="radio" name="radio" id="cabang2" />
                        Laporan Detail Perpindahan Barang
                    </label>
                    <select id="user_id">
                        <?php
                            $rs2 = $mysqli->query("SELECT user_id, kontak FROM kontak WHERE jenis LIKE 'B001' ORDER BY kontak ASC");
                            while ($data2 = mysqli_fetch_assoc($rs2))
                            {
                                ?>
                                    <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <br />
                <?php
            }
        ?>
        
		<input type="button" value="Cetak" onclick="generateReport();" />
	</div>
    
  </div>
</form>