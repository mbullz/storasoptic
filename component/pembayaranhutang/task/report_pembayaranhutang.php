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
        $title = 'Laporan Hutang Terbayar Periode: ' . $startPeriode . ' sampai ' . $endPeriode;
        $field_name = array('Tanggal', 'No. Invoice', 'Supplier', 'Total', 'Pembayaran', 'Jumlah', 'Info');
        $query = "select f.tgl, a.referensi, e.kontak, a.total, f.carabayar, f.jumlah, f.info "
				. "from aruskas f "
                . "join masukbarang a ON a.referensi = f.referensi "
                . "join dmasukbarang b on a.referensi=b.noreferensi "
                . "join barang c on c.kode=b.barang "
                . "join jenisbarang d on d.kode=c.jenis "
                . "join kontak e on e.kode=a.supplier "
                . "where f.tgl>='$startPeriode' and f.tgl<='$endPeriode' and c.tipe=$tipe "
				. "AND f.tipe like 'hutang' ";
		
		if ($_GET['supplier'] != "") $query .= " and e.kode = " . intval($_GET['supplier']);
        
        $res = $mysqli->query($query);
        $gTotal = 0;
        while($row = mysqli_fetch_assoc($res)) {
            $field_row[] = array(
                $row['tgl'], $row['referensi'], $row['kontak'],
                $row['total'], $row['carabayar'], $row['jumlah'], 
                $row['info']
            );
            $gTotal += $row['jumlah'];
        }
        
        $add_row = $add_row . "<td colspan='" . (count($field_name) - 2) . "'><strong>Grand Total</strong></td>";
        $add_row = $add_row . "<td colspan='2' align='center'><strong>Rp. " . number_format($gTotal, 0, ',', '.') . "</strong></td>";
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