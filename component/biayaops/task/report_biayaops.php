<?php
	include('../../../include/config_db.php');
    require '../../../include/config.php';
	
	$mode = $_GET['mode'];
	$startDate = $_GET['start'];
	$endDate = $_GET['end'];
	$query = '';
    $title = '';
	$res = null;
	$field_name = array();
	$field_row = array();
	$add = '';
	
	switch($mode) {
		case 'general_report':
			$total = 0;
            $title = 'Laporan Biaya Operasional Periode: ' . $startDate . ' sampai ' . $endDate;
			$query = "select a.id, a.account, a.tgl, a.referensi, a.jumlah, a.info, b.matauang, d.pembayaran "
					. "from aruskas a "
					. "join matauang b on a.matauang_id = b.matauang_id "
					. "join carabayar d on a.carabayar_id = d.carabayar_id "
					. "where a.tipe='operasional' and a.tgl >= '$startDate' and a.tgl <= '$endDate'";
			$res = $mysqli->query($query);
			
			$field_name = array('Tanggal', 'Pembayaran', 'No. Ref', 'Jenis', 'Info', 'Jumlah');
			while($row = mysqli_fetch_assoc($res)) {
				$field_row[] = array(
					$row['tgl'], 
					$row['pembayaran'], 
					$row['referensi'], 
					$row['account'],
					$row['info'],
					number_format($row['jumlah'],0,',','.'), 
				);
				$total += $row['jumlah'];
			}
			$add = "<p align='right'>Grand Total: <strong>Rp. " . number_format($total,0,',','.') . "</strong>&nbsp;&nbsp;</p>";
			break;
	}
?>
<!doctype html>
<html>
<head>
</head>
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
		<thead>
			<tr>
				<?php foreach ($field_name as $field) { ?>
				<th align="center"><?php echo $field; ?></th>
				<?php } ?>
			</tr>
		</thead>

		<tbody style="font-size: 12px;">
			<?php foreach ($field_row as $rs) { ?>
			<tr>
				<?php foreach ($rs as $r) { ?>
				<td align="center"><?php echo $r; ?></td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php echo $add; ?>
</body>
</html>