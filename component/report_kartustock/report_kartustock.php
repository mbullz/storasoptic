<?php
include('include/config_db.php');
require 'include/config.php';
include('include/define.php');

$periode1 = $_POST['periode1'];
$periode2 = $_POST['periode2'];

?>

<style type="text/css">
	@media print
	{
		body *
		{
			visibility:hidden;
		} 
		
		#printable, #printable *
		{
			visibility:visible;
		}
		
		#printable
		{
			/* aligning the printable area */
			position:absolute;
			left:0;
			top:0;
		}
	}
</style>

<br />
<hr size="1" color="#FF0000" />
<br />

<form name="form_periode" method="post" action="index-c-report_kartustock.pos">
Periode: 
<span>
    <input type="text" class="calendar" placeholder="Tanggal Mulai" name="periode1" id="periode1" size="20" value="<?=$periode1?>" />
</span>
s/d 
<span>
	<input type="text" class="calendar" placeholder="Tanggal Selesai" name="periode2" id="periode2" size="20" value="<?=$periode2?>" />
</span>
<input type="submit" value="Go" />
<input type="button" onclick="javascript:window.print()" value="Print" />
</form>
<br />

<?php
	if ($periode1 != "" && $periode2 != "")
	{
		?>
        
<table border="0" width="100%" cellpadding="10">
	<tr>
    	<td width="35%" valign="top">
        	<center>
            	<font size="+1"><em>Barang Masuk</em></font>
            </center>
            
            <br />
            
            <div style="width:100%;height:25px;border-bottom:solid 1px #000">
                <div style="width:55%;float:left;text-align:center;">
                	Barang
                </div>
                <div style="width:15%;float:left;text-align:center">
                	Qty
                </div>
                <div style="width:30%;float:left;text-align:center">
                	Tanggal
                </div>
                <div style="clear:both">
                </div>
            </div>
            
			<?php
                $rs = $mysqli->query(" SELECT a.qty , b.tgl , c.barang , c.color , d.jenis 
                                    FROM dmasukbarang a 
                                    JOIN masukbarang b ON b.referensi = a.noreferensi 
									JOIN barang c ON c.kode = a.barang 
									JOIN jenisbarang d ON d.kode = c.jenis
                                    WHERE b.tgl >= '$periode1' 
                                    AND b.tgl <= '$periode2' 
									ORDER BY b.tgl ASC");
                
				$i = 1;
                while ($data = mysqli_fetch_assoc($rs))
                {
                    ?>
                    	<div style="width:100%;color:#333;height:auto;min-height:20px;<?php if ($i%2==0) echo "background-color:#CFF"; ?>">
                            <div style="width:55%;float:left;text-align:center">
                                <?=$data['jenis']?> - <?=$data['barang']?> - <?=$data['color']?>
                            </div>
                            <div style="width:15%;float:left;text-align:center">
                                <?=$data['qty']?>
                            </div>
                            <div style="width:30%;float:left;text-align:center">
                                <?=$data['tgl']?>
                            </div>
                            <div style="clear:both">
                            </div>
                        </div>
                    <?php
					$i++;
                }
            ?>
        </td>
        
        <td width="35%" valign="top">
        	<center>
            	<font size="+1"><em>Barang Keluar</em></font>
            </center>
            
            <br />
            
            <div style="width:100%;height:25px;border-bottom:solid 1px #000">
                <div style="width:55%;float:left;text-align:center;">
                	Barang
                </div>
                <div style="width:15%;float:left;text-align:center">
                	Qty
                </div>
                <div style="width:30%;float:left;text-align:center">
                	Tanggal
                </div>
                <div style="clear:both">
                </div>
            </div>
            
			<?php
                $rs = $mysqli->query(" SELECT a.qty , b.tgl , c.barang , c.color , d.jenis 
                                    FROM dkeluarbarang a 
                                    JOIN keluarbarang b ON b.referensi = a.noreferensi 
									JOIN barang c ON c.kode = a.barang 
									JOIN jenisbarang d ON d.kode = c.jenis
                                    WHERE b.tgl >= '$periode1' 
                                    AND b.tgl <= '$periode2' 
									ORDER BY b.tgl ASC");
                
				$i = 1;
                while ($data = mysqli_fetch_assoc($rs))
                {
                    ?>
                    	<div style="width:100%;color:#333;height:auto;min-height:20px;<?php if ($i%2==0) echo "background-color:#CFF"; ?>">
                            <div style="width:55%;float:left;text-align:center">
                                <?=$data['jenis']?> - <?=$data['barang']?> - <?=$data['color']?>
                            </div>
                            <div style="width:15%;float:left;text-align:center">
                                <?=$data['qty']?>
                            </div>
                            <div style="width:30%;float:left;text-align:center">
                                <?=$data['tgl']?>
                            </div>
                            <div style="clear:both">
                            </div>
                        </div>
                    <?php
					$i++;
                }
            ?>
        </td>
        
        <td width="29%" valign="top">
        	<div style="width:100%" id="printable">
        	<center>
            	<font size="+1"><em>Persediaan Akhir</em></font>
            </center>
            
            <br />
            
            <div style="width:100%;height:25px;border-bottom:solid 1px #000">
                <div style="width:85%;float:left;text-align:center;">
                	Barang
                </div>
                <div style="width:15%;float:left;text-align:center">
                	Stock
                </div>
                <div style="clear:both">
                </div>
            </div>
            
			<?php
                $rs = $mysqli->query(" SELECT c.qty , c.barang , c.color , d.jenis 
                                    FROM dkeluarbarang a 
                                    JOIN keluarbarang b ON b.referensi = a.noreferensi 
									JOIN barang c ON c.kode = a.barang 
									JOIN jenisbarang d ON d.kode = c.jenis
                                    WHERE b.tgl >= '$periode1' 
                                    AND b.tgl <= '$periode2' 
									ORDER BY b.tgl ASC");
                
				$i = 1;
                while ($data = mysqli_fetch_assoc($rs))
                {
                    ?>
                    	<div style="width:100%;color:#333;height:auto;min-height:20px;<?php if ($i%2==0) echo "background-color:#CFF"; ?>">
                            <div style="width:85%;float:left;text-align:center">
                                <?=$data['jenis']?> - <?=$data['barang']?> - <?=$data['color']?>
                            </div>
                            <div style="width:15%;float:left;text-align:center">
                                <?=$data['qty']?>
                            </div>
                            <div style="clear:both">
                            </div>
                        </div>
                    <?php
					$i++;
                }
            ?>
            </div>
        </td>
    </tr>
</table>

		<?php
	}
?>