<?php
include('../../../include/config_db.php');

$mode = $_GET['mode'];
$field_name = array();
$field_row = array();
$title = '';
$query = '';
$res = null;

$aa = array('Frame', 'Softlens', 'Lensa');

$frame = array(
    array('Plastic Frame', 'Metal Frame', 'Sunglass', 'Frameless'),
    array('Softlens - 1', 'Softlens - 2'),
	array('Lensa - 1', 'Lensa - 2')
);

switch($mode)
{
    case 'general_report':
        $title = 'Laporan Stok Barang';
        $tipe = $_GET['tipe'];
		$frame = $_GET['frame'];
		$total_qty = 0;
        
        $query  = "SELECT a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, a.info as supplier "
                . "FROM barang a JOIN jenisbarang b ON b.brand_id = a.brand_id "
                . "WHERE a.tipe = $tipe AND frame LIKE '$frame' AND a.qty > 0 "
				. "ORDER BY b.jenis ASC , a.barang ASC ";
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res))
		{
			$total_qty += $row['qty'];
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['jenis'], $row['barang'], 
                $row['color'], $row['qty'], $row['supplier']
            );
        }
		
		$field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty (' . $total_qty . ')', 'Nama Supplier Brand');
		
        break;
    case 'brand_report':
        $tipe = intval($_GET['tipe']);
        $brand_id = $_GET['brand_id'];
		$total_qty = 0;
        
        $query = "select * from jenisbarang where brand_id=$brand_id";
        $res1 = $mysqli->query($query);
        $temp = mysqli_fetch_assoc($res1);
        $title = 'Laporan Stok Brand: ' . $temp['jenis'];
        
        $query  = "SELECT a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, a.info as supplier "
                . "FROM barang a JOIN jenisbarang b ON b.brand_id = a.brand_id "
                . "WHERE a.tipe = $tipe AND b.brand_id = $brand_id AND a.qty > 0 "
				. "ORDER BY b.jenis ASC , a.barang ASC ";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res))
		{
			$total_qty += $row['qty'];
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['barang'], 
                $row['color'], $row['qty'], $row['supplier']
            );
        }
		
		$field_name = array('Kode', 'Jenis ' . $aa[$tipe-1], 'Type ' . $aa[$tipe-1], 'Warna', 'Qty (' . $total_qty . ')', 'Nama Supplier Brand');
		
        break;
	case 'old_stock_report':
        $title = 'Laporan Stok Barang Lama';
        $tipe = $_GET['tipe'];
		$periode1 = $_GET['periode1'];
		$periode2 = $_GET['periode2'];	
        $field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand', 'Tgl Masuk');
        $query  = "select a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, a.info as supplier, a.tgl_masuk_akhir "
                . "from barang a join jenisbarang b on a.brand_id = b.brand_id "
                . "where a.tipe=$tipe "
				//. "AND tgl_masuk_akhir <= CURRENT_DATE - INTERVAL $aboveYear YEAR "
				. "AND tgl_masuk_akhir BETWEEN '$periode1' AND '$periode2' "
				. "ORDER BY tgl_masuk_akhir ASC ";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['jenis'], $row['barang'], 
                $row['color'], $row['qty'], $row['supplier'], $row['tgl_masuk_akhir']
            );
        }
        break;
	case 'price_report':
		$harga1 = $_GET['harga1'];
		$harga2 = $_GET['harga2'];
        $title = 'Laporan Barang dengan Harga : ' . number_format($harga1,0,".",",") . " - " . number_format($harga2,0,".",",");
        $tipe = $_GET['tipe'];
		
        $field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand', 'Harga');
        $query  = "select a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, a.info as supplier, a.price "
                . "from barang a join jenisbarang b on a.brand_id = b.brand_id "
                . "where a.tipe=$tipe "
				. "AND price BETWEEN $harga1 AND $harga2 "
				. "ORDER BY price ASC ";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['jenis'], $row['barang'], 
                $row['color'], $row['qty'], $row['supplier'], $row['price']
            );
        }
        break;
	case 'supplier_report':
        $title = 'Laporan Barang Per Supplier';
		$supplier = $_GET['supplier'];
        $tipe = $_GET['tipe'];
        $field_name = array('Kode', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand');
				
		$query = "SELECT distinct c.kode, c.frame, d.jenis, c.barang, c.color, c.qty, e.kontak 
                	FROM masukbarang a 
                	JOIN dmasukbarang b ON b.noreferensi = a.referensi 
                	JOIN barang c ON c.product_id = b.product_id 
                	JOIN jenisbarang d ON d.brand_id = c.brand_id 
                	JOIN kontak e ON e.user_id = a.supplier 
                	WHERE c.tipe=$tipe ";
		
		if ($supplier != "") $query .= " and e.user_id = " . intval($supplier);
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['jenis'], $row['barang'], 
                $row['color'], $row['qty'], $row['kontak']
            );
        }
        break;
	case 'import_report':
        $title = 'Laporan Input Barang';
        $tipe = $_GET['tipe'];
		$periode1 = $_GET['periode1'];
		$periode2 = $_GET['periode2'];	
        $field_name = array('Brand', 'Type', 'Frame', 'Color', 'Qty', 'Created By', 'Created Date');
        $query  = "SELECT b.jenis, a.barang, a.frame, a.color, a.qty, c.kontak, a.created_date "
                . "from barang a join jenisbarang b on a.brand_id = b.brand_id "
				. "JOIN kontak c on c.user_id = a.created_user_id "
                . "WHERE a.tipe=$tipe "
				. "AND created_date BETWEEN '$periode1' AND '$periode2' "
				. "ORDER BY created_date DESC ";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['jenis'], $row['barang'], $row['frame'], $row['color'], 
                $row['qty'], $row['kontak'], $row['created_date']
            );
        }
        break;
    case 'laporan_umum_cabang':
        $title = 'Laporan Umum Cabang';
        $periode1 = $_GET['periode1'];
        $periode2 = $_GET['periode2'];
        $field_name = array('Cabang', 'Tanggal', 'Qty');
        $query  = "SELECT c.kontak, a.tgl, SUM(qty) AS qty "
                . "FROM keluarbarang a "
                . "JOIN dkeluarbarang b ON b.noreferensi = a.referensi "
                . "JOIN kontak c ON c.user_id = a.client "
                . "WHERE a.tgl BETWEEN '$periode1' AND '$periode2' "
                . "AND c.jenis LIKE 'B001' "
                . "GROUP BY c.kontak, a.tgl "
                . "ORDER BY a.tgl ASC";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kontak'], $row['tgl'], $row['qty'] 
            );
        }
        break;
    case 'laporan_detail_cabang':
        $user_id = $_GET['user_id'];
        $periode1 = $_GET['periode1'];
        $periode2 = $_GET['periode2'];
        
        $rs2 = $mysqli->query("SELECT * FROM kontak WHERE user_id=$user_id");
        $data2 = mysqli_fetch_assoc($rs2);
        $title = 'Laporan Detail Cabang : ' . $data2['kontak'];
        
        $field_name = array('Tanggal', 'Product', 'Qty');
        $query  = "SELECT a.tgl, d.jenis, c.barang, c.color, b.qty "
                . "FROM keluarbarang a "
                . "JOIN dkeluarbarang b ON b.noreferensi = a.referensi "
                . "JOIN barang c ON c.product_id = b.product_id "
                . "JOIN jenisbarang d ON d.brand_id = c.brand_id "
                . "WHERE a.tgl BETWEEN '$periode1' and '$periode2' "
                . "AND a.client = $user_id "
                . "ORDER BY a.tgl ASC";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['tgl'], 
                $row['jenis'] . " # " . $row['barang'] . " # " . $row['color'], 
                $row['qty'] 
            );
        }
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
                    <th align="center"><?php echo $field; ?></th>
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
        </table>
    </body>
</html>