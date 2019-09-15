<?php
// get variable
$ce = $_GET['component'] ?? '';
$ce= base64_decode($ce);
$c = $_GET['component'] ?? '';
$t = $_GET['task'] ?? '';
$w = $_GET['w'] ?? '';
$ak= $_GET['aktif'] ?? '';
$cu= $_GET['curr'] ?? '';
$q = $_GET['q'] ?? '';
$q = str_replace("+","", $q);
$q_ = $_GET['q_'] ?? '';
$q_  = str_replace("+","", $q_);
$q__ = $_GET['q__'] ?? '';
$q__ = str_replace("+","", $q__);
$klas= $_GET['klasifikasi'] ?? '';
$pe  = $_GET['period'] ?? '';
//------ paging
$w_export    = "";
$currentPage = "index-c-".$c.".pos";
if($w <>'all' AND $w <>'') {
	$currentPage .="&w=".$w;
}
if($ak <>'') {
	$currentPage .="&aktif=".$ak;
	$w_export    .="&aktif=".$ak;
}
if($cu <>'') {
	$currentPage .="&curr=".$cu;
}
if($t <>'') {
	$currentPage .="&task=".$t;
}
if($pe <>'') {
	$currentPage .="&period=".$pe;
}
if($klas <>'') {
	$currentPage .="-k-".$klas;
}
if($q <>'') {
	$currentPage  = str_replace(".pos","",$currentPage);
	$currentPage .="-q-".str_replace(" ","+",$q).".pos";
	$w_export    .="&q=".str_replace(" ","+",$q);
}
if($q_ <>'') {
	$currentPage .="&q_=".str_replace(" ","+",$q_);
	$w_export    .="&q_=".str_replace(" ","+",$q_);
}
if($q__ <>'') {
	$currentPage .="&q__=".str_replace(" ","+",$q__);
	$w_export    .="&q__=".str_replace(" ","+",$q__);
}
// ---- var db 
$b = 15;
if(isset($_GET['page'])) { 
	$p = $_GET['page'];
}else{
	$p = 0;
}
$bp= $b * $p;
//---
$awal_bulan   = date("Y-m-01");
$akhir_bulan  = date("Y-m-31");
$periode_awal = date("Y-01-01");
$periode_akhir= date("Y-12-31");
$periode_bulan= date("m");
$periode_tahun= date("Y");
//------- Other variable
$label_koordinator_it = "Koordinator IT";
$nama_koordinator_it = "Hombang Kurniawan";
$label_kadephrga = "Kadep HRGA";
$nama_kadephrga = "Muhammad";
//----

$menu = array(
    'home'              => array(
        '0'         => 'Home'
    ),
    'user'              => array(
        '0'         => 'User Internal',
        'add'       => 'User Baru',
        'edit'      => 'Edit User'
    ),
    'satuan'            => array(
        '0'         => 'Satuan',
        'add'       => 'Satuan Baru',
        'edit'      => 'Edit Satuan'
    ),
    'matauang'      => array(
        '0'         => 'Mata Uang',
        'add'       => 'Mata Uang Baru',
        'edit'      => 'Edit Mata Uang',
    ),
    'cbayar'        => array(
        '0'         => 'Cara Pembayaran',
        'add'       => 'Cara Pembayaran Baru',
        'edit'      => 'Edit Cara Pembayaran',
    ),
    'config'        => array(
        '0'         => 'Toko',
    ),
    'jenisbarang'       => array(
        '0'         => 'Jenis Brand',
        'add'       => 'Jenis Brand Baru',
        'edit'      => 'Edit Jenis Brand'
    ),
    'masterbarang'      => array(
        '0'         => 'Master Barang',
        'add'       => 'Master Barang Baru',
        'edit'      => 'Edit Master Barang'
    ),
    'jeniskontak'       => array(
        '0'         => 'Jenis Kontak',
        'add'       => 'Jenis Kontak Baru',
        'edit'      => 'Edit Jenis Kontak'
    ),
    'masterkontak'      => array(
        '0'         => 'Data Kontak',
        'add'       => 'Kontak Baru',
        'edit'      => 'Kontak Sales'
    ),
    'barangmasuk'      => array(
        '0'         => 'Penerimaan Barang',
        'edit'      => 'Edit Penerimaan Barang'
    ),
    'barangreturmasuk'  => array(
        '0'         => 'Retur Penerimaan Barang',
        'edit'      => 'Edit Retur Penerimaan Barang'
    ),
    'barangkeluar'      => array(
        '0'         => 'Pengiriman Barang',
        'edit'      => 'Edit Penerimaan Barang'
    ),
    'barangreturkeluar' => array(
        '0'         => 'Retur Pengiriman Barang',
        'edit'      => 'Edit Retur Pengiriman Barang'
    ),
    'invoicepembelian'  => array(
        '0'         => 'Data Barang Masuk',
        'add'       => 'Barang Masuk Baru',
        'edit'      => 'Edit Barang Masuk'
    ),
    'hutangjtempo'      => array(
        '0'         => 'Hutang Jatuh Tempo'
    ),
    'pembayaranhutang'  => array(
        '0'         => 'Pembayaran Hutang',
        'add'       => 'Pembayaran Hutang Baru',
        'edit'      => 'Edit Pembayaran Hutang'
    ),
    'invoicepenjualan'  => array(
        '0'         => 'Data Barang Keluar',
        'add'       => 'Barang Keluar Baru',
        'edit'      => 'Edit Barang Keluar'
    ),
    'piutangjtempo'     => array(
        '0'         => 'Hutang Jatuh Tempo'
    ),
    'pembayaranpiutang' => array(
        '0'         => 'Pembayaran Piutang',
        'add'       => 'Pembayaran Piutang Baru',
        'edit'      => 'Edit Pembayaran Piutang'
    ),
    'specialorder'  => array(
        '0'         => 'Special Order',
    ),
    'biayaops'          => array(
        '0'         => 'Biaya Operasional',
        'add'       => 'Biaya Operasional Baru',
        'edit'      => 'Edit Biaya Operasional'
    ),
	'report_masterbarang'      => array(
        '0'         => 'Laporan Master Barang'
    ),
	'report_kartustock'      => array(
        '0'         => 'Laporan Kartu Stock'
    ),
    'copyright'         => array(
        '0'         => 'Copyright'
    ),
    'profile'       => array(
        '0'         => 'Profile',
    ),
    'report_all'    => array(
        '0'         => 'Laporan',
    ),
);
?>