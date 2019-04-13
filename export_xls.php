<?php
include("include/config_db.php");
if(isset($_GET['klas'])) {
	$select ="select a.kode, a.kontak, a.alamat, a.kperson, a.pinbb, a.mulai, a.jabatan, a.notlp, a.notlp2, a.hp, a.fax, a.email, a.info, b.jenis from kontak a, jeniskontak b where b.klasifikasi='$_GET[klas]' AND a.jenis = b.kode";
}else{
	$select = "select * from ".$_GET['tabel'];	
}
$export = $mysqli->query($select);
$fields = mysql_num_fields($export);
for ($i = 0; $i < $fields; $i++) {
$header .= mysql_field_name($export, $i) . "\t";
}
while($row = mysql_fetch_row($export)) {
$line = '';
foreach($row as $value) {
if ((!isset($value)) OR ($value == "")) {
$value = "\t";
} else {
$value = str_replace('"', '""', $value);
$value = '"' . $value . '"' . "\t";
}
$line .= $value;
}
$data .= trim($line)."\n";
}
$data = str_replace("\r","",$data);
if ($data == "") {
$data = "n(0) record found!\n";
}
$tanggal=date("Ymd");
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=exportxls".$_GET['tabel']."_".$_GET['klas']."_".$tanggal.".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>