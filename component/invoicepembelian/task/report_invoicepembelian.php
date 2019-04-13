<?php
include('../../../include/config_db.php');

$mode = $_GET['mode'];
$tipe = $_GET['tipe'];
$startPeriode = $mysqli->real_escape_string($_GET['sp']);
$endPeriode = $mysqli->real_escape_string($_GET['ep']);
$field_name = array();
$field_row = array();
$title = '';
$query = '';
$res = null;
$add_row = '';

$frame = array(
    array('Plastic Frame', 'Metal Frame', 'Sunglass', 'Frameless'),
    array('Softlens - 1', 'Softlens - 2')
);

switch($mode) {
    case 'general_report':
        $title = 'Update Pembelian Periode: ' . $startPeriode . ' sampai ' . $endPeriode;
        $field_name = array('Tanggal', 'Brand', 'Tipe', 'Supplier', 'Qty', 'Harga', 'Diskon', 'Total');
        $query = "SELECT a.tgl, d.jenis, c.barang, e.kontak, b.qty, b.harga, b.tdiskon, b.diskon, b.subtotal 
                	FROM masukbarang a 
                	JOIN dmasukbarang b on a.referensi = b.noreferensi 
                	JOIN barang c on c.product_id = b.product_id 
                	JOIN jenisbarang d on d.brand_id = c.brand_id 
                	JOIN kontak e on e.user_id = a.supplier 
               		WHERE tgl>='$startPeriode' and tgl<='$endPeriode' and c.tipe=$tipe ";
		
		if ($_GET['supplier'] != "") $query .= " AND e.user_id = " . intval($_GET['supplier']);
        
        $res = $mysqli->query($query);
        $gTotal = 0;
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['tgl'], $row['jenis'], $row['barang'], $row['kontak'],
                $row['qty'], $row['harga'], $row['diskon'] . ($row['tdiskon'] == 0 ? '' : '%'), 
                number_format($row['subtotal'], 0, ',', '.')
            );
            $gTotal += $row['subtotal'];
        }
        
        $add_row = $add_row . "<td colspan='" . (count($field_name) - 1) . "'><strong>Grand Total</strong></td>";
        $add_row = $add_row . "<td align='center'><strong>Rp. " . number_format($gTotal, 0, ',', '.') . "</strong></td>";
        break;
    default:
        break;
}

?>
<html>
	<head>
    	<style>
			body
			{
				background: #fafafa url('../../../images/noise-diagonal.png');
				color: #444;
				font: 100%/30px 'Helvetica Neue', helvetica, arial, sans-serif;
				text-shadow: 0 1px 0 #fff;
			}
			
			strong {
				font-weight: bold; 
			}
			
			em {
				font-style: italic; 
			}
			
			table {
				background: #f5f5f5;
				border-collapse: separate;
				box-shadow: inset 0 1px 0 #fff;
				font-size: 12px;
				line-height: 24px;
				margin: 30px auto;
				text-align: left;
				width: 95%;
			}	
			
			th {
				background: url('../../../images/noise-diagonal.png'), linear-gradient(#777, #444);
				border-left: 1px solid #555;
				border-right: 1px solid #777;
				border-top: 1px solid #555;
				border-bottom: 1px solid #333;
				box-shadow: inset 0 1px 0 #999;
				color: #fff;
			  font-weight: bold;
				padding: 10px 15px;
				position: relative;
				text-shadow: 0 1px 0 #000;	
			}
			
			th:after {
				background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.08));
				content: '';
				display: block;
				height: 25%;
				left: 0;
				margin: 1px 0 0 0;
				position: absolute;
				top: 25%;
				width: 100%;
			}
			
			th:first-child {
				border-left: 1px solid #777;	
				box-shadow: inset 1px 1px 0 #999;
			}
			
			th:last-child {
				box-shadow: inset -1px 1px 0 #999;
			}
			
			td {
				border-right: 1px solid #fff;
				border-left: 1px solid #e8e8e8;
				border-top: 1px solid #fff;
				border-bottom: 1px solid #e8e8e8;
				padding: 10px 15px;
				position: relative;
				transition: all 300ms;
			}
			
			td:first-child {
				box-shadow: inset 1px 0 0 #fff;
			}	
			
			td:last-child {
				border-right: 1px solid #e8e8e8;
				box-shadow: inset -1px 0 0 #fff;
			}	
			
			tr {
				background: url('../../../images/noise-diagonal.png');	
			}
			
			tr:nth-child(odd) td {
				background: #f1f1f1 url('../../../images/noise-diagonal.png');	
			}
			
			tr:last-of-type td {
				box-shadow: inset 0 -1px 0 #fff; 
			}
			
			tr:last-of-type td:first-child {
				box-shadow: inset 1px -1px 0 #fff;
			}	
			
			tr:last-of-type td:last-child {
				box-shadow: inset -1px -1px 0 #fff;
			}	
			
			tbody:hover td {
				color: transparent;
				text-shadow: 0 0 3px #aaa;
			}
			
			tbody:hover tr:hover td {
				color: #444;
				text-shadow: 0 1px 0 #fff;
			}
		</style>
    </head>
    
    <body>
        <table cellspacing="0" width="100%" style="margin-top:0px" border="0">
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>
                	<div style="float:left;margin-bottom:10px;"><strong><?=$title?></strong></div>
                    <div style="float:right;">
                        <strong>
                            <?php 
								date_default_timezone_set('Asia/Jakarta');
								echo '<small>' . date('d-m-Y H:i:s') . '</small>'; 
                            ?>
                        </strong>
                    </div>
                    <div style="clear:both"></div>
                    <small>
						<?php echo $GLOBALS['company_address']; ?>
                    </small>
                </td>
            </tr>
        </table>

        <table cellspacing="0" width="100%">
        	<thead>
                <tr>
                    <?php foreach ($field_name as $field) { ?>
                    <th align="center"><?php echo $field; ?></td>
                    <?php } ?>
                </tr>
			</thead>
            
            <tbody>
				<?php foreach ($field_row as $rs) { ?>
                <tr>
                    <?php foreach ($rs as $r) { ?>
                    <td align="center"><?php echo $r; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
			</tbody>
            
            <tfoot>
                <tr>
                    <?php echo $add_row; ?>
                </tr>
			</tfoot>
        </table>
    </body>
</html>