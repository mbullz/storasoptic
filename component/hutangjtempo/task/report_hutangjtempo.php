<?php
include('../../../include/config_db.php');
require '../../../include/config.php';
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
        $title = 'Laporan Hutang Jatuh Tempo Periode: ' . $startPeriode . ' sampai ' . $endPeriode;
        $field_name = array('Jatuh Tempo', 'Nama Brand', 'Tipe Frame', 'Supplier', 'Qty', 'Harga', 'Diskon', 'Total');
        $query = "select a.jtempo, d.jenis, c.barang, e.kontak, b.qty, b.harga, b.tdiskon, b.diskon, b.subtotal "
                . "from masukbarang a "
                . "join dmasukbarang b on a.referensi=b.noreferensi "
                . "join barang c on c.kode=b.barang "
                . "join jenisbarang d on d.kode=c.jenis "
                . "join kontak e on e.kode=a.supplier "
                . "where a.jtempo>='$startPeriode' and a.jtempo<='$endPeriode' and c.tipe=$tipe and a.lunas like '0' ";
		
		if ($_GET['supplier'] != "") $query .= " and e.kode = " . intval($_GET['supplier']);
        
        $res = $mysqli->query($query);
        $gTotal = 0;
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['jtempo'], $row['jenis'], $row['barang'], $row['kontak'],
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
<!doctype html>
<html>
    <body>
        <h3><?php echo $title; ?></h3>
        <table width="100%">
            <tr>
                <td valign="top" align="left"><strong><?php echo $GLOBALS['company_name']; ?></strong></td>
                <td align="right">
                    <?php echo '<small>' . date('d M Y h:m:s') . '</small>'; ?>
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
            <tr>
                <?php echo $add_row; ?>
            </tr>
        </table>
    </body>
</html>