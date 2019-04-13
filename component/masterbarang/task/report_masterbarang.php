<?php
include('../../../include/config_db.php');
require '../../../include/config.php';
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
        $field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand');
        $query  = "select a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, b.info as supplier "
                . "from barang a join jenisbarang b on a.jenis = b.kode "
                . "where a.tipe=$tipe";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['jenis'], $row['barang'], 
                $row['color'], $row['qty'], $row['supplier']
            );
        }
        break;
    case 'brand_report':
        $tipe = intval($_GET['tipe']);
        $jenis = $mysqli->real_escape_string($_GET['jenis']);
        
        $query = "select * from jenisbarang where kode='$jenis'";
        $res1 = $mysqli->query($query);
        $temp = mysqli_fetch_assoc($res1);
        $title = 'Laporan Stok Brand: ' . $temp['jenis'];
        
        $field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand');
        $query  = "select a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, b.info as supplier "
                . "from barang a join jenisbarang b on a.jenis = b.kode "
                . "where a.tipe=$tipe and b.kode='$jenis'";
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['barang'], 
                $row['color'], $row['qty'], $row['supplier']
            );
        }
        break;
	case 'old_stock_report':
        $title = 'Laporan Stok Barang Lama';
        $tipe = $_GET['tipe'];
		$periode1 = $_GET['periode1'];
		$periode2 = $_GET['periode2'];	
        $field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand', 'Tgl Masuk');
        $query  = "select a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, b.info as supplier, a.tgl_masuk_akhir "
                . "from barang a join jenisbarang b on a.jenis = b.kode "
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
        $query  = "select a.kode, a.barang, a.frame, a.color, a.info, a.qty, b.jenis, b.info as supplier, a.price "
                . "from barang a join jenisbarang b on a.jenis = b.kode "
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
        $field_name = array('Kode Brand', 'Jenis ' . $aa[$tipe-1], 'Nama Brand', 'Type ' . $aa[$tipe-1], 'Warna', 'Qty', 'Nama Supplier Brand');
				
		$query = "select distinct c.kode, c.frame, d.jenis, c.barang, c.color, c.qty, e.kontak "
                . "from masukbarang a "
                . "join dmasukbarang b on a.referensi=b.noreferensi "
                . "join barang c on c.kode=b.barang "
                . "join jenisbarang d on d.kode=c.jenis "
                . "join kontak e on e.kode=a.supplier "
                . "where c.tipe=$tipe ";
		
		if ($supplier != "") $query .= " and e.kode = " . intval($supplier);
        
        $res = $mysqli->query($query);
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['kode'], $row['frame'], $row['jenis'], $row['barang'], 
                $row['color'], $row['qty'], $row['kontak']
            );
        }
        break;
    default:
        break;
}

?>
<html>
    <body>
        <h3><?php echo $title; ?></h3>
        <table width="100%">
            <tr>
                <td valign="top" align="left"><strong><?php echo $GLOBALS['company_name']; ?></strong></td>
                <td align="right">
                    <?php 
                    date_default_timezone_set('Asia/Jakarta');
                    echo '<small>' . date('d-m-Y H:i:s') . '</small>'; 
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <small>
                    <?php echo $GLOBALS['company_address']; ?>
                    </small>
                </td>
            </tr>
        </table>
        <br>
        <table class="datatable-print" rules="all" border="1" width="100%">
            <tr>
                <?php foreach ($field_name as $field) { ?>
                <td align="center"><?php echo $field; ?></td>
                <?php } ?>
            </tr>
            <?php foreach ($field_row as $rs) { ?>
            <tr>
                <?php foreach ($rs as $r) { ?>
                <td align="center"><?php echo $r; ?></td>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>